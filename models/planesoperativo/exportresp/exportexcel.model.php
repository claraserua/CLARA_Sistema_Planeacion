<?php

class exportexcelModel {
	

	var $idplan;
	var $lineas;
	var $objetivos;
	var $medios;
	var $areas;
	var $fortalezas;
	var $objetivose;
	var $comentariosg;
	var $comentariosr;
	var $comentariosd;
	var $periodos;
	var $comentariosp;
	var $evidencias;
	var $evidenciasRes;
	
	function __construct() {
		
	}
	
	
	function getAvanceMedio($idperiodo,$idmedio){
		
		$sql ="SELECT PORCENTAJE FROM PL_POPERATIVOS_MEDIOS_AVANCES WHERE PK_PERIODO = '$idperiodo' AND PK_MEDIO = '$idmedio'";
		
		
		$row = database::getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		
	}
	
	
	function getAvanceResultado($idperiodo,$idresultado){
		
		
		$sql = "SELECT PORCENTAJE FROM PL_POPERATIVOS_OBJETIVOST_AVANCES WHERE PK_PERIODO = '$idperiodo' AND PK_OTACTICO = '$idresultado'";
		
		$row = database::getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		
		
		
	}
	
	
	function getPeriodos($id){
		
		$this->periodos = array();
		
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$id' ORDER BY ORDEN";
		
		$result = database::executeQuery($sql);
		

		while  ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
		
	    $this->periodos[] = $row;
		
        }
		
		
	}
     
	 
    function getPlan($id){
		
		$sql = "SELECT * FROM PL_POPERATIVOS WHERE PK1='$id'";   
		$row = database::getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}

     function getJerarquia($id){
	 	$sql = "SELECT * FROM PL_JERARQUIAS WHERE PK1='$id'";   
		$row = database::getRow($sql);
	
		if($row){
			return $row['NOMBRE'];
		}else{
			return FALSE;
		}
	 	
	 }

     function getLineas(){
		
		$this->lineas = array();
		$id = $_GET['IDPlanE'];
		$sql = "SELECT * FROM PL_PESTRATEGICOS_LINEASE WHERE PK_PESTRATEGICO = '$id' ORDER BY ORDEN";
		
        $result = database::executeQuery($sql);
		
		while  ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
		
	    $this->lineas[] = $row;	   
		
        }
		
		}
	
	
	    function getAreas($plan){
			
		$this->areas = array();
		
		$sql = "SELECT * FROM PL_POPERATIVOS_AREAS WHERE PK_POPERATIVO = '$plan' ORDER BY ORDEN";
		
        $result = database::executeQuery($sql);
		
		while  ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
		
	    $this->areas[] = $row;
		
        }
			
		}
		
		
		function getFortalezas($plan){
			
		$this->fortalezas = array();
		
		$sql = "SELECT * FROM PL_POPERATIVOS_FORTALEZAS WHERE PK_POPERATIVO = '$plan' ORDER BY ORDEN";
		
        $result = database::executeQuery($sql);
		
		while  ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
		
	    $this->fortalezas[] = $row;
		
        }
			
		}
	
	
	
	
	
	 function getObjetivosTacticos($plan,$idlinea){
		
		$this->objetivos = array();
			
		$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_POPERATIVO = '$plan' AND PK_LESTRATEGICA = '$idlinea'  ORDER BY ORDEN";
		  
        $objetivos = database::executeQuery($sql);
		 
		while  ($row = mssql_fetch_array($objetivos, MSSQL_ASSOC)) {
		
	    $this->objetivos[] = $row;
		
        }
			 
		}
	
	
	 function getObjetivosEstrategicos($linea){
	  
	  $this->objetivose = array();
	  $sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$linea' ORDER BY ORDEN";
	  
	  $objetivos = database::executeQuery($sql);
		 
		while  ($row = mssql_fetch_array($objetivos, MSSQL_ASSOC)) {
		
	    $this->objetivose[] = $row;
		
        }
	  
	 }
	
	  function getObjetivoEstrategico($id){
		
		$sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK1 = '$id'  ORDER BY ORDEN";

        $row = database::getRow($sql);
		
		if($row){
			return $row['OBJETIVO'];
		}else{
			return FALSE;
		}
	
     }
	 
	 
	 function getResponsable($id){
	 	
		$sql = "SELECT CONCAT(TITULO,' ',NOMBRE,' ',APELLIDOS) AS RESPONSABLE FROM PL_USUARIOS WHERE PK1 = '$id'";

        $row = database::getRow($sql);
		
		if($row){
			return $row['RESPONSABLE'];
		}else{
			return FALSE;
		}
	 	
	 }
	 
	 
	 
	 
	 function getMedios($id){
		
		$this->medios = array();
		
        $sql = "SELECT * FROM PL_POPERATIVOS_MEDIOS WHERE PK_OTACTICO = '$id' ORDER BY ORDEN";	
	    $result = database::executeQuery($sql);
		
	    while  ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
		
	    $this->medios[] = $row;
		
        }
		
     	}
		
		
		function getEvidencias($id){
		
		$this->evidenciasRes = array();
		
        $sql = "SELECT * FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_OTACTICO = '$id' ORDER BY ORDEN";	
	    $result = database::executeQuery($sql);
		
	    while  ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
		
	    $this->evidenciasRes[] = $row;
		
        }
		
     	}
		
		
		
		
		
		
		function getEvidencias2($id){
		
		//$evidencias = "";
        $sql = "SELECT * FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_OTACTICO = '$id' ORDER BY ORDEN";	
	    
		$result = database::executeQuery($sql);
	    
		
	/*	$cont=1;
	    while ($row =  mssql_fetch_array($result, MSSQL_ASSOC)) {
		
		$evidencias .= $cont;
		$evidencias .=". ".$row['EVIDENCIA'];
		$evidencias .=" ";
	    $cont++;
        }*/
     	while  ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
		
	         $this->evidencias[] = $row;
		
            }
	
		
		
		}
		
		
		
		function getComentariosResultadoPeriodo($idresultado,$idperiodo){
			
			$this->comentariosp = array();
			$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST_COMENTARIOS_PERIODOS where PK_OTACTICO = '$idresultado' AND PK_PERIODO = '$idperiodo' ORDER BY FECHA_R DESC";
			$result = database::executeQuery($sql);
			
			while  ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
		
	         $this->comentariosp[] = $row;
		
            }
	        
		}
		
		
		
		function getComentariosResultado($idresultado){
			
			$this->comentariosr = array();
			$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST_COMENTARIOS WHERE PK_OTACTICO = '$idresultado' ORDER BY FECHA_R DESC";
			$result = database::executeQuery($sql);
			
			while  ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
		
	         $this->comentariosr[] = $row;
		
            }
	        
		}
		
		
		function getComentariosDiagnostico($idplan){
			
			$this->comentariosd = array();
			$sql = "SELECT * FROM PL_POPERATIVOS_RESUMENE_COMENTARIOS WHERE PK_POPERATIVO = '$idplan' ORDER BY FECHA_R DESC";
			$result = database::executeQuery($sql);
			
			while  ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
		
	         $this->comentariosd[] = $row;
		
            }
	        
		}
		
		
		function getComentariosGenerales($idplan){
			
			$this->comentariosg = array();
			$sql = "SELECT * FROM PL_POPERATIVOS_COMENTARIOS WHERE PK_POPERATIVO = '$idplan' ORDER BY FECHA_R DESC";
			$result = database::executeQuery($sql);
			
			while  ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
		
	         $this->comentariosg[] = $row;
		
            }
	        
		}
	
}

?>