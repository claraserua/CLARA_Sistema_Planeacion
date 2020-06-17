<?php
include "controllers/planestrategico/reportes/reportes.class.php";

class descargar_reportes{
		
    var $claseReporte; 
 
	function descargar_reportes() {
			 
	   $this->claseReporte = new reportes();
       $this->loadPage();		
						 
	}	
	
		
  function loadPage(){	 	
	 	// create excel document
	 	$fechaActual= date("dmY");
	 	
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=reporte_PE_".$fechaActual.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$this->claseReporte->Reporte();
			
  }
	
		  
	  
}




?>