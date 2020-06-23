<?php

class editplaneModel {
	

	var $titulo;
	var $descripcion;
	var $jerarquia;
    var $disponible;
	var $fechai;
	var $fechat;
    var $usuario;
	var $idplan;
	
	
	var $campos;
	

	
	
	function __construct() {
		
	}

    function ActualizarPlan(){
				
		 $this->campos = array('TITULO'=>$this->titulo,
		                       'DESCRIPCION'=>$this->descripcion,
							   'DISPONIBLE'=>$this->disponible,
							   'FECHA_I'=>$this->fechai,
							   'FECHA_T'=>$this->fechat,
							   'PK_JERARQUIA'=>$this->jerarquia,
							   'FECHA_M'=>date("Y-m-d H:i:s"),
							   'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
										   
		 $condition = "PK1='".$this->idplan."'";
		 
		database::updateRecords("PL_PESTRATEGICOS",$this->campos,$condition);
		

	}
	
	
	
	 function getPlan($id){
		
		$sql = "SELECT * FROM PL_PESTRATEGICOS WHERE PK1 = '$id' ";   
		$row = database::getRow($sql);

		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}

	
}

?>