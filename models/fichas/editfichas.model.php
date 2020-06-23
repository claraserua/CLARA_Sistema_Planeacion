<?php

class editfichasModel {
	
	var $ficha;
	var $descripcion;

	
	function __construct() {
		
	}

 
    function ObtenerFicha($id){
	 	
		$sql = "SELECT * FROM PL_FICHAS WHERE PK1 = '$id'";   
		$row = database::getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
	 }
   
   
}

?>