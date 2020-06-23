<?php

class usuariosModel {
	
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
	
	var $usuarios;
	var $planes;
	
	
	var $campos;
	

	
	
	function __construct() {
		
	}
	
	
	
	function getUsuarios($niveles,$anos){		
		
		//$filano = "";
		//if($anos != "all"){	$filano = "AND FECHA_I = '".$anos."'";	}
		
		
		//$filter = "'".str_replace(";","','",$niveles)."'";
		//WHERE PK_JERARQUIA IN( $filter )
		
		$sql = "SELECT * FROM PL_USUARIOS ORDER BY PK_JERARQUIA";
		$rows = database::getRows($sql);
		
		foreach($rows as $row){
	    $this->usuarios[] = $row;
        }
		
		
	}
	
	
	
	function getUsuarioPlanesOperativos($niveles,$usuario,$anos){
		
		
		$filano = "";
		if($anos != "all"){	$filano = "AND   year(P.FECHA_I) = '".$anos."'"; }
		
		$filter = "'".str_replace(";","','",$niveles)."'";
		
		$this->planes = array();
		
		$sql  ="SELECT P.PK1, P.TITULO, P.PK_JERARQUIA, P.ESTADO, (SELECT ROLE FROM PL_ROLES WHERE PK1 = PA.ROL) AS ROL FROM PL_POPERATIVOS_ASIGNACIONES PA, PL_POPERATIVOS P WHERE PA.PK_POPERATIVO = P.PK1 AND  PA.PK_USUARIO = '$usuario' AND P.PK_JERARQUIA IN( $filter ) $filano";
		
		$rows = database::getRows($sql);
		foreach($rows as $row){
	    $this->planes[] = $row;
        }
	}
	
	function getPlan($id){
		
		$sql = "SELECT * FROM PL_POPERATIVOS WHERE PK1='$id'";
		$row = database::getRow($sql);
		
		if($row){
			return $row;
		}else{
			return FALSE;
		}
	}
	
	
	

   
    
    
   

}

?>