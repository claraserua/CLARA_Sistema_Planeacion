<?php
include "controllers/planesoperativo/reportes/reportes.class.php";
require_once 'libs/excel/excel/Classes/PHPExcel.php';

class descargar_excel{
		
 var $claseReporte; 
 
	function descargar_excel() {
			 
	   $this->claseReporte = new reportes();
       $this->loadPage();		
						 
	}	
	
		
  function loadPage(){	 	
	 	// create excel documentY-m-d
	 	
	 	$fechaActual= date("dmY");							
	 	
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=reportes_POA_".$fechaActual.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		$html = $this->claseReporte->Reporte();
		
		
				
		/*
$inputFileType = 'HTML';
//$inputFileName = './myHtmlFile.html';
$outputFileType = 'Excel2007';
$outputFileName = 'prueba.xls';

$objPHPExcelReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objPHPExcelReader->load($html);

$objPHPExcelWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,$outputFileType);
$objPHPExcel = $objPHPExcelWriter->save($outputFileName);


$filename = "DownloadReport";
$table    = $html;

// save $table inside temporary file that will be deleted later
$tmpfile = tempnam(sys_get_temp_dir(), 'html');
file_put_contents($tmpfile, $table);

// insert $table into $objPHPExcel's Active Sheet through $excelHTMLReader
$objPHPExcel     = new PHPExcel();
$excelHTMLReader = PHPExcel_IOFactory::createReader('HTML');
$excelHTMLReader->loadIntoExisting($tmpfile, $objPHPExcel);
$objPHPExcel->getActiveSheet()->setTitle('any name you want'); // Change sheet's title if you want

unlink($tmpfile); // delete temporary file because it isn't needed anymore

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
header('Content-Disposition: attachment;filename='.$filename); // specify the download file name
header('Cache-Control: max-age=0');

// Creates a writer to output the $objPHPExcel's content
$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$writer->save('php://output');
exit;*/

			
  }
	
		  
	  
}




?>