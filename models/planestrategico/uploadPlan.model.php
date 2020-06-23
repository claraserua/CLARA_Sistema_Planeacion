<?php

class uploadPlanModel {
	

	var $titulo;
	var $descripcion;
	var $jerarquia;
    var $disponible;
	var $fechai;
	var $fechat;
    var $usuario;
	var $idplan;
	var $idlinea;
	var $idobjetivo;
	var $autor;
	var $tipo;
	var $imagen;
	var $adjunto;
	
	var $lineas;
	var $objetivos;
	
	var $campos;
	


	function __construct() {
		
	}
	
	
	function getPlan($id){
		
		$sql = "SELECT * FROM PL_PESTRATEGICOS WHERE PK1 = '$id'";   
		$row = database::getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}
		
		
		
	function getLineasPlan(){
		$this->lineas = array();
		$id = $_GET['IDPlan'];
		$sql = "SELECT * FROM PL_PESTRATEGICOS_LINEASE WHERE PK_PESTRATEGICO = '$id' ORDER BY ORDEN";	
	    $result = database::executeQuery($sql);
		
	    while ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
		
	   $this->lineas[] = $row;
		
        }	
	 }
	
	function getObjetivosPlan($idlinea){
		
		$this->objetivos = array();
		
		$sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$idlinea' ORDER BY ORDEN";	
	    $result = database::executeQuery($sql);
		
	    while ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
		
	    $this->objetivos[] = $row;
		
        }
		
	}
		
		
	

    function UploadFile(){
		
		$this->campos = array('PK1'=>uniqid($this->tipo),
	                         'TITULO'=>$this->titulo,
							 'DESCRIPCION'=>$this->descripcion,
							 'AUTOR'=>$this->autor,
							 'TIPO'=>$this->tipo,
							 'IMAGEN'=>$this->imagen,
							 'ADJUNTO'=>$this->adjunto,
							 'PK_PESTRATEGICO'=>$this->idplan,
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'PK_USUARIO'=>"admin",
							 );
	
		database::insertRecords("PL_PESTARTEGICOS_ADJUNTOS",$this->campos);
		
	}
	
	
	
}

?>