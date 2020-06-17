<?php
include "models/planesoperativo/reportes/general.model.php";
include "libs/resizeimage/class.upload.php";


class general {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $nodoprincipal;
	var $image;
	var $targetPathumbail;
	

	function general() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("filtro",TRUE);
	 $this->nodoprincipal = new Niveles("option");
	 $this->Model = new generalModel();
		
		
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
	 	
		$contenido = $this->View->Template(TEMPLATE.'modules/reportes/po/GENERAL.TPL');
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
		
		
		
	function EstadoPeriodo($plan,$periodo){
		
		$estado = '';
		
		switch($periodo['ENVIADO']){
					   	
					   	 case 0:
					   	     $estado = '<span class="label label-warning">Sin comenzar</span>';
					   	 
					   	 if(trim($plan['ESTADO'])=='S'&&$periodo['ORDEN'] == 1 ){
					   	 	
					   	 	 $estado = '</span> <span class="label label-info">Elaborando Informe</span>';	
						 	
						 }					   	 
					   	 
					   	 break;
					   	 
					   	 case 1:
					   	 $estado = '<span class="label label-revision">Revisando Informe</span>';
					   	 
					   	/*  if(trim($plan['ESTADO'])=='I' ){
					   	 	
					   	 	 $estado = '<span class="label label-success">Operando</span> <span class="label label-revision">Revisando Informe</span>';	
						 	
						 }	*/					   	 
					   	 
					   	 
					   	 break;
					   	 
					   	 case 2:
					   	 $estado = '<span class="label label-info">Elaborando Informe</span>';
					   	/* if(trim($plan['ESTADO'])=='S' ){
					   	 	
					   	 	 $estado = '<span class="label label-success">Operando</span> <span class="label label-info">Elaborando Informe</span>';	
						 	
						 }	*/
					   	 
					   	 
					   	 break;		   	 
					   	 
					   	 
					   	 case 3:
					   	 $estado = '<span class="label label-important">Terminado</span>';
					   	 break;
					   	 
					   }
		
		
		return $estado;
		
	}	 
    
	 function EstadoPeriodo2($plan,$periodo){
		
		$estado = '';
		
		switch($periodo['ENVIADO']){
					   	
					   	 case 0:
					   	     $estado = 'Sin comenzar';
					   	 
					   	 if(trim($plan['ESTADO'])=='S'&&$periodo['ORDEN'] == 1 ){
					   	 	
					   	 	// $estado = '<span class="label label-success">Operando</span> <span class="label label-info">Elaborando Informe</span>';	
					   	 	 $estado = 'Elaborando Informe';	
						 	
						 }					   	 
					   	 
					   	 break;
					   	 
					   	 case 1:
					   	 $estado = 'Revisando Informe';
					   	 
					   					   	 
					   	 
					   	 
					   	 break;
					   	 
					   	 case 2:
					   	 $estado = 'Elaborando Informe';					   
					   	 
					   	 
					   	 break;		   	 
					   	 
					   	 
					   	 case 3:
					   	 $estado = 'Terminado';
					   	 break;
					   	 
					   }
		
		
		return $estado;
		
	}	  
	  
	function Reporte(){
		
		$this->Model->getPlanes($_GET['nodos'],$_GET['anos']);
		$html='<div class="datagrid2" style="overflow-x:auto;"><table>';
		$numplanes = sizeof($this->Model->planes); 
		
		 if($numplanes != 0){
		 	 
		 	  $html.='<thead><tr>';
		 	  
		 	//  $html.='<th>CLAVE</th>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;"  width="40%">PLAN OPERATIVO</th>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" width="20%" >ESTADO</th>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712;  color:#FFF;" width="40%">CENTRO</th>';
		 	  $html.='</tr>';
		 	
		 	$i=1;
		 	$j=1;
		 	  foreach($this->Model->planes as $plan){
		 	$html.='<tr>';
		 	
		 	//$html.='<th>'.$plan['PK1'].'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.$this->EtiquetaEstado($plan['PK1'],trim($plan['ESTADO'])).'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.$plan['PK_JERARQUIA'].'</th>';
		 	$html.='</tr>';	
		 			
		 	
		 	$html.='<tr><td colspan="3" ><table><tr>';	
		 	
		 	$html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;"   width=""><strong>Plan</td></strong>';		 
		 		 
		 	$html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;"   width="60px"><strong>L&iacute;nea</td></strong>';
		    $html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="60px"><strong>Objetivo Estrat&eacute;gico</strong></td>';
		 	$html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="30px"><strong>Resultado</strong></td>';
		 	$html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="40px"><strong>Resp del Resultado</strong></td>';
		 	$html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="40px"><strong>Medios</strong> </th>';
		 	$html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="40px"><strong>Resp del Medio</strong></td>';	
		 	$html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="40px"><strong># Evidencias Propuestas</strong></td>';
		    $html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="40px"><strong># Evidencias Subidas</strong></td>';
		    $html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="40px"><strong>% de Avance de Evidencias</strong></td>';
		 			   	 	
		 	
		 	$this->Model->getPeriodos($plan['PK1']);   
		 	$numperiodos = sizeof($this->Model->periodos);
		 	   if($numperiodos != 0){
		 	     foreach($this->Model->periodos as $periodo){		 	            		
		 	            
		 	    $html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="40px" ><strong>'.htmlentities($periodo['PERIODO'], ENT_QUOTES, "ISO-8859-1").' '.$this->EstadoPeriodo($plan,$periodo).'</strong></td>'; 
		 	    
		 	   //  $html.='<td  class="oldtd" width="4%" ><strong>estado </strong></td>'; 	
		 	      	      		 	           
		 	         } 	
		 	}
		 		 	
		 	$html.='</tr>';
		 	
		 	
		 	
		 	        
		 	      
		 	      $this->Model->getLineas($plan['PK_PESTRATEGICO']);
		 	      $numlineas = sizeof($this->Model->lineas);
		 	      if($numlineas != 0){
		 	      	   $l=1;
		 	      	  
		 	      	   foreach($this->Model->lineas as $linea){
		 	      	   	
		 	      	   	
		 	      	   $promedio = 0;
		 	      	   $porcentaje = 0;
		 	      	   $periodoColumn = 0;		 	      	   
		 	      	   
		 	      	   	
		 	      	   	
		 	      	  $html.='<tr>'; 	  
		 	      
		 	      	   	
		 	      	   	
		 	            $this->Model->getResultados($plan['PK1'],$linea['PK1']);   
		 	            $numresultados = sizeof($this->Model->resultados);
		 	            if($numresultados != 0){		 	            	
		 	            	$r=1;
		 	            	
		 	              foreach($this->Model->resultados as $resultado){ 	            	       	
		 	            	    
		 	            	    
		 	            	   
		 	            	$rowobjestr = $this->Model->getObjetivoEst($resultado['PK_OESTRATEGICO']);
		 	            	
		 	            	$idobjestr =  intval($rowobjestr['ORDEN']);
		                    $idobjestr++;
		 	            	   							 
		 	            	   
		 	            	   
		 	            	   //evidencias p
		 	             $numevidenciaP =$this->Model->getNumeroEvidenciasP($plan['PK1'],$linea['PK1'],$resultado['PK1']); 
		 	             $numevidenciaS =$this->Model->getNumeroEvidenciasS($plan['PK1'],$linea['PK1'],$resultado['PK1']);                     
		 	             	
		 	             $porcenevidencia = 0;
		 	             if($numevidenciaP != 0){
						 	$porcenevidencia = ($numevidenciaS * 100)/$numevidenciaP;
						 }	
		 	             	   	            	
		 	            	
		 	            $ponred = false;
		 	            	          
		 	            	
		 	            $color_evidenciaS="";
		 	            $color_evidenciaPorc = "";	          
		 	            if( $numevidenciaS == '0' && $porcenevidencia == '0' ){								
								$ponred = true;
								 $color_evidenciaS = "color: #ec3f35;";
					             $color_evidenciaPorc = "color: #ec3f35;";
					    }else{							
							if($numevidenciaS == '0'){ $color_evidenciaS = "color: #ec3f35;";}
							if($porcenevidencia == '0'){ $color_evidenciaPorc = "color: #ec3f35;";}
							
						}
					    
					    
					   	            	          
		 	            	          
				 	        
		 	            $numperiodos = sizeof($this->Model->periodos);
		 	            if($numperiodos != 0){  
		 	            
		 	                $valorant=0;//periodo anterior
			 	            $maxvalor = 0;
		 	                $todosperiodos = 0;
		 	                $periodos = 0;
		 	                      	
		 	            	foreach($this->Model->periodos as $periodo){ 	          		 	      	 	      	
		 	      	       	    $porcentaje = $this->Model->getAvanceResultado($resultado['PK1'],$periodo['PK1']);
		 	      	       	    
		 	      	       	    
		 	      	       	    if($valorant>$porcentaje){
				 	            	$maxvalor = $valorant;	
				 	            }
				 	            else{
				 	            	$maxvalor = $porcentaje;
				 	            	$valorant = $porcentaje;		 	            
				 	            } 	
		 	      	       	    
		 	      	       	    if($maxvalor == 0 || $maxvalor == '0' ){								
								//$ponred = true;
								$todosperiodos++;
							    }  
							    
							    $periodos++;  	       	
		 	      	       	
		 	            
		 	                 }
		 	            }	
		 	            
		 	            $todos = false;			 	            
		 	            $color = "";
		 	            $backgraund = "";
		 	            $font = 'font-size:14px;';	
		 	            $color_periodo="";	
		 	           
		 	             	           
		 	            if($todosperiodos == $periodos && $ponred == true){
					      $color = "color: #ec3f35;";
					      $color_periodo =  "color: #ec3f35;";					    
		 	              $backgraund = "background: #EEEEEE;";
		 	              
		 	              $todos = true;							
						}
		 	                        
		 	              		 	            
		 	           /* $color = "";
		 	            $backgraund = "";
		 	            if($ponred == true){
					      $color = "color: #ec3f35;";
		 	            $backgraund = "background: #EEEEEE;";
							
						}*/					 	            	    
		 	            	    
		 	            	    
		 	            	   
		 	            	    
		 	            	    
		 	            $this->Model->getMedios($resultado['PK1']);   
		 	            $nummedios = sizeof($this->Model->medios);
		 	            $m = 1;
		 	            if($nummedios != 0){
		 	            	
		 	             foreach($this->Model->medios as $medio){
		 	            	         	   
		 	            	
		 	           $html.='<td style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</td>';  	
		 	            	    
		 	            	    
		 	           $html.='<td style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.'"  colspan="">'.$l.'.-'.htmlentities($linea['LINEA'], ENT_QUOTES, "ISO-8859-1").'</td>';  	    
		 	            	    
		 	            	    
		 	            	    
		 	       $html.='<td   style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.'" colspan="">'.$l.'.'.$idobjestr.':'.htmlentities($rowobjestr['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>';
		 	       
		 	       
		 	       //RESULTADO
		 	        $html.='<td  style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.'" colspan="">'.$l.'.'.$r.':'.htmlentities($resultado['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>';
		 	        
		 	           $html.='<td  style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.'" colspan="">'.$this->Model->getResponsable($resultado['PK_RESPONSABLE']).'</td>';	 
		 	       
		 	       
		 	        //MEDIO
		 	           $html.='<td  style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.'"  colspan="">'.$l.'.'.$r.'.'.$m.': '.htmlentities($medio['MEDIO'], ENT_QUOTES, "ISO-8859-1").'</td>';
		 	         
		 	         //RESPONS DE MEDIO 	    
$html.='<td  style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.'" colspan="">'.$this->Model->getResponsable($medio['PK_RESPONSABLE']).'</td>'; 

					 //EVIDENCIAS PROPUESTAS	
                     $html.='<td    style="text-align: center; border:1px #999999 solid; font-size:14px;'.$color.'  '.$backgraund.'" colspan="">'.$numevidenciaP.'</td>';	         
		 	         $html.='<td    style="text-align: center; border:1px #999999 solid; font-size:14px; '.$color_evidenciaS.'  '.$backgraund.'"  colspan="">'.$numevidenciaS.'</td>';  
		 	         
		 	          $html.='<td   style="text-align: center; border:1px #999999 solid; font-size:14px; '.$color_evidenciaPorc.'  '.$backgraund.'  " colspan="">'.round($porcenevidencia, 2).' %</td>';
		 	          
		 	          		 	         
		 	         
		 	         // $this->Model->getPeriodos($plan['PK1']);   
		 	            $numperiodos = sizeof($this->Model->periodos);
		 	            if($numperiodos != 0){
		 	            	
		 	            	$valorant=0;//periodo anterior
			 	            $maxvalor = 0;
		 	            	
		 	            	foreach($this->Model->periodos as $periodo){		 	            		 	            
		 	          		 	      	 	      	
		 	      	 	$porcentaje = $this->Model->getAvanceResultado($resultado['PK1'],$periodo['PK1']); 		 	         
		 	            
		 	                   if($valorant>$porcentaje){
				 	            	$maxvalor = $valorant;	
				 	            }
				 	            else{
				 	            	$maxvalor = $porcentaje;
				 	            	$valorant = $porcentaje;		 	            
				 	            } 
				 	            
				 	            
				 if( ($maxvalor == 0 || $maxvalor == '0') && ($todos==false/* && $ponred != true*/) ){					
							    $color_periodo = "color: #ec3f35;";
				 	           // $font = "font-size:14px;";	
				    } else if($todosperiodos != $periodos){
						         $color_periodo = "";
					}	  				 	       
		 	         	
		 	            
		 	            
		 	            
		 	           $html.='<td   colspan="" style="text-align: center; border:1px #999999 solid; font-size:14px; '.$color_periodo.'  '.$backgraund.'">'.round($maxvalor,2).' %</td>';
		 	           
		 	          
					 
					 
		 	         
		 	                  }//FIN PERIODOS (FOR)
		 	                 
		 	             //    $html.='</tr>';
		 	            	
		 	            	}//FIN PERIODOS
		 	         
		 	         
		 	         
		 	         	
		 	       
		 	               $html.='</tr>';        
		 	         
		 	           
		 	                $m++;		 	            	         	
		 	            	         
		 	            	    }//END MEDIOS(for)
		 	           
		 	                 }else{//end medios
								 
								 
								 
								      	
		 	           $html.='<td style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</td>';  	
		 	            	    
		 	            	    
		 	           $html.='<td style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.'"  colspan="">'.$l.'.-'.htmlentities($linea['LINEA'], ENT_QUOTES, "ISO-8859-1").'</td>';  	    
		 	            	    
		 	            	    
		 	            	    
		 	       $html.='<td   style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.'" colspan="">'.$l.'.'.$idobjestr.':'.htmlentities($rowobjestr['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>';
		 	       
		 	       
		 	       //RESULTADO
		 	        $html.='<td  style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.'" colspan="">'.$l.'.'.$r.':'.htmlentities($resultado['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>';
		 	        
		 	           $html.='<td  style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.'" colspan="">'.$this->Model->getResponsable($resultado['PK_RESPONSABLE']).'</td>';	 
		 	       
		 	       
		 	        //MEDIO
		 	           $html.='<td  style="border:1px #999999 solid; font-size:12px;"  colspan=""></td>';
		 	         
		 	         //RESPONS DE MEDIO 	    
$html.='<td  style="border:1px #999999 solid; font-size:12px;" colspan=""></td>'; 

					 //EVIDENCIAS PROPUESTAS	
                     $html.='<td    style="text-align: center; border:1px #999999 solid; font-size:14px;'.$color.'  '.$backgraund.'" colspan="">'.$numevidenciaP.'</td>';	         
		 	         $html.='<td    style="text-align: center; border:1px #999999 solid; font-size:14px; '.$color_evidenciaS.'  '.$backgraund.'"  colspan="">'.$numevidenciaS.'</td>';  
		 	         
		 	          $html.='<td   style="text-align: center; border:1px #999999 solid; font-size:14px; '.$color_evidenciaPorc.'  '.$backgraund.'  " colspan="">'.round($porcenevidencia, 2).' %</td>';
		 	          
		 	          		 	         
		 	         
		 	         // $this->Model->getPeriodos($plan['PK1']);   
		 	            $numperiodos = sizeof($this->Model->periodos);
		 	            if($numperiodos != 0){
		 	            	
		 	            	$valorant=0;//periodo anterior
			 	            $maxvalor = 0;
		 	            	
		 	            	foreach($this->Model->periodos as $periodo){		 	            		 	            
		 	          		 	      	 	      	
		 	      	 	$porcentaje = $this->Model->getAvanceResultado($resultado['PK1'],$periodo['PK1']); 		 	         
		 	            
		 	                   if($valorant>$porcentaje){
				 	            	$maxvalor = $valorant;	
				 	            }
				 	            else{
				 	            	$maxvalor = $porcentaje;
				 	            	$valorant = $porcentaje;		 	            
				 	            } 
				 	            
				 	            
				 if( ($maxvalor == 0 || $maxvalor == '0') && ($todos==false/* && $ponred != true*/) ){					
							    $color_periodo = "color: #ec3f35;";
				 	           // $font = "font-size:14px;";	
				    } else if($todosperiodos != $periodos){
						         $color_periodo = "";
					}	  				 	       
		 	         	
		 	            
		 	            
		 	           $html.='<td   colspan="" style="text-align: center; border:1px #999999 solid; font-size:14px; '.$color_periodo.'  '.$backgraund.'">'.round($maxvalor,2).' %</td>';
		 	           
		 	          
					 
					 
		 	         
		 	                  }//FIN PERIODOS (FOR)
		 	                 
		 	             //    $html.='</tr>';
		 	            	
		 	            	}//FIN PERIODOS
		 	         
		 	         
		 	       
		 	               $html.='</tr>';      
								 
								 
								 
								 
							 }
		 	                 
		 	                  $r++;    
		 	           	
		 	      	    }//END RESULTADOS
		 	                     
		 	           }          
		 	                     
		 	      	   		 	      	   	
		 	      	 /*  $html.='<tr>';		 
		 	           $html.='<td class="oldtd" width="20%">Total L&iacute;nea '.$l.'</td>';
					   $html.='<td class="" class="oldtd3" width="10%"></td>';
					   $html.='<td class="" class="oldtd3" width="10%"></td>';					   
					   
					  //  $this->Model->getPeriodos($plan['PK1']);   
		 	            $numperiodos = sizeof($this->Model->periodos);
		 	            if($numperiodos != 0){
		 	            	foreach($this->Model->periodos as $periodo){ 	            
		 	                  $sumaporcentaje = 0;		 	            
		 	            // $this->Model->getResultados($plan['PK1'],$linea['PK1']);  
		 	                   $numresultados = sizeof($this->Model->resultados);
			 	            if($numresultados != 0){		 	            	
			 	            	$res=0;		 	            	
			 	              foreach($this->Model->resultados as $resultado){ 		 	              
			 	              	  $porcentaje = $this->Model->getAvanceResultado($resultado['PK1'],$periodo['PK1']); 
			 	              	  $sumaporcentaje += $porcentaje;
			 	              	  $res++;
			 	               }	              
			 	              
			 	            }		 	            
		 	            
		 	            $promedio = $sumaporcentaje / $res;           
		 	            
		 	            
		 	             $html.='<td  class="oldtd" width="3%" colspan=""><strong>'.round($promedio,2).' %</strong></td>';
		 	             $html.='<td  width="15%" class="oldtd3" colspan=""></td>';
		 	           
		 	           
					        }
					   
					   }	*/   
					   	
					   	
					   		 	
		 	            $html.='</tr>';
		 	      	   	 
		 	      	   	$l++; 
		 	      	   	
		 	      	   	
		 	      	   	}//end linea(for)
		 	      	   
		 	      }else{
				  	 $html.='<tr><td colspan="5" style="border:1px #999999 solid; font-size:12px;"><div class="empty_results">NO ESTA INSCRITO(A) EN UN PLAN OPERATIVO</div></td></tr>';
		 	      	  
				  	
				  }
				  $html.='</table></td></tr>';
				  	//$html.='</tr>';
		 
		      }
		      $html.='</thead>';
		      
		 }
		
		$html.='</div></table>';
		
		echo $html;
	}
	
	
	

	
}

?>