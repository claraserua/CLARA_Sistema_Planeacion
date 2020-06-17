<?php
include "models/planesoperativo/reportes/indicadores.model.php";
include "libs/resizeimage/class.upload.php";
class indicadores {
    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $nodoprincipal;
	var $image;
	var $targetPathumbail;
	
	function indicadores() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("filtro",TRUE);
	 $this->nodoprincipal = new Niveles("option");
	 $this->Model = new indicadoresModel();
		
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
	 	
		$contenido = $this->View->Template(TEMPLATE.'modules/reportes/po/INDICADORES.TPL');
		$contenido =  $this->View->replace('/\#NODOS\#/ms' ,$this->nodos->nodos,$contenido);	
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		
		/*$contenido =  $this->View->replace('/\#NODOS\#/ms' ,$this->nodos->nodos,$contenido);	
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		 */
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
	function Reporte_Excel_pba(){
		
		$this->Model->getPlanes($_GET['nodos'],$_GET['anos']);
		$html='<div class="datagrid" style="overflow-x:auto;"';
		$html.='<table style="width: 150%;">';
		$numplanes = sizeof($this->Model->planes); 
		//$html.='numero registros:'.$numplanes;
		if($numplanes != 0){
			$html.='<thead><tr>';
					$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">PLAN OPERATIVO</th>';
					$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="3">ESTADO</th>';
					$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="2">CENTRO</th>';  
		 	$html.='</tr></thead>';
			foreach($this->Model->planes as $plan){
				  $html.='<tr><thead>';  
					  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</th>';
					  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="3">'.$this->EtiquetaEstado($plan['PK1'],trim($plan['ESTADO'])).'</th>';
					  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="2">'.$plan['PK_JERARQUIA'].'</th>';
				  //$html.='</tr></thead>';
				  $html.='</tr></thead>';
				  $html.='<tr><td>';
				  $html.='<table><thead>';
				  $html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;"><strong>Plan</strong></td>';
				  $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="5%"><strong>L&iacute;nea</strong></td>';
				  $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="8%"><strong>Objetivo Estrat&Eacute;gico</strong></td>';
				  $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="8%"><strong>Meta 2024</strong></td>';
				  $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="5%"><strong>Resultado</strong></td>';
				  $html.='</thead>';
				  $html.='</table>';
				  $html.='</td>';
				  $html.='<td>';
				  $html.='<table><thead>';
				  $html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;"><strong>Meta Anual</strong></td>';
				$this->Model->getPeriodos($plan['PK1']);   
				$numperiodos = sizeof($this->Model->periodos);
				if($numperiodos != 0){
					foreach($this->Model->periodos as $periodo){		 	            				 	            
						if($numperiodos<4){
							$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="8%"><strong>'.htmlentities($periodo['PERIODO'], ENT_QUOTES, "ISO-8859-1").'</strong></td>';
						}else if($numperiodos==4){
							$html.='</thead>';
							$html.='</table>';
							$html.='</td>';
							$html.='<td>';
							$html.='<table><thead>';
							$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="8%"><strong>'.htmlentities($periodo['PERIODO'], ENT_QUOTES, "ISO-8859-1").'</strong></td>';
						} else if($numperiodos>4){
							$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="8%"><strong>'.htmlentities($periodo['PERIODO'], ENT_QUOTES, "ISO-8859-1").'</strong></td>';
						}
					} 	
				}
				$html.='</thead>';
				$html.='</table>';
				$html.='</td>';
				$html.='</tr>';
				//fin de los cabceros
				$this->Model->getLineas($plan['PK_PESTRATEGICO']);
		 	    $numlineas = sizeof($this->Model->lineas);
		 	    /*if($numlineas != 0){
					$l=1;
		 	      	foreach($this->Model->lineas as $linea){
						$promedio = 0;
						$porcentaje = 0;
						$periodoColumn = 0;	
						$array_porcentajes = array(); 
						$array_porcentajes_sum = array();		 	            	
						$y=0;//num res	 	      	   			 	      	   	
						$html.='<tr>';
		 	            $this->Model->getResultados($plan['PK1'],$linea['PK1']);   
		 	            $numresultados = sizeof($this->Model->resultados);
		 	            if($numresultados != 0){		 	            	
							$r=1;           	
							foreach($this->Model->resultados as $resultado){ 		 	    				 	      							    
								$ponred = false;  
								$numperiodos = sizeof($this->Model->periodos);
								if($numperiodos != 0){  
									$valorant=0;//periodo anterior
									$maxvalor = 0;
									$todos = 0;
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
											$ponred = true;
											$todos++;
										} 							    
										$periodos++;
									}
								}
								$color = "";
								$backgraund = "";
								$font = 'font-size:14px;';	
								$color_periodo="";	 	           
								if($todos == $periodos){
									$color = "color: #ec3f35;";
									$color_periodo =  "color: #ec3f35;";
									$backgraund = "background: #EEEEEE;";
								}												
								$rowobjestr = $this->Model->getObjetivoEst($resultado['PK_OESTRATEGICO']);	
								$idobjestr =  intval($rowobjestr['ORDEN']);
								$idobjestr++;
								//Aqui se obtienen los Indicadores por Objetivo estrategico
								$this->Model->getIndicadoresMetasByObjE($resultado['PK1'],$resultado['PK_OESTRATEGICO']);
								$ArrayIndicadoresMetasByObjE = $this->getTextIndicadoresMetasByObje($l,$idobjestr,1);
								$indicadorByObjE = $ArrayIndicadoresMetasByObjE[0];     
								$metaByObjE = $ArrayIndicadoresMetasByObjE[1]; 
								//Aqui se obtienen los Indicadores por Objetivo Táctico
								$this->Model->getIndicadoresMetasByObjT($resultado['PK1']);  
								$ArrayIndicadoresMetasByObjT = $this->getTextIndicadoresMetasByObje($l,$idobjestr,2);
								$indicadorByObjT = $ArrayIndicadoresMetasByObjT[0];     
								$metaByObjT = $ArrayIndicadoresMetasByObjT[1]; 
								
								//$html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;"><strong>Plan</strong></td>';
								$html.='<tr>';
								$html.='<table>';
								 $html.='<td style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  >'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</td>';        	
								 $html.='<td style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  "   colspan="1">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</td>';        	
								 $html.='<td style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  "  colspan="1">'.$l.'.-'.htmlentities($linea['LINEA'], ENT_QUOTES, "ISO-8859-1").'</td>';  	    		 	            	    
								$html.='<td  width="8%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " colspan="1">'.$l.'.'.$idobjestr.':'.htmlentities($rowobjestr['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>';		 	    
								 $html.='<td  width="8%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " colspan="1">'.$metaByObjE.'</td>';   
								
								$html.='<td  width="50%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.' " colspan="1">'.$l.'.'.$r++.':'.htmlentities($resultado['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>';				
								//$html.='<td  width="8%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " colspan="1">'.$indicadorByObjT.'</td>';
								$html.='<td  width="8%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " colspan="1">'.$metaByObjT.'</td>'; 
								//$html.='<td  width="50%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.' " colspan="1">'.$this->Model->getResponsable($resultado['PK_RESPONSABLE']).'</td>';	 	 	
								$numperiodos = sizeof($this->Model->periodos);
								if($numperiodos != 0){
									$z=0;           	
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
									   if(($maxvalor == 0 || $maxvalor == '0') && $todos != $periodos){							
											$color_periodo = "color: #ec3f35;";
										   // $font = "font-size:14px;";	
									   }else if($todos != $periodos){
											$color_periodo = "";
									   }		 	       
									   $html.='<td  width="4%" colspan="" style="text-align: center; border:1px #999999 solid; '.$font.' '.$color_periodo.'  '.$backgraund.'">'.round($maxvalor,2).' %</td>';         
									   $this->Model->getComentariosResultadoPeriodo($resultado['PK1'],$periodo['PK1']);
									   $numcomentarios = sizeof($this->Model->comentariosp); 
									   $z++;
									}
									$html.='</table>';
									$html.='</tr>';
								}
								$y++;
							}//END RESULTADOS
						}            
						
					}
				}*/
			}
		}		
	}	
    function Reporte_Excel(){
		
		$this->Model->getPlanes($_GET['nodos'],$_GET['anos']);
		$html='<div class="datagrid" style="overflow-x:auto;"';
		$html.='<table style="width: 150%;">';
		$numplanes = sizeof($this->Model->planes); 
		 if($numplanes != 0){
		 	 
		 	  $html.='<thead><tr>';
		 	  //$html.='<th>CLAVE</th>';
			  
					$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">PLAN OPERATIVO</th>';
					$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="3">ESTADO</th>';
					$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="2">CENTRO</th>';  
				
		 	  $html.='</tr>';
		 	
		 	$i=1;
		 	$j=1;
		 	  foreach($this->Model->planes as $plan){
		 	$html.='<tr>';
		 	//$html.='<th>'.$plan['PK1'].'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="3">'.$this->EtiquetaEstado($plan['PK1'],trim($plan['ESTADO'])).'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="2">'.$plan['PK_JERARQUIA'].'</th>';
		 	$html.='</tr></thead>';
			////////////
			$html.='<tr><td>';
			$html.='<table><thead>';
    		$html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;"><strong>Plan</strong></td>';
            $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="5%"><strong>L&iacute;nea</strong></td>';
            $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="8%"><strong>Objetivo Estrat&Eacute;gico</strong></td>';
            //$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="8%"><strong>Meta 2024</strong></td>';
            $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="5%"><strong>Resultado</strong></td>';
            $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="5%"><strong>Indicador Anual</strong></td>';
        	$html.='</thead>';
			$html.='</table>';
			$html.='</td>';
			$html.='<td>';
			$html.='<table><thead>';
    		$html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;"><strong>Meta Anual</strong></td>';
            //$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="5%">Responsable</strong></td>';
            $this->Model->getPeriodos($plan['PK1']);   
		 	$numperiodos = sizeof($this->Model->periodos);
		 	if($numperiodos != 0){
				foreach($this->Model->periodos as $periodo){		 	            				 	            
					if($numperiodos<4){
						$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="8%"><strong>'.htmlentities($periodo['PERIODO'], ENT_QUOTES, "ISO-8859-1").'</strong></td>';
					}else if($numperiodos==4){
						$html.='</thead>';
						$html.='</table>';
						$html.='</td>';
						$html.='<td>';
						$html.='<table><thead>';
						$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="8%"><strong>'.htmlentities($periodo['PERIODO'], ENT_QUOTES, "ISO-8859-1").'</strong></td>';
					} else if($numperiodos>4){
						$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="8%"><strong>'.htmlentities($periodo['PERIODO'], ENT_QUOTES, "ISO-8859-1").'</strong></td>';
					}
					//$html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="4%" ><strong>'.htmlentities($periodo['PERIODO'], ENT_QUOTES, "ISO-8859-1").'</strong></td>'; 		
		 	    } 	
				$html.='</thead>';
				$html.='</table>';
				$html.='</td>';
				$html.='</tr>';
		 	}   
			$html.='</tr></table>';			
			      /////////////////////
		 	      $this->Model->getLineas($plan['PK_PESTRATEGICO']);
		 	      $numlineas = sizeof($this->Model->lineas);
		 	      if($numlineas != 0){
		 	      	   $l=1;
		 	      	  
		 	      	   foreach($this->Model->lineas as $linea){		 	      	   	
		 	      	   	
		 	      	   $promedio = 0;
		 	      	   $porcentaje = 0;
		 	      	   $periodoColumn = 0;	
		 	      	   	 	      	   
			 	       $array_porcentajes = array(); 
			 	       $array_porcentajes_sum = array();		 	            	
		 	      	   $y=0;//num res	 	      	   	
		 	      	   	
		 	      	   $html.='<tr>';		 	      	  
		 	      	   	
		 	            $this->Model->getResultados($plan['PK1'],$linea['PK1']);   
		 	            $numresultados = sizeof($this->Model->resultados);
		 	            
		 	            if($numresultados != 0){		 	            	
		 	             $r=1;           	
		 	             foreach($this->Model->resultados as $resultado){ 		 	    				 	      							    
				 	    $ponred = false;  
		 	            $numperiodos = sizeof($this->Model->periodos);
		 	            if($numperiodos != 0){  
		 	            
			 	            $valorant=0;//periodo anterior
			 	            $maxvalor = 0;
		 	                $todos = 0;
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
								$ponred = true;
								$todos++;
							    } 
							    
							    $periodos++;
							    
							            
		 	                 }
		 	            }
		 	              
		 	            
		 	            $color = "";
		 	            $backgraund = "";
		 	            $font = 'font-size:14px;';	
		 	            $color_periodo="";	 	           
		 	            if($todos == $periodos){
					      $color = "color: #ec3f35;";
					      $color_periodo =  "color: #ec3f35;";
		 	            $backgraund = "background: #EEEEEE;";
							
						}												
		 	            	   
					$rowobjestr = $this->Model->getObjetivoEst($resultado['PK_OESTRATEGICO']);	
					$idobjestr =  intval($rowobjestr['ORDEN']);
					$idobjestr++;
								
				//Aqui se obtienen los Indicadores por Objetivo estrategico
				$this->Model->getIndicadoresMetasByObjE($resultado['PK1'],$resultado['PK_OESTRATEGICO']);
				$ArrayIndicadoresMetasByObjE = $this->getTextIndicadoresMetasByObje($l,$idobjestr,1);
				$indicadorByObjE = $ArrayIndicadoresMetasByObjE[0];     
				$metaByObjE = $ArrayIndicadoresMetasByObjE[1]; 
				//Aqui se obtienen los Indicadores por Objetivo Táctico
				$this->Model->getIndicadoresMetasByObjT($resultado['PK1']);  
				$ArrayIndicadoresMetasByObjT = $this->getTextIndicadoresMetasByObje($l,$idobjestr,2);
				$indicadorByObjT = $ArrayIndicadoresMetasByObjT[0];     
				$metaByObjT = $ArrayIndicadoresMetasByObjT[1]; 
				
				//$html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;"><strong>Plan</strong></td>';
				$html.='<tr><td>';
				$html.='<table>';
				$html.='<td style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  ">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</td>';        	             	    
 $html.='<td style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " width="5%" colspan="">'.$l.'.-'.htmlentities($linea['LINEA'], ENT_QUOTES, "ISO-8859-1").'</td>';  	                 	    
$html.='<td  width="8%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " colspan="">'.$l.'.'.$idobjestr.':'.htmlentities($rowobjestr['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>';
 $html.='<td  width="5%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.' " colspan="">'.$l.'.'.$r++.':'.htmlentities($resultado['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>'; 	
 $html.='<td  width="8%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " colspan="">'.$indicadorByObjT.'</td>';
 $html.='<td  width="8%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " colspan="">'.$metaByObjT.'</td>'; 
		 	     /*$html.='<td style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  >'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</td>';        	
		 	     $html.='<td style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  "   colspan="1">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</td>';        	
		 	     $html.='<td style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  "  colspan="1">'.$l.'.-'.htmlentities($linea['LINEA'], ENT_QUOTES, "ISO-8859-1").'</td>';  	    		 	            	    
		 	    $html.='<td  width="8%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " colspan="1">'.$l.'.'.$idobjestr.':'.htmlentities($rowobjestr['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>';		 	    
		 	    //$html.='<td  width="8%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " colspan="1">'.$indicadorByObjE.'</td>';
				 $html.='<td  width="8%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " colspan="1">'.$metaByObjE.'</td>';   
				$html.='<td  width="50%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.' " colspan="1">'.$l.'.'.$r++.':'.htmlentities($resultado['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>';				
				//$html.='<td  width="8%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " colspan="1">'.$indicadorByObjT.'</td>';
				$html.='<td  width="8%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " colspan="1">'.$metaByObjT.'</td>'; 
				//$html.='<td  width="50%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.' " colspan="1">'.$this->Model->getResponsable($resultado['PK_RESPONSABLE']).'</td>';	 	 	
				*/

			
		 	           // $this->Model->getPeriodos($plan['PK1']);   
		 	            $numperiodos = sizeof($this->Model->periodos);
		 	            if($numperiodos != 0){
		 	            	
		 	            	$z=0;           	
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
		 	       
			 	       if(($maxvalor == 0 || $maxvalor == '0') && $todos != $periodos){							
						    $color_periodo = "color: #ec3f35;";
			 	           // $font = "font-size:14px;";	
					   }else if($todos != $periodos){
					        $color_periodo = "";
					   }		 	       
		 	           $html.='<td  width="4%" colspan="" style="text-align: center; border:1px #999999 solid; '.$font.' '.$color_periodo.'  '.$backgraund.'">'.round($maxvalor,2).' %</td>';         

		 	           $this->Model->getComentariosResultadoPeriodo($resultado['PK1'],$periodo['PK1']);
		 	            $numcomentarios = sizeof($this->Model->comentariosp); 

		 	           $z++;

		 	                 }
		 	                 $html.='</table>';
				$html.='</tr>';
		 	                 $html.='</tr>';
		 	            	
		 	            	}
		 	           
		 	            $y++;//
		 	           	
		 	      	    }//END RESULTADOS
		 	                     
		 	           }            
		 	            $html.='<tr><td>';
					  $html.='<table>';
				
		 	      	  // $html.='<tr>';		 
		 	           $html.='<td style="border:1px #999999 solid; background:#663300; color:#FFFFFF;" width="10%">Total L&iacute;nea '.$l.'</td>';
		 	           $html.='<td style="border:1px #999999 solid; background:#663300; color:#333;" width="10%"></td>';
					   $html.='<td style="border:1px #999999 solid; background:#663300; color:#333;" width="10%"></td>';
					   $html.='<td style="border:1px #999999 solid; background:#663300; color:#333;" width="10%"></td>';
					   $html.='<td style="border:1px #999999 solid; background:#663300; color:#333;" width="10%"></td>';
					   $html.='<td style="border:1px #999999 solid; background:#663300; color:#333;" width="10%"></td>';
					   //$html.='<td style="border:1px #999999 solid; background:#663300; color:#333;" width="10%"></td>';					   
					   //$html.='<td style="border:1px #999999 solid; background:#663300; color:#333;" width="10%"></td>';					   
					   //$y = Resultados
					   if($y>0){					   	
					  //calculo suma 00 10 20 30 ... | 01 11 21 31 ... |   02 12 22 32...; $y: resultados; $z: periodos  
						      for($i=0;$i<$z;$i++){//periodos (columnas)										
									   $suma = 0;										
										 for($j=0;$j<$y;$j++){//resultados (fila)					 	
										    $suma += $array_porcentajes[$j][$i];									
									     }									
										$array_porcentajes_sum[] = $suma;
							  }				   	
					   }	   
		 	            $numperiodos = sizeof($this->Model->periodos);
		 	            if($numperiodos != 0){		 	            	
		 	            	$x=0;		 	            	
		 	            	foreach($this->Model->periodos as $periodo){ 			 	             	            
				 	          
				 	          if($y>0){ $promedio = $array_porcentajes_sum[$x] / $y;  }
				 	          else{	$promedio = 0; }//Sin Resultados
				 	                       
		 	            
		 	             $html.='<td  style="text-align: center; border:1px #999999 solid; background:#663300; color:#FFFFFF;" width="4%" colspan=""><strong>'.round($promedio,2).' %</strong></td>';
		 	             //$html.='<td  width="10%" style="border:1px #999999 solid; background:#663300; color:#333;" colspan=""></td>';
		 	           $x++;
		 	           
					        }
					   
					   }	   
		 	            //$html.='</tr>';
						$html.='</table>';
		 	      	   	 $html.='</td></tr>';
				
		 	      	   	$l++; 
		 	      	   	
		 	      	   	}//end linea
		 	      	   
		 	      }else{
				  	 $html.='<tr><td colspan="5" style="border:1px #999999 solid; background:#CCC; color:#333;"><div class="empty_results">NO ESTA INSCRITO(A) EN UN PLAN OPERATIVO</div></td></tr>';

				  }
				  $html.='</table></td></tr>';
				  	//$html.='</tr>';
		 
		      }
		      $html.='</thead>';
		 }
		
		$html.='</div></table>';
		echo $html;
	}
	function Reporte(){
		$this->Model->getPlanes($_GET['nodos'],$_GET['anos']);
		$html='<div class="datagrid" style="overflow-x:auto;">';
		$html.='<table style="width: 135%;">';
		$numplanes = sizeof($this->Model->planes); 
		
		 if($numplanes != 0){
			$html.='<thead><tr>';
			$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">PLAN OPERATIVO</th>';
			$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">ESTADO</th>';
			$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">CENTRO</th>  ';
			$html.='</tr>';
		 	
		 	$i=1;
		 	$j=1;
			  
		 	  foreach($this->Model->planes as $plan){
		 	$html.='<tr>';
		 	//$html.='<th>'.$plan['PK1'].'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" width="26.4%">'.$this->EtiquetaEstado($plan['PK1'],trim($plan['ESTADO'])).'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" width="20.4%">'.$plan['PK_JERARQUIA'].'</th>';
		 	$html.='</tr>';
		 	
			//$html.='<tr colspan="5"><table style="width: 100.7%;">';	
			$html.='<tr><table style="width: 135%;">';	
		 	//$html.='<tr><table style="width: 150%;">';			 	
			
		 	$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="20%"><strong>Plan</td></strong>';
		 	$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="25%"><strong>L&iacute;nea</strong></td>';
			$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="25%"><strong>Objetivo Estrat&eacute;gico</strong></td>';
//			$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="5%"><strong>Indicador 2024</strong></td>';
	//		$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="11.4%"><strong>Meta 2024</strong></td>';
			$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="18%"><strong>Resultado</strong></td>';	
			$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="8%"><strong>Indicador Anual</strong></td></td>';	
			//$html.='<tr><td colspan="5"><table style="width: 50%;">';	
			$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="12%"><strong>Meta Anual</strong></td>';
		// 	$html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="8.2%" ><strong>Responsable del Resultado</strong></td>';
		 	
		 	$this->Model->getPeriodos($plan['PK1']);   
		 	$numperiodos = sizeof($this->Model->periodos);
		 	if($numperiodos != 0){
				foreach($this->Model->periodos as $periodo){		 	            				 	      
					$html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="10%"  ><strong>'.htmlentities($periodo['PERIODO'], ENT_QUOTES, "ISO-8859-1").'</strong></td>'; 		
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
			 	       $array_porcentajes = array(); 
			 	       $array_porcentajes_sum = array();		 	            	
		 	      	   $y=0;//num res	 	      	   	
		 	      	   $html.='<tr>';		 	      	  
		 	            $this->Model->getResultados($plan['PK1'],$linea['PK1']);   
		 	            $numresultados = sizeof($this->Model->resultados);
		 	            if($numresultados != 0){		 	            	
							$r=1;           	
							foreach($this->Model->resultados as $resultado){ 		 	    				 	      
								$ponred = false;  
								$numperiodos = sizeof($this->Model->periodos);
								if($numperiodos != 0){  
									$valorant=0;//periodo anterior
									$maxvalor = 0;
									$todos = 0;
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
										$ponred = true;
										$todos++;
										} 
										$periodos++;
									}
								}
								$color = "";
								$backgraund = "";
								$font = 'font-size:14px;';	
								$color_periodo="";	 	           
								if($todos == $periodos){
								  $color = "color: #ec3f35;";
								  $color_periodo =  "color: #ec3f35;";
								$backgraund = "background: #EEEEEE;";
								}												
								$rowobjestr = $this->Model->getObjetivoEst($resultado['PK_OESTRATEGICO']);	
								$idobjestr =  intval($rowobjestr['ORDEN']);
								$idobjestr++;
								
								//Aqui se obtienen los Indicadores por Objetivo estrategico
								$this->Model->getIndicadoresMetasByObjE($resultado['PK1'],$resultado['PK_OESTRATEGICO']);
								$ArrayIndicadoresMetasByObjE = $this->getTextIndicadoresMetasByObje($l,$idobjestr,1);
								$indicadorByObjE = $ArrayIndicadoresMetasByObjE[0];     
								$metaByObjE = $ArrayIndicadoresMetasByObjE[1]; 
								//Aqui se obtienen los Indicadores por Objetivo Táctico
								$this->Model->getIndicadoresMetasByObjT($resultado['PK1']);  
								$ArrayIndicadoresMetasByObjT = $this->getTextIndicadoresMetasByObje($l,$idobjestr,2);
								$indicadorByObjT = $ArrayIndicadoresMetasByObjT[0];     
								$metaByObjT = $ArrayIndicadoresMetasByObjT[1]; 
								$html.='<td style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  ">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</td>';        	             	    
 $html.='<td style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " width="5%" colspan="">'.$l.'.-'.htmlentities($linea['LINEA'], ENT_QUOTES, "ISO-8859-1").'</td>';  	                 	    
$html.='<td  width="8%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " colspan="">'.$l.'.'.$idobjestr.':'.htmlentities($rowobjestr['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>';
 $html.='<td  width="5%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.' " colspan="">'.$l.'.'.$r++.':'.htmlentities($resultado['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>'; 	
 $html.='<td  width="8%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " colspan="">'.$indicadorByObjT.'</td>';
 $html.='<td  width="8%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " colspan="">'.$metaByObjT.'</td>'; 
								$numperiodos = sizeof($this->Model->periodos);
		 	            if($numperiodos != 0){
		 	            	$z=0;           	
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
						   if(($maxvalor == 0 || $maxvalor == '0') && $todos != $periodos){							
								$color_periodo = "color: #ec3f35;";
							   // $font = "font-size:14px;";	
						   }else if($todos != $periodos){
								$color_periodo = "";
						   }		 	       
		 	           $html.='<td  width="4%" colspan="" style="text-align: center; border:1px #999999 solid; '.$font.' '.$color_periodo.'  '.$backgraund.'">'.round($maxvalor,2).' %</td>';         
		 	           
		 	           $this->Model->getComentariosResultadoPeriodo($resultado['PK1'],$periodo['PK1']);
		 	            $numcomentarios = sizeof($this->Model->comentariosp); 
		 	           $z++;
		 	                 }
		 	                 $html.='</tr>';
		 	            	}
		 	            $y++;//
		 	      	    }//END RESULTADOS
  
		 	           }            
		 	                         
		 	      	   		 	      	   	
		 	      	   $html.='<tr>';		 
		 	           $html.='<td style="border:1px #999999 solid; background:#663300; color:#FFFFFF;" width="10%">Total L&iacute;nea '.$l.'</td>';
		 	           //$html.='<td style="border:1px #999999 solid; background:#663300; color:#333;" width="10%"></td>';
					   //$html.='<td style="border:1px #999999 solid; background:#663300; color:#333;" width="10%"></td>';
					   //$html.='<td style="border:1px #999999 solid; background:#663300; color:#333;" width="10%"></td>';						   					   
					   $html.='<td style="border:1px #999999 solid; background:#663300; color:#333;" width="10%"></td>';
					   $html.='<td style="border:1px #999999 solid; background:#663300; color:#333;" width="10%"></td>';
					   $html.='<td style="border:1px #999999 solid; background:#663300; color:#333;" width="10%"></td>';						   					   
					   $html.='<td style="border:1px #999999 solid; background:#663300; color:#333;" width="10%"></td>';
					   $html.='<td style="border:1px #999999 solid; background:#663300; color:#333;" width="10%"></td>';						   					   
					   //$y = Resultados
					   if($y>0){					   	
					  //calculo suma 00 10 20 30 ... | 01 11 21 31 ... |   02 12 22 32...; $y: resultados; $z: periodos  
						      for($i=0;$i<$z;$i++){//periodos (columnas)										
									   $suma = 0;										
										 for($j=0;$j<$y;$j++){//resultados (fila)					 	
										    $suma += $array_porcentajes[$j][$i];									
									     }									
										$array_porcentajes_sum[] = $suma;
							  }				   	
					   }	   
		 	                    
					  
		 	            $numperiodos = sizeof($this->Model->periodos);
		 	            if($numperiodos != 0){		 	            	
		 	            	$x=0;		 	            	
		 	            	foreach($this->Model->periodos as $periodo){ 			 	             	            
				 	          
				 	          if($y>0){ $promedio = $array_porcentajes_sum[$x] / $y;  }
				 	          else{	$promedio = 0; }//Sin Resultados
				 	                       
		 	            
		 	             $html.='<td  style="text-align: center; border:1px #999999 solid; background:#663300; color:#FFFFFF;" width="4%" colspan=""><strong>'.round($promedio,2).' %</strong></td>';
		 	             //$html.='<td  width="10%" style="border:1px #999999 solid; background:#663300; color:#333;" colspan=""></td>';
		 	           $x++;
		 	           
					        }
					   
					   }	   
		 	            $html.='</tr>';
		 	      	   	 
		 	      	   	$l++; 
		 	      	   	
		 	      	   	}//end linea
		 	      	   
		 	      }else{
				  	 $html.='<tr><td colspan="5" style="border:1px #999999 solid; background:#CCC; color:#333;"><div class="empty_results">NO ESTA INSCRITO(A) EN UN PLAN OPERATIVO</div></td></tr>';
		 	      	  
				  	
				  }
				  $html.='</table></td></tr>';
				  	//$html.='</tr>';
		 
		      }
		      $html.='</thead>';
		      
		 }
		
		$html.='</div></table>';
	
		echo $html;
	}
	
	function getTextIndicadoresMetasByObje($numL,$numObjE,$tipo){
		$arrayInd = array();
		$indicadores= "";
		$metas="";		
		switch ($tipo) {
			case 1:
				foreach($this->Model->indicadoresMetasByObjE as $indi){ 
					$indicadores .= $numL.'.'.$numObjE.'.'.(intval($indi['ORDEN'])+1).':'.htmlentities($indi['INDICADOR'], ENT_QUOTES, "ISO-8859-1").'</br>';
					$metas .= $numL.'.'.$numObjE.'.'.(intval($indi['ORDEN'])+1).':'.htmlentities($indi['META'], ENT_QUOTES, "ISO-8859-1").'</br>';
				}
			break;
			case 2:
				foreach($this->Model->indicadoresMetasByObjT as $indi){ 
					$indicadores .= $numL.'.'.$numObjE.'.'.(intval($indi['ORDEN'])).':'.htmlentities($indi['INDICADOR'], ENT_QUOTES, "ISO-8859-1").'</br>';
					$metas .= $numL.'.'.$numObjE.'.'.(intval($indi['ORDEN'])).':'.htmlentities($indi['META'], ENT_QUOTES, "ISO-8859-1").'</br>';
				}		
			break;
		}
		array_push($arrayInd,$indicadores,$metas);
		return $arrayInd;
	}
	
	
}