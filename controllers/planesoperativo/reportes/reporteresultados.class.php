<?php
include "models/planesoperativo/reportes/reporteresultados.model.php";



class reporteresultados {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $nodoprincipal;
	var $image;
	var $targetPathumbail;
	

	function reporteresultados() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("filtro",TRUE);

	 

	 $this->nodoprincipal = new Niveles("option");
	 $this->Model = new reporteresultadosModel();
		
	if(isset($_GET['method'])){
		
		 switch($_GET['method']){
	 	
		case "Reporte":
			$this->Reporte();
			break;
			
		case "Descargar":
			$this->Descargar();
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
	 $nombre = $_SESSION['session']['titulo'].' '.htmlentities($_SESSION['session']['nombre'], ENT_QUOTES, "ISO-8859-1").' '.htmlentities($_SESSION['session']['apellidos'], ENT_QUOTES, "ISO-8859-1");
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
	 	
		$contenido = $this->View->Template(TEMPLATE.'modules/reportes/po/REPORTE_RESULTADOS.TPL');


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
	  
	  
	  
	  
	function ReporteHtml(){
		
		$this->Model->getPlanes($_GET['nodos'],$_GET['anos']);
		$html='<div class="datagrid"><table>';
		$numplanes = sizeof($this->Model->planes); 
		
		 if($numplanes != 0){
		 	 
		 	  $html.='<thead><tr>';
		 	  
		 
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">PLAN OPERATIVO</th>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">ESTADO</th>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">CENTRO</th>';
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
		 	
		 	$html.='<tr><td colspan="3" ><table>';		
		 	
		 	
		 	 
		 	$html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;"   width="20%"><strong>L&iacute;nea</strong></td>';
		    
		 	$html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="5%"><strong>No. Resultados</strong></td>';
		 	
		 	
		 	
		 	
		 		 	
		 	 	
		 	 	$this->Model->getPeriodos($plan['PK1']);   
		 	$numperiodos = sizeof($this->Model->periodos);
		 	   if($numperiodos != 0){
		 	     foreach($this->Model->periodos as $periodo){		 	            		
		 	            
		 	    $html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="5%" ><strong>No. Resultados sin avance(0%) '.htmlentities($periodo['PERIODO'], ENT_QUOTES, "ISO-8859-1").'</strong></td>'; 	
		 	    
		 	    $html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="5%"><strong>% respecto al total</strong></td>';
		 	    
		 	      	   
		 	      	      		 	           
		 	         } 	
		 	}	 	
		 	 	
		 	
		 	
		 	
		 	 	//$this->Model->getPeriodos($plan['PK1']);   
		 	$numperiodos = sizeof($this->Model->periodos);
		 	   if($numperiodos != 0){
		 	     foreach($this->Model->periodos as $periodo){		 	            		
		 	            
		 	    $html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="5%" ><strong>%Promedio de avance Resultado '.htmlentities($periodo['PERIODO'], ENT_QUOTES, "ISO-8859-1").'</strong></td>'; 	
		 	    
		 	    	
		 	
		 	      	   
		 	      	      		 	           
		 	         } 	
		 	}	 	
		 	
		 	
		 	$html.='</tr>';
		 	        
		 	
		 	      $this->Model->getLineas($plan['PK_PESTRATEGICO']);
		 	      $numlineas = sizeof($this->Model->lineas);
		 	      if($numlineas != 0){
		 	      	   $l=1;
					   
					  
		 	      	   foreach($this->Model->lineas as $linea){						 
						 
						 
					   $array_porcentajes = array(); 
			 	       $array_porcentajes_sum = array();	
					 //  $y=0;//num res	
						 
		 	      	   	 
		 	      	   	$html.='<tr>'; 	  
		 	      	   	
		 	      	   	
		 	         	$html.= '<td style="border:1px #999999 solid; font-size:12px;" width="20%" colspan=""><strong>'.$l.'.</strong>'.htmlentities($linea['LINEA'], ENT_QUOTES, "ISO-8859-1").'</td>'; 										
									
						$numresultados = $this->Model->getNumResultados($plan['PK1'],$linea['PK1']);      
								
						  $html.='<td style="text-align: center;  border:1px #999999 solid; font-size:14px;">'.$numresultados .'</td>'; 
									
				
				
					        	
		 	            
		 	            
		 	            
		 	            //-------------------------------------------------------------------------------------------
		 	            
		 	            
		 	                     
			 	   $this->Model->getResultados($plan['PK1'],$linea['PK1']);   
			 	   $numresultados = sizeof($this->Model->resultados);
			 	    $y=0;//num res	
			 	   if($numresultados != 0){	
			 	   			// $r=0;				 	       		 	            	
					       foreach($this->Model->resultados as $resultado){			 	           
					 	           
					 	$numperiodos = sizeof($this->Model->periodos);
					 	$z=0; 
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
				 	            	 	            
				 	           $array_porcentajes[$y][$z] = $maxvalor;		 	           	 	           
				 	           $z++;		 	       
			 	           
			 	           } 	 	            
		 	            	
		 	          }	 	 	           
					 	           
                        $y++;
					    
					 	            	
					}//END(for) RESULTADOS			 	      	    
			 	      	   		 	                     
			 	}else{//si no hay resultados
			 	}     
		 	                 
		 	               
		 	     // echo "res: ".$y."\n";   
		 	     // echo $z."\n";                      
		 	    
		 	    //$y = Resultados
		 	      $countsinA = 0;   
		 	      $countsinA_array = array(); 
				 if($y>0){					   	
					  //calculo suma 00 10 20 30 ... | 01 11 21 31 ... |   02 12 22 32...; $y: resultados; $z: periodos  
					  
					for($i=0;$i<$z;$i++){//periodos (columnas)										
						$suma = 0;										
							for($j=0;$j<$y;$j++){//resultados (fila)										
									
									if($array_porcentajes[$j][$i] < 16){//conteo de < 16
											$countsinA++;  								
									}	
																	 	
									 $suma += $array_porcentajes[$j][$i];				 									 									 
									 									
							}	
															
							$array_porcentajes_sum[] = $suma;
							$countsinA_array[] = $countsinA;
							$countsinA = 0;  			
					}				   	
				}			 	                 
		 	             
		 	             
		 	             
		 	             
		 	             
		 	             
		 	            //------------------------------------------------------------------------- 
		 	             
		 	             
		 	             
		 	             
		 	     	
		 	$numperiodos = sizeof($this->Model->periodos);
		 	$count=0;
		 	   if($numperiodos != 0){
		 	     foreach($this->Model->periodos as $periodo){	            
		 	             
		 	            
		 	            if($numresultados>0){
		 	            	$numres_savance = $countsinA_array[$count++];	
		 	            	$porcavanceTotal = round((($numres_savance * 100) /  $numresultados ),2);				                    }		 	         					
						else{
							$numres_savance = "-";
							$porcavanceTotal = "-";	
						}
												
						
		 	  	
		 	  	$html.='<td style="text-align: center; border:1px #999999 solid; font-size:14px;">'.$numres_savance.'</td>'; 
		 	  	
		 	  	
		 	  	
		 	  	$html.='<td style="text-align: center; border:1px #999999 solid; font-size:14px;">'.$porcavanceTotal.'</td>';		
		 	  	
					//	$html.='<td style="text-align: center; border:1px #999999 solid; font-size:14px;">'.$this->Model->porcRespTotal.'</td>'; 		
		 	      	   
		 	      	      		 	           
		 	         } 	
		 	}	 	
				
				        
		 	             
		 	             
		 	             
		 	                 
		 	 		 	        
		 	 		 	        
		 	 		 	     //** % PROMEDIO DE AVANCE RESULTADO (PERIODOS )  
		 	 	$numperiodos = sizeof($this->Model->periodos);
		 	 	$x=0;
		 	   if($numperiodos != 0){
		 	   
			 	     foreach($this->Model->periodos as $periodo){	
			 	     
			 	         if($y>0){ $promedio = $array_porcentajes_sum[$x] / $y;  }
				 	          else{	$promedio = 0; }//Sin Resultados
				 	                       	 	            		
			 	            
				 	    $html.='<td  style=" text-align: center;font-size:14px; border:1px #999999 solid; " width="3%" >'.round($promedio,2).'</td>'; 
				 	    
				 	      $x++; 	 	      	   
			 	      	      		 	           
			 	     } 	
		 	   }
		 	 		 	        
		 	                 
		 	                 
		 	                //-------------------------------------------------------------------------------------------   
		 	    
		 	 		 	        		 	 		 	        
		 	 		 	                     
		 	      	   	$l++;  	
		 	      	   	 	$html.='</tr>';//**     	
		 	      	   	
		 	      	   	}//END LINEA
		 	      	   	
		 	     
		 	      	   
		 	      }else{
				  	 $html.='<tr><td  style="border:1px #999999 solid; font-size:12px;" colspan="11"><div class="empty_results">NO ESTA INSCRITO(A) EN UN PLAN OPERATIVO</div></td></tr>';
		 	      	  
				  	
				  }
				  
				  	$html.='</table></td></tr>';
		 
		      }
		      $html.='</thead>';
		      
		 }
		
		$html.='</div></table>';
		
		return $html;
	}
	
	
	function Reporte(){
	
	echo $this->ReporteHtml();
	
	
	
	}
	
	
	
	
	
	
	

	
}

?>