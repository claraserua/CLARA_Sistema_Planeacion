<?php

require_once "../../config.php";
require_once "Spreadsheet/Excel/Writer.php";



//require_once "Spreadsheet/Excel/Writer.php";
//require_once APPDIRECTORY."Spreadsheet/Excel/Writer.php";

//require_once "../../../../libs/excel/Spreadsheet/Excel/Writer.php";
 //require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/app/planeacion/libs/excel/Spreadsheet/Excel/Writer.php');
 
 
 //D:\home\site\wwwroot/libs/excel/Spreadsheet/Excel/Writer.php
        ///site/wwwroot/app/planeacion/libs/excel/Spreadsheet/Excel

//require_once "./libs/excel/Spreadsheet/Excel/Writer.php";
//require_once "../../libs/excel/Spreadsheet/Excel/Writer.php";





/*error_reporting(E_ALL);
ini_set("display_errors", 0);*/
 
# Conexion DB
/*define('HOST','claradbp.database.windows.net');	//
define('DB', 'planeacion');
define('USERDB', 'adminserver'); //sa
define('PWDDB', 'U_p1ck_1T');//
define('TYPE', 'sqlsrv');  */


ini_set('memory_limit', '-1');

error_reporting( E_ALL );


ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


//include "models/planesoperativo/exportexcel.model.php";
//require_once 'core/dbaccess.php';
include "../../models/planesoperativo/exportexcel.model.php";
require_once '../../core/dbaccess.php';

    
	exportar();
	//prueba();
	 
function prueba(){
	header('Content-Description: File Transfer'); 
	header('Content-Type: application/vnd.ms-excel'); 
	header('Content-Transfer-Encoding: none');
	header('Pragma: public');
	ob_end_clean();
	ob_start();

	$workbook = new Spreadsheet_Excel_Writer();
	$workbook->setVersion(8); // Use Excel97/2000 Format
	$workbook->send('test.xls');

	$worksheet =& $workbook->addWorksheet('My first worksheet');
	$varDos = "���aaaaaaaaaaaaaaaaaaaaaabbbbbbbbbbbbbbbbbbbbbbbbbcccccccccccccccccccccccccddddddddddddddddddddddddd���eeeeeeeeeeeeeeeeeeeeeefffffffffffffffffffffffffggggggggggggggggggggggggghhhhhhhhhhhhhhhhhhhhhhhhhiiiiiiiiiiiiiiiiiiiiiiiiikkkkkkkkkkkkkkkkkkkkkkkkkjjjjjjjjjjjjjjjjjjjjjjjjjzzzzzzzzzzzzzzzzzzzzzz";


	$worksheet->write(0, 0, 'Name');
	$worksheet->write(0, 1, $varDos);
	$worksheet->write(1, 0, realpath($_SERVER["DOCUMENT_ROOT"]));
	$worksheet->write(1, 1, 30);
	$worksheet->write(2, 0, APPDIRECTORY);
	$worksheet->write(2, 1, 31);
	$worksheet->write(3, 0, 'Juan Herrera');
	$worksheet->write(3, 1, 32);
	
	// We still need to explicitly close the workbook
	$workbook->close();
	


}
function exportar(){
      
      
      //local
	$Model = new exportexcelModel(); 
	$plan = $Model->getPlan($_GET['IDPlan']);
	$titulo = $plan['TITULO'];
	$jerarquia = $Model->getJerarquia($plan['PK_JERARQUIA']);
	$idplan = $_GET['IDPlan'];
	//$namefile = 'media/download/'.$_GET['IDPlan'].'.xlsx';
	$file = $titulo.'.xls';
      
    //ob_end_clean();
	//ob_start();

	$workbook = new Spreadsheet_Excel_Writer();
	$workbook->setVersion(8); // Use Excel97/2000 Format
	$workbook->send($file);
	$worksheet = $workbook->addWorksheet('Plan Operativo');


	$worksheet->setColumn(1, 1, 10);
	
	$worksheet->setColumn(2, 2, 10);
	$worksheet->setColumn(3, 3, 50);
	$worksheet->setColumn(4, 4, 40);
	$worksheet->setColumn(5, 5, 12);
	$worksheet->setColumn(6, 6, 12);
	$worksheet->setColumn(7, 7, 30);



	$Model->getPeriodos($idplan);
	$periodos = $Model->periodos;

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
	
	
	$multipleLineDataFormat2 = &$workbook->addFormat( array(
	'Border'=> 0, 'Align' => 'top' ) );
	$multipleLineDataFormat2->setTextWrap();




	$worksheet->write(0, 1, $titulo,$multiple);
	$worksheet->mergeCells(0, 1, 0, 7);
	$worksheet->write(1, 1, $jerarquia,$multiple);
	$worksheet->mergeCells(1, 1, 1, 7);
	
	
	

	$worksheet->write(3, 1, 'Resultado: Acci�n propuesta que ayuda al cumplimiento de alg�n Objetivo Estrat�gico del Plan Estrat�gico de la universidad y el responsable de lograr dicho resultado.');
	$worksheet->mergeCells(3, 1, 3, 7);

	$worksheet->write(4, 1, 'Medios: Tareas a llevar a cabo para el logro del resultado y los responsables de llevarlas a cabo.');
	$worksheet->mergeCells(4, 1, 4, 7);

	$worksheet->write(5, 1, 'Evidencias propuestas: Elementos f�sicos que ayudan a evaluar el cumplimiento de los objetivos t�cticos. Ejemplos: reportes, fotograf�as, informes de reuniones, correos, etc.');
	$worksheet->mergeCells(5, 1, 5, 7);



$Model->getLineas();
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


$format_our_green4 =& $workbook->addFormat();
$format_our_green4->setFgColor(12);
$format_our_green4->setColor('16');



    
     
//aqui le

foreach($Model->lineas as $row){//LINEAS ESTRATEGICAS
	

   
$worksheet->write($celda, 1, 'L�nea estrat�gica '.$contlinea.': '.$row['LINEA'],$format_our_green);
 $worksheet->mergeCells($celda, 1, $celda, 7); 
	

                     
                      //OBJETIVOS TACTICOS
               $contobjetivo = 1;
			   $Model->getObjetivosTacticos($idplan,$row['PK1']);
			   foreach($Model->objetivos as $resultados){
			   	
				    $celda++;
					
					
					$worksheet->write($celda,2,'Resultado',$format_our_green2);
			        $worksheet->mergeCells($celda, 2, $celda, 3);
			        $worksheet->setRow($celda,26);				
					
			        
					$worksheet->write($celda,4,'Objetivo estrat�gico',$format_our_green2);
				    
					$worksheet->write($celda,5,'Responsable',$format_our_green2);
					$worksheet->mergeCells($celda, 5, $celda, 6);	 
					
				
	               $worksheet->write($celda,7,'Evidencias propuestas',$format_our_green2);						
				   //$worksheet->mergeCells($celda,7,$celda,7);

				   
				  
					// PERIODOS  
					
					 
                   $numperiodo  = sizeof($periodos);
                    $fila = 1;
                    
                    $columnas = array(8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25);
				
				
				
				    foreach($periodos as $periodo){                   
					  
										 
					//   if($periodo['PERIODO']==""||$periodo['PERIODO']==NULL){ $worksheet->write($celda,$columnas[$fila],'',$format_our_green2);}
					 //  else{  $worksheet->write($celda,$columnas[$fila],$periodo['PERIODO'],$format_our_green2); }
                                
                   //
					//$worksheet->write($celda,$columnas[$fila],'prueba',$format_our_green2);
					$worksheet->write($celda,$columnas[$fila],trim($periodo['PERIODO']),$format_our_green2);
					$worksheet->setColumn($columnas[$fila], $columnas[$fila], 60);
					
                    	
					$fila+=2;
					}
					
					
					
					
             
  
					
					$celda++;
					$rowevidencia = $celda;
					//NUMERO OBJETIVO
					$worksheet->write($celda, 1, $contlinea.'.'.$contobjetivo);
					
					$worksheet->write($celda,2,$resultados['OBJETIVO'],$multipleLineDataFormat);
					$worksheet->mergeCells($celda, 2, $celda, 3);	
					
					$oestrategico = $Model->getObjetivoEstrategico($resultados['PK_OESTRATEGICO']);
					
					 
					$worksheet->write($celda,4,$oestrategico,$multipleLineDataFormat);
					
					
					$responsable = $Model->getResponsable($resultados['PK_RESPONSABLE']);
					
					$worksheet->write($celda,5,$responsable,$multipleLineDataFormat);
				    $worksheet->mergeCells($celda, 5, $celda, 6);
				    
				    
				    
				    //PORCENTAJE DE AVANCE RESULTADOS
					
					$numperiodo  = sizeof($periodos);
                    $fila = 1;
                    
                    $columnas = array(8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25);
                 
                    
                    foreach($periodos as $periodo){
                    	
                    $avance = $Model->getAvanceResultado($periodo['PK1'],$resultados['PK1']);
                    
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
					
					
					
				           $Model->getMedios($resultados['PK1']);
						   $contmedio = 1;
			               foreach($Model->medios as $medios){
			   	             
							 $celda++;
							
						    
							 
							 
							 $worksheet->write($celda, 2, $contlinea.'.'.$contobjetivo.'.'.$contmedio);
                            $worksheet->setRow($celda,getNumRow($medios['MEDIO']));
							 
				             //MEDIOS
								
							
				           $worksheet->write($celda,3,$medios['MEDIO'],$multipleLineDataFormat);
						   $worksheet->mergeCells($celda, 3, $celda, 4);
							 // $worksheet->setRow($celda,30);
				          
							 							 
							 //RESPONSABLE RESULTADO
					         $responsable = $Model->getResponsable($medios['PK_RESPONSABLE']);
					       
				           
                            $worksheet->write($celda,5,$responsable,$multipleLineDataFormat);
                            $worksheet->mergeCells($celda, 5, $celda, 6);
                           
                           					        
					        
					         
					         //PORCENTAJE DE AVANCE MEDIOS
					         
					     
					         
					$numperiodo  = sizeof($periodos);
                    $fila = 1;
                    
                      $columnas = array(8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25);
                 
                    
                    foreach($periodos as $periodo){			
                    	
                    $avance = $Model->getAvanceMedio($periodo['PK1'],$medios['PK1']);
                    
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
	          
	          
					 $evidencias = $Model->getEvidencias($resultados['PK1']);				   
					 	     
				     $worksheet->write($rowevidencia,7,$evidencias,$multipleLineDataFormat2);   // multiplemedios      					   
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
	              
	              
	    
	             
	             
	             
	             
	            	//COMENTARIOS PERIODOS
					$numperiodo  = sizeof($Model->periodos);
                    $fila = 1;
                    
                    $columnas = array(8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25);
                 
                foreach($Model->periodos as $periodo){
                   
                   $celdaperiodo =  $celdacolumna;	
                   

                   $Model->getComentariosResultadoPeriodo($resultados['PK1'],$periodo['PK1']);
                   
                   	$contcomentarios = 1;
					foreach($Model->comentariosp as $comentario){
						
			$usuario = $Model->getResponsable($comentario['PK_USUARIO']);
					
				   // $sheet->setCellValue($columnas[$fila].$celdaperiodo, utf8_encode($usuario).'         '.$comentario['FECHA_R']);          
 $worksheet->write($celdaperiodo,$columnas[$fila],$usuario.'         '.$comentario['FECHA_R']->format('Y-m-d'),$format_our_green2);
				    
                   
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
					
					
					
					
					$Model->getComentariosResultado($resultados['PK1']);
					
					foreach($Model->comentariosr as $comentario){
						
					$filacoment = $celda-$numperiodo;
						
				    $usuario = $Model->getResponsable($comentario['PK_USUARIO']);
				
				    
				   $worksheet->write($filacoment,3,$usuario.'         '.$comentario['FECHA_R']->format('Y-m-d'),$format_our_green2);
                    $worksheet->mergeCells($filacoment, 3, $filacoment, 7);
					  
					$celda++;
					$filacoment++;
					
				
				
				  $worksheet->write($filacoment,3,$comentario['COMENTARIO'],$multipleLineDataFormat);
                    $worksheet->mergeCells($filacoment, 3, $filacoment, 7);
                   
					$celda++;	
						} 
	             
	             
	             
	             
	             
	             
	      
					  
			   }//END OBJETIVOS TACTICOS



$contlinea++;
$celda++;

}//END LINEAS ESTRATEGICAS




                

    
 // Creating a worksheet
$worksheet = $workbook->addWorksheet('Diagn�stico Inicial');
//$worksheet->setInputEncoding("UTF-8");

$worksheet->write(0, 4, $jerarquia);
//$worksheet->mergeCells(1, 3, 1, 7);	

$worksheet->write(2, 1, 'En este apartado, el Rector expone un diagn�stico inicial del estado general que guarda la universidad al inicio del a�o.');



$worksheet->setColumn(1, 1, 10);
$worksheet->setColumn(2, 2, 10);
$worksheet->setColumn(3, 3, 50);
$worksheet->setColumn(4, 4, 40);
$worksheet->setColumn(5, 5, 12);
$worksheet->setColumn(6, 6, 12);
$worksheet->setColumn(7, 7, 30);



$worksheet->write(4, 1, 'An�lisis Interno:',$format_our_green4);//comentar
$worksheet->mergeCells(4, 1, 4, 7);//comentar


$worksheet->write(5, 1, 'Fortalezas',$format_our_green);
$worksheet->mergeCells(5, 1, 5, 7);



  $contcelda=7;
				  //FORTALEZAS
				  
				           $Model->getFortalezas($idplan);
						   $contarea = 1;
			               foreach($Model->fortalezas as $fortalezas){
						   	
														 
							 
                            $worksheet->write($contcelda, 1,  $contarea.'.');                       
					
							
						   	  $worksheet->write($contcelda, 2, $fortalezas['FORTALEZA']);
							
							 $worksheet->mergeCells($contcelda, 2, $contcelda, 7);
				         
				           
                          
							$contarea++;	
							$contcelda++;
							}
							
							$contcelda++;



                   //DEBILIDADES
	           $worksheet->write($contcelda, 1, 'Debilidades',$format_our_green);
                $worksheet->mergeCells($contcelda, 1, $contcelda, 7);


                     $contcelda++;
							
                          $Model->getAreas($idplan);
						   $contarea = 1;
			               foreach($Model->areas as $areas){						   	
						
                            
							  $worksheet->write($contcelda, 1,  $contarea.'.');  				  
				         
				            
                          	   $worksheet->write($contcelda, 2, $areas['AREA']);
                          	   $worksheet->mergeCells($contcelda, 2, $contcelda, 7);
                          	  
							$contarea++;	
							$contcelda++;
							}

                      $contcelda++;
                      
                      
                      
                      
                  /***********inicio nuevos********/
                  
                $contcelda++;//comentar                  
                $worksheet->write($contcelda, 1, 'An�lisis Externo:',$format_our_green4);//comentar
                $worksheet->mergeCells($contcelda, 1, $contcelda, 7);//comentar                  
                $contcelda++;//comentar
                                    
                    //OPORTUNIDADES
                $worksheet->write($contcelda, 1, 'Oportunidades',$format_our_green);
                $worksheet->mergeCells($contcelda, 1, $contcelda, 7);


                     $contcelda++;
							
                          $Model->getOportunidades($idplan);
						   $contarea = 1;
			               foreach($Model->oportunidades as $oportunidades){						   	
						
                            
							  $worksheet->write($contcelda, 1,  $contarea.'.');  				  
				         
				            
                          	   $worksheet->write($contcelda, 2, $oportunidades['OPORTUNIDADES']);
                          	   $worksheet->mergeCells($contcelda, 2, $contcelda, 7);
                          	  
							$contarea++;	
							$contcelda++;
							}

                      $contcelda++;
                      
                      
                      
                      //AMENAZAS
                      
                      
                    //  $worksheet->write($contcelda, 1, 'Amenazas',$format_our_green); 
                      
                    $worksheet->write($contcelda, 1, 'Amenazas',$format_our_green);
                    $worksheet->mergeCells($contcelda, 1, $contcelda, 7);


                     $contcelda++;
							
                          $Model->getAmenazas($idplan);
						   $contarea = 1;
			               foreach($Model->amenazas as $amenazas){						   	
						
                            
							  $worksheet->write($contcelda, 1,  $contarea.'.');  				  
				         
				            
                          	   $worksheet->write($contcelda, 2, $amenazas['AMENAZAS']);
                          	   $worksheet->mergeCells($contcelda, 2, $contcelda, 7);
                          	  
							$contarea++;	
							$contcelda++;
							}

                      $contcelda++;
                  
                                
                  
                  
                  /*****fin nuevos****/     
            
                                           
                      
                        $contcelda++;//checar**
			  			  
			       // $sheet2->mergeCells('C'.$contcelda.':H'.$contcelda);
				   // $sheet2->setCellValue('C'.$contcelda, "COMENTARIOS");
                   $worksheet->write($contcelda, 2, 'COMENTARIOS',$format_our_green2);
                  $worksheet->mergeCells($contcelda, 2, $contcelda, 7);

                
                    $contcelda++;
					$Model->getComentariosDiagnostico($idplan);
					
					foreach($Model->comentariosd as $comentario){
						
				    $usuario = $Model->getResponsable($comentario['PK_USUARIO']);				    
					
                  
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

$worksheet = $workbook->addWorksheet('Planeaci�n Estrat�gica');
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
foreach($Model->lineas as $row){

 $worksheet->write($celda, 1, 'L�nea estrat�gica '.$contlinea.':',$format_our_green);
 
 $worksheet->mergeCells($celda, 1, $celda, 7);

$celda++;

 $worksheet->write($celda, 1, $row['LINEA']);
 $worksheet->mergeCells($celda, 1, $celda, 7);


$celda++;
$celda++;

 $worksheet->write($celda, 1, "Objetivos Estrat�gicos",$format_our_green2);
 $worksheet->mergeCells($celda, 1, $celda, 7);

           $contobjetivo = 1;           
           
           
           $Model->getObjetivosEstrategicos($row['PK1']);
		   foreach($Model->objetivose as $rowe){
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
				
				           $Model->getComentariosGenerales($idplan);
						   $contarea = 1;
			               foreach($Model->comentariosg as $comentario){
						   	
							       
                       
						
							//$sheet4->setCellValue('B'.$contcelda, $contarea.'.');
                         
							 $worksheet->write($contcelda, 1, $contarea.'.');
                         $worksheet->mergeCells($contcelda, 2, $contcelda, 7);
 
							
							$usuario = $Model->getResponsable($comentario['PK_USUARIO']);				    
							
							
							 $worksheet->write($contcelda, 2, $usuario.'         '.$comentario['FECHA_R']->format('Y-m-d'),$format_our_green2);
							 $worksheet->mergeCells($contcelda, 2, $contcelda, 7);
							 
							 $contcelda++;
							 
														
						 
							 $worksheet->write($contcelda, 2, $comentario['COMENTARIO']);
							 $worksheet->mergeCells($contcelda, 2, $contcelda, 7);
						
						
						
						   $contarea++;	
							$contcelda++;
						
						
							}
							
							$contcelda++;

	
	
	$workbook->close();
}


function getNumRow($cadena){
	
	
  $num = strlen(trim($cadena));
  
  $numero = round($num/100);
  
  $num = $numero*26;
  
  return $num;
  
  
}


    

?>