<?php
include "models/planesoperativo/reportes/evidencias.model.php";
include "libs/resizeimage/class.upload.php";


class evidencias {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $nodoprincipal;
	var $image;
	var $targetPathumbail;
	

	function evidencias() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("filtro",TRUE);
	 $this->nodoprincipal = new Niveles("option");
	 $this->Model = new evidenciasModel();
		
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
		
	   //	if($this->passport->privilegios->hasPrivilege('P12')){
		$this->loadContent();
	/*	}else{
		$this->error();
		}*/
		$this->loadFooter();
		$this->View->viewPage();
		
	 }
	 
	 
	  function loadHeader(){
	  $section = TEMPLATE.'sections/header.tpl';
	  $section = $this->View->loadSection($section);
	 $nombre = $_SESSION['session']['titulo'].' '.htmlentities($_SESSION['session']['nombre']).' '.htmlentities($_SESSION['session']['apellidos']);
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
	 	
		$contenido = $this->View->Template(TEMPLATE.'modules/reportes/po/EVIDENCIAS.TPL');
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
		 	
		 //	$html.='<th>'.$plan['PK1'].'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.$this->EtiquetaEstado($plan['PK1'],trim($plan['ESTADO'])).'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.$plan['PK_JERARQUIA'].'</th>';
		 	$html.='</tr>';
		 	
		 	$html.='<tr><td colspan="3"><table>';
		 	
		 	$html.='<tr>';
		 	
		 	
		 	          $html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;"   width="20%"><strong>Plan</td></strong>';
		 	
		 	      
		 	           $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="20%"><strong>L&iacute;nea</strong></td>';
		 	           $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="20%" ><strong>Objetivo Estrat&Eacute;gico</strong></td>';		 	          
		 	           $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="20%"><strong>Resultado</strong></td>';
		 	           $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="10%"><strong>Responsable del Resultado</strong></td>';
		 			 //  $html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="20%"><strong>Medios</strong> </td>';
		 			 //  $html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="10"><strong>Responsable del Medio</strong></td>';
		 			   $html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="10"><strong># Evidencias Propuestas</strong></td>';
		 			   $html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="10"><strong># Evidencias Subidas</strong></td>';
		 			   $html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="10"><strong>% de Avance de Evidencias</strong></td>';
		 			   
		 			   
		 			   
		 	           
		 	           $html.='</tr>';
		 	 
		 	
		 	
		 	      $this->Model->getLineas($plan['PK_PESTRATEGICO']);
		 	      $numlineas = sizeof($this->Model->lineas);
		 	      if($numlineas != 0){
		 	      	 $l=1;
		 	      	   foreach($this->Model->lineas as $linea){
		 	                     
		 	            $this->Model->getResultados($plan['PK1'],$linea['PK1']);   
		 	            $numresultados = sizeof($this->Model->resultados);
		 	            if($numresultados != 0){
		 	            		$r=1;
		 	            	       foreach($this->Model->resultados as $resultado){
		 	            
		 	           //  $this->Model->getEvidencias($plan['PK1'],$linea['PK1'],$resultado['PK1']); 
		 	           //  $numevidencias = sizeof($this->Model->evidencias);
		 	             
		 	             $rowobjestr = $this->Model->getObjetivoEst($resultado['PK_OESTRATEGICO']);
		 	             $idobjestr =  intval($rowobjestr['ORDEN']);
		                 $idobjestr++;
		 	             		 	             
		 	             
		 	             
		 	             $numevidenciaP =$this->Model->getNumeroEvidenciasP($plan['PK1'],$linea['PK1'],$resultado['PK1']); 
		 	             $numevidenciaS =$this->Model->getNumeroEvidenciasS($plan['PK1'],$linea['PK1'],$resultado['PK1']);                     
		 	             $porcentaje = 0;
		 	             if($numevidenciaP != 0){
						 	$porcentaje = ($numevidenciaS * 100)/$numevidenciaP;
						 }
		 	             
		 	             
		 	            $ponred = false;             
		 	            
		 	             if( $numevidenciaP == '0' || $numevidenciaS == '0' || $porcentaje == '0'){								
								$ponred = true;
							} 
		 	               
		 	            $color = "";
		 	            $backgraund = "";
		 	            if($ponred == true){
					      $color = "color: #ec3f35;";
		 	            $backgraund = "background: #EEEEEE;";
							
						}	 	             
		 	          	 	      	  
		 	            
		 	            
		 	            
		 	           /* $this->Model->getMedios($resultado['PK1']);   
		 	            $nummedios = sizeof($this->Model->medios);
		 	            $m = 1;
		 	            if($nummedios != 0){
		 	            	
		 	             foreach($this->Model->medios as $medio){*/
		 	            	         	
		 	            	 	            
		 	        
		 	                       	
		 	               $html.='<tr>';
		 	                  
		 	                   
		 	                   
		 	               $html.='<td style="border:1px #999999 solid; font-size:12px;  '.$color.'  '.$backgraund.' ">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</td>';     
		 	                   
		 	               $html.='<td style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'    ">'.$l.'.'.htmlentities($linea['LINEA'], ENT_QUOTES, "ISO-8859-1").'</td>';
		 	                     
		 	               $html.='<td  width="10%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " colspan="">'.$l.'.'.$idobjestr.':'.htmlentities($rowobjestr['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>';
		 	       
		 	                     
		 	                     
		 	               $html.='<td colspan="" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " >'.$l.'.'.$r.':'.htmlentities($resultado['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>';
		 	                      
		 	                       //RESPONSABLE DE RESULTADO
		 	          $html.='<td  width=""  style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " colspan="">'.htmlentities($this->Model->getResponsable($resultado['PK_RESPONSABLE']), ENT_QUOTES, "ISO-8859-1").'</td>';
		 	          
		 	          
		 	          
		 	           //MEDIO
		 	       //    $html.='<td  width="20%" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  "  colspan="">'.$l.'.'.$r.'.'.$m.': '.htmlentities($medio['MEDIO'], ENT_QUOTES, "ISO-8859-1").'</td>';
		 	         
		 	         //RESPONS DE MEDIO 	    
//$html.='<td  width="10%"  colspan="" style="border:1px #999999 solid; font-size:12px; '.$color.'  '.$backgraund.'  " >'.htmlentities($this->Model->getResponsable($medio['PK_RESPONSABLE']), ENT_QUOTES, "ISO-8859-1").'</td>';
		 	           
		 	          
		 	          $html.='<td  width="10%"   style="text-align: center; border:1px #999999 solid; font-size:14px; '.$color.'  '.$backgraund.'  " colspan="">'.$numevidenciaP.'</td>';		 	          
		 	          
		 	          
		 	          
		 	          $html.='<td  width="10%"  style="text-align: center; border:1px #999999 solid; font-size:14px; '.$color.'  '.$backgraund.'  "  colspan="">'.$numevidenciaS.'</td>';         
		 	           $html.='<td  width="10%"  style="text-align: center; border:1px #999999 solid; font-size:14px; '.$color.'  '.$backgraund.'  " colspan="">'.round($porcentaje, 2).' %</td>';
		 	           
		 	           
		 	                     
		 	            $html.='</tr>';
		 	                       	
		 	                       	
		 	                   //    	}//end EVIDENCIAS
		 	            	       	
		 	            	//}
		 	            	
		 	          // 	$m++;
		 	          //  }//end medios
		 	            
		 	            //}	
		 	            	
		 	            	
		 	            	$r++;
		 	            	
		 	      	    }//END RESULTADOS
		 	                     
		 	           }          
		 	                     
		 	      	   	$l++;
		 	      	   	
		 	      	   	}
		 	      	   
		 	      }else{
				  	 $html.='<tr><td style="border:1px #999999 solid; font-size:12px;" colspan="5"><div class="empty_results">NO ESTA INSCRITO(A) EN UN PLAN OPERATIVO</div></td></tr>';
		 	      	  
				  	
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