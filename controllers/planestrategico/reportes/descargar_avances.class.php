<?php
include "controllers/planestrategico/reportes/avances.class.php";

class descargar_avances{
		
    var $claseReporte; 
 
	function descargar_avances() {
			 
	   $this->claseReporte = new avances();
       $this->loadPage();		
						 
	}	
	
		
  function loadPage(){	 	
	 	// create excel document
	 	$fechaActual= date("dmY");
	 	
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=reporte_avances_PE_".$fechaActual.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		//$this->claseReporte->Reporte();
		$this->claseReporte->Reporte_E();
			
  }
	
		  
	  
}




?>