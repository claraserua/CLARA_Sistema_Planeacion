<?php

class editplanoModel {
	

	var $titulo;
	var $descripcion;
    var $disponible;
	var $fechai;
	var $fechat;
    var $usuario;
	var $idplan;
	var $seguimiento;
	var $periodos;
	var $jerarquia;
	
	
	var $campos;
	

	
	function __construct() {
		
	}

    function GuardarPlan(){
		
		$this->campos = array('TITULO'=>$this->titulo,
							 'DESCRIPCION'=>$this->descripcion,
							 'PK_JERARQUIA'=>$this->jerarquia,
							 'DISPONIBLE'=>$this->disponible,
							 'FECHA_I'=>$this->fechai,
							 'FECHA_T'=>$this->fechat,
							 'FECHA_M'=>date("Y-m-d H:i:s"),
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 );
		
		$condition = "PK1='".$this->idplan."'";
		 
		database::updateRecords("PL_POPERATIVOS",$this->campos,$condition);
		
		$this->GuardarPeriodosSeguimiento();
		
	}
	
	
	
	
	function GuardarPeriodosSeguimiento(){
		
		$fecha = date("Y-m-d H:i:s");
		$usuario = $_SESSION['session']['user'];
		
		
		$plano = $this->idplan;
		
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$plano'";
	    $numperiodosbase =  database::getNumRows($sql);
		
		$numperiodos = sizeof($this->seguimiento)-1;
		
		if($numperiodosbase>$numperiodos){
			
		for($i=$numperiodos;$i<=$numperiodosbase;$i++){
		
		$sql = "DELETE FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$plano' AND ORDEN='$i'";	
		database::executeQuery($sql);
			
			}
		
		}
		
	
		$cont = 1;
		for($i=0;$i<sizeof($this->seguimiento)-1;$i++){
			 
		      $periodo = explode("^",$this->seguimiento[$i]);
			  $titulo = $periodo[0];
			  $fechai = $periodo[1];
			  $fechat = $periodo[2];
			  
		      $sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$plano' AND ORDEN = '$cont'";
		      $row = database::getRow($sql);
		
		 		
	          if($row){
		  
			   $this->campos = array('PERIODO'=>$titulo,
							 'FECHA_I'=>$fechai,
							 'FECHA_T'=>$fechat,
							 'FECHA_M'=>$fecha,
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 );
		
		 $condition = "PK_POPERATIVO = '$plano' AND ORDEN = '$cont'";
		 
		 database::updateRecords("PL_POPERATIVOS_PERIODOS",$this->campos,$condition);
			
		      }else{
			  
			  
		       $idperiodo =  strtoupper(substr(uniqid('SP'), 0, 15));
		       $this->campos = array('PK1'=>$idperiodo,
	                         'PERIODO'=>$periodo[0],
							 'ORDEN'=>$cont,
							 'FECHA_I'=>$periodo[1],
							 'FECHA_T'=>$periodo[2],
							 'PK_POPERATIVO'=>$this->idplan,
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'FECHA_M'=>NULL,
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 );
		
		
		database::insertRecords("PL_POPERATIVOS_PERIODOS",$this->campos);
		  }
		$cont++;
		}
	}
	
	
	
	
	function getPlanO($id){
		
		$sql = "SELECT * FROM PL_POPERATIVOS WHERE PK1='$id'";   
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		
	}
	
	
	 function getPlanE($id){
		
		$sql = "SELECT * FROM PL_PESTRATEGICOS WHERE PK1='$id'";   
		$row = database::getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}
		
	
	
	function getPeriodos(){
		
		
	   $id = $this->idplan;
	   $this->periodos = array();
       $sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$id' ORDER BY ORDEN ASC";   
      
	   $rows = database::getRows($sql);
		
		foreach($rows as $row){
		
	    $this->periodos[] = $row;
		
        }
		
	}
		
	
}

?>