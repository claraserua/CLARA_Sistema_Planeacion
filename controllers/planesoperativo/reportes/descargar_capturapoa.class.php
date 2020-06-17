<?php
include "controllers/planesoperativo/reportes/capturapoa.class.php";

class descargar_capturapoa{
		
    var $claseReporte; 
 
	function descargar_capturapoa() {
			 
	   $this->claseReporte = new capturapoa();
       $this->loadPage();		
						 
	}	
	
		
  function loadPage(){	 	
	 	// create excel document
	 	$fechaActual= date("dmY");
	 	
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=reporte_captura_POA_".$fechaActual.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$this->claseReporte->Reporte();
			
  }
	
		  
	  
}




?>