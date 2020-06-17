<?php
include "models/planesoperativo/exportexcel.model.php";


/** Include PHPExcel */
require_once 'libs/excel/excel/Classes/PHPExcel.php';

/** Include PHPExcel_IOFactory */
require_once 'libs/excel/excel/Classes/PHPExcel/IOFactory.php';


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


        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp; 
		$cacheSettings = array( 'memoryCacheSize' => '32MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);	
    
    $objPHPExcel = new PHPExcel();
    
    $objPHPExcel->getProperties()->setCreator("Sistema de Planeación")
							 ->setLastModifiedBy("Sistema de Planeación")
							 ->setTitle($plan['TITULO'])
							 ->setSubject($plan['TITULO'])
							 ->setDescription("Plan Operativo.")
							 ->setKeywords("Plan Operativo")
							 ->setCategory("Plan Operativo");
    		
$objPHPExcel->setActiveSheetIndex(0);

$sheet = $objPHPExcel->getActiveSheet();
$sheet->setTitle('Plan Operativo');



$sheet->mergeCells('B1:H1');
$sheet->getStyle('B1:H1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$sheet->getStyle('B1:H1')->getFill()->getStartColor()->setARGB('FF7C4300');
$sheet->setCellValue('B1', utf8_encode($titulo));
//$sheet->getStyle('B1')->getFont()->setName('Tahoma');
//$sheet->getStyle('B1')->getFont()->setSize(10);
//$sheet->getStyle('B1')->getFont()->setBold(true);
//$sheet->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$sheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$sheet->mergeCells('B2:H2');
//$sheet->getStyle('B2:H2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$sheet->getStyle('B2:H2')->getFill()->getStartColor()->setARGB('FF7C4300');
$sheet->setCellValue('B2', utf8_encode($jerarquia));
//$sheet->getStyle('B2')->getFont()->setName('Tahoma');
//$sheet->getStyle('B2')->getFont()->setSize(10);
//$sheet->getStyle('B2')->getFont()->setBold(true);
//$sheet->getStyle('B2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$sheet->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$sheet->getColumnDimension('B')->setWidth(10);
$sheet->getColumnDimension('C')->setWidth(10);
$sheet->getColumnDimension('D')->setWidth(50);
$sheet->getColumnDimension('E')->setWidth(40);
$sheet->getColumnDimension('F')->setWidth(12);
$sheet->getColumnDimension('G')->setWidth(12);
$sheet->getColumnDimension('H')->setWidth(30);



$sheet->setCellValue('B4', 'En el plan se describe lo siguiente:');
//$sheet->getStyle('B4')->getFont()->setName('Tahoma');
//$sheet->getStyle('B4')->getFont()->setSize(8);
//$sheet->getStyle('B4')->getFont()->setBold(true);

$sheet->setCellValue('B5', 'Resultado: Acción propuesta que ayuda al cumplimiento de algún Objetivo Estratégico del Plan Estratégico de la universidad y el responsable de lograr dicho resultado.');
//$sheet->getStyle('B5')->getFont()->setName('Tahoma');
//$sheet->getStyle('B5')->getFont()->setSize(8);
//$sheet->getStyle('B5')->getFont()->setBold(true);

$sheet->setCellValue('B6', 'Medios: Tareas a llevar a cabo para el logro del objetivo táctico y los responsables de llevarlas a cabo.');
//$sheet->getStyle('B6')->getFont()->setName('Tahoma');
//$sheet->getStyle('B6')->getFont()->setSize(8);
//$sheet->getStyle('B6')->getFont()->setBold(true);


$sheet->setCellValue('B7', 'Evidencias propuestas: Elementos físicos que ayudan a evaluar el cumplimiento de los objetivos tácticos. Ejemplos: reportes, fotografías, informes de reuniones, correos, etc.');
//$sheet->getStyle('B7')->getFont()->setName('Tahoma');
//$sheet->getStyle('B7')->getFont()->setSize(8);
//$sheet->getStyle('B7')->getFont()->setBold(true);


$sheet->mergeCells('B9:H9');
//$sheet->getStyle('B9:H9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$sheet->getStyle('B9:H9')->getFill()->getStartColor()->setARGB('FFD9D9D9');


$this->Model->getPeriodos($idplan);
$periodos = $this->Model->periodos;


$this->Model->getLineas();
$celda=10;
$contlinea = 1;
foreach($this->Model->lineas as $row){
	
$sheet->setCellValue('B'.$celda, 'Línea estratégica '.$contlinea.': '.utf8_encode($row['LINEA']));
//$sheet->getStyle('B'.$celda)->getFont()->setName('Tahoma');
//$sheet->getStyle('B'.$celda)->getFont()->setSize(9);
//$sheet->getStyle('B'.$celda)->getFont()->setBold(true);
//$sheet->getStyle('B'.$celda)->getFont()->getColor()->setARGB('FF7C4300');

$sheet->mergeCells('B'.$celda.':H'.$celda);
//$sheet->getStyle('B'.$celda.':H'.$celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$sheet->getStyle('B'.$celda.':H'.$celda)->getFill()->getStartColor()->setARGB('FFF8991D');

                    

                  
               //OBJETIVOS TACTICOS
               $contobjetivo = 1;
			   $this->Model->getObjetivosTacticos($idplan,$row['PK1']);
			   
			   foreach($this->Model->objetivos as $resultados){
			   	
				    $celda++;
					
					
					$sheet->getRowDimension($celda)->setRowHeight(26);
				    $sheet->mergeCells('C'.$celda.':D'.$celda);
				    $sheet->setCellValue('C'.$celda, 'Resultado');
                    //$sheet->getStyle('C'.$celda)->getFont()->setName('Tahoma');
                   // $sheet->getStyle('C'.$celda)->getFont()->setSize(8);
					//$sheet->getStyle('C'.$celda)->getFont()->setBold(true);
					//$sheet->getStyle('C'.$celda.':D'.$celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                  //  $sheet->getStyle('C'.$celda.':D'.$celda)->getFill()->getStartColor()->setARGB('FFD9D9D9');
					
					
					
				    $sheet->setCellValue('E'.$celda, 'Objetivo estratégico');
                   // $sheet->getStyle('E'.$celda)->getFont()->setName('Tahoma');
                   // $sheet->getStyle('E'.$celda)->getFont()->setSize(8);
					//$sheet->getStyle('E'.$celda)->getFont()->setBold(true);
				//	$sheet->getStyle('E'.$celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                  //  $sheet->getStyle('E'.$celda)->getFill()->getStartColor()->setARGB('FFD9D9D9');
					
					$sheet->mergeCells('F'.$celda.':G'.$celda);
					$sheet->setCellValue('F'.$celda, 'Responsable');
                  //  $sheet->getStyle('F'.$celda)->getFont()->setName('Tahoma');
                  //  $sheet->getStyle('F'.$celda)->getFont()->setSize(8);
				//	$sheet->getStyle('F'.$celda)->getFont()->setBold(true);
				//	$sheet->getStyle('F'.$celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                  //  $sheet->getStyle('F'.$celda)->getFill()->getStartColor()->setARGB('FFD9D9D9');
					
					
					
					$sheet->setCellValue('H'.$celda, 'Evidencias propuestas');
                   // $sheet->getStyle('H'.$celda)->getFont()->setName('Tahoma');
                   // $sheet->getStyle('H'.$celda)->getFont()->setSize(8);
					//$sheet->getStyle('H'.$celda)->getFont()->setBold(true);
					//$sheet->getStyle('H'.$celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                //    $sheet->getStyle('H'.$celda)->getFill()->getStartColor()->setARGB('FFD9D9D9');
                    
                    
                    
                    
                    
                    
                    $numperiodo  = sizeof($periodos);
                    $fila = 1;
                    
                    $columnas = array("I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
                 
                    
                    foreach($periodos as $periodo){
                    	
                    $sheet->setCellValue($columnas[$fila].$celda, $periodo['PERIODO']);
                    $sheet->getStyle($columnas[$fila].$celda)->getFont()->setName('Tahoma');
                   // $sheet->getStyle($columnas[$fila].$celda)->getFont()->setSize(8);
					//$sheet->getStyle($columnas[$fila].$celda)->getFont()->setBold(true);
				//	$sheet->getStyle($columnas[$fila].$celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                 //   $sheet->getStyle($columnas[$fila].$celda)->getFill()->getStartColor()->setARGB('FFD9D9D9');   
                  //  $sheet->getStyle($columnas[$fila].$celda)->getAlignment()->setWrapText(true);
                     
                     
                     $sheet->getColumnDimension($columnas[$fila])->setWidth(60);
                    	
					$fila+=2;
					}
                    
                    
  
			   	
				    $celda++;
					$rowevidencia = $celda;
					//NUMERO OBJETIVO
					$sheet->getRowDimension($celda)->setRowHeight(30);
					$sheet->setCellValue('B'.$celda, $contlinea.'.'.$contobjetivo);
                  //  $sheet->getStyle('B'.$celda)->getFont()->setName('Tahoma');
                   // $sheet->getStyle('B'.$celda)->getFont()->setSize(8);
					
				     //OBJETIVO TACTICO
					
				    $sheet->mergeCells('C'.$celda.':D'.$celda);
				    $sheet->setCellValue('C'.$celda, utf8_encode($resultados['OBJETIVO']));
                   // $sheet->getStyle('C'.$celda)->getFont()->setName('Tahoma');
                   // $sheet->getStyle('C'.$celda)->getFont()->setSize(8);
					//$sheet->getStyle('C'.$celda)->getAlignment()->setWrapText(true);
					
					//OBJETIVO ESTRATEGICO
					$oestrategico = $this->Model->getObjetivoEstrategico($resultados['PK_OESTRATEGICO']);
				    $sheet->setCellValue('E'.$celda, utf8_encode($oestrategico));
                  //  $sheet->getStyle('E'.$celda)->getFont()->setName('Tahoma');
                   // $sheet->getStyle('E'.$celda)->getFont()->setSize(8);
					//$sheet->getStyle('E'.$celda)->getAlignment()->setWrapText(true);
					
					//RESPONSABLE RESULTADO
					$responsable = $this->Model->getResponsable($resultados['PK_RESPONSABLE']);
					$sheet->mergeCells('F'.$celda.':G'.$celda);
				    $sheet->setCellValue('F'.$celda, utf8_encode($responsable));
                  //  $sheet->getStyle('F'.$celda)->getFont()->setName('Tahoma');
                  //  $sheet->getStyle('F'.$celda)->getFont()->setSize(8);
					//$sheet->getStyle('F'.$celda)->getAlignment()->setWrapText(true);
					
					
					//PORCENTAJE DE AVANCE RESULTADOS
					
					$numperiodo  = sizeof($periodos);
                    $fila = 1;
                    
                    $columnas = array("I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
                 
                    
                    foreach($periodos as $periodo){
                    	
                    $avance = $this->Model->getAvanceResultado($periodo['PK1'],$resultados['PK1']);
                    
                    $numporcent = $avance['PORCENTAJE'];
                    
                    if($numporcent == ""){ $numporcent = 0; }
                    
                   $numresul =  $contlinea.'.'.$contobjetivo;
                    
                  $porcentaje = $numresul.' Avance: '.$numporcent.'%';
                    	
                 $sheet->setCellValue($columnas[$fila].$celda, $porcentaje);
                // $sheet->getStyle($columnas[$fila].$celda)->getFont()->setName('Tahoma');
                // $sheet->getStyle($columnas[$fila].$celda)->getFont()->setSize(12);
				// $sheet->getStyle($columnas[$fila].$celda)->getFont()->setBold(true);
					
               //  $sheet->getStyle($columnas[$fila].$celda)->getAlignment()->setWrapText(true);
                     
                    	
					$fila+=2;
					}
					
			
					$celda++;
					
					//MEDIOS
				    $sheet->mergeCells('D'.$celda.':E'.$celda);
				    $sheet->setCellValue('D'.$celda, 'Medios');
                  //  $sheet->getStyle('D'.$celda)->getFont()->setName('Tahoma');
                  //  $sheet->getStyle('D'.$celda)->getFont()->setSize(8);
					//$sheet->getStyle('D'.$celda)->getFont()->setBold(true);
					//$sheet->getStyle('D'.$celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                   // $sheet->getStyle('D'.$celda)->getFill()->getStartColor()->setARGB('FFD9D9D9');	
				
				    $sheet->mergeCells('F'.$celda.':G'.$celda);
				    $sheet->setCellValue('F'.$celda, 'Responsable');
                   // $sheet->getStyle('F'.$celda)->getFont()->setName('Tahoma');
                  //  $sheet->getStyle('F'.$celda)->getFont()->setSize(8);
					//$sheet->getStyle('F'.$celda)->getFont()->setBold(true);
					//$sheet->getStyle('F'.$celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                  //  $sheet->getStyle('F'.$celda)->getFill()->getStartColor()->setARGB('FFD9D9D9');
					
					
					  
					  
						
				
				           $this->Model->getMedios($resultados['PK1']);
						   $contmedio = 1;
			               foreach($this->Model->medios as $medios){
			   	             
							 $celda++;
							 $sheet->getRowDimension($celda)->setRowHeight(23);
							 $sheet->setCellValue('C'.$celda, $contlinea.'.'.$contobjetivo.'.'.$contmedio);
                           //  $sheet->getStyle('C'.$celda)->getFont()->setName('Tahoma');
                           // $sheet->getStyle('C'.$celda)->getFont()->setSize(8);
							 
				             //MEDIOS
							 
				             $sheet->mergeCells('D'.$celda.':E'.$celda);
				             $sheet->setCellValue('D'.$celda, utf8_encode($medios['MEDIO']));
                           //  $sheet->getStyle('D'.$celda)->getFont()->setName('Tahoma');
                           //  $sheet->getStyle('D'.$celda)->getFont()->setSize(8);
					       //  $sheet->getStyle('D'.$celda.':E'.$celda)->getAlignment()->setWrapText(true);
							
							 
							 
							 //RESPONSABLE RESULTADO
					         $responsable = $this->Model->getResponsable($medios['PK_RESPONSABLE']);
					         $sheet->mergeCells('F'.$celda.':G'.$celda);
				             $sheet->setCellValue('F'.$celda, utf8_encode($responsable));
                            // $sheet->getStyle('F'.$celda)->getFont()->setName('Tahoma');
                            // $sheet->getStyle('F'.$celda)->getFont()->setSize(8);
					       //  $sheet->getStyle('F'.$celda)->getAlignment()->setWrapText(true);
					         
					         //PORCENTAJE DE AVANCE MEDIOS
					$numperiodo  = sizeof($periodos);
                    $fila = 1;
                    
                    $columnas = array("I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
                 
                    
                    foreach($periodos as $periodo){
                    	
                    $avance = $this->Model->getAvanceMedio($periodo['PK1'],$medios['PK1']);
                    
                    $numporcent = $avance['PORCENTAJE'];
                    
                    if($numporcent == ""){ $numporcent = 0; }
                    
                   $numresul =  $contlinea.'.'.$contobjetivo.'.'.$contmedio;
                    
                  $porcentaje = $numresul.' Avance: '.$numporcent.'%';
                    	
                 $sheet->setCellValue($columnas[$fila].$celda, $porcentaje);
                 //$sheet->getStyle($columnas[$fila].$celda)->getFont()->setName('Tahoma');
                // $sheet->getStyle($columnas[$fila].$celda)->getFont()->setSize(10);
				// $sheet->getStyle($columnas[$fila].$celda)->getFont()->setBold(true);
					
                // $sheet->getStyle($columnas[$fila].$celda)->getAlignment()->setWrapText(true);
                     
                    	
					$fila+=2;
					}
					         
							 
							 
							 $contmedio++;
				            }
							
					   $contobjetivo++;
							
			           $sheet->mergeCells('H'.$rowevidencia.':H'.$celda);
					   $evidencias = $this->Model->getEvidencias($resultados['PK1']);
				       $sheet->setCellValue('H'.$rowevidencia, utf8_encode($evidencias));
                      // $sheet->getStyle('H'.$rowevidencia)->getFont()->setName('Tahoma');
                     //  $sheet->getStyle('H'.$rowevidencia)->getFont()->setSize(8);
					//   $sheet->getStyle('H'.$rowevidencia)->getAlignment()->setWrapText(true);
					   $sheet->getStyle('H'.$rowevidencia)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					
					
					$celda++;
					
					
					//COMENTARIOS DE RESULTADO
					$sheet->mergeCells('C'.$celda.':H'.$celda);
				    $sheet->setCellValue('C'.$celda, "COMENTARIOS");
                    $sheet->getStyle('C'.$celda)->getFont()->setName('Tahoma');
                   // $sheet->getStyle('C'.$celda)->getFont()->setSize(8);
					//$sheet->getStyle('C'.$celda)->getFont()->setBold(true);
					//$sheet->getStyle('C'.$celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                   // $sheet->getStyle('C'.$celda)->getFill()->getStartColor()->setARGB('FFD9D9D9');
                    
                    
                    
                    //COMENTARIOS
					$numperiodo  = sizeof($periodos);
                    $fila = 1;
                    
                    $columnas = array("I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
                 
                    
                 foreach($periodos as $periodo){
                    	   	
                 $sheet->setCellValue($columnas[$fila].$celda, "COMENTARIOS");
               //  $sheet->getStyle($columnas[$fila].$celda)->getFont()->setName('Tahoma');
                // $sheet->getStyle($columnas[$fila].$celda)->getFont()->setSize(10);
				// $sheet->getStyle($columnas[$fila].$celda)->getFont()->setBold(true);
                 $sheet->getStyle($columnas[$fila].$celda)->getAlignment()->setWrapText(true);	
               //  $sheet->getStyle($columnas[$fila].$celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
               //  $sheet->getStyle($columnas[$fila].$celda)->getFill()->getStartColor()->setARGB('FFD9D9D9');
                 
					$fila+=2;
					}
                    
				
					$celda++;
					$celdaperiodo = $celda;
					
					$celdacolumna = $celda;
					
					$numfilascomentarios = 0;
					
					
					//COMENTARIOS PERIODOS
					$numperiodo  = sizeof($periodos);
                    $fila = 1;
                    
                    $columnas = array("I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
                 /*
                    foreach($periodos as $periodo){
                   
                   $celdaperiodo =  $celdacolumna;	
                   

                   $this->Model->getComentariosResultadoPeriodo($resultados['PK1'],$periodo['PK1']);
                   
                   	$contcomentarios = 1;
					foreach($this->Model->comentariosp as $comentario){
						
			        $usuario = $this->Model->getResponsable($comentario['PK_USUARIO']);
					
				    $sheet->setCellValue($columnas[$fila].$celdaperiodo, utf8_encode($usuario).'         '.$comentario['FECHA_R']);
				    
                    $sheet->getStyle($columnas[$fila].$celdaperiodo)->getFont()->setName('Tahoma');
                    $sheet->getStyle($columnas[$fila].$celdaperiodo)->getFont()->setSize(8);
					$sheet->getStyle($columnas[$fila].$celdaperiodo)->getFont()->setBold(true);
					$sheet->getStyle($columnas[$fila].$celdaperiodo)->getAlignment()->setWrapText(true);
					$sheet->getStyle($columnas[$fila].$celdaperiodo)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                    $sheet->getStyle($columnas[$fila].$celdaperiodo)->getFill()->getStartColor()->setARGB('FFD9D9D9');
						
					$celdaperiodo++;
					
					$sheet->getRowDimension($columnas[$fila].$celdaperiodo)->setRowHeight(56);
					$sheet->setCellValue($columnas[$fila].$celdaperiodo, utf8_encode($comentario['COMENTARIO']));
                    $sheet->getStyle($columnas[$fila].$celdaperiodo)->getFont()->setName('Tahoma');
                    $sheet->getStyle($columnas[$fila].$celdaperiodo)->getFont()->setSize(8);
					$sheet->getStyle($columnas[$fila].$celdaperiodo)->getAlignment()->setWrapText(true);
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
					$sheet->mergeCells('D'.$filacoment.':H'.$filacoment);
				    $sheet->setCellValue('D'.$filacoment, utf8_encode($usuario).'         '.$comentario['FECHA_R']);
                    $sheet->getStyle('D'.$filacoment)->getFont()->setName('Tahoma');
                    $sheet->getStyle('D'.$filacoment)->getFont()->setSize(8);
					$sheet->getStyle('D'.$filacoment)->getFont()->setBold(true);
					$sheet->getStyle('D'.$filacoment)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                    $sheet->getStyle('D'.$filacoment)->getFill()->getStartColor()->setARGB('FFD9D9D9');
						
					$celda++;
					$filacoment++;
					
					$sheet->getRowDimension($filacoment)->setRowHeight(56);
					$sheet->mergeCells('D'.$filacoment.':H'.$filacoment);
				    $sheet->setCellValue('D'.$filacoment, utf8_encode($comentario['COMENTARIO']));
                    $sheet->getStyle('D'.$filacoment)->getFont()->setName('Tahoma');
                    $sheet->getStyle('D'.$filacoment)->getFont()->setSize(8);
					$sheet->getStyle('D'.$filacoment)->getAlignment()->setWrapText(true);
					$celda++;	
						}
				*/		
						
					  
			   }
 

			   
$contlinea++;
$celda++;	
	}

$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(1);
$sheet2 = $objPHPExcel->getActiveSheet();
$sheet2->setTitle('Diagnóstico Inicial');
$sheet2->mergeCells('B1:H1');
//$sheet2->getStyle('B1:H1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$sheet2->getStyle('B1:H1')->getFill()->getStartColor()->setARGB('FF7C4300');
//$sheet2->setCellValue('B1', utf8_encode($titulo));
//$sheet2->getStyle('B1')->getFont()->setName('Tahoma');
//$sheet2->getStyle('B1')->getFont()->setSize(10);
//$sheet2->getStyle('B1')->getFont()->setBold(true);
//$sheet2->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
//$sheet2->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$sheet2->mergeCells('B2:H2');
//$sheet2->getStyle('B2:H2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$sheet2->getStyle('B2:H2')->getFill()->getStartColor()->setARGB('FF7C4300');
$sheet2->setCellValue('B2', utf8_encode($jerarquia));
//$sheet2->getStyle('B2')->getFont()->setName('Tahoma');
//$sheet2->getStyle('B2')->getFont()->setSize(10);
//$sheet2->getStyle('B2')->getFont()->setBold(true);
//$sheet2->getStyle('B2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$sheet2->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$sheet2->getColumnDimension('B')->setWidth(10);
$sheet2->getColumnDimension('C')->setWidth(10);
$sheet2->getColumnDimension('D')->setWidth(50);
$sheet2->getColumnDimension('E')->setWidth(40);
$sheet2->getColumnDimension('F')->setWidth(12);
$sheet2->getColumnDimension('G')->setWidth(12);
$sheet2->getColumnDimension('H')->setWidth(30);



$sheet2->setCellValue('B4', 'En este apartado, el Rector expone un diagnóstico inicial del estado general que guarda la universidad al inicio del año.');
//$sheet2->getStyle('B4')->getFont()->setName('Tahoma');
//$sheet2->getStyle('B4')->getFont()->setSize(8);
//$sheet2->getStyle('B4')->getFont()->setBold(true);


$sheet2->mergeCells('B6:H6');
//$sheet2->getStyle('B6:H6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$sheet2->getStyle('B6:H6')->getFill()->getStartColor()->setARGB('FFF8991D');
$sheet2->setCellValue('B6', 'Áreas de oportunidad');
//$sheet2->getStyle('B6')->getFont()->setName('Tahoma');
//$sheet2->getStyle('B6')->getFont()->setSize(9);
//$sheet2->getStyle('B6')->getFont()->setBold(true);
//$sheet2->getStyle('B6')->getFont()->getColor()->setARGB('FF7C4300');

                           $contcelda=7;
				
				           $this->Model->getAreas($idplan);
						   $contarea = 1;
			               foreach($this->Model->areas as $areas){
						   	
							 $sheet2->setCellValue('B'.$contcelda, $contarea.'.');
                            // $sheet2->getStyle('B'.$contcelda)->getFont()->setName('Tahoma');
                           //  $sheet2->getStyle('B'.$contcelda)->getFont()->setSize(8);
					         $sheet2->getStyle('B'.$contcelda.':H'.$contcelda)->getAlignment()->setWrapText(true);
							
						   	 
							 $sheet2->mergeCells('C'.$contcelda.':H'.$contcelda);
				             $sheet2->setCellValue('C'.$contcelda, utf8_encode($areas['AREA']));
                            // $sheet2->getStyle('C'.$contcelda)->getFont()->setName('Tahoma');
                           //  $sheet2->getStyle('C'.$contcelda)->getFont()->setSize(8);
					      //   $sheet2->getStyle('C'.$contcelda.':H'.$contcelda)->getAlignment()->setWrapText(true);
							$contarea++;	
							$contcelda++;
							}
							
							$contcelda++;
							
$sheet2->mergeCells('B'.$contcelda.':H'.$contcelda);
$sheet2->getStyle('B'.$contcelda.':H'.$contcelda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$sheet2->getStyle('B'.$contcelda.':H'.$contcelda)->getFill()->getStartColor()->setARGB('FFF8991D');
$sheet2->setCellValue('B'.$contcelda, 'Fortalezas');
//$sheet2->getStyle('B'.$contcelda)->getFont()->setName('Tahoma');
//$sheet2->getStyle('B'.$contcelda)->getFont()->setSize(9);
//$sheet2->getStyle('B'.$contcelda)->getFont()->setBold(true);
//$sheet2->getStyle('B'.$contcelda)->getFont()->getColor()->setARGB('FF7C4300');

                            $contcelda++;
							
                          $this->Model->getFortalezas($idplan);
						   $contarea = 1;
			               foreach($this->Model->fortalezas as $fortalezas){
						   	
							 $sheet2->setCellValue('B'.$contcelda, $contarea.'.');
                             //$sheet2->getStyle('B'.$contcelda)->getFont()->setName('Tahoma');
                            // $sheet2->getStyle('B'.$contcelda)->getFont()->setSize(8);
					       //  $sheet2->getStyle('B'.$contcelda.':H'.$contcelda)->getAlignment()->setWrapText(true);
							
						   	 
							 $sheet2->mergeCells('C'.$contcelda.':H'.$contcelda);
				             $sheet2->setCellValue('C'.$contcelda, utf8_encode($fortalezas['FORTALEZA']));
                           //  $sheet2->getStyle('C'.$contcelda)->getFont()->setName('Tahoma');
                           //  $sheet2->getStyle('C'.$contcelda)->getFont()->setSize(8);
					       //  $sheet2->getStyle('C'.$contcelda.':H'.$contcelda)->getAlignment()->setWrapText(true);
							$contarea++;	
							$contcelda++;
							}


                    $contcelda++;
			  			  
			        $sheet2->mergeCells('C'.$contcelda.':H'.$contcelda);
				    $sheet2->setCellValue('C'.$contcelda, "COMENTARIOS");
                   // $sheet2->getStyle('C'.$contcelda)->getFont()->setName('Tahoma');
                   // $sheet2->getStyle('C'.$contcelda)->getFont()->setSize(8);
					//$sheet2->getStyle('C'.$contcelda)->getFont()->setBold(true);
					//$sheet2->getStyle('C'.$contcelda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                   // $sheet2->getStyle('C'.$contcelda)->getFill()->getStartColor()->setARGB('FFD9D9D9');
					
					$contcelda++;
					$this->Model->getComentariosDiagnostico($idplan);
					
					foreach($this->Model->comentariosd as $comentario){
						
				    $usuario = $this->Model->getResponsable($comentario['PK_USUARIO']);
					$sheet2->mergeCells('D'.$contcelda.':H'.$contcelda);
				    $sheet2->setCellValue('D'.$contcelda, $usuario.'         '.$comentario['FECHA_R']);
                   // $sheet2->getStyle('D'.$contcelda)->getFont()->setName('Tahoma');
                  //  $sheet2->getStyle('D'.$contcelda)->getFont()->setSize(8);
					//$sheet2->getStyle('D'.$contcelda)->getFont()->setBold(true);
					//$sheet2->getStyle('D'.$contcelda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                   // $sheet2->getStyle('D'.$contcelda)->getFill()->getStartColor()->setARGB('FFD9D9D9');
						
					$contcelda++;
					
					$sheet2->getRowDimension($contcelda)->setRowHeight(56);
					$sheet2->mergeCells('D'.$contcelda.':H'.$contcelda);
				    $sheet2->setCellValue('D'.$contcelda, utf8_encode($comentario['COMENTARIO']));
                   // $sheet2->getStyle('D'.$contcelda)->getFont()->setName('Tahoma');
                   // $sheet2->getStyle('D'.$contcelda)->getFont()->setSize(8);
					//$sheet2->getStyle('D'.$contcelda)->getAlignment()->setWrapText(true);
					$contcelda++;	
						}



//PLAN ESTRATEGICO

$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(2);
$sheet3 = $objPHPExcel->getActiveSheet();
$sheet3->setTitle('Planeación Estratégica');
$sheet3->mergeCells('B1:H1');
$sheet3->getStyle('B1:H1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$sheet3->getStyle('B1:H1')->getFill()->getStartColor()->setARGB('FF7C4300');
$sheet3->setCellValue('B1', utf8_encode($titulo));
//$sheet3->getStyle('B1')->getFont()->setName('Tahoma');
//$sheet3->getStyle('B1')->getFont()->setSize(10);
//$sheet3->getStyle('B1')->getFont()->setBold(true);
//$sheet3->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$sheet3->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$sheet3->mergeCells('B2:H2');
//$sheet3->getStyle('B2:H2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$sheet3->getStyle('B2:H2')->getFill()->getStartColor()->setARGB('FF7C4300');
$sheet3->setCellValue('B2', utf8_encode($jerarquia));
//$sheet3->getStyle('B2')->getFont()->setName('Tahoma');
////$sheet3->getStyle('B2')->getFont()->setSize(10);
//$sheet3->getStyle('B2')->getFont()->setBold(true);
//$sheet3->getStyle('B2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$sheet3->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$sheet3->getColumnDimension('B')->setWidth(10);
$sheet3->getColumnDimension('C')->setWidth(10);
$sheet3->getColumnDimension('D')->setWidth(50);
$sheet3->getColumnDimension('E')->setWidth(40);
$sheet3->getColumnDimension('F')->setWidth(12);
$sheet3->getColumnDimension('G')->setWidth(12);
$sheet3->getColumnDimension('H')->setWidth(30);




$celda=5;
$contlinea = 1;
foreach($this->Model->lineas as $row){
	
$sheet3->setCellValue('B'.$celda, 'Línea estratégica '.$contlinea.':');
//$sheet3->getStyle('B'.$celda)->getFont()->setName('Tahoma');
//$sheet3->getStyle('B'.$celda)->getFont()->setSize(9);
//$sheet3->getStyle('B'.$celda)->getFont()->setBold(true);
//$sheet3->getStyle('B'.$celda)->getFont()->getColor()->setARGB('FF7C4300');

$sheet3->mergeCells('B'.$celda.':H'.$celda);
//$sheet3->getStyle('B'.$celda.':H'.$celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$sheet3->getStyle('B'.$celda.':H'.$celda)->getFill()->getStartColor()->setARGB('FFF8991D');


$celda++;
$sheet3->setCellValue('B'.$celda, utf8_encode($row['LINEA']));
//$sheet3->getStyle('B'.$celda)->getFont()->setName('Tahoma');
//$sheet3->getStyle('B'.$celda)->getFont()->setSize(9);
//$sheet3->getStyle('B'.$celda)->getFont()->setBold(true);
//$sheet3->getStyle('B'.$celda)->getFont()->getColor()->setARGB('FF7C4300');
$sheet3->mergeCells('B'.$celda.':H'.$celda);

$celda++;
$celda++;
$sheet3->setCellValue('B'.$celda, "Objetivos Estratégicos");
//$sheet3->getStyle('B'.$celda)->getFont()->setName('Tahoma');
//$sheet3->getStyle('B'.$celda)->getFont()->setSize(9);
//$sheet3->getStyle('B'.$celda)->getFont()->setBold(true);
//$sheet3->getStyle('B'.$celda)->getFont()->getColor()->setARGB('FF7C4300');
$sheet3->mergeCells('B'.$celda.':H'.$celda);
//$sheet3->getStyle('B'.$celda.':H'.$celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$sheet3->getStyle('B'.$celda.':H'.$celda)->getFill()->getStartColor()->setARGB('FFD9D9D9');

           $contobjetivo = 1;
           $this->Model->getObjetivosEstrategicos($row['PK1']);
		   foreach($this->Model->objetivose as $rowe){
		   	$celda++;

			//OBJETIVO ESTRATEGICO
				    $sheet3->mergeCells('B'.$celda.':H'.$celda);
					$sheet3->getRowDimension($celda)->setRowHeight(23);
				    $sheet3->setCellValue('B'.$celda,$contobjetivo.". ".utf8_encode($rowe['OBJETIVO']));
                   // $sheet3->getStyle('B'.$celda)->getFont()->setName('Tahoma');
                   // $sheet3->getStyle('B'.$celda)->getFont()->setSize(8);
					//$sheet3->getStyle('B'.$celda)->getAlignment()->setWrapText(true);
			        $contobjetivo++;
			
			}

$contlinea++;
$celda++;
}



//COMENTARIOS GENERALES

$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(3);
$sheet4 = $objPHPExcel->getActiveSheet();
$sheet4->setTitle('Comentarios Generales');
$sheet4->mergeCells('B1:H1');
$sheet4->getStyle('B1:H1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$sheet4->getStyle('B1:H1')->getFill()->getStartColor()->setARGB('FF7C4300');
$sheet4->setCellValue('B1', utf8_encode($titulo));
//$sheet4->getStyle('B1')->getFont()->setName('Tahoma');
//$sheet4->getStyle('B1')->getFont()->setSize(10);
//$sheet4->getStyle('B1')->getFont()->setBold(true);
//$sheet4->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$sheet4->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$sheet4->mergeCells('B2:H2');
//$sheet4->getStyle('B2:H2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$sheet4->getStyle('B2:H2')->getFill()->getStartColor()->setARGB('FF7C4300');
$sheet4->setCellValue('B2', utf8_encode($jerarquia));
//$sheet4->getStyle('B2')->getFont()->setName('Tahoma');
//$sheet4->getStyle('B2')->getFont()->setSize(10);
//$sheet4->getStyle('B2')->getFont()->setBold(true);
$sheet4->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



$sheet4->mergeCells('B5:H5');
//$sheet4->getStyle('B5:H5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$sheet4->getStyle('B5:H5')->getFill()->getStartColor()->setARGB('FFF8991D');
$sheet4->setCellValue('B5', "Comentarios Generales");
//$sheet4->getStyle('B5')->getFont()->setName('Tahoma');
//$sheet4->getStyle('B5')->getFont()->setSize(10);
//$sheet4->getStyle('B5')->getFont()->setBold(true);
//$sheet4->getStyle('B5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$sheet4->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


/*
$objPHPExcel->getActiveSheet()->setCellValue('B'.$celda, 'Línea estratégica '.$contlinea.': '.utf8_encode($row['LINEA']));
$objPHPExcel->getActiveSheet()->getStyle('B'.$celda)->getFont()->setName('Tahoma');
$objPHPExcel->getActiveSheet()->getStyle('B'.$celda)->getFont()->setSize(9);
$objPHPExcel->getActiveSheet()->getStyle('B'.$celda)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B'.$celda)->getFont()->getColor()->setARGB('FF7C4300');

$objPHPExcel->getActiveSheet()->mergeCells('B'.$celda.':H'.$celda);
$objPHPExcel->getActiveSheet()->getStyle('B'.$celda.':H'.$celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('B'.$celda.':H'.$celda)->getFill()->getStartColor()->setARGB('FFF8991D');
*/



$sheet4->getColumnDimension('B')->setWidth(10);
$sheet4->getColumnDimension('C')->setWidth(10);
$sheet4->getColumnDimension('D')->setWidth(50);
$sheet4->getColumnDimension('E')->setWidth(40);
$sheet4->getColumnDimension('F')->setWidth(12);
$sheet4->getColumnDimension('G')->setWidth(12);
$sheet4->getColumnDimension('H')->setWidth(30);



                           $contcelda=7;
				
				           $this->Model->getComentariosGenerales($idplan);
						   $contarea = 1;
			               foreach($this->Model->comentariosg as $comentario){
						   	
							
							
							$sheet4->setCellValue('B'.$contcelda, $contarea.'.');
                         //   $sheet4->getStyle('B'.$contcelda)->getFont()->setName('Tahoma');
                           // $sheet4->getStyle('B'.$contcelda)->getFont()->setSize(8);
					        //$sheet4->getStyle('B'.$contcelda.':H'.$contcelda)->getAlignment()->setWrapText(true);
							
							
							$usuario = $this->Model->getResponsable($comentario['PK_USUARIO']);
							$sheet4->mergeCells('C'.$contcelda.':H'.$contcelda);
				            $sheet4->setCellValue('C'.$contcelda, utf8_encode($usuario.'         '.$comentario['FECHA_R']));
							//$sheet4->getStyle('C'.$contcelda)->getFont()->setBold(true);
                          //  $sheet4->getStyle('C'.$contcelda)->getFont()->setName('Tahoma');
                          //  $sheet4->getStyle('C'.$contcelda)->getFont()->setSize(8);
					      //  $sheet4->getStyle('C'.$contcelda.':H'.$contcelda)->getAlignment()->setWrapText(true);
						//	$sheet4->getStyle('C'.$contcelda.':H'.$contcelda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                           // $sheet4->getStyle('C'.$contcelda.':H'.$contcelda)->getFill()->getStartColor()->setARGB('FFD9D9D9');	
							
							
							
							
							$contcelda++;
							
						   	
							
							
						   	$sheet4->getRowDimension($contcelda)->setRowHeight(56);
							$sheet4->mergeCells('C'.$contcelda.':H'.$contcelda);
				            $sheet4->setCellValue('C'.$contcelda, utf8_encode($comentario['COMENTARIO']));
                           // $sheet4->getStyle('C'.$contcelda)->getFont()->setName('Tahoma');
                          //  $sheet4->getStyle('C'.$contcelda)->getFont()->setSize(8);
					       // $sheet4->getStyle('C'.$contcelda.':H'.$contcelda)->getAlignment()->setWrapText(true);
							$contarea++;	
							$contcelda++;
							}
							
							$contcelda++;






$objPHPExcel->setActiveSheetIndex(0);


/*$objPHPExcel->getActiveSheet()->setCellValue('A8',"Hello\nWorld");
$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);*/

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$file.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//$objWriter->save('php://output');

$this->SaveViaTempFile($objWriter);

exit;



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