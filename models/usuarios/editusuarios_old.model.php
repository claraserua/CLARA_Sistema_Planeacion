<?php

class editusuariosModel {
	
	var $image;
	var $titulo;
	var $nombre;
	var $apellidos;
	var $correo;
	var $usuario;
	var $password;
	var $jerarquia;
	var $roles;
	var $rolesusuario;
	var $niveles;
	var $disponible;
	
	
	var $campos;
	

	
	
	function editusuariosModel() {
		
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
								'DISPONIBLE'=>$this->disponible,
								'PK_JERARQUIA'=>$this->jerarquia,
								'IMAGEN'=>$this->image,
								'FECHA_M'=>date("Y-m-d H:i:s"),
								'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
										   
		 $condition = "PK1='".$this->usuario."'";
		 
		database::updateRecords("PL_USUARIOS",$this->camposM,$condition);
		
		
	
		$this->AgregarRolesUsuario();
		
	    $this->AgregarNiveles();

		
	}
	
	
	 function AgregarRolesUsuario(){
	  $usuario = $this->usuario;
	  $sql = "DELETE PL_ROLES_USUARIO WHERE PK_USUARIO = '$usuario'";
	  database::executeQuery($sql);
	  
	  foreach($this->rolesusuario as $row){
		$this->campos = array('PK_USUARIO'=>$this->usuario,
	                         'PK_ROLE'=>$row,
							 );
					 
	 database::insertRecords("PL_ROLES_USUARIO",$this->campos);
		
		}
		
		
	 }
	 
	 
	  function AgregarNiveles(){
	  $usuario = $this->usuario;
	  $sql = "DELETE PL_USUARIOS_JERARQUIA WHERE PK_USUARIO = '$usuario'";
	  database::executeQuery($sql);
	  
	  foreach($this->niveles as $row){
		$this->campos = array('PK_USUARIO'=>$this->usuario,
	                         'PK_JERARQUIA'=>$row,
							 );
		database::insertRecords("PL_USUARIOS_JERARQUIA",$this->campos);
		}
	 }
	 
	 
	 
	 function obtenerRoles(){
	 	$sql = "SELECT * FROM PL_ROLES WHERE TIPO IN('A','G') "; 
		$rows = database::getRows($sql);
		
		foreach($rows as $row){
		
	     $this->roles[] = $row;
		
        }
	 }
	 
	 
	 function obtenerRolesUsuario($id){
	 	$sql = "SELECT * FROM PL_ROLES_USUARIO WHERE PK_USUARIO = '$id'"; 
		$rows = database::getRows($sql);
		
		foreach($rows as $row){
		
	     $this->rolesusuario[] = $row['PK_ROLE'];
		
        }
	 }
	
}

?>