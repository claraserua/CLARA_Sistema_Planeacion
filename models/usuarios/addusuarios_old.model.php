<?php

class addusuariosModel {
	
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
	var $disponible;
	
	
	var $campos;
	

	
	
	function addusuariosModel() {
		
	}

    function ExisteUsuario($id){
		
		$sql = "SELECT * FROM PL_USUARIOS WHERE PK1='$id'";
		$row = database::getRow($sql);
		
		if($row){
			return TRUE;
		}else{
			return FALSE;
		}
	}


    function GuardarUsuario(){
		
        $usuario = $this->sanear_string($this->usuario);
        
		$this->campos = array('PK1'=>$usuario,
	                         'PASSWORD'=>$this->password,
							 'TITULO'=>$this->titulo,
							 'NOMBRE'=>$this->nombre,
							 'APELLIDOS'=>$this->apellidos,
							 'EMAIL'=>$this->correo,
							 'IMAGEN'=>$this->image,
							 'DISPONIBLE'=>$this->disponible,
							 'PK_JERARQUIA'=>$this->jerarquia,
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'FECHA_M'=> NULL,
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 );
	
	    
		$result = database::insertRecords("PL_USUARIOS",$this->campos);
	
		$this->AgregarRolesUsuario();
		
	  	$this->AgregarNiveles();
		
		
	}
	
	
	 function AgregarRolesUsuario(){
	 	
	  foreach($this->rolesUsuario as $row){
	  $this->campos = array('PK_USUARIO'=>$this->usuario,
	                         'PK_ROLE'=>$row,
							 );
							 
	 $result = database::insertRecords("PL_ROLES_USUARIO",$this->campos);
		}
		
		
	 }
	 
	 
	  function AgregarNiveles(){
	 	
	  foreach($this->niveles as $row){
		$this->campos = array('PK_USUARIO'=>$this->usuario,
	                         'PK_JERARQUIA'=>$row,
							 );
		
		$result = database::insertRecords("PL_USUARIOS_JERARQUIA",$this->campos);
		}
		
	 }
	 
	 
	 
	 function obtenerRoles(){
	 	$sql = "SELECT * FROM PL_ROLES WHERE TIPO IN('A','G')"; 
        /*$result = database::executeQuery($sql);
			
		while ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
	     $this->roles[] = $row;
        }*/
		  $rows = database::getRows($sql);
		 foreach($rows as $row){
			   $this->roles[] = $row;
			}
		
	 }
	
    
    
    
    function sanear_string($string)
{

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             " "),
        '',
        $string
    );


    return $string;
}

}

?>