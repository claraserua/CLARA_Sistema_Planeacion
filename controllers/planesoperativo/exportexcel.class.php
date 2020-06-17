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

error_reporting(E_ALL);


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);


//include "models/planesoperativo/exportexcel.model.php";
//require_once 'core/dbaccess.php';
include "../../models/planesoperativo/exportexcel.model.php";
require_once '../../core/dbaccess.php';


exportar();
//prueba();

function prueba()
{
	header('Content-Description: File Transfer');
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Transfer-Encoding: none');
	header('Pragma: public');
	ob_end_clean();
	ob_start();

	$workbook = new Spreadsheet_Excel_Writer();
	$workbook->setVersion(8); // Use Excel97/2000 Format
	$workbook->send('test.xls');

	$worksheet = &$workbook->addWorksheet('My first worksheet');
	$worksheet->setInputEncoding("UTF-8");
	$varDos = "áááaaaaaaaaaaaaaaaaaaaaaabbbbbbbbbbbbbbbbbbbbbbbbbcccccccccccccccccccccccccdddddddddddddddddddddddddéééeeeeeeeeeeeeeeeeeeeeeefffffffffffffffffffffffffggggggggggggggggggggggggghhhhhhhhhhhhhhhhhhhhhhhhhiiiiiiiiiiiiiiiiiiiiiiiiikkkkkkkkkkkkkkkkkkkkkkkkkjjjjjjjjjjjjjjjjjjjjjjjjjzzzzzzzzzzzzzzzzzzzzzz";


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
function exportar()
{
	header('Content-Description: File Transfer');
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Transfer-Encoding: none');
	header('Pragma: public');

	//local
	$Model = new exportexcelModel();
	$plan = $Model->getPlan($_GET['IDPlan']);
	$titulo = $plan['TITULO'];
	$jerarquia = $Model->getJerarquia($plan['PK_JERARQUIA']);
	$idplan = $_GET['IDPlan'];
	//$namefile = 'media/download/'.$_GET['IDPlan'].'.xlsx';
	$file = $titulo . '.xls';

	ob_end_clean();
	ob_start();

	$workbook = new Spreadsheet_Excel_Writer();
	$workbook->setVersion(8); // Use Excel97/2000 Format
	$workbook->send($file);
	//$worksheet = $workbook->addWorksheet('Plan Operativo');


	$worksheet = &$workbook->addWorksheet('Plan Operativo');
	$worksheet->setInputEncoding("UTF-8");


	$worksheet->setColumn(1, 1, 10);

	$worksheet->setColumn(2, 2, 10);
	$worksheet->setColumn(3, 3, 50);
	$worksheet->setColumn(4, 4, 40);
	$worksheet->setColumn(5, 5, 12);
	$worksheet->setColumn(6, 6, 12);
	$worksheet->setColumn(7, 7, 30);
	$worksheet->setColumn(8, 8, 20);
	$worksheet->setColumn(9, 9, 30);
	$worksheet->setColumn(10, 10, 12);
	$worksheet->setColumn(11, 11, 30);



	$Model->getPeriodos($idplan);
	$periodos = $Model->periodos;

	# Create a "text wrap" format
	//$format2 = $worksheet->addformat();

	$multiplemedios = &$workbook->addFormat(array(
		'Border' => 0
	));
	$multiplemedios->setVAlign('vcenter');
	//$multiplemedios->setTextWrap();




	$multipleLineDataFormat = &$workbook->addFormat(array(
		'Border' => 0, 'Align' => 'left'
	));
	$multipleLineDataFormat->setTextWrap();


	$multiple = &$workbook->addFormat(array(
		'Border' => 0, 'Align' => 'center'
	));

	$multipleLineDataFormat->setTextWrap();

	/*$lineae = &$workbook->addFormat( array(
	'Border'=> 0, 'fgcolor' => 50, ) );*/
	//$multipleLineDataFormat->setTextWrap();

	$lineae = $workbook->addFormat(array(
		'Border' => 0
	));


	$multipleLineDataFormat2 = &$workbook->addFormat(array(
		'Border' => 0, 'Align' => 'top'
	));
	$multipleLineDataFormat2->setTextWrap();




	$worksheet->write(0, 1, utf8_encode($titulo), $multiple);
	$worksheet->mergeCells(0, 1, 0, 7);
	$worksheet->write(1, 1, utf8_encode($jerarquia), $multiple);
	$worksheet->mergeCells(1, 1, 1, 7);

	$texto = 'Resultado: Acción propuesta que ayuda al cumplimiento de algún Objetivo Estratégico del Plan Estratégico de la universidad y el responsable de lograr dicho resultado.';

	$worksheet->write(3, 1, $texto);
	$worksheet->mergeCells(3, 1, 3, 7);

	$texto = 'Medios: Tareas a llevar a cabo para el logro del resultado y los responsables de llevarlas a cabo.';
	$worksheet->write(4, 1, $texto);
	$worksheet->mergeCells(4, 1, 4, 7);

	$texto = 'Evidencias propuestas: Elementos físicos que ayudan a evaluar el cumplimiento de los objetivos tácticos. Ejemplos: reportes, fotografías, informes de reuniones, correos, etc.';
	$worksheet->write(5, 1, $texto);
	$worksheet->mergeCells(5, 1, 5, 7);



	$Model->getLineas();
	$celda = 10;
	$contlinea = 1;

	//naranja
	$workbook->setCustomColor(12, 248, 153, 29);
	$format_our_green = &$workbook->addFormat();
	$format_our_green->setFgColor(12);
	$format_our_green->setColor('16');


	//gris      
	$workbook->setCustomColor(10, 217, 217, 217);
	$format_our_green2 = &$workbook->addFormat();
	$format_our_green2->setFgColor(10);
	$format_our_green2->setBold(700);



	$workbook->setCustomColor(12, 248, 153, 29);
	$format3 = &$workbook->addFormat(array(
		'Border' => 0, 'Align' => 'center'
	));
	$format3->setFgColor(12);


	$format_our_green4 = &$workbook->addFormat();
	$format_our_green4->setFgColor(12);
	$format_our_green4->setColor('16');
	//aqui le

	foreach ($Model->lineas as $row) { //LINEAS ESTRATEGICAS


		$texto =  'Línea estratégica ';
		$worksheet->write($celda, 1, $texto . (utf8_encode($contlinea . ': ' . $row['LINEA'])), $format_our_green);
		$worksheet->mergeCells($celda, 1, $celda, 11);



		//OBJETIVOS TACTICOS
		$contobjetivo = 1;
		$Model->getObjetivosTacticos($idplan, $row['PK1']);
		foreach ($Model->objetivos as $resultados) {

			$celda++;
			$worksheet->write($celda, 2, 'Resultado', $format_our_green2);
			$worksheet->mergeCells($celda, 2, $celda, 3);
			$worksheet->setRow($celda, 26);

			$texto = 'Objetivo estratégico';
			$worksheet->write($celda, 4, $texto, $format_our_green2);

			$worksheet->write($celda, 5, 'Responsable', $format_our_green2);
			$worksheet->mergeCells($celda, 5, $celda, 6);

			$worksheet->write($celda, 7, 'Indicador estratégico', $format_our_green2);
			$worksheet->mergeCells($celda, 7, $celda, 8);

			$worksheet->write($celda, 9, 'Meta 2024', $format_our_green2);
			$worksheet->mergeCells($celda, 9, $celda, 10);

			$worksheet->write($celda, 11, 'Evidencias propuestas', $format_our_green2);
			//$worksheet->mergeCells($celda,7,$celda,7);

			// PERIODOS			
			$numperiodo  = sizeof($periodos);
			$fila = 1;
			$columnas = array( 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29);

			foreach ($periodos as $periodo) {
				//   if($periodo['PERIODO']==""||$periodo['PERIODO']==NULL){ $worksheet->write($celda,$columnas[$fila],'',$format_our_green2);}
				//  else{  $worksheet->write($celda,$columnas[$fila],$periodo['PERIODO'],$format_our_green2); }

				//
				//$worksheet->write($celda,$columnas[$fila],'prueba',$format_our_green2);
				$texto = trim($periodo['PERIODO']);
				$worksheet->write($celda, $columnas[$fila], $texto, $format_our_green2);
				$worksheet->setColumn($columnas[$fila], $columnas[$fila], 60);
				$fila += 2;
			}
			$celda++;
			$rowevidencia = $celda;
			$worksheet->setRow($celda, 36);


			//NUMERO OBJETIVO
			$worksheet->write($celda, 1, $contlinea . '.' . $contobjetivo);
			$objeNum = $contlinea . '.' . $contobjetivo;
			$texto = $resultados['OBJETIVO'];
			$worksheet->write($celda, 2, utf8_encode($texto), $multipleLineDataFormat);
			$worksheet->mergeCells($celda, 2, $celda, 3);

			$oestrategico = $Model->getObjetivoEstrategico($resultados['PK_OESTRATEGICO']);
			$worksheet->write($celda, 4, utf8_encode($oestrategico), $multipleLineDataFormat);


			$responsable = $Model->getResponsable($resultados['PK_RESPONSABLE']);
			$worksheet->write($celda, 5, utf8_encode($responsable), $multipleLineDataFormat);

			$worksheet->mergeCells($celda, 5, $celda, 6);

			//PORCENTAJE DE AVANCE RESULTADOS
			$numperiodo  = sizeof($periodos);
			$fila = 1;

			$columnas = array( 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29);

			foreach ($periodos as $periodo) {
				$avance = $Model->getAvanceResultado($periodo['PK1'], $resultados['PK1']);
				$numporcent = $avance['PORCENTAJE'];

				if ($numporcent == "") {
					$numporcent = 0;
				}

				$numresul =  $contlinea . '.' . $contobjetivo;
				$porcentaje = $numresul . ' Avance: ' . $numporcent . '%';

				//  $sheet->setCellValue($columnas[$fila].$celda, $porcentaje);
				$worksheet->write($celda, $columnas[$fila], utf8_encode($porcentaje));
				//  $worksheet->mergeCells($celda, 5, $celda, 6);

				$fila += 2;
			}
			$celda++;
			//MEDIOS

			$worksheet->write($celda, 3, "Medios", $format_our_green2);
			$worksheet->mergeCells($celda, 3, $celda, 4);

			$worksheet->write($celda, 5, "Responsable", $format_our_green2);
			$worksheet->mergeCells($celda, 5, $celda, 6);

			$Model->getMedios($resultados['PK1']);
			$contmedio = 1;
			foreach ($Model->medios as $medios) {

				$celda++;

				$worksheet->write($celda, 2, $contlinea . '.' . $contobjetivo . '.' . $contmedio);
				$worksheet->setRow($celda, getNumRow($medios['MEDIO']));

				//MEDIOS

				// $workbook->setVersion(8); // Use Excel97/2000 Format
				$texto = $medios['MEDIO'];
				$worksheet->write($celda, 3, utf8_encode($texto), $multipleLineDataFormat);
				$worksheet->mergeCells($celda, 3, $celda, 4);
				// $worksheet->setRow($celda,30);


				//RESPONSABLE RESULTADO
				$responsable = $Model->getResponsable($medios['PK_RESPONSABLE']);

				$worksheet->write($celda, 5, utf8_encode($responsable), $multipleLineDataFormat);
				$worksheet->mergeCells($celda, 5, $celda, 6);

				//PORCENTAJE DE AVANCE MEDIOS
				$numperiodo  = sizeof($periodos);
				$fila = 1;

				$columnas = array( 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29);

				foreach ($periodos as $periodo) {

					$avance = $Model->getAvanceMedio($periodo['PK1'], $medios['PK1']);
					$numporcent = $avance['PORCENTAJE'];

					if ($numporcent == "") {
						$numporcent = 0;
					}

					$numresul =  $contlinea . '.' . $contobjetivo . '.' . $contmedio;
					$porcentaje = $numresul . ' Avance: ' . $numporcent . '%';
					// $sheet->setCellValue($columnas[$fila].$celda, $porcentaje);
					$worksheet->write($celda, $columnas[$fila], utf8_encode($porcentaje));
					$fila += 2;
				}


				$contmedio++;
			}	

		   
		  //    $sheet->mergeCells('H'.$rowevidencia.':H'.$celda);
			//   $evidencias = $this->Model->getEvidencias($resultados['PK1']);
		   //    $sheet->setCellValue('H'.$rowevidencia, utf8_encode($evidencias));

		   // INDICADORES Y METAS ESTRÄTEGICAS
			$indMetas = $Model->getObjEstrategicosToExl($objeNum,$resultados['PK1'],$resultados['PK_OESTRATEGICO']);
			   
			$texto = $indMetas["indicadores"];
			$worksheet->write($rowevidencia,7,$texto,$multipleLineDataFormat2);   // multiplemedios      					   
			$worksheet->mergeCells($rowevidencia, 7, $celda, 8);
			
			$texto = $indMetas["metas"];
			$worksheet->write($rowevidencia,9,$texto,$multipleLineDataFormat2);   // multiplemedios      					   
			$worksheet->mergeCells($rowevidencia, 9, $celda, 10);

			
			$evidencias = $Model->getEvidencias($resultados['PK1']);				   
			$texto = $evidencias;	
			$worksheet->write($rowevidencia,11,utf8_encode($texto),$multipleLineDataFormat2);   // multiplemedios      					   
			$worksheet->mergeCells($rowevidencia, 11, $celda, 11);
			// $worksheet->setRow($rowevidencia, 100);  

			$contobjetivo++; 
			$celda++;
			
			//INDICADORES ANUALES

			$worksheet->write($celda, 3, "Indicador Anual", $format_our_green2);
			$worksheet->mergeCells($celda, 3, $celda, 4);

			$worksheet->write($celda, 5, "Meta Anual", $format_our_green2);
			$worksheet->mergeCells($celda, 5, $celda, 6);

			$Model->getIndicadoresMetas($resultados['PK1']);
			$contmetanual = 1;
			foreach ($Model->metanual as $metanual) {

				$celda++;

				$worksheet->write($celda, 2, $contlinea . '.' . $contobjetivo . '.' . $contmetanual);
				$worksheet->setRow($celda, getNumRow($metanual['ORDEN']));

				//Indicadores

				// $workbook->setVersion(8); // Use Excel97/2000 Format
				$texto = $metanual['INDICADOR'];
				$worksheet->write($celda, 3, utf8_encode($texto), $multipleLineDataFormat);
				$worksheet->mergeCells($celda, 3, $celda, 4);
				 $worksheet->setRow($celda,30);


				//META
				$responsable =  $metanual['META'];
				$worksheet->write($celda, 5, utf8_encode($responsable), $multipleLineDataFormat);
				$worksheet->mergeCells($celda, 5, $celda, 6);
				//$worksheet->setRow($celda,30);

				//PORCENTAJE DE AVANCE MEDIOS
				$numperiodo  = sizeof($periodos);
				$fila = 1;

				$contmetanual++;
			}	

			$celda++;
			$worksheet->write($celda, 2, "COMENTARIOS", $format_our_green2);
			$worksheet->mergeCells($celda, 2, $celda, 7);

			



			//COMENTARIOS
			$numperiodo  = sizeof($periodos);
			$fila = 1;

			$columnas = array( 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29);



			foreach ($periodos as $periodo) {

				// $sheet->setCellValue($columnas[$fila].$celda, "COMENTARIOS");
				$worksheet->write($celda, $columnas[$fila], "COMENTARIOS", $format_our_green2);
				//  $sheet->getStyle($columnas[$fila].$celda)->getAlignment()->setWrapText(true);	


				$fila += 2;
			}


			$celda++;
			$celdaperiodo = $celda;
			$celdacolumna = $celda;
			$numfilascomentarios = 0;
			//COMENTARIOS PERIODOS
			$numperiodo  = sizeof($Model->periodos);
			$fila = 1;
			$columnas = array( 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29);
			$maxCeldaComentarios = array($celda);
			array_push($maxCeldaComentarios,$celda);
			
			foreach ($Model->periodos as $periodo) {

				$celdaperiodo =  $celdacolumna;


				$Model->getComentariosResultadoPeriodo($resultados['PK1'], $periodo['PK1']);

				$contcomentarios = 1;
				foreach ($Model->comentariosp as $comentario) {

					$usuario = $Model->getResponsable($comentario['PK_USUARIO']);

					// $sheet->setCellValue($columnas[$fila].$celdaperiodo, utf8_encode($usuario).'         '.$comentario['FECHA_R']);  

					$worksheet->write($celdaperiodo, $columnas[$fila], utf8_encode($usuario .'         ' . $comentario['FECHA_R']->format('Y-m-d')), $format_our_green2);


					$celdaperiodo++;

					$texto = 	$comentario['COMENTARIO'];
					//	$sheet->setCellValue($columnas[$fila].$celdaperiodo, utf8_encode($comentario['COMENTARIO']));
					//$texto = $resultados['PK1'].','.$periodo['PK1'].','.sizeof($Model->periodos).','.$idplan.'--'.$contcomentarios.'***'.sizeof($Model->comentariosp).'??'.$contcomentarios.'!!'.$celda.'%%'.$celdaperiodo;
					$worksheet->write($celdaperiodo, $columnas[$fila], utf8_encode($texto), $multipleLineDataFormat);
					$celdaperiodo++;
					$contcomentarios++;
					array_push($maxCeldaComentarios,$celdaperiodo);
				}



				$fila += 2;

				if ($contcomentarios >= $numfilascomentarios) {
					$numfilascomentarios = $contcomentarios;
				}

				//$celda++;
				//$celda = max($maxCeldaComentarios);
			}

			$Model->getComentariosResultado($resultados['PK1']);
			
			foreach ($Model->comentariosr as $comentario) {

				$filacoment = $celda - $numperiodo;

				$usuario = $Model->getResponsable($comentario['PK_USUARIO']);

				$texto = $usuario . '         ' . $comentario['FECHA_R']->format('Y-m-d');
				$worksheet->write($filacoment, 3, utf8_encode($texto), $format_our_green2);
				$worksheet->mergeCells($filacoment, 3, $filacoment, 7);

				//$celda++;
				$filacoment++;


				$texto = $comentario['COMENTARIO'];
				$worksheet->write($filacoment, 3, utf8_encode($texto), $multipleLineDataFormat);
				$worksheet->mergeCells($filacoment, 3, $filacoment, 7);
				$filacoment++;
				//$celda++;
				array_push($maxCeldaComentarios,$filacoment);
			}


			$celda = max($maxCeldaComentarios);
			$celda++;

			
		} //END OBJETIVOS TACTICOS

		$contlinea++;
		$celda++;
	} //END LINEAS ESTRATEGICAS

	// Creating a worksheet
	$worksheet = &$workbook->addWorksheet('Diagnóstico Inicial');
	$worksheet->setInputEncoding("UTF-8");

	$worksheet->write(0, 4, utf8_encode($jerarquia));
	//$worksheet->mergeCells(1, 3, 1, 7);	
	$texto = 'En este apartado, el Rector expone un diagnóstico inicial del estado general que guarda la universidad al inicio del año.';
	$worksheet->write(2, 1, $texto);

	$worksheet->setColumn(1, 1, 10);
	$worksheet->setColumn(2, 2, 10);
	$worksheet->setColumn(3, 3, 50);
	$worksheet->setColumn(4, 4, 40);
	$worksheet->setColumn(5, 5, 12);
	$worksheet->setColumn(6, 6, 12);
	$worksheet->setColumn(7, 7, 30);

	$texto = 'Análisis Interno:';
	$worksheet->write(4, 1, $texto, $format_our_green4); //comentar
	$worksheet->mergeCells(4, 1, 4, 7); //comentar

	$worksheet->write(5, 1, 'Fortalezas', $format_our_green);
	$worksheet->mergeCells(5, 1, 5, 7);



	$contcelda = 7;
	//FORTALEZAS

	$Model->getFortalezas($idplan);
	$contarea = 1;
	foreach ($Model->fortalezas as $fortalezas) {

		$worksheet->write($contcelda, 1,  $contarea . '.');

		$texto = $fortalezas['FORTALEZA'];
		$worksheet->write($contcelda, 2, utf8_encode($texto));
		$worksheet->mergeCells($contcelda, 2, $contcelda, 7);

		$contarea++;
		$contcelda++;
	}

	$contcelda++;

	//DEBILIDADES
	$worksheet->write($contcelda, 1, 'Debilidades', $format_our_green);
	$worksheet->mergeCells($contcelda, 1, $contcelda, 7);


	$contcelda++;

	$Model->getAreas($idplan);
	$contarea = 1;
	foreach ($Model->areas as $areas) {
		$worksheet->write($contcelda, 1,  $contarea . '.');
		$texto = $areas['AREA'];
		$worksheet->write($contcelda, 2, utf8_encode($texto));
		$worksheet->mergeCells($contcelda, 2, $contcelda, 7);

		$contarea++;
		$contcelda++;
	}

	$contcelda++;

	/***********inicio nuevos********/

	$contcelda++; //comentar  
	$texto = 'Análisis Externo:';
	$worksheet->write($contcelda, 1, $texto, $format_our_green4); //comentar
	$worksheet->mergeCells($contcelda, 1, $contcelda, 7); //comentar                  
	$contcelda++; //comentar

	//OPORTUNIDADES
	$worksheet->write($contcelda, 1, 'Oportunidades', $format_our_green);
	$worksheet->mergeCells($contcelda, 1, $contcelda, 7);

	$contcelda++;

	$Model->getOportunidades($idplan);
	$contarea = 1;
	foreach ($Model->oportunidades as $oportunidades) {

		$worksheet->write($contcelda, 1,  $contarea . '.');
		$text = $oportunidades['OPORTUNIDADES'];
		$worksheet->write($contcelda, 2, utf8_encode($text));
		$worksheet->mergeCells($contcelda, 2, $contcelda, 7);

		$contarea++;
		$contcelda++;
	}

	$contcelda++;



	//AMENAZAS 
	//$worksheet->write($contcelda, 1, 'Amenazas',$format_our_green); 

	$worksheet->write($contcelda, 1, 'Amenazas', $format_our_green);
	$worksheet->mergeCells($contcelda, 1, $contcelda, 7);


	$contcelda++;

	$Model->getAmenazas($idplan);
	$contarea = 1;
	foreach ($Model->amenazas as $amenazas) {
		$worksheet->write($contcelda, 1,  $contarea . '.');
		$text = $amenazas['AMENAZAS'];
		$worksheet->write($contcelda, 2, utf8_encode($text));
		$worksheet->mergeCells($contcelda, 2, $contcelda, 7);

		$contarea++;
		$contcelda++;
	}

	$contcelda++;

	/*****fin nuevos****/

	$contcelda++; //checar**

	// $sheet2->mergeCells('C'.$contcelda.':H'.$contcelda);
	// $sheet2->setCellValue('C'.$contcelda, "COMENTARIOS");
	$worksheet->write($contcelda, 2, 'COMENTARIOS', $format_our_green2);
	$worksheet->mergeCells($contcelda, 2, $contcelda, 7);


	$contcelda++;
	$Model->getComentariosDiagnostico($idplan);

	foreach ($Model->comentariosd as $comentario) {

		$usuario = $Model->getResponsable($comentario['PK_USUARIO']);

		$texto = $usuario . '         ' . $comentario['PK_USUARIO'];
		$worksheet->write($contcelda, 3, utf8_encode($texto));
		$worksheet->mergeCells($contcelda, 3, $contcelda, 7);

		$contcelda++;
		$texto = $comentario['COMENTARIO'];
		$worksheet->write($contcelda, 3, utf8_encode($texto));
		$worksheet->mergeCells($contcelda, 3, $contcelda, 7);

		$contcelda++;
	}

	//PLAN ESTRATEGICO
	//$multipleLineDataFormatplab = &$workbook->addFormat( array(
	//'Border'=> 0, 'Align' => 'center' ) );
	$multipleLineDataFormat->setTextWrap();


	/////////////////////////////////////////////////
	// Creating a worksheet Planeación Estratégica
	///////////////////////////////////////////////////

	$worksheet = &$workbook->addWorksheet('Planeación Estratégica');
	//$worksheet->mergeCells(0, 1, 0, 7);
	$worksheet->setInputEncoding("UTF-8");

	$worksheet->write(0, 1, utf8_encode($titulo), $multiple);
	$worksheet->mergeCells(0, 1, 0, 7);


	$worksheet->write(1, 1, utf8_encode($jerarquia), $multiple);
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


	$celda = 5;
	$contlinea = 1;
	foreach ($Model->lineas as $row) {

		$texto = 'Línea estratégica ';
		$worksheet->write($celda, 1, $texto . utf8_encode($contlinea . ':'), $format_our_green);
		$worksheet->mergeCells($celda, 1, $celda, 7);

		$celda++;
		$texto = $row['LINEA'];
		$worksheet->write($celda, 1, utf8_encode($texto));
		$worksheet->mergeCells($celda, 1, $celda, 7);

		$celda++;
		$celda++;

		$texto = "Objetivos Estratégicos";
		$worksheet->write($celda, 1, $texto, $format_our_green2);
		$worksheet->mergeCells($celda, 1, $celda, 7);

		$contobjetivo = 1;


		$Model->getObjetivosEstrategicos($row['PK1']);
		foreach ($Model->objetivose as $rowe) {
			$celda++;
			//OBJETIVO ESTRATEGICO
			$texto = 	$rowe['OBJETIVO'];
			$worksheet->write($celda, 1, $contobjetivo . ". " . utf8_encode($texto));
			$worksheet->mergeCells($celda, 1, $celda, 7);
			$contobjetivo++;
		}
		$contlinea++;
		$celda++;
	}
	//COMENTARIOS GENERALES
	//$multipleLine = &$workbook->addFormat( array(
	//	'Border'=> 0, 'Align' => 'center' ) );
	$multipleLineDataFormat->setTextWrap();


	////////////////////////////////////////////
	// Creating a worksheetComentarios Generales
	/////////////////////////////////////
	$worksheet = &$workbook->addWorksheet('Comentarios Generales');
	$worksheet->setInputEncoding("UTF-8");

	$worksheet->write(0, 1, utf8_encode($titulo), $multiple);
	$worksheet->mergeCells(0, 1, 0, 7);


	$worksheet->write(1, 1, utf8_encode($jerarquia), $multiple);
	$worksheet->mergeCells(1, 1, 1, 7);

	$worksheet->write(4, 1, "Comentarios Generales", $format3);
	$worksheet->mergeCells(4, 1, 4, 7);

	$worksheet->setColumn(1, 1, 10);
	$worksheet->setColumn(2, 2, 10);
	$worksheet->setColumn(3, 3, 50);
	$worksheet->setColumn(4, 4, 40);
	$worksheet->setColumn(5, 5, 12);
	$worksheet->setColumn(6, 6, 12);
	$worksheet->setColumn(7, 7, 30);

	$contcelda = 6;

	$Model->getComentariosGenerales($idplan);
	$contarea = 1;
	foreach ($Model->comentariosg as $comentario) {

		//$sheet4->setCellValue('B'.$contcelda, $contarea.'.');

		$worksheet->write($contcelda, 1, $contarea . '.');
		$worksheet->mergeCells($contcelda, 2, $contcelda, 7);


		$usuario = $Model->getResponsable($comentario['PK_USUARIO']);


		$worksheet->write($contcelda, 2, utf8_encode($usuario . '         ' . $comentario['FECHA_R']->format('Y-m-d')), $format_our_green2);
		$worksheet->mergeCells($contcelda, 2, $contcelda, 7);

		$contcelda++;

		$worksheet->write($contcelda, 2, utf8_encode($comentario['COMENTARIO']));
		$worksheet->mergeCells($contcelda, 2, $contcelda, 7);

		$contarea++;
		$contcelda++;
	}

	$contcelda++;
	$workbook->close();
}


function getNumRow($cadena)
{


	$num = strlen(trim($cadena));

	$numero = round($num / 100);

	$num = $numero * 26;

	return $num;
}
