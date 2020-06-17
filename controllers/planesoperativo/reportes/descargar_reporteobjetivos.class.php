<?php
include "controllers/planesoperativo/reportes/reporteobjetivos.class.php";
require_once 'libs/excel/excel/Classes/PHPExcel.php';

class descargar_reporteobjetivos{
		
 var $claseReporte; 
 
	function descargar_reporteobjetivos() {
			 
	   $this->claseReporte = new reporteobjetivos();
       $this->loadPage();		
						 
	}	
	
		
  function loadPage(){	 	
	 	// create excel documentY-m-d
	 	
	 	$fechaActual= date("dmY");							
	 	
		header("Content-type: application/octet-stream");
	//	header("Content-Disposition: attachment; filename=reportes_POA_".$fechaActual.".xls");
	    header("Content-Disposition: attachment; filename=reporte_objetivos.xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		$html = $this->claseReporte->Reporte();			
	
			
  }
	
		  
	  
}




?>