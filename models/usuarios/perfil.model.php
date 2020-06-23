<?php

class perfilModel {
	
	var $image;
	var $titulo;
	var $nombre;
	var $apellidos;
	var $correo;
	var $usuario;
	var $password;


	
	var $campos;
	
	function __construct() {
		
	}

   
   function ObtenerUsuario($id){
	 	
		$sql = "SELECT * FROM PL_USUARIOS WHERE PK1 = '$id'";   
		$row = database::getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
	 }
	 
	  function ActualizarUsuario(){
		
		
		
		 $this->camposM = array('PASSWORD'=>$this->password,
		                        'TITULO'=>$this->titulo,
								'NOMBRE'=>$this->nombre,
								'APELLIDOS'=>$this->apellidos,
								'EMAIL'=>$this->correo,
								'IMAGEN'=>$this->image,
								'FECHA_M'=>date("Y-m-d H:i:s"),
								'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
										   
		 $condition = "PK1='".$this->usuario."'";
		 
		database::updateRecords("PL_USUARIOS",$this->camposM,$condition);
		

		
	}
   
	
	
	
	
}

?>