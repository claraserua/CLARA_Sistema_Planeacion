<?php
include "controllers/planesoperativo/reportes/reporteresultados.class.php";
require_once 'libs/excel/excel/Classes/PHPExcel.php';

class descargar_reporteresultados{
		
 var $claseReporte; 
 
	function descargar_reporteresultados() {
			 
	   $this->claseReporte = new reporteresultados();
       $this->loadPage();		
						 
	}	
	
		
  function loadPage(){	 	
	 	// create excel documentY-m-d
	 	
	 	//$fechaActual= date("dmY");							
	 	
		header("Content-type: application/octet-stream");
	//	header("Content-Disposition: attachment; filename=reportes_POA_".$fechaActual.".xls");
	    header("Content-Disposition: attachment; filename=reporte_resultados.xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		$html = $this->claseReporte->Reporte();
		

			
  }
	
		  
	  
}




?>