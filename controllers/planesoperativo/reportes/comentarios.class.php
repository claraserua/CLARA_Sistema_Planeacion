<?php
include "models/planesoperativo/reportes/comentarios.model.php";



class comentarios {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $nodoprincipal;
	var $image;
	var $targetPathumbail;
	

	function comentarios() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("filtro",TRUE);
	 $this->nodoprincipal = new Niveles("option");
	 $this->Model = new comentariosModel();
		
		
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
	/*	}else{
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
	 	
		$contenido = $this->View->Template(TEMPLATE.'modules/reportes/po/COMENTARIOS.TPL');
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
		$html='<div class="datagrid2"><table>';
		$numplanes = sizeof($this->Model->planes); 
		
		 if($numplanes != 0){
		 	 
		 	  $html.='<tr>';
		 	  
		 
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF; width:40%">PLAN OPERATIVO</th>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF; width:20%">ESTADO</th>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF; width:40%">CENTRO</th>';
		 	  $html.='</tr>';
		 	
		 	$i=1;
		 	$j=1;
		 	  foreach($this->Model->planes as $plan){
		 	$html.='<tr>';
		 	
		 
		 $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.$this->EtiquetaEstado($plan['PK1'],trim($plan['ESTADO'])).'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.$plan['PK_JERARQUIA'].'</th>';
		 	$html.='</tr>';
		 	
		 	
		 	$html.='<tr><td colspan="3">';
		 	
		 	
		 	//______________________________________________________________________________
		 	$html.='<table>';
		 	
		 	$this->Model->getPeriodos($plan['PK1']); 
		 	$numperiodos = sizeof($this->Model->periodos);	
		 	//$numceldasfijas=4;
		 //	$varcolspan2 = $numceldasfijas+$numperiodos;	 	
		 	//$varcolspan= 9/$numperiodos;
		 	//$varcolspan = round($varcolspan);
		 	$varcolspan = 2;
		 	
		 	
		 	
		 	$html.='<tr><td colspan="9" style="border:1px #999999 solid; background:#CCC; color:#333;" align="center" width="100%" ><strong>Reporte Comentarios CENTRO</strong></td></tr>';
		 	
		 	
		 	$html.='<tr>';
		 	 
		 	 
		      $i=1;		 	
		 	   if($numperiodos != 0){
		 	     foreach($this->Model->periodos as $periodo){		 	            		
		 	           
		 	        if($i==4){$varcolspan = 3;}  
		 	        
		 	        $i++; 
		 	            
		 	     $html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;" width="25%" colspan="'.$varcolspan.'"><strong>Resumen ejecutivo '.htmlentities($periodo['PERIODO'], ENT_QUOTES, "ISO-8859-1").'</strong></td>';	
		 	     	      		 	           
		 	         } 	
		 	    }
		 	
		 	$html.='</tr>';
		 		
		 		
		 		
		 		$html.='<tr>';
		 	 		
			 
		 
		 	 if($numperiodos != 0){
		 	 	
		 	 	$varcolspan = 2;
		 	 	$j=1;
		 	     foreach($this->Model->periodos as $periodo){
		 	     
		 	     	
		 	    
		 	     	$this->Model->getComentariosResumenSeguimiento($plan['PK1'],$periodo['PK1']);
		            $numcomentarios = sizeof($this->Model->comentarios); 
					
					if($numcomentarios != 0){
					
					
					 if($j==4){$varcolspan = 3;}  
		 	        
		 	        
					
					    $comejec=1; 
		 	           	$html.='<td  width="25%" colspan="'.$varcolspan.'" class="oldtd3" style="border:1px #999999 solid; font-size:12px;" >';//colspan = 4
					
						foreach($this->Model->comentarios as $rowcomentarios)
						{
							
							
							$rowusuario	= $this->Model->getImagen($rowcomentarios['PK_USUARIO']);	
							//$imagen =  "media/usuarios/".$rowusuario['IMAGEN'];
							//  $usuario = $this->Model->getResponsable($comentario['PK_USUARIO']);  
							
		$usuario = '<span><font color="black"><strong>'.htmlentities($rowusuario["NOMBRE"]."".$rowusuario["APELLIDOS"], ENT_QUOTES, "ISO-8859-1").'</strong></font></span>';
							 
							
							 $html.="\n ".$usuario.'         '.$comejec++.'.'.htmlentities($rowcomentarios['COMENTARIO'], ENT_QUOTES, "ISO-8859-1")."\n";
							
														
							
							
 						}
 						 $html.='</td>';     			
 						
 					}else{
 						
 						 if($j==4){$varcolspan = 3;}  
 						
					 	$html.='<td  width="25%" style="border:1px #999999 solid; font-size:12px;" colspan="'.$varcolspan.'" align="center">No Existen Comentarios </td>';
					 //	break;
					 	
					 }  		 	            		
		 	            
		 	  $j++; 
		 	     	
		 	     	      		 	           
		 	         } 	
		 	    }
		 	    
		 	    $html.='</tr>';
		 	
		 		
		 	$html.='</table>';
		 	//_____-_____-_____-_____-_____-_____-_____-_____-_____-_____-_____-_____-
		 	
		 	$numceldasfijas=4;
		 	$varcolspan2 = $numceldasfijas+$numperiodos;
		    $numceline = 8/ $varcolspan2;
		 	$numceline = round($numceline);	
		 	
		 	$html.='</td></tr><tr><td colspan="8"><table ><tr>';
		 	
		 	
		 	
		 		$html.='<td  style="border:1px #999999 solid; background:#CCC; color:#333;"  ><strong>Plan</td></strong>';
		 			 
		 	$html.='<th style="border:1px #999999 solid; background:#CCC; color:#333;" width="300px" colspan="'.$numceline.'">L&iacute;nea</th>';
		    $html.='<th  style="border:1px #999999 solid; background:#CCC; color:#333;" width="300px" colspan="'.$numceline.'">Objetivo Estrategico</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#CCC; color:#333;" width="150px" colspan="'.$numceline.'">Resultado</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#CCC; color:#333;" width="150px" colspan="'.$numceline.'"><strong>Responsable del Resultado</strong></th>';		 	
		 	
		  
		 	$numperiodos = sizeof($this->Model->periodos);
		 	   if($numperiodos != 0){
		 	     foreach($this->Model->periodos as $periodo){		 	            		
		 	            
		 	     $html.='<th width="150px" style="border:1px #999999 solid; background:#CCC; color:#333;" colspan="'.$numceline.'" >Comentarios '.htmlentities($periodo['PERIODO'], ENT_QUOTES, "ISO-8859-1").'</th>';	
		 	     	      		 	           
		 	         } 	
		 	}
		 		 	
		 	$html.='</tr>';
		 	
		 	
		 
		 	        
		 	      
		 	      $this->Model->getLineas($plan['PK_PESTRATEGICO']);
		 	      $numlineas = sizeof($this->Model->lineas);
		 	      if($numlineas != 0){
		 	      	   $l=1;
		 	      	   foreach($this->Model->lineas as $linea){
		 	      	   	
		 	      	  $html.='<tr>';
		 	      	
		 	           		 	      	   	
		 	      	   	
		 	            $this->Model->getResultados($plan['PK1'],$linea['PK1']);   
		 	            $numresultados = sizeof($this->Model->resultados);
		 	            if($numresultados != 0){
		 	            	
		 	            	$r=1;
		 	            	
		 	              foreach($this->Model->resultados as $resultado){ 	            	       	
		 	            	    
		 	            	    
		 	           
				 	     		 	      	 	      	   	    
		 	            	   
		 	            	$rowobjestr = $this->Model->getObjetivoEst($resultado['PK_OESTRATEGICO']);
		 	            	
		 	            	$idobjestr =  intval($rowobjestr['ORDEN']);
		                    $idobjestr++;
		 	            	   							 
		 	        
		 	        $html.='<td style="border:1px #999999 solid; font-size:12px;">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</td>'; 
		 	        
		 	        
		 	         $html.='<td style="border:1px #999999 solid; font-size:12px;" width="300px" colspan="'.$numceline.'">'.$l.'.-'.htmlentities($linea['LINEA'], ENT_QUOTES, "ISO-8859-1").'</td>';
		 	            	    
		 	            	    
		 	       $html.='<td  style="border:1px #999999 solid; font-size:12px;" width="300px" colspan="'.$numceline.'">'.$l.'.'.$idobjestr.':'.htmlentities($rowobjestr['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>';
		 	       
		 	       
		 	       
		 	        $html.='<td   style="border:1px #999999 solid; font-size:12px;" width="150px" colspan="'.$numceline.'">'.$l.'.'.$r++.':'.htmlentities($resultado['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>';
		 	       
		 	      
		 	         
		 	         
		 	           //RESPONSABLE DE RESULTADO
		 	          $html.='<td  style="border:1px #999999 solid; font-size:12px;" width="150px" colspan="'.$numceline.'">'.htmlentities( $this->Model->getResponsable( $resultado['PK_RESPONSABLE']), ENT_QUOTES, "ISO-8859-1").'</td>';
		 	         
		 	          
		 	       
		 	         
		 	                    
		 	            $this->Model->getPeriodos($plan['PK1']);   
		 	            $numperiodos = sizeof($this->Model->periodos);
		 	            if($numperiodos != 0){
		 	            	foreach($this->Model->periodos as $periodo){
		 	            
		 	            
		 	          	           
		 	           $this->Model->getComentariosResultadoPeriodo($resultado['PK1'],$periodo['PK1']);
		 	           $numcomentarios = sizeof($this->Model->comentariosp); 
					
					if($numcomentarios != 0){
						$countcom=1; 
		 	           	$html.='<td width="" style="border:1px #999999 solid; font-size:12px;" colspan="'.$numceline.'">';
		 	          	foreach($this->Model->comentariosp as $comentario)
						{
							//$espacios=array(" ");
							//$fecha = str_replace(array(" "),"&nbsp;",$comentario['FECHA_R']);
							$fecha = $comentario['FECHA_R'];
							
							$usuario = $this->Model->getResponsable($comentario['PK_USUARIO']);
							
							$responfech = '<span><font color="black"><strong>'.htmlentities($usuario, ENT_QUOTES, "ISO-8859-1").'         '.$fecha->format('Y-m-d').'</strong></font></span>';
							$str_comentario = htmlentities($comentario['COMENTARIO'], ENT_QUOTES, "ISO-8859-1");
							
							//$html.="<p> ".$responfech.'         '.$countcom++.'.'.." </p>";
							
							$html.= " $responfech $countcom.$str_comentario   <br style=\"mso-data-placement:same-cell;\" /> <br style=\"mso-data-placement:same-cell;\" />";
							$countcom++;
						}
						$html.='</td>';
					}else{
						$html.='<td  width="" style="border:1px #999999 solid; font-size:12px;" colspan="'.$numceline.'"></td>';
					}  
		 	           
		 	        
		 	           
		 	                 }
		 	                 
		 	                 $html.='</tr>';
		 	            	
		 	            	}
		 	           
		 	           
		 	           
		 	           
		 	           	
		 	      	    }//END RESULTADOS
		 	                     
		 	           }          
		 	                     
		 	      	   	$l++;
		 	      	   	
		 	      	 
		 	      	   	
		 	      	   	$html.='</tr>';
		 	      	   	}
		 	      	   
		 	      }else{
				  	 $html.='<tr><td style="border:1px #999999 solid; font-size:12px;" colspan="5"><div class="empty_results">NO ESTA INSCRITO(A) EN UN PLAN OPERATIVO</div></td></tr>';
		 	      	  
				  	
				  }
				  $html.='</table></td></tr>';
				  
		 
		      }
		  
		      
		 }
		
		$html.='</div></table>';
		
		echo $html;
	}
	
	
	

	
}

?>