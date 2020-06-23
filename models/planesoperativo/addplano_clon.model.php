<?php

class addplano_clonModel {
	
	var $titulo;
	var $descripcion;
	var $plane;
    var $disponible;
	var $fechai;
	var $fechat;
    var $usuario;
	var $idplan;
	var $seguimiento;
	var $jerarquia;
	var $campos;
	var $idplan_clonar;
	
	
	
	
	function __construct() {
		
	}

    function GuardarPlan(){
		
		$JERARQUIA = $this->jerarquia;
		
		$this->campos = array('PK1'=>$this->idplan,
	                         'TITULO'=>$this->titulo,
							 'DESCRIPCION'=>$this->descripcion,
							 'PK_PESTRATEGICO'=>$this->plane,
							 'PK_JERARQUIA'=>$this->jerarquia,
							 'DISPONIBLE'=>$this->disponible,
							 'ESTADO'=>'P',
							 'FECHA_I'=>$this->fechai,
							 'FECHA_T'=>$this->fechat,
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 );
		
		database::insertRecords("PL_POPERATIVOS",$this->campos);
	
		$this->GuardarPeriodosSeguimiento();
		$this->ClonarResponsables();//clona los responsables del plan al nuevo plan
		
		
		
		
		
		
	}
	
	
	
	
	function GuardarPeriodosSeguimiento(){
		
		
		$cont = 1;
		for($i=0;$i<sizeof($this->seguimiento)-1;$i++){
			 
		      $periodo = explode("^",$this->seguimiento[$i]);
			  
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
		$cont++;
		
		database::insertRecords("PL_POPERATIVOS_PERIODOS",$this->campos);
		}
		
	}
	
	function ClonarResponsables(){
		
		$idplan_clonar = $this->idplan_clonar;
		
		$sql = "SELECT * FROM PL_POPERATIVOS_ASIGNACIONES WHERE PK_POPERATIVO = '$idplan_clonar' ";    		
	    $rows = database::getRows($sql);		
		
		//if(!$rows){
			
			foreach($rows as $resp){					
			
				$this->campos = array(
								 'PK_POPERATIVO'=>$this->idplan,
								 'PK_USUARIO'=>$resp['PK_USUARIO'],
								 'ROL'=>$resp['ROL'],	                      
								 'FECHA_R'=>date("Y-m-d H:i:s"),
								 );
			
			   $result = database::insertRecords("PL_POPERATIVOS_ASIGNACIONES",$this->campos);	
			
						
		   }			
			
			
		//}		
		
		
		
	}
	
	
	
	 function getPlanE($id){
		
		$sql = "SELECT * FROM PL_PESTRATEGICOS WHERE PK1='$id'";   
		$params = array($id);
		$row = database::getRow($sql,$params);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}
	
}

?>