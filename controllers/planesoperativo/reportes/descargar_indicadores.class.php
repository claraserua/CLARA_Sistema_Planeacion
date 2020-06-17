<?php
include "controllers/planesoperativo/reportes/indicadores.class.php";

class descargar_indicadores{
		
 var $claseReporte; 
 
	function descargar_indicadores() {
			 
	   $this->claseReporte = new indicadores();
       $this->loadPage();		
						 
	}	
	
		
  function loadPage(){	 	
	 	// create excel document
	 	$fechaActual= date("dmY");
	 	
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=reporte_indicadores_POA_".$fechaActual.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		//funcion que genera el reporte
		$this->claseReporte->Reporte_Excel();
			
  }
	
		  
	  
}




?>