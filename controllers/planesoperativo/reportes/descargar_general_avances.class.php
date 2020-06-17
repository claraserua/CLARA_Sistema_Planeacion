<?php
include "controllers/planesoperativo/reportes/generalavances.class.php";

class descargar_general_avances{
		
 var $claseReporte; 
 
	function descargar_general_avances() {
			 
	   $this->claseReporte = new generalavances();
       $this->loadPage();		
						 
	}	
	
		
  function loadPage(){	 	
	 	// create excel document
	 	$fechaActual= date("dmY");
	 	
		header("Content-type: application/octet-stream");
		//header("Content-Disposition: attachment; filename=reporte_avances_POA_".$fechaActual.".xls");
			header("Content-Disposition: attachment; filename=reporte_general_avances_POA.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$this->claseReporte->Reporte();
			
  }
	
		  
	  
}




?>