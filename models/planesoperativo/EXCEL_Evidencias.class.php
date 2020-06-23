<?php

require_once "Spreadsheet/Excel/Writer.php";

ini_set('memory_limit', '-1');

error_reporting( E_ALL );
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


include "models/planesoperativo/exportexcelEvidencias.model.php";

    
class EXCEL_Evidencias{
	
	var $Model;
	
	function __construct(){
		$this->Model = new exportexcelEvidenciasModel();
		$this->loadPage();
		
	}
	function valida($dato)
	{
		if(!isset($dato) || !is_string($dato) || $dato==null || $dato=="NULL" || $dato=="")
			return ' ';
		return trim($dato);
	}
	function loadPage(){
	 	// create excel document
	 	$fechaActual= date("dmY");
		$id_plan = $_GET['IDPlan'];
		$titulo = $this->Model->getPlanOperativo($id_plan);
		$evidencias = $this->Model->getEvidencias($id_plan);
		$numevidencias  = sizeof($evidencias);
	 	$file = $titulo.'.xls';
		
		
		$workbook = new Spreadsheet_Excel_Writer();
		
		
		$workbook->send($file);
		$worksheet = $workbook->addWorksheet('Plan Operativo');

		// ESTILOS

		$style_1 = &$workbook->addFormat( array('Border'=> 0, 'Align' => 'center' ) );
		$style_1->setBold(700);

		$workbook->setCustomColor(12, 248, 153, 29);
		$style_2 = &$workbook->addFormat( array('Border'=> 0, 'Align' => 'center' ) );
		$style_2->setFgColor(12);
		$style_2->setBold(700);
		
		//$format_caption =& $workbook->addFormat(array('size' => 11, 'fontFamily' => 'Calibri', 'numformat' => '@', 'bold' => 1, 'left' => 1, 'top' => 1, 'bottom' => 1, 'right' => 1, 'vAlign' => 'vcenter', 'align' => 'center', 'fgcolor' => 50));
		$style_3 = &$workbook->addFormat( array('Border'=> 0, 'vAlign' => 'center', 'TextWrap' => '1' ) );
		
		//$style_3->setTextWrap();
		
		// ANCHOS DE COLUMNA
		
		$worksheet->setColumn(0,0,5);
		$worksheet->setColumn(1,1,35);
		$worksheet->setColumn(2,2,60);
		$worksheet->setColumn(3,3,60);

		
		//                y  x  string
		$worksheet->write(0, 0, "EVIDENCIAS - $titulo", $style_1);
		$worksheet->mergeCells(0, 0, 0, 4);
		
		$line=1;
		$worksheet->write($line, 0, 'No', $style_2);
		$worksheet->write($line, 1, 'Linea', $style_2);
		$worksheet->write($line, 2, 'Resultado', $style_2);
		$worksheet->write($line, 3, 'Evidencia', $style_2);
		$worksheet->write($line, 4, 'Adjunto', $style_2);
		
		$line++;
		$count=1;
		foreach ($evidencias as $row)
		{
			if ($row['ADJUNTO']=="" || $row['ADJUNTO'] == "NULL")
				$ADJUNTO = "NO";
			else
				$ADJUNTO = "SI";
			
			$worksheet->write($line, 0, $count);
			$worksheet->write($line, 1, $this->valida($row['LINEA']), $style_3);
			$worksheet->write($line, 2, $this->valida($row['OBJETIVO']), $style_3);
			$worksheet->write($line, 3, $this->valida($row['EVIDENCIA']), $style_3);
			$worksheet->write($line, 4, $ADJUNTO);
			
			$line++; $count++;
		}
		
		$workbook->close();
	}
}
?>