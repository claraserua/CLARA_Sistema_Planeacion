<?php
include "models/planestrategico/reportes/reportes.model.php";



class reportes {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $nodoprincipal;
	var $image;
	var $targetPathumbail;
	

	function reportes() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	  $this->nodos = new Niveles("filtro",TRUE);
	 $this->nodoprincipal = new Niveles("option");
	 $this->Model = new reportesModel();
		
 		
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
	 	
		$contenido = $this->View->Template(TEMPLATE.'modules/reportes/pe/REPORTE.TPL');
		$contenido =  $this->View->replace('/\#NODOS\#/ms' ,$this->nodos->nodos,$contenido);	
		
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		 
		 }
	 

	  
	  
	function Reporte(){
		
		$this->Model->getPlanesE($_GET['nodos'],$_GET['anos']);
		$html='<div class="datagrid"><table>';
		$numplanes = sizeof($this->Model->planes); 
		
		 if($numplanes != 0){
		 	 
		 	  $html.='<thead><tr>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" width="15%">No.</th>';
		 	 // $html.='<th width="25%">CLAVE</th>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" width="45%">PLAN ESTRATEGICO</th>';		 	 
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" width="15%">CENTRO</th>';
		 	  $html.='</tr>';
		 	
		 	$i=1;
		 	$j=1;
		 	  foreach($this->Model->planes as $plan){
		 	$html.='<tr>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.$i++.'</th>';
		 	//$html.='<th>'.$plan['PK1'].'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</th>';		 
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.$plan['PK_JERARQUIA'].'</th>';
		 	$html.='</tr>';
		 	
		 	$html.='<tr><td colspan="4"><table>';
		 	$html.='<td   style="border:1px #999999 solid; background:#CCC; color:#333;" width="50%"><strong>L&iacute;nea</td></strong>';
		    $html.='<td   style="border:1px #999999   solid; background:#CCC; color:#333;" width="50%"><strong>Objetivo Estrat&eacute;gico</strong></td>';
		 	$html.='</tr>';
		 	        
		 	
		 	      $this->Model->getLineas($plan['PK1']);
		 	      $numlineas = sizeof($this->Model->lineas);
		 	      if($numlineas != 0){
		 	      	   $l=1;
		 	      	   foreach($this->Model->lineas as $linea){
		 	      	   	
		 	      	  $this->Model->getObjetivoEstrateLinea($linea['PK1']);		 
		 	          $numlineas = sizeof($this->Model->objetivose);
		 	          if($numlineas != 0){
		 	      	   $idobjestr=1;  
			 	      	 foreach($this->Model->objetivose as $objetivoe){
			 	      	 	$html.='<tr>';		
			 	      	 	
			 	      	 	  	$html.= '<td style="border:1px #999999 solid; font-size:12px;" width="20%" colspan=""><strong>'.$l.'.</strong>'.htmlentities($linea['LINEA'], ENT_QUOTES, "ISO-8859-1").'</td>'; 
		 	      	 
		 	      	
		 	      	
		 	      	$html.='<td  width="10%" colspan="2"  style="border:1px #999999 solid; font-size:12px;" colspan="">'.$l.'.'.$idobjestr.':'.htmlentities($objetivoe['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>';
			 	      	 	
			 	      	 	
			 	      	 	        
		 	            $html.='</tr>'; 
			 	      	 	
			 	      	 	  $idobjestr++;  
			 	      	 	
			 	      	 }
		 	      	
		 	      	
		 	      	 }
		                        
		                 
		 	            
						         
		 	                     
		 	      	   	$l++;
		 	      	   	
		 	      	   	}
		 	      	   
		 	      }else{
				  	 $html.='<tr><td colspan="5"><div class="empty_results">NO ESTA INSCRITO(A) EN UN PLAN OPERATIVO</div></td></tr>';
		 	      	  
				  	
				  }
				  
				  	$html.='</table></td></tr>';
		 
		      }
		      $html.='</thead>';
		      
		 }
		
		$html.='</div></table>';
		
		echo $html;
	}
	
	
	

	
}

?>