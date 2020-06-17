<?php
//header("Content-Type: text/html; charset=UTF-8");

include "models/planesoperativo/exportexcel.model.php";


require_once 'libs/excel/Spreadsheet/Excel/Writer.php';


 error_reporting(E_ALL);
 ini_set("display_errors", 1);
 ini_set('memory_limit', '-1');

class exportexcel{

    
	var $Model;
	

	function exportexcel() {
		
	 $this->Model = new exportexcelModel(); 
	 
     $this->loadPage();
	// $this->loadContent();		
						 
	}
	
	

	 function loadPage(){
	 
	 $plan = $this->Model->getPlan($_GET['IDPlan']);
	 $titulo = $plan['TITULO'];
	 
	 $jerarquia = $this->Model->getJerarquia($plan['PK_JERARQUIA']);
	 
	 
	 $idplan = $_GET['IDPlan'];
	 
	 $namefile = 'media/download/'.$_GET['IDPlan'].'.xlsx';
	 $file = $_GET['IDPlan'].'.xlsx';


    
    $workbook = new Spreadsheet_Excel_Writer();
    
    
    $workbook->send('planoperativo.xls');
    
    
    // Creating a worksheet
$worksheet = $workbook->addWorksheet('Plan Operativo');
//$worksheet->setInputEncoding("UTF-8");


// The actual data

//$format = $workbook->addFormat();
//$format->setFgColor(10);
//$worksheet->write(0, 0, 'Cell Start', $format);

// Merge cells from row 0, col 0 to row 2, col 2
//$worksheet->setMerge(0, 1, 0, 7);
//$worksheet->setMerge(1, 1, 1, 7);

$worksheet->setColumn(1, 1, 10);
$worksheet->setColumn(2, 2, 10);
$worksheet->setColumn(3, 3, 50);
$worksheet->setColumn(4, 4, 40);
$worksheet->setColumn(5, 5, 12);
$worksheet->setColumn(6, 6, 12);
$worksheet->setColumn(7, 7, 30);



$this->Model->getPeriodos($idplan);
$periodos = $this->Model->periodos;

# Create a "text wrap" format
//$format2 = $worksheet->addformat();

$multiplemedios = &$workbook->addFormat( array(
'Border'=> 0) );
$multiplemedios->setVAlign('vcenter');
//$multiplemedios->setTextWrap();




$multipleLineDataFormat = &$workbook->addFormat( array(
'Border'=> 0, 'Align' => 'left' ) );
$multipleLineDataFormat->setTextWrap();


$multiple = &$workbook->addFormat( array(
'Border'=> 0, 'Align' => 'center' ) );

$multipleLineDataFormat->setTextWrap();

/*$lineae = &$workbook->addFormat( array(
'Border'=> 0, 'fgcolor' => 50, ) );*/
//$multipleLineDataFormat->setTextWrap();

 $lineae = $workbook->addFormat( array(
'Border'=> 0 ) );
   


$worksheet->write(0, 1, $titulo,$multiple);
 $worksheet->mergeCells(0, 1, 0, 7);
$worksheet->write(1, 1, $jerarquia,$multiple);
 $worksheet->mergeCells(1, 1, 1, 7);

$worksheet->write(3, 1, 'Resultado: Accion propuesta que ayuda al cumplimiento de algun Objetivo Estrategico del Plan Estratégico de la universidad y el responsable de lograr dicho resultado');


$worksheet->write(4, 1, 'Medios: Tareas a llevar a cabo para el logro del objetivo tactico y los responsables de llevarlas a cabo.');

$worksheet->write(5, 1, 'Evidencias propuestas: Elementos fisicos que ayudan a evaluar el cumplimiento de los objetivos tácticos. Ejemplos: reportes, fotografias, informes de reuniones, correos, etc.');



$this->Model->getLineas();
$celda=10;
$contlinea = 1;

//naranja
$workbook->setCustomColor(12, 248, 153, 29);
$format_our_green =& $workbook->addFormat();
$format_our_green->setFgColor(12);
$format_our_green->setColor('16');



 //gris      
$workbook->setCustomColor(10, 217, 217, 217);
$format_our_green2 =& $workbook->addFormat();
$format_our_green2->setFgColor(10);
$format_our_green2->setBold(700);



$workbook->setCustomColor(12, 248, 153, 29);
$format3 = &$workbook->addFormat( array(
'Border'=> 0, 'Align' => 'center' ) );
$format3->setFgColor(12);

               
//$lineaest = 'Línea estratégica ';
//$lineaest = utf8_encode($lineaest);
foreach($this->Model->lineas as $row){//LINEAS ESTRATEGICAS
	
	//$lineae->setFgColor(5);
   
$worksheet->write($celda, 1, 'Linea estrategica '.$contlinea.': '.$row['LINEA'],$format_our_green);
 $worksheet->mergeCells($celda, 1, $celda, 7); 
// $worksheet->setRow($celda,26);	

                     
                      //OBJETIVOS TACTICOS
               $contobjetivo = 1;
			   $this->Model->getObjetivosTacticos($idplan,$row['PK1']);
			   foreach($this->Model->objetivos as $resultados){
			   	
				    $celda++;
					
					
			
           //   $format_our_green->setFgColor(12);
					//$lineae->setFgColor(5);
                  //  $lineae->setColor('16');
					$worksheet->write($celda,2,'Resultado',$format_our_green2);
			        $worksheet->mergeCells($celda, 2, $celda, 3);
			        $worksheet->setRow($celda,26);	
			        
					$worksheet->write($celda,4,'Objetivo estrategico',$format_our_green2);
				    
					$worksheet->write($celda,5,'Responsable',$format_our_green2);
					 $worksheet->mergeCells($celda, 5, $celda, 6);
					
					
					$worksheet->write($celda,7,'Evidencias propuestas',$format_our_green2);
					// $worksheet->mergeCells($celda, 7, $celda, 7);
					
					/*´PERIODOS  */
					
					 
                   $numperiodo  = sizeof($periodos);
                    $fila = 1;
                    
                    $columnas = array(8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25);
				
				    foreach($periodos as $periodo){                    
                    
                    
                //    $worksheet->write($columnas[$fila].$celda,$periodo['PERIODO']);	
                    $worksheet->write($celda,$columnas[$fila],$periodo['PERIODO'],$format_our_green2);
					
					$worksheet->setColumn($columnas[$fila], $columnas[$fila], 60);
                    	
					$fila+=2;
					}
                    
                    
  
					
					$celda++;
					$rowevidencia = $celda;
					//NUMERO OBJETIVO
					$worksheet->write($celda, 1, $contlinea.'.'.$contobjetivo);
					// $worksheet->setRow($celda,30);
					
					$worksheet->mergeCells($celda, 2, $celda, 3);	
					//$worksheet->setColumn($celda, 2, 3);	
					$worksheet->write($celda,2,$resultados['OBJETIVO'],$multipleLineDataFormat);
					$worksheet->mergeCells($celda, 2, $celda, 3);	
					
					$oestrategico = $this->Model->getObjetivoEstrategico($resultados['PK_OESTRATEGICO']);
					
					 
					$worksheet->write($celda,4,$oestrategico,$multipleLineDataFormat);
					
					
					$responsable = $this->Model->getResponsable($resultados['PK_RESPONSABLE']);
					
					$worksheet->write($celda,5,$responsable,$multipleLineDataFormat);
				    $worksheet->mergeCells($celda, 5, $celda, 6);
				    
				    
				    
				    //PORCENTAJE DE AVANCE RESULTADOS
					
					$numperiodo  = sizeof($periodos);
                    $fila = 1;
                    
                    $columnas = array(8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25);
                 
                    
                    foreach($periodos as $periodo){
                    	
                    $avance = $this->Model->getAvanceResultado($periodo['PK1'],$resultados['PK1']);
                    
                    $numporcent = $avance['PORCENTAJE'];
                    
                    if($numporcent == ""){ $numporcent = 0; }
                    
                   $numresul =  $contlinea.'.'.$contobjetivo;
                    
                  $porcentaje = $numresul.' Avance: '.$numporcent.'%';
                    	
               //  $sheet->setCellValue($columnas[$fila].$celda, $porcentaje);
                 
             
					$worksheet->write($celda,$columnas[$fila],$porcentaje);
				  //  $worksheet->mergeCells($celda, 5, $celda, 6);
                     
                    	
					$fila+=2;
					}    
				    
				    
					$celda++;
					//MEDIOS
					
					$worksheet->write($celda,3,"Medios",$format_our_green2);
					$worksheet->mergeCells($celda, 3, $celda, 4);
					
					$worksheet->write($celda,5,"Responsable",$format_our_green2);
					$worksheet->mergeCells($celda, 5, $celda, 6);
					
					
					
				           $this->Model->getMedios($resultados['PK1']);
						   $contmedio = 1;
			               foreach($this->Model->medios as $medios){
			   	             
							 $celda++;
							
						
							 $worksheet->write($celda, 2, $contlinea.'.'.$contobjetivo.'.'.$contmedio);
                          //  $worksheet->setRow($celda,23);
							 
				             //MEDIOS
								
				           $worksheet->write($celda,3,$medios['MEDIO'],$multipleLineDataFormat);
				            $worksheet->mergeCells($celda, 3, $celda, 4);
							 							 
							 //RESPONSABLE RESULTADO
					         $responsable = $this->Model->getResponsable($medios['PK_RESPONSABLE']);
					       
				           
                            $worksheet->write($celda,5,$responsable,$multipleLineDataFormat);
                            $worksheet->mergeCells($celda, 5, $celda, 6);
                           
                           					        
					        
					         
					         //PORCENTAJE DE AVANCE MEDIOS
					         
					     
					         
					$numperiodo  = sizeof($periodos);
                    $fila = 1;
                    
                      $columnas = array(8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25);
                 
                    
                    foreach($periodos as $periodo){			
                    	
                    $avance = $this->Model->getAvanceMedio($periodo['PK1'],$medios['PK1']);
                    
                    $numporcent = $avance['PORCENTAJE'];
                    
                    if($numporcent == ""){ $numporcent = 0; }
                    
                   $numresul =  $contlinea.'.'.$contobjetivo.'.'.$contmedio;
                    
                  $porcentaje = $numresul.' Avance: '.$numporcent.'%';
                  
                    	
                // $sheet->setCellValue($columnas[$fila].$celda, $porcentaje);
                 $worksheet->write($celda,$columnas[$fila],$porcentaje);
                     
                    	
					$fila+=2;
					}        
							 
							 
							 $contmedio++;
				            }	
					
					
					
	             $contobjetivo++;          
	             
	               
	              //    $sheet->mergeCells('H'.$rowevidencia.':H'.$celda);
					//   $evidencias = $this->Model->getEvidencias($resultados['PK1']);
				   //    $sheet->setCellValue('H'.$rowevidencia, utf8_encode($evidencias));
	          
	          
					 $evidencias = $this->Model->getEvidencias($resultados['PK1']);				   
					 	     
				     $worksheet->write($rowevidencia,7,$evidencias,$multiplemedios);     					   
                     $worksheet->mergeCells($rowevidencia, 7, $celda, 7);
                    // $worksheet->setRow($rowevidencia, 100);  
                     
					  
					
					
					$celda++;
					
				  $worksheet->write($celda,2,"COMENTARIOS",$format_our_green2);				
	              $worksheet->mergeCells($celda, 2, $celda, 7);
	              
	              
	              
	              	              
	                 
                    //COMENTARIOS
					$numperiodo  = sizeof($periodos);
                    $fila = 1;
                    
                    $columnas = array(8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25);
                 
                 
                    
                 foreach($periodos as $periodo){
                    	   	
                // $sheet->setCellValue($columnas[$fila].$celda, "COMENTARIOS");
                $worksheet->write($celda,$columnas[$fila],"COMENTARIOS",$format_our_green2);
               //  $sheet->getStyle($columnas[$fila].$celda)->getAlignment()->setWrapText(true);	
               
                 
					$fila+=2;
					}
                    
	              
	              $celda++;
					$celdaperiodo = $celda;
					
					$celdacolumna = $celda;
					
					$numfilascomentarios = 0;
	              
	              
	             /*  */
	             
	             
	             
	             
	            	//COMENTARIOS PERIODOS
					$numperiodo  = sizeof($this->Model->periodos);
                    $fila = 1;
                    
                    $columnas = array(8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25);
                 
                foreach($this->Model->periodos as $periodo){
                   
                   $celdaperiodo =  $celdacolumna;	
                   

                   $this->Model->getComentariosResultadoPeriodo($resultados['PK1'],$periodo['PK1']);
                   
                   	$contcomentarios = 1;
					foreach($this->Model->comentariosp as $comentario){
						
			$usuario = $this->Model->getResponsable($comentario['PK_USUARIO']);
					
				   // $sheet->setCellValue($columnas[$fila].$celdaperiodo, utf8_encode($usuario).'         '.$comentario['FECHA_R']);          
 $worksheet->write($celdaperiodo,$columnas[$fila],$usuario.'         '.$comentario['FECHA_R'],$format_our_green2);
				    
                   
					$celdaperiodo++;
					
					
				//	$sheet->setCellValue($columnas[$fila].$celdaperiodo, utf8_encode($comentario['COMENTARIO']));
   $worksheet->write($celdaperiodo,$columnas[$fila],$comentario['COMENTARIO'],$multipleLineDataFormat);                
					$celdaperiodo++;
					$contcomentarios++;
					
						
						}
						
				
				
					$fila+=2;
					
					if($contcomentarios >= $numfilascomentarios){
						
						$numfilascomentarios = $contcomentarios;
						
					}
					
					$celda++;
					
					}
					
					
					
					
					$this->Model->getComentariosResultado($resultados['PK1']);
					
					foreach($this->Model->comentariosr as $comentario){
						
					$filacoment = $celda-$numperiodo;
						
				    $usuario = $this->Model->getResponsable($comentario['PK_USUARIO']);
				//	$sheet->mergeCells('D'.$filacoment.':H'.$filacoment);
				   // $sheet->setCellValue('D'.$filacoment, utf8_encode($usuario).'         '.$comentario['FECHA_R']);
				    
				   $worksheet->write($filacoment,3,$usuario.'         '.$comentario['FECHA_R'],$format_our_green2);
                    $worksheet->mergeCells($filacoment, 3, $filacoment, 7);
					  
					$celda++;
					$filacoment++;
					
				//	$sheet->getRowDimension($filacoment)->setRowHeight(56);
				//	$sheet->mergeCells('D'.$filacoment.':H'.$filacoment);
				//    $sheet->setCellValue('D'.$filacoment, utf8_encode($comentario['COMENTARIO']));
				
				  $worksheet->write($filacoment,3,$comentario['COMENTARIO'],$multipleLineDataFormat);
                    $worksheet->mergeCells($filacoment, 3, $filacoment, 7);
                   
					$celda++;	
						} 
	             
	             
	             
	             
	             
	             
	             /*  */
	             
	             
					  
			   }//END OBJETIVOS TACTICOS



$contlinea++;
$celda++;

}//END LINEAS ESTRATEGICAS

                 

    
 // Creating a worksheet
$worksheet = $workbook->addWorksheet('Diagnóstico Inicial');
//$worksheet->setInputEncoding("UTF-8");

$worksheet->write(0, 4, $jerarquia);
//$worksheet->mergeCells(1, 3, 1, 7);	

$worksheet->write(2, 1, 'En este apartado, el Rector expone un diagnóstico inicial del estado general que guarda la universidad al inicio del año.');



//$worksheet->setMerge(0, 1, 0, 7);
//$worksheet->setMerge(1, 1, 1, 7);

$worksheet->setColumn(1, 1, 10);
$worksheet->setColumn(2, 2, 10);
$worksheet->setColumn(3, 3, 50);
$worksheet->setColumn(4, 4, 40);
$worksheet->setColumn(5, 5, 12);
$worksheet->setColumn(6, 6, 12);
$worksheet->setColumn(7, 7, 30);


$worksheet->write(5, 1, 'Áreas de oportunidad',$format_our_green);
$worksheet->mergeCells(5, 1, 5, 7);



  $contcelda=7;
				
				           $this->Model->getAreas($idplan);
						   $contarea = 1;
			               foreach($this->Model->areas as $areas){
						   	
														 
							 
                            $worksheet->write($contcelda, 1,  $contarea.'.');                       
					
							
						   	  $worksheet->write($contcelda, 2, $areas['AREA']);
							
							 $worksheet->mergeCells($contcelda, 2, $contcelda, 7);
				         
				           
                          
							$contarea++;	
							$contcelda++;
							}
							
							$contcelda++;




	           $worksheet->write($contcelda, 1, 'Fortalezas',$format_our_green);
                $worksheet->mergeCells($contcelda, 1, $contcelda, 7);


                     $contcelda++;
							
                          $this->Model->getFortalezas($idplan);
						   $contarea = 1;
			               foreach($this->Model->fortalezas as $fortalezas){						   	
						
                            
							  $worksheet->write($contcelda, 1,  $contarea.'.');  				  
				         
				            
                          	   $worksheet->write($contcelda, 2, $fortalezas['FORTALEZA']);
                          	   $worksheet->mergeCells($contcelda, 2, $contcelda, 7);
                          	  
							$contarea++;	
							$contcelda++;
							}


                      $contcelda++;
			  			  
			       // $sheet2->mergeCells('C'.$contcelda.':H'.$contcelda);
				   // $sheet2->setCellValue('C'.$contcelda, "COMENTARIOS");
                   $worksheet->write($contcelda, 2, 'COMENTARIOS',$format_our_green2);
                  $worksheet->mergeCells($contcelda, 2, $contcelda, 7);

                
                    $contcelda++;
					$this->Model->getComentariosDiagnostico($idplan);
					
					foreach($this->Model->comentariosd as $comentario){
						
				    $usuario = $this->Model->getResponsable($comentario['PK_USUARIO']);				    
					
                  
                   $worksheet->write($contcelda, 3, $usuario.'         '.$comentario['PK_USUARIO']);
                   $worksheet->mergeCells($contcelda, 3, $contcelda, 7);                 
                  
					$contcelda++;					
					
				  $worksheet->write($contcelda, 3, $comentario['COMENTARIO']);
                   $worksheet->mergeCells($contcelda, 3, $contcelda, 7);
                   
					$contcelda++;	
						}

//PLAN ESTRATEGICO
$multipleLineDataFormatplab = &$workbook->addFormat( array(
'Border'=> 0, 'Align' => 'center' ) );
$multipleLineDataFormat->setTextWrap();


  
 // Creating a worksheet

$worksheet = $workbook->addWorksheet('Planeacion Estrategica');
 //$worksheet->mergeCells(0, 1, 0, 7);



$worksheet->write(0, 1, $titulo,$multipleLineDataFormatplab);
 $worksheet->mergeCells(0, 1, 0, 7);	


$worksheet->write(1, 1, $jerarquia,$multipleLineDataFormatplab);
 $worksheet->mergeCells(1, 1, 1, 7);

//$worksheet->setMerge(0, 1, 0, 7);
//$worksheet->setMerge(1, 1, 1, 7);

$worksheet->setColumn(1, 1, 10);
$worksheet->setColumn(2, 2, 10);
$worksheet->setColumn(3, 3, 50);
$worksheet->setColumn(4, 4, 40);
$worksheet->setColumn(5, 5, 12);
$worksheet->setColumn(6, 6, 12);
$worksheet->setColumn(7, 7, 30);


$celda=5;
$contlinea = 1;
foreach($this->Model->lineas as $row){

 $worksheet->write($celda, 1, 'Linea estrategica '.$contlinea.':',$format_our_green);
 
 $worksheet->mergeCells($celda, 1, $celda, 7);

$celda++;

 $worksheet->write($celda, 1, $row['LINEA']);
 $worksheet->mergeCells($celda, 1, $celda, 7);


$celda++;
$celda++;

 $worksheet->write($celda, 1, "Objetivos Estrategicos",$format_our_green2);
 $worksheet->mergeCells($celda, 1, $celda, 7);

           $contobjetivo = 1;           
           
           
           $this->Model->getObjetivosEstrategicos($row['PK1']);
		   foreach($this->Model->objetivose as $rowe){
		   	$celda++;

			//OBJETIVO ESTRATEGICO				
                   
                    $worksheet->write($celda, 1, $contobjetivo.". ".$rowe['OBJETIVO']);
                   $worksheet->mergeCells($celda, 1, $celda, 7);
                   
                   
			        $contobjetivo++;
			
			}

$contlinea++;
$celda++;
}


//COMENTARIOS GENERALES


$multipleLine = &$workbook->addFormat( array(
'Border'=> 0, 'Align' => 'center' ) );
$multipleLineDataFormat->setTextWrap();


  
 // Creating a worksheet

$worksheet = $workbook->addWorksheet('Comentarios Generales');

$worksheet->write(0, 1, $titulo,$multipleLineDataFormatplab);
 $worksheet->mergeCells(0, 1, 0, 7);	


$worksheet->write(1, 1, $jerarquia,$multipleLineDataFormatplab);
 $worksheet->mergeCells(1, 1, 1, 7);
 

  
   $worksheet->write(4, 1, "Comentarios Generales",$format3);
  $worksheet->mergeCells(4, 1, 4, 7);
 
 
 
$worksheet->setColumn(1, 1, 10);
$worksheet->setColumn(2, 2, 10);
$worksheet->setColumn(3, 3, 50);
$worksheet->setColumn(4, 4, 40);
$worksheet->setColumn(5, 5, 12);
$worksheet->setColumn(6, 6, 12);
$worksheet->setColumn(7, 7, 30);



  $contcelda=6;
				
				           $this->Model->getComentariosGenerales($idplan);
						   $contarea = 1;
			               foreach($this->Model->comentariosg as $comentario){
						   	
							       
                       
						
							//$sheet4->setCellValue('B'.$contcelda, $contarea.'.');
                         
							 $worksheet->write($contcelda, 1, $contarea.'.');
                         $worksheet->mergeCells($contcelda, 2, $contcelda, 7);
 
							
							$usuario = $this->Model->getResponsable($comentario['PK_USUARIO']);				    
							
							
							 $worksheet->write($contcelda, 2, $usuario.'         '.$comentario['FECHA_R'],$format_our_green2);
							 $worksheet->mergeCells($contcelda, 2, $contcelda, 7);
							 
							 $contcelda++;
							 
														
						 
							 $worksheet->write($contcelda, 2, $comentario['COMENTARIO']);
							 $worksheet->mergeCells($contcelda, 2, $contcelda, 7);
						
						
						
						   $contarea++;	
							$contcelda++;
						
						
							}
							
							$contcelda++;




// Let's send the file
$workbook->close();


	 }
	 
	 
static function SaveViaTempFile($objWriter){
    $filePath = '/mnt/resource/tmp/' . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
    $objWriter->save($filePath);
    readfile($filePath);
    unlink($filePath);
}
	 

	
  
	 function loadContent(){
	   	
	  
	   $this->View->template = TEMPLATE.'excel.tpl';
	   $this->View->loadTemplate();	
	  
	  
	   $section = "<table width=\"1200\">";
	   $section .= $this->getPlan();
	   $section .= $this->getLineas();
	   $section .= "</table>";
	   
	   
	   $this->View->replace_content('/\#CONTENT\#/ms' ,$section);
	
	   $this->View->viewPage();
		
		}
	 
	  
	
	   function getLineas(){
		      
		return $this->Model->getLineas();
		   	   
	   }
	
	  
	   
	  
	 
	
}

?>