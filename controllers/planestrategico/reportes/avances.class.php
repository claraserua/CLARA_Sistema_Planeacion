<?php
include "models/planestrategico/reportes/avances.model.php";


class avances {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $nodoprincipal;
	var $image;
	var $targetPathumbail;
	var $arraytotal;
	var $stringtotal;
	var $numlineasn;
	var $arraymayor;
	var $arrayDts;

	function avances() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("filtro",TRUE);
	 $this->nodoprincipal = new Niveles("option");
	 $this->Model = new avancesModel();
		
		
	 if(isset($_GET['method'])){	
		
		 switch($_GET['method']){
		 	
			case "Reporte": 
				//$this->Reporte();
				//$this->Reporte_();//hqc
				$this->Reporte_V();
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
	 	
		$contenido = $this->View->Template(TEMPLATE.'modules/reportes/pe/AVANCES.TPL');
//		$contenido =  $this->View->replace('/\#NODOS\#/ms' ,$this->nodos->nodos,$contenido);	 /*HQC CAMBIO PARA EL RADIO*/
		$contenido =  $this->View->replace('/\#NODOSPRINCIPAL\#/ms' ,$this->nodoprincipal->nodos,$contenido);	
		
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		 
		 }
	 
function Reporte(){		
		
		
		$this->Model->getPlanesEstrategicos($_GET['nodos'],$_GET['anos']);
		$html='<div class="datagrid"><table>';
		$numplanese = sizeof($this->Model->planese); 
		
		 if($numplanese != 0){
		 	 
		 	  $html.='<thead><tr>';
		 	  
		 	  //$html.='<th>CLAVE</th>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">PLAN ESTRATEGICO</th>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">CENTRO</th>';
		 	  $html.='</tr>';
		 	
		 	$i=1;
		 	$j=0;
		 	  foreach($this->Model->planese as $plane){
		 	  	
		 	  	
		 	  	$this->arraytotal = array();
		 	  	$this->stringtotal = '';
		 	  	$this->numlineasn = 0;
		 	  	
		 	$html.='<tr>';
		 	
		 	//$html.='<th>'.$plane['PK1'].'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.$i++.' .- '.htmlentities($plane['TITULO'], ENT_QUOTES, "ISO-8859-1").'</th>';		 	
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.$plane['PK_JERARQUIA'].'</th>';
		 	$html.='</tr>';
		 	$j+=4;
		 	
		 	$html.='<tr><td colspan="'.$j.'"><table style="table-layout:fixed";><tr>';	
		 	
		      $this->Model->getPlanes($plane['PK1'],$plane['PK_JERARQUIA']);
		      $numplanes = sizeof($this->Model->planes);
		    if($numplanes != 0){
		 	            	
		 	          
		 	     $p=0;       	
		 	   foreach($this->Model->planes as $plan){
		 	   		$html.='<td colspan="2" style="vertical-align:top;">';
		 	                    
		 	$p++;  
		 	 
		 	$findme = '2';  
		 	$inicioc = strpos($plan['TITULO'], $findme);
		 	$plananio = substr ($plan['TITULO'],$inicioc,4);
		 	
		 	               
			$html.='<table>
			
			 <tr><td style="border:1px #999999 solid; background:#CCC; color:#333;"  align="center" colspan="4" width=""><strong>POA '.$plananio.'</strong></td></tr>
			
			<tr>';
			 
			 
			    
			 if($p==1){
			 $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width=""><strong>L&iacute;nea</strong></td>';				 	
			 }      		 
		 	
		    $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="33.3%"><strong>Objetivo Estrategico</strong></td>';
		 	$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="33.3%"><strong>Resultado</strong></td>';	
		 	$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;" width="33.3%"><strong>Avance de resultados POA '.$plananio.'</strong></td>';		
		 	        
		 	                    
		 	                  //lineas
							 	   $this->Model->getLineas($plan['PK_PESTRATEGICO']);
							 	   $numlineas = sizeof($this->Model->lineas);
							 	   //
							 	   $this->numlineasn = $numlineas;
							 	   
							 	   if($numlineas != 0){
							 	      	 $l=1;
							 	      	  
							 	      	foreach($this->Model->lineas as $linea){		 	      	   	
							 	      	   	
							 	      	  $promedio = 0;
							 	      	  $porcentaje = 0;
							 	      	  $periodoColumn = 0;			 	      	   	
							 	      	   	
							 	     // 	  $html.='<tr>';  
							 	      	  
		 	                    		//resultados
								 	              $this->Model->getResultados($plan['PK1'],$linea['PK1']);   
								 	            $numresultados = sizeof($this->Model->resultados);
								 	            if($numresultados != 0){
								 	            	
								 	            	 $r=1;
								 	            	
								 	                 foreach($this->Model->resultados as $resultado){ 	  
								 	                    		
		 	                    		 $html.='<tr>';  	 	                    		 
		 	                    		 
		 	                    		 
		 	                    		 
		 	                    		 
		 	                    		 
		 	            $trimentre = 0;
						$sumatotaltrim = 0;
						$porcmayor = 0;
						$this->arraymayor = array();
										 	            
						$this->Model->getPeriodos($plan['PK1']);   
		 	            $numperiodos = sizeof($this->Model->periodos);
		 	            if($numperiodos != 0){
		 	            	foreach($this->Model->periodos as $periodo){
		 	             	            
		 	             	  $trimentre = $this->Model->getAvanceResultado($resultado['PK1'],$periodo['PK1']);  
		 	             	  $this->arraymayor[] =  $trimentre; 		 	             	       
		 	             	 //  $sumatotaltrim += $trimentre; 
		 	             	     
							}			 	            
						}		
		 	                  $porcmayor = max($this->arraymayor);  		 
		 	                    		 
		 	                    		 
		 	                    	
		 	                    	 $ponred = false;
		 	            	          
		 	            	          
		 	            if( $porcmayor == '0'  ){								
								$ponred = true;
					    } 	
					    
					    
					    $color = "";
		 	            $backgraund = "";
		 	            if($ponred == true){
					      $color = "color: #ec3f35;";
		 	            $backgraund = "background: #EEEEEE;";
							
						}		
		 	                    	
		 	                    	
		 	                    		 
		 	                    		
		 	                    	                   	$rowobjestr = $this->Model->getObjetivoEst($resultado['PK_OESTRATEGICO']);						 	            	$idobjestr =  intval($rowobjestr['ORDEN']);
									                    $idobjestr++;         	   							 
		 	            	    
		 	            	    
		 	            	    if($p==1){
		 	            	    	
									 $html.='<td style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.' heigth:20%; "    width="10%" colspan="">'.$l.'.-'.htmlentities($linea['LINEA'], ENT_QUOTES, "ISO-8859-1").'</td>';	
									
								}
		 	            	     	            	    
										 	            $html.='<td  width="10%" style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.' heigth:20%; "   colspan="">'.$l.'.'.$idobjestr.':'.htmlentities($rowobjestr['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>';			 	       
										 	       
										 	       
										 	            $html.='<td  width="10%" style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.' heigth:20%;"  colspan="">'.$l.'.'.$r.':'.htmlentities($resultado['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td>';
										 	            
										 	            
										//suma de resultado 	            
						
													 	            
							
							
								 	            
										 	            
							$html.='<td  width="10%" style="text-align: center; border:1px #999999 solid; font-size:14px;'.$color.'  '.$backgraund.' " colspan="">'.$porcmayor.' %</td>';
					        $html.='</tr>';    
										       
		 	             			 	                $r++; 
		 	                    		             }//fin resultados (for)
		 	                    		
		 	                    		          } 	                    			
		 	                     	       		 	
		 	                     	       		 	
					 	                     	       		 	
					 	          $html.='<tr>';	
					 	           if($p==1){$html.='<td style="border:1px #999999 solid; background:#663300; color:#FFFFFF;" width="20%">Total L&iacute;nea '.$l.'</td>';}  
					 	                  
								   if($p==1){$html.='<td  style="border:1px #999999 solid; background:#663300; color:#333;" width="20%">&nbsp;</td>';}
								   else{$html.='<td style="border:1px #999999 solid; background:#663300; color:#FFFFFF;" width="20%">Total L&iacute;nea '.$l.'</td>';  }
								   $html.='<td  style="border:1px #999999 solid; background:#663300; color:#333;" width="20%">&nbsp;</td>';
								   
								   					
										//suma de resultado 	            
						
						$trimestrer = 0;						
						$sumatotalr = 0;	
						
																			
										
							 $numresultados = sizeof($this->Model->resultados);
						 	   if($numresultados != 0){		 	            	
						 	           $res=0;		 	            	
						 	     foreach($this->Model->resultados as $resultado){ 
						 	           $sumatotaltrimr = 0;
						 	           	$porcmayor_2 = 0;	
						 	           $arraymayor_2 = array();   						 	            
									$this->Model->getPeriodos($plan['PK1']);   
					 	            $numperiodos = sizeof($this->Model->periodos);
					 	            if($numperiodos != 0){
					 	            	foreach($this->Model->periodos as $periodo){
					 	             	            
					 	             	       $trimestrer = $this->Model->getAvanceResultado($resultado['PK1'],$periodo['PK1']);    						  
					 	             	       $arraymayor_2[] =  $trimestrer;  
					 	             	        //$sumatotaltrimr += $trimestrer; 
					 	             	         				 	             	      
										}								 	            
									}
									
									$porcmayor_2 = max($arraymayor_2);
									
									
									//$sumatotalr += $sumatotaltrimr;
									
									$sumatotalr += $porcmayor_2;
										
									 $res++;								
									
								 }
							  }										 	
								
								
						 $promedio = $sumatotalr / $res;
						 
						 
						 $this->stringtotal .= $promedio;  
						 $this->stringtotal .= "^";
		 	            
		 	             $html.='<td style="text-align: center; border:1px #999999 solid; background:#663300; color:#FFFFFF;" width="10% font-size:14px;" colspan=""><strong>'.round($promedio,2).' %</strong></td>';	
											   	               	       		 	
					 	           $html.='</tr>';					 	            
					 	            
					 	            
		 	            		 	      $l++; 
		 	            		 	      
		 	            		 	      
		 	            		 	      
		 	            		 	      
		 	            		 	      
		 	            		 	      /******/
		 	            		 	      //suma de resultado 	            
						
						
						
						
						/*  $this->Model->getPlanes($plane['PK1'],$plane['PK_JERARQUIA']);
				          $numplanes = sizeof($this->Model->planes);
				          if($numplanes != 0){	          
					 	     $p=0;       	
						 	   foreach($this->Model->planes as $plan){										
								 //lineas
							 	   $this->Model->getLineas($plan['PK_PESTRATEGICO']);
							 	   $numlineas = sizeof($this->Model->lineas);
							 	   if($numlineas != 0){							 	   	
							 	   		 $l=1;							 	      	  
							 	      	foreach($this->Model->lineas as $linea){			 	   
		 	                    		//resultados
								 	              $this->Model->getResultados($plan['PK1'],$linea['PK1']);   
								 	            $numresultados = sizeof($this->Model->resultados);
								 	            if($numresultados != 0){            	
								 	            	 $r=1;
								 	            	
								 	                 foreach($this->Model->resultados as $resultado){			
														
										
														
														
							                         }						 				
						 						}
						 				}//l(for)
									}//l
									
									$this->stringtotal .= '|'; 										
								}//p (for)			
							}//p				
						     */
						
						
						
					/*	$trimestrer = 0;						
						$sumatotalr = 0;																
										
							 $numresultados = sizeof($this->Model->resultados);
						 	   if($numresultados != 0){		 	            	
						 	           $res=0;		 	            	
						 	     foreach($this->Model->resultados as $resultado){ 
						 	           $sumatotaltrimr = 0;   						 	            
									$this->Model->getPeriodos($plan['PK1']);   
					 	            $numperiodos = sizeof($this->Model->periodos);
					 	            if($numperiodos != 0){
					 	            	foreach($this->Model->periodos as $periodo){
					 	             	            
					 	             	       $trimestrer = $this->Model->getAvanceResultado($resultado['PK1'],$periodo['PK1']);    						 	       $sumatotaltrimr += $trimestrer;    				 	             	      
										}								 	            
									}
									
									$sumatotalr += $sumatotaltrimr;	
									 $res++;								
									
								 }
							  }										 	
								
								
						 $promedio = $sumatotalr / $res; */ 
		 	            		 	      
		 	            	/******/
							
							 	 	      
		 	            		 	      
		 	            		 	      
		 	            		
		 	            		    }//fin lineas (for)
		 	            		    
		 	            		  } //fin lineas (num)
		 	            		   
		 	            		
		 	            		$this->stringtotal .= "|"; 
		 	            		
		 	            			$html.='</tr></table>';
		 	            			$html.='</td>';
		 	            		}
		 	            		//$html.='</tr></table></td>';
		 	            	
		 	            	}
		 	            		 	      
		 	      $html.='</tr>';
				  $html.='</table></td></tr>';
				  
				  
				  
				//  $this->$numlineasn 
				  
				 /*   $html.='</br><div><table boder="1" style="";>';
				    $lineasn = explode("|",$this->stringtotal);				
						
					for($i=0;$i<sizeof($lineasn);$i++){//(3)ejem  0  1  2		
					
					     $html.='<tr>';
					
				        $totline = explode("^",$lineasn[$i]);//0
				        
				        for($z=0;$z<sizeof($totline);$z++){//0
				        	
				        	//  $totline = explode("^",$lineas[$i]);//0
				        	  
				        	  
				        	    $html.='<td>'.round($totline[$z],2).'</td>';
				        	    
				        	
				        }
				        
				         $html.='</tr>';
				        	    	      
						  
					}	
					
					  $html.='</table> </div>';  */
				  
					
		      }
		      $html.='</thead>';
		      
		 }
		
		$html.='</div></table>';
		
		echo $html;
	}
	
	function Reporte_V(){
		$arrayPE=array();
		$arrayPO=array();
		$arrayLN=array();
		$arrayRES=array();
		$arrayFIN=array();
		$arrayTblPoas=array();
		$arrPOAS=array();
		$arregloRes='';
		$html='<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">';
 	    $html.='<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
	    $html.='<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>';
	    $html.='<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>';
		$ano_I=substr($_GET['anos'],0,4);
		$ano_F=substr($_GET['anos'],5);
		$this->Model->getPlanesEstrategicos($_GET['nodos'],$ano_I,$ano_F);
		$numplanese = sizeof($this->Model->planese);  
		//echo "numplanese:".$numplanese;
		if($numplanese != 0){
			$i=0;
			//print_r($this->Model->planese);
			foreach($this->Model->planese as $planE){//PE
				$arrayPE[$i]=array('PK1'=>$planE['PK1'],'TITULO'=>htmlentities($planE['TITULO'], ENT_QUOTES, "ISO-8859-1"),'JERARQUIA'=>$planE['PK_JERARQUIA']);
				$i++;
			}
		}
		$i=0;
		$MaxPOAS=0;
		//$longitudMaxRes=0;
		$arrLonRes=array();
		$maxLineas=0;
		$maxArr='';
		foreach($arrayPE as $PE){
			$t=0;
			$this->Model->getPlanes($PE['PK1'],$_GET['nodos']);//PE
			$numplanes = sizeof($this->Model->planes);			
			if($numplanes != 0){
				$j=0;
				foreach($this->Model->planes as $PO){//PO
					$arrayPO[$i]=array('PO_PK1'=>$PO['PK1'],'PO_TITULO'=>htmlentities($PO['TITULO'], ENT_QUOTES, "ISO-8859-1"));
					$this->Model->getLineas($PE['PK1']);
					$numlineas = sizeof($this->Model->lineas);
					$maxLineas=max($numlineas,$maxLineas);
					$k=0;
					$resMax=0;
					foreach($this->Model->lineas as $LN){
						$arrayLN[$i][$k]=array('LN_PK1'=>$LN['PK1'],'LINEA'=>htmlentities($LN['LINEA'], ENT_QUOTES, "ISO-8859-1"));
						$this->Model->getResultados($PO['PK1'],$LN['PK1']);
						$numRes=sizeof($this->Model->resultados);
						$numresultados = sizeof($this->Model->resultados);
						$resMax=max($numresultados,$resMax);
						$maxArr.=''.$k.','.$numresultados.' ';
						//echo ''.$k.','.$numresultados.' ';
						if($numRes!=0){
							$l=0;
							foreach($this->Model->resultados as $RES){//resultados
								$arrayRES[$j][$l]=array('LN_PK1'=>$LN['PK1'],'LN_LINEA'=>htmlentities($LN['LINEA'], ENT_QUOTES, "ISO-8859-1"),
								'RES_PK1'=>$RES['PK1'],'RES_TITULO'=>htmlentities($RES['OBJETIVO'], ENT_QUOTES, "ISO-8859-1"));
								//echo "+RES:".$l."+";
								$porcmayor='';
								$this->Model->getPeriodos($PO['PK1']);
								$numPer = sizeof($this->Model->periodos);
								if($numPer!=0){
									$periodos="";
									foreach($this->Model->periodos as $PER){//periodos
										$periodos.="'".$PER['PK1']."',";
									}
									$findme = '2';  
									$inicioc = strpos($PO['TITULO'], $findme);
									$porcmayor=$this->Model->getAvanceResultado($RES['PK1'],substr($periodos,0,strlen($periodos)-1));
									$arrayFIN[$PE['PK1']][$PO['PK1']][$LN['PK1']][$l]=array(
										'PE_PK1'=>$PE['PK1'],
										'PO_PK1'=>$PO['PK1'],
										'LN_PK1'=>$LN['PK1'],
										'LN_TITULO'=>$LN['LINEA'],
										'RES_PK1'=>$RES['PK1'],
										'RES_TITULO'=>htmlentities($RES['OBJETIVO'], ENT_QUOTES, "ISO-8859-1"),
										'AVANCE'=>$porcmayor.'%'
									);
								}
								$l++; 
							}
						}
						$k++;
						
					}
					$maxArr.="	";
					$j++;
				}$MaxPOAS=max($MaxPOAS,$j);
			}
			$i++;
		}
		$cadena="	";
		//echo 'lineas:'.$maxLineas;
		$arregloRes=explode($cadena,$maxArr); 
		$arrSeparado='';
		$nuevaCadena='';
		$arrOrden=array();
//		print_r($arregloRes);
		//echo "size: ".sizeof($arregloRes);
		//for($i=0;$i<sizeof($arregloRes)-1;$i++){
		for($i=0;$i<=$maxLineas;$i++){
			foreach($arregloRes as $cadena){
		//		print_r($cadena);
				$separador=" "; 
				$arregloResFin=explode($separador,$cadena); 
				/*echo "//";
				print_r($arregloResFin[$i]);*/
				if(isset ($arregloResFin[$i])==true){
					$nuevaCadena.= ' '.substr($arregloResFin[$i],2);
				}else{
					break;
				}
			}
			$nuevaCadena.='	';
		}
		$cadena="	";
		$nuevaCadena=explode($cadena,$nuevaCadena); 
		$i=0;
		$valMax=0;
		//print_r($nuevaCadena);
		//echo"---";
		foreach($nuevaCadena as $ln){
			$arrglo=explode(' ',$ln);
			$maxLn=0;
			foreach($arrglo as $sp){
				$maxLn=max($sp,$maxLn);
			}
			$arrOrden[$i]=$maxLn;
			$i++;
		} 
		//print_r($arrOrden);
		
		$arrLnPE=array();
		$ano_I=substr($_GET['anos'],0,4);
		$ano_F=substr($_GET['anos'],5);		
		$this->Model->getPlanesEstrategicos($_GET['nodos'],$ano_I,$ano_F);
		//obtenemos total de PE
		$totPE = sizeof($this->Model->planese);
		$contPE=0;
		foreach($this->Model->planese as $PE){
			$lnPOas=0;
			$this->Model->getPlanes($PE['PK1'],$_GET['nodos']);//PE
			$totPOAS = sizeof($this->Model->planes);			
			if($contPE==0){
				$lnPOas=($totPOAS*2)+1;
			}else{
				$lnPOas=($totPOAS*2);
			}
			$arrLnPE[$contPE]=array('PE'=>$PE['PK1'],'PE_TITULO'=>htmlentities($PE['TITULO'], ENT_QUOTES, "ISO-8859-1"),'TPOAS'=>$totPOAS,'LN'=>$lnPOas,'JERARQUIA'=>$PE['PK_JERARQUIA']);
			$contPE++;
		}
		$html='
			<table class="table table-responsive table-bordered" >
			<thead>';
		foreach($arrLnPE as $PES){
			$html.='';
			//echo (floor($PES['TPOAS']/2));
			//echo "#PE:".($PES['TPOAS']);
			$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="'.(ceil($PES['LN']/2)).'">PLAN ESTRATEGICO</th>
				<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="'.floor($PES['LN']/2).'">CENTRO</th>';
			$html.='</td>';
		}
		$cntPOA=1;
		$html.='<tr>';
		foreach($arrLnPE as $PES){
				$html.='
				<td style="border:1px #999999 solid; background:#FF4712; color:#FFF;"colspan="'.(ceil($PES['LN']/2)).'">'.$cntPOA.'.-'.$PES['PE_TITULO'].'</td>
				<td style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="'.(floor($PES['LN']/2)).'">'.htmlentities($PES['JERARQUIA'], ENT_QUOTES, "ISO-8859-1").'</td>
				';
				$cntPOA++;
		}
		$html.='</tr>';
		$html.='<tr>';
		$cntPOA=0;
		$this->Model->getAnoPOAS($_GET['nodos'],$ano_I,$ano_F);
		$totPOAS=sizeof($this->Model->poas);
		if($totPOAS!=0){
			foreach($this->Model->poas as $POAS){
				if($cntPOA==0){
					$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333; text-align:center;" colspan="3"><strong>'.$POAS['POA'].'</strong></td>';
					
				}else{
					$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333; text-align:center;" colspan="2"><strong>'.$POAS['POA'].'</strong></td>';
				}
				$this->Model->getArrPOAS($_GET['nodos'],$ano_I,$ano_F,$POAS['POA_PK1'],$POAS['PE_PK']);
				$totLineasRes=sizeof($this->Model->arrPoas);
				$cntLnRs=0;
				foreach($this->Model->arrPoas as $LnRs){
					$arrPOAS[$cntPOA][$cntLnRs]=array('PE_PK1'=>$LnRs['PE_PK1'],'POA_PK1'=>$LnRs['POA_PK1'],'LN_PK1'=>$LnRs['LN_PK1'],'LINEA'=>$LnRs['LINEA'],'RS_PK1'=>$LnRs['RS_PK1'],'OBJETIVO'=>$LnRs['OBJETIVO'],'POA_TITULO'=>$LnRs['POA_TITULO']);
					$cntLnRs++;
				}
				//
				$cntPOA++;
			}
		}
		$html.='</tr>';
		$html.='<tr>';
		$cntPOA=0;
		if($totPOAS!=0){
			foreach($this->Model->poas as $POAS){
				if($cntPOA==0){
					$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333; text-align:center; " colspan="1" width="500"><strong>L&iacute;nea</strong></td>';
					$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333; text-align:center;" colspan="2"><strong>Resultado</strong></td>';
				}else{
					$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333; text-align:center;" colspan="2"><strong>Resultado</strong></td>';
				}
				$cntPOA++;
			}
		}
		$html.='</tr>';
		$html.='</tr>';
		$html.='<tr>';

		$html.='<tr>';
		$html.='</tr>';
		$NoPoas= sizeof($arrayLN);
		$valMax=0;
		//creacion de tablas para poas
		$valMax=0;
		foreach($arrPOAS as $POA){
			$valMax=max(sizeof($POA),$valMax);
		}
		$cntPO=0;
		foreach($arrayFIN as $pe){
			//print_r($pe);
			$fPoa=0;
			$arr_POAS='';
			foreach($pe as $poa){
				$NoLinea=1;
				if($cntPO==0){
					$html.='<td colspan="3" style="vertical-align:top;"><table><tr>';
				}else{
					$html.='<td colspan="2" style="vertical-align:top;"><table><tr>';
				}
				$numeroLinea=1;
				foreach($poa as $ln){
					$tLinea=1;
					$sum=0;
					$PO_key='';
					foreach($ln as $rs){
						//PRIMER POA
						$dts=substr($rs['AVANCE'],0,strlen($rs['AVANCE'])-1);
						$ponred = false;
						if($dts==0){
							$ponred = true;
						}
						$color = "";
						$backgraund = "";
						if($ponred == true){
							$color = "color: #ec3f35;";
							$backgraund = "background: #EEEEEE;";
						}
						$html.='';
						if($cntPO==0){
							$html.='<td style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.'  height: 40px;"  width="500" colspan="2">'.$NoLinea.'.'.htmlentities($rs['LN_TITULO'], ENT_QUOTES, "ISO-8859-1").'</td>';
							$html.='<td style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.'  height: 40px;"  colspan="1">'.($rs['AVANCE']).'</td>'; 
						}else{
							$html.='
						<td style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.' height: 40px;"     colspan="2">'.($rs['AVANCE']).'</td>
											
						';
						}
						//Siguiente POA
						//ciclo para las lineas de los siguientes poas
						$sum=$sum+substr($rs['AVANCE'],0,strlen($rs['AVANCE'])-1);
						if($tLinea==sizeof($ln)){
							$sum=$sum/$tLinea;
							if($cntPO==0){
								//print_r(sizeof($arrOrden);
		//						print_r($arrOrden);
		//						echo "--".$tLinea.','.$arrOrden[($NoLinea-1)];
								for ($i=$tLinea;$i<$arrOrden[($NoLinea-1)];$i++){
									//if($tLinea<$arrOrden[($NoLinea-1)]){}
									$html.='<tr><td style="height: 40px;"></td></tr>';
								}
								$html.='<tr>
								<td style="border:1px #999999 solid; background:#663300; color:#FFFFFF;" colspan="2">Total L&iacute;nea '.$NoLinea.'</td>
								<td style="border:1px #999999 solid; background:#663300; color:#FFFFFF;"  colspan=".5">'.round($sum,2).'%</td>
								';
							}else{
								for ($i=$tLinea;$i<$arrOrden[($NoLinea-1)];$i++){
									$html.='<tr><td style="height: 40px;"></td></tr>';
								}
								$html.='<tr>
							<td style="border:1px #999999 solid; background:#663300; color:#FFFFFF;" width="10%" colspan="3">'.round($sum,2).'%</td>
							';
							}
							$NoLinea++;
						}						
						$tLinea++;
						$html.='</tr>';
					}
					$numeroLinea++;
				}
				$html.='</table></td>';
				$fPoa++;
				$cntPO++;
			}
		}
		$html.='</tbody>
		</table>
			';
		echo $html;
	}
	
	function Reporte_E(){
			$arrayPE=array();
		$arrayPO=array();
		$arrayLN=array();
		$arrayRES=array();
		$arrayFIN=array();
		$arrayTblPoas=array();
		$arrPOAS=array();
		$arregloRes='';
		$html='<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">';
 	    $html.='<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
	    $html.='<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>';
	    $html.='<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>';
		$ano_I=substr($_GET['anos'],0,4);
		$ano_F=substr($_GET['anos'],5);
		$this->Model->getPlanesEstrategicos($_GET['nodos'],$ano_I,$ano_F);
		$numplanese = sizeof($this->Model->planese);  
		if($numplanese != 0){
			$i=0;
			foreach($this->Model->planese as $planE){//PE
				$arrayPE[$i]=array('PK1'=>$planE['PK1'],'TITULO'=>htmlentities($planE['TITULO'], ENT_QUOTES, "ISO-8859-1"),'JERARQUIA'=>$planE['PK_JERARQUIA']);
				$i++;
			}
		}
		$i=0;
		$MaxPOAS=0;
		//$longitudMaxRes=0;
		$arrLonRes=array();
		$maxLineas=0;
		$maxArr='';
		foreach($arrayPE as $PE){
			$t=0;
			$this->Model->getPlanes($PE['PK1'],$_GET['nodos']);//PE
			$numplanes = sizeof($this->Model->planes);			
			if($numplanes != 0){
				$j=0;
				foreach($this->Model->planes as $PO){//PO
					$arrayPO[$i]=array('PO_PK1'=>$PO['PK1'],'PO_TITULO'=>htmlentities($PO['TITULO'], ENT_QUOTES, "ISO-8859-1"));
					$this->Model->getLineas($PE['PK1']);
					$numlineas = sizeof($this->Model->lineas);
					$maxLineas=max($numlineas,$maxLineas);
					$k=0;
					$resMax=0;
					foreach($this->Model->lineas as $LN){
						$arrayLN[$i][$k]=array('LN_PK1'=>$LN['PK1'],'LINEA'=>htmlentities($LN['LINEA'], ENT_QUOTES, "ISO-8859-1"));
						$this->Model->getResultados($PO['PK1'],$LN['PK1']);
						$numRes=sizeof($this->Model->resultados);
						$numresultados = sizeof($this->Model->resultados);
						$resMax=max($numresultados,$resMax);
						$maxArr.=''.$k.','.$numresultados.' ';
						//echo ''.$k.','.$numresultados.' ';
						if($numRes!=0){
							$l=0;
							foreach($this->Model->resultados as $RES){//resultados
								$arrayRES[$j][$l]=array('LN_PK1'=>$LN['PK1'],'LN_LINEA'=>htmlentities($LN['LINEA'], ENT_QUOTES, "ISO-8859-1"),
								'RES_PK1'=>$RES['PK1'],'RES_TITULO'=>htmlentities($RES['OBJETIVO'], ENT_QUOTES, "ISO-8859-1"));
								//echo "+RES:".$l."+";
								$porcmayor='';
								$this->Model->getPeriodos($PO['PK1']);
								$numPer = sizeof($this->Model->periodos);
								if($numPer!=0){
									$periodos="";
									foreach($this->Model->periodos as $PER){//periodos
										$periodos.="'".$PER['PK1']."',";
									}
									$findme = '2';  
									$inicioc = strpos($PO['TITULO'], $findme);
									$porcmayor=$this->Model->getAvanceResultado($RES['PK1'],substr($periodos,0,strlen($periodos)-1));
									$arrayFIN[$PE['PK1']][$PO['PK1']][$LN['PK1']][$l]=array(
										'PE_PK1'=>$PE['PK1'],
										'PO_PK1'=>$PO['PK1'],
										'LN_PK1'=>$LN['PK1'],
										'LN_TITULO'=>$LN['LINEA'],
										'RES_PK1'=>$RES['PK1'],
										'RES_TITULO'=>htmlentities($RES['OBJETIVO'], ENT_QUOTES, "ISO-8859-1"),
										'AVANCE'=>$porcmayor.'%'
									);
								}
								$l++; 
							}
						}
						$k++;
						
					}
					$maxArr.="	";
					$j++;
				}$MaxPOAS=max($MaxPOAS,$j);
			}
			$i++;
		}
		$cadena="	";
		$arregloRes=explode($cadena,$maxArr); 
		$arrSeparado='';
		$nuevaCadena='';
		$arrOrden=array();
		//for($i=0;$i<=sizeof($arregloRes);$i++){
		for($i=0;$i<$maxLineas;$i++){
			foreach($arregloRes as $cadena){
				$separador=" "; 
				$arregloResFin=explode($separador,$cadena); 
				if(isset ($arregloResFin[$i])==true){
					$nuevaCadena.= ' '.substr($arregloResFin[$i],2);
				}else{
					break;
				}
			}
			$nuevaCadena.='	';
		}
		$cadena="	";
		$nuevaCadena=explode($cadena,$nuevaCadena); 
		$i=0;
		$valMax=0;
		foreach($nuevaCadena as $ln){
			$arrglo=explode(' ',$ln);
			$maxLn=0;
			foreach($arrglo as $sp){
				$maxLn=max($sp,$maxLn);
			}
			$arrOrden[$i]=$maxLn;
			$i++;
		}
		$arrLnPE=array();
		$ano_I=substr($_GET['anos'],0,4);
		$ano_F=substr($_GET['anos'],5);		
		$this->Model->getPlanesEstrategicos($_GET['nodos'],$ano_I,$ano_F);
		//obtenemos total de PE
		$totPE = sizeof($this->Model->planese);
		$contPE=0;
		foreach($this->Model->planese as $PE){
			$lnPOas=0;
			$this->Model->getPlanes($PE['PK1'],$_GET['nodos']);//PE
			$totPOAS = sizeof($this->Model->planes);			
			if($contPE==0){
				$lnPOas=($totPOAS*2)+1;
			}else{
				$lnPOas=($totPOAS*2);
			}
			$arrLnPE[$contPE]=array('PE'=>$PE['PK1'],'PE_TITULO'=>htmlentities($PE['TITULO'], ENT_QUOTES, "ISO-8859-1"),'TPOAS'=>$totPOAS,'LN'=>$lnPOas,'JERARQUIA'=>$PE['PK_JERARQUIA']);
			$contPE++;
		}
		$html='
			<table class="table table-responsive table-bordered" >
			<thead>';
			$i=0;
			//echo 
		foreach($arrLnPE as $PES){
			$html.=''; 
			if($i==0){
				$html.='<td style="border:1px #999999 solid; background:#FF4712; color:#FFF;"colspan="'.ceil((($PES['TPOAS']*2)+1)/2).'">PLAN ESTRATEGICO</td>
				<td style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="'.floor((($PES['TPOAS']*2)+1)/2).'">CENNTRO</td>';
			}else{
				$html.='<td style="border:1px #999999 solid; background:#FF4712; color:#FFF;"colspan="'.ceil((($PES['TPOAS']*2))/2).'">PLAN ESTRATEGICO</td>
				<td style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="'.floor((($PES['TPOAS']*2))/2).'">CENTRO</td>';
			}
			//$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="'.(floor($PES['TPOAS'])).'">PLAN ESTRATEGICO</th>';
			//$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="'.floor($PES['TPOAS']/2).'"> CENTRO</th>';
			//$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="'.$PES['TPOAS'].'">PLAN ESTRATEGICO</th>';
			//$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="'.$PES['TPOAS'].'"> CENTRO</th>';
			
			$html.='</td>';
			$i++;
		}
		$cntPOA=1;
		$html.='<tr>'; 
		foreach($arrLnPE as $PES){
			if($cntPOA==1){
				$html.='<td style="border:1px #999999 solid; background:#FF4712; color:#FFF;"colspan="'.ceil((($PES['TPOAS']*2)+1)/2).'">'.$cntPOA.'.-'.$PES['PE_TITULO'].'</td>
				<td style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="'.floor((($PES['TPOAS']*2)+1)/2).'">'.htmlentities($PES['JERARQUIA'], ENT_QUOTES, "ISO-8859-1").'</td>';
			}else{
				$html.='<td style="border:1px #999999 solid; background:#FF4712; color:#FFF;"colspan="'.ceil((($PES['TPOAS']*2))/2).'">'.$cntPOA.'.-'.$PES['PE_TITULO'].'</td>
				<td style="border:1px #999999 solid; background:#FF4712; color:#FFF;" colspan="'.floor((($PES['TPOAS']*2))/2).'">'.htmlentities($PES['JERARQUIA'], ENT_QUOTES, "ISO-8859-1").'</td>';
			}
				
				
				$cntPOA++;
		}
		$html.='</tr>';
		$html.='<tr>';
		$cntPOA=0;
		$this->Model->getAnoPOAS($_GET['nodos'],$ano_I,$ano_F);
		$totPOAS=sizeof($this->Model->poas);
		if($totPOAS!=0){
			foreach($this->Model->poas as $POAS){
				if($cntPOA==0){
					$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333; text-align:center;" colspan="3"><strong>'.$POAS['POA'].'</strong></td>';
					
				}else{
					$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333; text-align:center;" colspan="2"><strong>'.$POAS['POA'].'</strong></td>';
				}
				
				$this->Model->getArrPOAS($_GET['nodos'],$ano_I,$ano_F,$POAS['POA_PK1'],$POAS['PE_PK']);
				$totLineasRes=sizeof($this->Model->arrPoas);
				$cntLnRs=0;
				foreach($this->Model->arrPoas as $LnRs){
					$arrPOAS[$cntPOA][$cntLnRs]=array('PE_PK1'=>$LnRs['PE_PK1'],'POA_PK1'=>$LnRs['POA_PK1'],'LN_PK1'=>$LnRs['LN_PK1'],'LINEA'=>$LnRs['LINEA'],'RS_PK1'=>$LnRs['RS_PK1'],'OBJETIVO'=>$LnRs['OBJETIVO'],'POA_TITULO'=>$LnRs['POA_TITULO']);
					$cntLnRs++;
				}
				//
				$cntPOA++;
			}
		}
		$html.='</tr>';
		$html.='<tr>';
		$cntPOA=0;
		if($totPOAS!=0){ 
			foreach($this->Model->poas as $POAS){
				if($cntPOA==0){
					$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333; text-align:center; " colspan="1"><strong>L&iacute;nea</strong></td>';
					$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333; text-align:center;" colspan="1"><strong>Avance de resultado</strong></td>';
					$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333; text-align:center;" colspan="1"><strong>Avance anual PE</strong></td>';
				}else{
					$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333; text-align:center;" colspan="1"><strong>Avance de resultado</strong></td>';
					$html.='<td style="border:1px #999999 solid; background:#CCC; color:#333; text-align:center;" colspan="1"><strong>Avance anual PE</strong></td>';
				}
				$cntPOA++;
			}
		}
		$html.='</tr>';
		$html.='</tr>';
		//$html.='<tr>';

	//	$html.='<tr>';
		//$html.='</tr>';
		$NoPoas= sizeof($arrayLN);
		$valMax=0;
		//creacion de tablas para poas
		$valMax=0;
		foreach($arrPOAS as $POA){
			$valMax=max(sizeof($POA),$valMax);
		}
		$cntPO=0;
		foreach($arrayFIN as $pe){
			//print_r($pe);
			$fPoa=0;
			$arr_POAS='';
			foreach($pe as $poa){
				$NoLinea=1;
				if($cntPO==0){
					$html.='<td colspan="3" style="vertical-align:top;"><table><tr>';
				}else{
					$html.='<td colspan="2" style="vertical-align:top;"><table><tr>';
				}
				$numeroLinea=1;
				foreach($poa as $ln){
					$tLinea=1;
					$sum=0;
					$PO_key='';
					foreach($ln as $rs){
						//PRIMER POA
						$dts=substr($rs['AVANCE'],0,strlen($rs['AVANCE'])-1);
						$ponred = false;
						if($dts==0){
							$ponred = true;
						}
						$color = "";
						$backgraund = "";
						if($ponred == true){
							$color = "color: #ec3f35;";
							$backgraund = "background: #EEEEEE;";
						}
						$html.='';
						if($cntPO==0){
							$html.='<td style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.'   colspan="30">'.$NoLinea.'.-'.htmlentities($rs['LN_TITULO'], ENT_QUOTES, "ISO-8859-1").'</td>';
							$html.='<td style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.'    colspan="1">'.($rs['AVANCE']).'</td>'; 
							$html.='<td style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.'    colspan=1">'.(($rs['AVANCE'])/$totPOAS).'</td>'; 
						}else{
							//$html.='<td style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.'    colspan="2">'.($rs['AVANCE']).'</td>'; 
							$html.='<td style="border:1px #999999 solid; '.$color.'  '.$backgraund.'" width="10%" colspan="2">'.($rs['AVANCE']).'</td>';
							$html.='<td style="border:1px #999999 solid; '.$color.'  '.$backgraund.'" width="10%" colspan="2">'.(($rs['AVANCE'])/$totPOAS).'</td>';
						}
						
						//Siguiente POA
						//ciclo para las lineas de los siguientes poas
						$sum=$sum+substr($rs['AVANCE'],0,strlen($rs['AVANCE'])-1);
						if($tLinea==sizeof($ln)){
							$sum=$sum/$tLinea;
							if($cntPO==0){
								for ($i=$tLinea;$i<$arrOrden[($NoLinea-1)];$i++){
									if($tLinea<$arrOrden[($NoLinea-1)])
								//	$html.='<tr><td style="height: 40px;"></td></tr>';
								$html.='<tr><td style="border:1px #999999 solid; font-size:12px;'.$color.'  '.$backgraund.'   colspan="30">'.$NoLinea.'.-'.htmlentities($rs['LN_TITULO'], ENT_QUOTES, "ISO-8859-1").'</td>';
								$html.='<td style="border:1px #999999 solid; font-size:12px;"  colspan="1"></td>';
								$html.='<td style="border:1px #999999 solid; font-size:12px;"  colspan="1"></td></tr>';
								}
								$html.='<tr>
									<td style="border:1px #999999 solid; background:#663300; color:#FFFFFF;" colspan="1">Total L&iacute;nea '.$NoLinea.'</td>
									<td style="border:1px #999999 solid; background:#663300; color:#FFFFFF;"  colspan="1">'.round($sum,2).'%</td>';
							$html.='<td style="border:1px #999999 solid; background:#663300; color:#FFFFFF;" width="10%" colspan="1">'.(round($sum,2)/$totPOAS).'%</td>';
							}else{/*HQC*/
								for ($i=$tLinea;$i<$arrOrden[($NoLinea-1)];$i++){
									//$html.='<tr><td style="height: 40px;"></td></tr>';
									if(isset ($arrOrden[($NoLinea-1)])==true){
										//$html.='<tr><td style=" height: 40px; "></td></tr>';
										$html.='<tr><td style="border:1px #999999 solid; font-size:12px; height: 40px; " colspan="2"></td>';
										$html.='<td style="border:1px #999999 solid; font-size:12px; height: 40px; " colspan="2"></td></tr>';
									}else{
										break;
									}
								}
								$html.='<tr><td style="border:1px #999999 solid; background:#663300; color:#FFFFFF;" width="10%" colspan="2">'.round($sum,2).'%</td>';
								$html.='<td style="border:1px #999999 solid; background:#663300; color:#FFFFFF;" width="10%" colspan="2">'.(round($sum,2)/$totPOAS).'%</td>';
							}
							$NoLinea++;
						}						
						$tLinea++;
						$html.='</tr>';
					}
					$numeroLinea++;
				}
				$html.='</table></td>';
				$fPoa++;
				$cntPO++;
			}
		}
		$html.='</tbody>
		</table>
			';
		echo $html;
	}
	
	
	

	
}

?>