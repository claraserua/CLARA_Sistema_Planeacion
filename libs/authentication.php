<?php

require 'session.php';
require 'roles.php';

class Authentication extends Session{
  
   
	var $session;
	var $cookie;
	var $only_cookies;
	var $login;
	var $sid;
	var $privilegios;
         
	
	function Authentication()
	{
	 
	if(!isset($_SESSION)) 
         { 
        session_start(); 
		
         } 
		  
	      #VALIDAMOS SI EXISTE UNA SESSION
	    if(empty($_SESSION)){
		 
		 #SI NO EXISTE UNA SESSION VERIFICAMOS $_POST LOGIN
		  
			$this->validaLogin();
		}
		else{
		
		    
			$this->validaSession();
		}
		
	
	}
	 
		
	function validaSession(){
	
	$this->login=false;
	$this->session = $_SESSION['session'];
	$this->privilegios = new RolesUsuario($this->session["user"]);
		
		
		
	}
	
	function validaLogin(){
	
	
	 if($_POST){
		 
		 
	 	
		if ( isset( $_POST['usuario'] ) && isset( $_POST['password'] ) ){
		    $this->login = true;
		
			
		   #VALIDAMOS QUE EL USUARIO Y PASSWORD SEAN CORRECTOS
		if($this->validarUsuario($_POST['usuario'],$_POST['password'])){
			
			
			
			  
	    $campos = array('ACTIVO'=>1,
							    );
		$user = $_SESSION['session']['user'];
		$condition = "PK1 = '$user' ";
		database::updateRecords("PL_USUARIOS",$campos,$condition);
	
	 
			  $camposM = array(
	              'APLICACION'=>'SISTEMA',
			      'MODULO'=>'INGRESO',
				  'MENSAJE'=>'LOGIN SISTEMA',
				  'PK_USUARIO'=>$_SESSION['session']['user'],
				  'FECHA_R'=>date("Y-m-d H:i:s"),
							               );
	
	    database::insertRecords("PL_ACTIVIDAD_USUARIO",$camposM);
			  
			  
		}
		
		}else{$this->login = TRUE;}
	  }else{
	  	
	  	$this->session = NULL;
	  }
		
	}
	
	
	function setPassport($user,$titulo,$nombre,$apellidos,$email,$imagen,$nodo){
		
	$this->session = $this->setSession($user,$titulo,$nombre,$apellidos,$email,$imagen,$nodo);
		
	}
	
	
	function mssql_escape($str)
    {
    if(get_magic_quotes_gpc())
    {
        $str= stripslashes($str);
    }
    return str_replace("'", "''", $str);
    }
	
	
	
	function  validarUsuario($user,$pass){
		
		
			
		
	        $user = $this->mssql_escape(htmlspecialchars($user));
			$pass = $this->mssql_escape(htmlspecialchars($pass));
	    
     		$sql = "SELECT * FROM PL_USUARIOS WHERE PK1= '$user' AND PASSWORD = '$pass'";
			
			
			
		    $row = database::getRow($sql);
	
	        
	
		if($row){
			
			
			 $this->privilegios = new RolesUsuario($_POST['usuario']);
			 $this->setPassport($_POST['usuario'],$row['TITULO'],$row['NOMBRE'],$row['APELLIDOS'],$row['EMAIL'],$row['IMAGEN'],$row['PK_JERARQUIA']);
			 return true;
		}else{
			return false;
		}
		
		
	}
	
	    function isActivo($plan){
         
        $user = $_SESSION['session']['user'];
		$sql = "SELECT * FROM PL_POPERATIVOS WHERE PK1 = '$plan' ";
		//$sql = "SELECT * FROM PL_ROLES_USUARIO WHERE PK_USUARIO = '$user' AND PK_ROLE = 'R00'";
		$row = database::getRow($sql);
		if($row['ACTIVO']== NULL || $row['ACTIVO']==$user){
			return FALSE;
		}else{
            return TRUE;
        }
        
        }
	
	
	
        function isAdmin(){
         
        $user = $_SESSION['session']['user'];
		$sql = "SELECT * FROM PL_ROLES_USUARIO WHERE PK_USUARIO = '$user' AND PK_ROLE = 'R00'";
		$row = database::getNumRows($sql);
		if($row){
			return TRUE;
		}else{
            return FALSE;
        }
        
        }
	
    
    
		function getPrivilegio($plan,$permiso){
		
		$user = $_SESSION['session']['user'];
		
		$sql = "SELECT * FROM PL_ROLES_USUARIO WHERE PK_USUARIO = '$user' AND PK_ROLE = 'R00'";
		$row = database::getNumRows($sql);
		if($row){
			return TRUE;
		}else{
			
		$sql = "SELECT * FROM PL_POPERATIVOS_ASIGNACIONES WHERE PK_POPERATIVO = '$plan' AND PK_USUARIO = '$user' ";	
		$row = database::getRow($sql);
	
		if($row){
			$rol = $row['ROL'];
			$sql = "SELECT * FROM PL_ROLES_PERMISOS WHERE PK_ROL = '$rol' AND PK_PERMISO = '$permiso' ";	
			$rows = database::getNumRows($sql);
			if($rows){ return TRUE;}else{ return FALSE;}
			
		}else{
			return FALSE;
		}
			
			}
		}
	
	
	function getPrivilegioRol($rol,$permiso){
		
			$sql = "SELECT * FROM PL_ROLES_PERMISOS WHERE PK_ROL = '$rol' AND PK_PERMISO = '$permiso' ";	
			$rows = database::getNumRows($sql);
			if($rows){ return TRUE;}else{ return FALSE;}	
		}
	
	
	
	function fail($message,$to=''){ // fails forward
		$_SESSION['message']=$message;
		@header('Location: '.($to!=''?$to:$_SERVER['HTTP_REFERER']));
		die();
	}
	


     # Terminamos la session del usuario
	 function setlogOut() {
		 //session_start();
         //unset($_SESSION["nombre_usuario"]); 
         //unset($_SESSION["nombre_cliente"]);
         session_destroy();
		 session_unset();
		 header("Location: index.php");
         exit;
	}

	
}
?>
