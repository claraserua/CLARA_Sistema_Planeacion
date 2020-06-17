<?php
include "controllers/planesoperativo/reportes/usuarios.class.php";

class descargar_usuarios{
		
    var $claseReporte; 
 
	function descargar_usuarios() {
			 
	   $this->claseReporte = new usuarios();
       $this->loadPage();		
						 
	}	
	
		
  function loadPage(){	 	
	 	// create excel document
	 	$fechaActual= date("dmY");
	 	
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=reporte_usuarios_.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$this->claseReporte->Reporte();
			
  }
	
		  
	  
}




?>