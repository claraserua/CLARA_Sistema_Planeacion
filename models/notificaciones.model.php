<?php

class notificacionesModel {
		
	
	function __construct(){
		
	}
	
	
        function goAlerta($ID){
		
		$sql = "UPDATE PL_NOTIFICACIONES SET VISTO = '1' WHERE PK1='$ID'";
		database::executeQuery($sql);
		
		
		$sql = "SELECT * FROM PL_NOTIFICACIONES WHERE PK1 = '$ID' ";   
		$row = database::getRow($sql);
		
		    if($row['PARAMETROS']==NULL){
				
				echo $row['URL'];
			}else{
				
				//echo $row['URL'];
				
			$parametros = explode(",",$row['PARAMETROS']);			
			$estado = explode("=",$parametros[0]);
			$plan = explode("=",$parametros[1]);
				
	
            				
		    $estado =  $estado[1];
			$plan =  $plan[1];
				
				$sql2 = "SELECT * FROM PL_POPERATIVOS WHERE PK1='$plan' AND ESTADO='$estado'";   
				
				//echo $sql2;
				
				 $result = database::getNumRows($sql2);
			//	$row2 = database::getRow($sql);
				if($result>0){
					echo $row['URL'];
				}
				
			}
		
		
	    }
		
		
		
		//########ELIMINAMOS EL PLAN OPERATIVO#####//
		function Eliminar($id){
		
        $sql = "DELETE FROM PL_POPERATIVOS WHERE PK1 = '$id' ";
        $result = database::executeQuery($sql);
	
	    if($result){
			$this->EliminarObjetivos($id);
		}else{
			return FALSE;
		}

     	}
		
		
		
		function EliminarObjetivos($PK_PLAN){
			
        $sql = "SELECT PK1 FROM PL_POPERATIVOS_OBJETIVOST where PK_POPERATIVO = '$PK_PLAN' ";
        //$result = database::executeQuery($sql);
	
	   // while ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
	   foreach(database::getRows($sql) as $row){ 
			   $id=$row['PK1'];
		       $this->eliminarEvidencias($id);
			   $this->eliminarMedios($id);
        }
		
		$sql = "DELETE FROM PL_POPERATIVOS_OBJETIVOST where PK_POPERATIVO = '$PK_PLAN' ";
        $result = database::executeQuery($sql);
		
		
		$sql = "DELETE FROM PL_POPERATIVOS_RESUMENE where PK_POPERATIVO = '$PK_PLAN' ";
        $result = database::executeQuery($sql);
		
		}
		
		
		
		
		function eliminarEvidencias($id){
			
		$sql = "DELETE FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_OTACTICO = '$id' ";
        $result = database::executeQuery($sql);
	
	    if($result){
			//$this->EliminarEvidencias($PK_PLAN);
		}else{
			return FALSE;
		}
			
		}
		
		
		
		
		function eliminarMedios($id){
				
		$sql = "DELETE FROM PL_POPERATIVOS_MEDIOS WHERE PK_OTACTICO = '$id' ";
        $result = database::executeQuery($sql);
	
	    if($result){
			//$this->EliminarEvidencias($PK_PLAN);
		}else{
			return FALSE;
		}
		
		}
		
		
		
		
		
		function getAsignacion($idplan,$idusuario){
		
		$sql = "SELECT * FROM PL_POPERATIVOS_ASIGNACIONES WHERE PK_POPERATIVO = '$idplan' AND PK_USUARIO = '$idusuario'";   
		
		$row = database::getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}
		
		
		
}

?>