<?php
include "controllers/planesoperativo/reportes/general.class.php";

class descargar_general{
		
    var $claseReporte; 
 
	function descargar_general() {
			 
	   $this->claseReporte = new general();
       $this->loadPage();		
						 
	}	
	
		
  function loadPage(){	 	
	 	// create excel document
	 	$fechaActual= date("dmY");
	 	
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=reporte_global_POA_".$fechaActual.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$this->claseReporte->Reporte();
			
  }
	
		  
	  
}




?>