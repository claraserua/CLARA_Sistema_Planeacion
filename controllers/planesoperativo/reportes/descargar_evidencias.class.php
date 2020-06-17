<?php
include "controllers/planesoperativo/reportes/evidencias.class.php";

class descargar_evidencias{
		
 var $claseReporte; 
 
	function descargar_evidencias() {
			 
	   $this->claseReporte = new evidencias();
       $this->loadPage();		
						 
	}	
	
		
  function loadPage(){	 	
	 	// create excel document
	 	$fechaActual= date("dmY");
	 	
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=reporte_evidencias_POA_".$fechaActual.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$this->claseReporte->Reporte();
			
  }
	
		  
	  
}




?>