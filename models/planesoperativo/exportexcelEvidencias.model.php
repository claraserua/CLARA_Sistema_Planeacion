<?php
//include "controllers/planesoperativo/reportes/evidencias.class.php";

//include "models/planesoperativo/seguimiento.model.php";

class exportexcelEvidenciasModel{
		
     //var $claseReporte; 
 
	function __construct() {
			 
	  
						 
	}	
	
		
   function getPlanOperativo($id){
		
		$sql = "SELECT TITULO FROM PL_POPERATIVOS WHERE PK1='$id'";   
		$row = database::getRow($sql);
		if($row){
			return $row['TITULO'];
		}else{
			return FALSE;
		}
	}
	
	
	
	function getEvidencias($idplanOperativo){
	
		//	ISNULL((SELECT TOP 1 OBJETIVO FROM PL_POPERATIVOS_OBJETIVOST WHERE PK1 = PK_OTACTICO AND PK_POPERATIVO = '".$idplanOperativo."'),'') AS 'OBJETIVO'
		$sql="
			SELECT PK1,
			ISNULL(EVIDENCIA,'') AS 'EVIDENCIA',
			ISNULL(ADJUNTO,'') AS 'ADJUNTO',
			ISNULL((SELECT TOP 1 LINEA FROM PL_PESTRATEGICOS_LINEASE WHERE PK1 = PK_LESTRATEGICA),'') AS 'LINEA',
			ISNULL(CAST( (SELECT TOP 1 OBJETIVO FROM PL_POPERATIVOS_OBJETIVOST WHERE PK1 = PK_OTACTICO AND PK_POPERATIVO = '$idplanOperativo') AS varchar(8000)), '') AS 'OBJETIVO'
			FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_POPERATIVO =  '$idplanOperativo'";
		$rows = database::getRows($sql);
		
		return $rows;
	}
	
	
	
	
		  
	  
}