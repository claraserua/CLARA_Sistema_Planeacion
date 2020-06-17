<?php
include "controllers/planesoperativo/reportes/informes.class.php";

class descargar_informes{
		
    var $claseReporte; 
 
	function descargar_informes() {
			 
	   $this->claseReporte = new informes();
       $this->loadPage();		
						 
	}	
	
		
  function loadPage(){	 	
	 	// create excel document
	 	$fechaActual= date("dmY");
	 	
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=reporte_informes_POA_".$fechaActual.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$this->claseReporte->Reporte();
			
  }
	
		  
	  
}




?>