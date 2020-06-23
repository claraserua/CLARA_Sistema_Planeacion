<?php

class ordenarjerarquiaModel {
	
	var $image;
	var $titulo;
	var $nombre;
	var $apellidos;
	var $correo;
	var $usuario;
	var $password;
	var $jerarquia;
	var $roles;
	var $rolesUsuario;
	var $niveles;
	
	
	var $campos;
	

	
	function __construct() {
		
	}



	 function ObtenerJerarquia($id){
	 	
		$sql = "SELECT * FROM PL_JERARQUIAS WHERE PK1 = '$id'";   
		$row = database::getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
	 }
	 
	 
	 
	 function ObtenerJerarquias($id){
	 	
		$sql = "SELECT * FROM PL_JERARQUIAS WHERE PADRE = '$id' ORDER BY ORDEN" ;
	   // $result = database::executeQuery($sql);
	   // while ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
	   $rows = database::getRows($sql);
		foreach($rows as $row){
		
	          $this->niveles[] = $row;
		
        }
		
	 }
	 
	 
	
}

?>