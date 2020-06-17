<?php
include "controllers/planesoperativo/reportes/comentarios.class.php";

class descargar_comentarios{
		
 var $claseReporte; 
 
	function descargar_comentarios() {
			 
	   $this->claseReporte = new comentarios();
       $this->loadPage();		
						 
	}	
	
		
  function loadPage(){	 	
	 	// create excel document
	 	$fechaActual= date("dmY");
	 	
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=reporte_comentarios_POA_".$fechaActual.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$this->claseReporte->Reporte();
			
  }
	
		  
	  
}




?>