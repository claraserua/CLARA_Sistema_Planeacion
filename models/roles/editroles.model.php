<?php

class editrolesModel {
	
	var $rol;
	var $descripcion;

	
	function __construct() {
		
	}

   function ObtenerRol($id){
	 	
		$sql = "SELECT * FROM PL_ROLES WHERE PK1 = '$id'";   
		$row = database::getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
	 }
   
   
}

?>