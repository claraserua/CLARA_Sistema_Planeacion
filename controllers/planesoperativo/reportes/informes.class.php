<?php
include "models/planesoperativo/reportes/informes.model.php";
include "libs/resizeimage/class.upload.php";


class informes {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $nodoprincipal;
	var $image;
	var $targetPathumbail;
	

	function informes() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("filtro",TRUE);
	 $this->nodoprincipal = new Niveles("option");
	 $this->Model = new informesModel();
		
  if(isset($_GET['method'])){			
		
	 switch($_GET['method']){
	 	
		case "Reporte":
			$this->Reporte();
			break;
			
		default:	
	      $this->View = new View(); 
          $this->loadPage();
		  break;
		}
		
	}	
				 
		 
	}
	
	
	
	 function loadPage(){
	
		$this->View->template = TEMPLATE.'FRMPRINCIPAL.TPL';	
		$this->View->loadTemplate();
        $this->loadHeader();		
		$this->loadMenu();
		
		//if($this->passport->privilegios->hasPrivilege('P12')){
		$this->loadContent();
		/*}else{
		$this->error();
		}*/
		$this->loadFooter();
		$this->View->viewPage();
		
	 }
	 
	 
	  function loadHeader(){
	  $section = TEMPLATE.'sections/header.tpl';
	  $section = $this->View->loadSection($section);
	 $nombre = htmlentities($_SESSION['session']['titulo'], ENT_QUOTES, "ISO-8859-1").' '.htmlentities($_SESSION['session']['nombre'], ENT_QUOTES, "ISO-8859-1").' '.htmlentities($_SESSION['session']['apellidos'], ENT_QUOTES, "ISO-8859-1");
	  $imagen = 'thum_40x40_'.$_SESSION['session']['imagen'];
	  $section = $this->View->replace('/\#AVATAR\#/ms' ,$imagen,$section);
	  $section = $this->View->replace('/\#USUARIO\#/ms' ,$nombre,$section);
	  $this->View->replace_content('/\#HEADER\#/ms' ,$section);
	  }
	 
	 
	 function loadFooter(){
      $section = TEMPLATE.'sections/footer.tpl';
	  $section = $this->View->loadSection($section);
	  $this->View->replace_content('/\#FOOTER\#/ms' ,$section);
	 }
	 
	 
	
	 function loadMenu(){
	 $menu =  $this->menu->menu; 
	 $this->View->replace_content('/\#MENU\#/ms' ,$menu);
	 }
	 
	

	function error(){
		
		$contenido = $this->View->Template(TEMPLATE.'modules/error.tpl');
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
	}


  
	 function loadContent(){
	 	
		$contenido = $this->View->Template(TEMPLATE.'modules/reportes/po/INFORMES.TPL');
		$contenido =  $this->View->replace('/\#NODOS\#/ms' ,$this->nodos->nodos,$contenido);	
		
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		 
		 }
	 
function periodos($idPO,$estado){	  	
	  	$this->Model->periodos = array();
	  	
	  	$periodo ='';
	  	$this->Model->getPeriodos($idPO);

		$numperiodos = sizeof($this->Model->periodos); 
		
		$i = 1;		
		 
		 if($numperiodos != 0){
		 	
	       foreach($this->Model->periodos as $rowperiodos){	        	
	        	
	       $periodo ='';
		      	
	       if(trim($estado)=='S' && ( $rowperiodos['ENVIADO']==0 && $rowperiodos['ORDEN']== 1)){	
				$periodo = $rowperiodos['PERIODO'];	
				break;				
			
			}
			
			else if(trim($estado)=='S' && $rowperiodos['ENVIADO']==2){
				 $periodo = $rowperiodos['PERIODO'];
				 break;
			}
			
			else if(trim($estado)=='I' && $rowperiodos['ENVIADO']==1){				
				  $periodo = $rowperiodos['PERIODO'];
				  break;
			}	  	
	  	
	  	
	  	  }
	  	}
	  	
	  	return $periodo;
	  	
	  	
	  }



    function EtiquetaEstado($idPO,$estadoE){
	  
	    $estado='';
	  
	 switch($estadoE){
			  	
				case 'P':				
					$estado = '<span class="label label-warning">Pendiente</span> <span class="label label-info">Elaborando</span>';
			  		break;				
				
				case "G":				    
					$estado = '<span class="label label-warning">Pendiente:</span> <span class="label label-info">Elaborando</span>';	
			  		break;				
					
			    case "E":					
					$estado = '<span class="label label-warning">Pendiente</span> <span class="label label-revision">Revisando</span>';					
			  		break;
					
				case "R":	
					$estado = '<span class="label label-warning">Pendiente</span> <span class="label label-revision">Revisando Centro</span>';					
			  		break;					
					
				case "S":					
				    $periodo = $this->periodos($idPO,'S');					
				    $estado = '<span class="label label-success">Operando</span> <span class="label label-info">Elaborando Informe</span><div class="periodo">
                          <div class="periodo">
                       <h5>'.htmlentities($periodo, ENT_QUOTES, "ISO-8859-1").'</h5>
                           </div>  
                     </div>';					
			  	    break;			  	
				
				case "I":					
				    $periodo = $this->periodos($idPO,'I');							
					$estado = '<span class="label label-success">Operando</span> <span class="label label-revision">Revisando Informe</span>
					 <div class="periodo">
                          <div class="periodo">
                       <h5>'.htmlentities($periodo, ENT_QUOTES, "ISO-8859-1").'</h5>
                           </div>  
                     </div>';			
			  		break;			  		
			  		
			  	case "T":				
					$estado = '<span class="label label-important">Terminado</span>';					
			  		break;			  		
			  		
			  	default:			  	
			  	    $estado = '<span class="label label-warning">Pendiente</span>';	
			  	break;				
			  	
			  }
			  
			  return $estado;		
		
		}  
	  
	  
	function Reporte(){
		
		$this->Model->getPlanes($_GET['nodos'],$_GET['anos']);
		$html='<div class="datagrid"><table>';
		$numplanes = sizeof($this->Model->planes); 
		 $estado = "";
		
		 if($numplanes != 0){
		 	 
		 	  $html.='<thead><tr>';
		 	  
		 	 // $html.='<th>CLAVE</th>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF; width:33%;">PLAN OPERATIVO</th>';
		 	  $html.='<th  style="border:1px #999999 solid; background:#FF4712; color:#FFF; width:33%;" colspan="1" >ESTADO</th>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF; width:33%;" colspan="1">CENTRO</th>';
		 	  
		 	  $html.='<td  width="5%" style="border:1px #999999 solid; font-size:12px;"><strong>Trimenstre enero-marzo</strong></td>';
		 	  
		 	   
		 	  $html.='<td  width="5%" style="border:1px #999999 solid; font-size:12px;"><strong>Trimestre abril-junio</strong></td>';
		 	  
		 	   $html.='<td  width="5%" style="border:1px #999999 solid; font-size:12px;"><strong>Trimestre julio-septiembre</strong></td>';
		 	   
		 	   
		 	   $html.='<td  width="5%" style="border:1px #999999 solid; font-size:12px;"><strong>Trimestre octubre-diciembre</strong></td>';
		 	  
		 	  $html.='</tr>';
		 	
		 	$i=1;
		 	$j=1;
		 	  foreach($this->Model->planes as $plan){
		 	//$html.='<tr>';
		 	
		 			 	
		 	
		 	// $html.='</tr>';
		 	
		 	
		 	
		 	//$html.='<th>'.$plan['PK1'].'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF; width:33%;">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF; width:33%;">'.$this->EtiquetaEstado($plan['PK1'],trim($plan['ESTADO'])).'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF; width:33%; ">'.$plan['PK_JERARQUIA'].'&nbsp;&nbsp;&nbsp;&nbsp;</th>';
		 	
		 	
		 	 $this->Model->getPeriodos($plan['PK1']);   
		 	            $numperiodos = sizeof($this->Model->periodos);
		 	            if($numperiodos != 0){
		 	            	foreach($this->Model->periodos as $periodo){
		 	            //	$html.='<tr>';
		 	            	
		 	      //     $html.='<td style="border:1px #999999 solid; font-size:12px;">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</td>';  	
		 	      	 
		 	      	 //  $html.='<td  width="5%" style="border:1px #999999 solid; font-size:12px;"><strong>'.htmlentities($periodo['PERIODO'], ENT_QUOTES, "ISO-8859-1").'</strong></td>';
		 	      	   
		 	      	   		 	      	   
		 	      	   
		 	      	   switch($periodo['ENVIADO']){
					   	
					   	 case 0:
					   	     $estado = '<span class="label label-warning">Sin comenzar</span>';
					   	 
					   	 if(trim($plan['ESTADO'])=='S'&&$periodo['ORDEN'] == 1 ){
					   	 	
					   	 	 $estado = '<span class="label label-success">Operando</span> <span class="label label-info">Elaborando Informe</span>';	
						 	
						 }					   	 
					   	 
					   	 break;
					   	 
					   	 case 1:
					   	 $estado = '<span class="label label-success">Operando</span> <span class="label label-revision">Revisando Informe</span>';
					   	 
					   	/*  if(trim($plan['ESTADO'])=='I' ){
					   	 	
					   	 	 $estado = '<span class="label label-success">Operando</span> <span class="label label-revision">Revisando Informe</span>';	
						 	
						 }	*/					   	 
					   	 
					   	 
					   	 break;
					   	 
					   	 case 2:
					   	 $estado = '<span class="label label-success">Operando</span> <span class="label label-info">Elaborando Informe</span>';
					   	/* if(trim($plan['ESTADO'])=='S' ){
					   	 	
					   	 	 $estado = '<span class="label label-success">Operando</span> <span class="label label-info">Elaborando Informe</span>';	
						 	
						 }	*/
					   	 
					   	 
					   	 break;		   	 
					   	 
					   	 
					   	 case 3:
					   	 $estado = '<span class="label label-important">Terminado</span>';
					   	 break;
					   	 
					   }
		 	      	   
		 	      	   
		 	      	   
		 	      	   
		 	           $html.='<td  width="33%" style="border:1px #999999 solid; font-size:12px;" colspan="">'.$estado.'</td>';
		 	          // $html.='</tr>';
		 	                 }
		 	            	
		 	            	}else{
				  	 $html.='<td colspan="5"><div class="empty_results">NO EXISTEN PERIODOS EN EL PLAN OPERATIVO</div></td>';
				  	
				  }
		 	
		 	
		 	
		 	
		 	
		 	
		 	
		 /*	$html.='</tr>';
		 	
		 	$html.='<tr>';
		 
		 
		    $html.='<td  colspan="1"  style="border:1px #999999 solid; background:#CCC; color:#333; width:33%;">PLAN</td>';	
		 	$html.='<td  colspan="1"  style="border:1px #999999 solid; background:#CCC; color:#333; width:33%;">PERIODO</td>';
		 	$html.='<td  colspan="1" style="border:1px #999999 solid; background:#CCC; color:#333; width:33%;" >ESTADO&nbsp;&nbsp;&nbsp;&nbsp;</td>';
		 	
			$html.='</tr>';*/
		 	
		 	
		 	
		 	

				  
				  	$html.='</tr>';
		 
		      }
		      
		      
		      
		      $html.='</thead>';
		      
		 }
		
		$html.='</div></table>';
		
		echo $html;
	}
	
	
	

	
}

?>