<?php
include "controllers/planesoperativo/reportes/informejecutivo.class.php";

class descargar_informejecutivo{
		
 var $claseReporte; 
 
	function descargar_informejecutivo() {
			 
	   $this->claseReporte = new informejecutivo();
       $this->loadPage();		
						 
	}	
	
		
  function loadPage(){	 	
	 	// create excel document
	 	$fechaActual= date("dmY");
	 	
		header("Content-type: application/octet-stream");
		//header("Content-Disposition: attachment; filename=reporte_avances_POA_".$fechaActual.".xls");
			header("Content-Disposition: attachment; filename=reporte_informejecutivo.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$this->claseReporte->Reporte();
			
  }
	
		  
	  
}




?>