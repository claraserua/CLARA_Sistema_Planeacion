<?php

class avancesModel {
	
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
	var $planese;
	var $resultados;
	var $evidencias;
	var $comentarios;
	var $periodos;
	
	
	var $campos;
	

	
	
	function __construct() {
		
	}
	
	
	 function getComentariosGenerales($id){
		
		$this->comentarios = array();
		$sql = "SELECT * FROM PL_POPERATIVOS_COMENTARIOS WHERE PK_POPERATIVO = '$id' ORDER BY FECHA_R DESC";	
	    
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->comentarios[] = $row;
		
        }
        }
	
	function getImagen($id){
		$sql = "SELECT * FROM PL_USUARIOS WHERE PK1 = '$id'";   
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
	}
	
	
	function getPlanesEstrategicos($niveles){
		$this->planese = array();
		
		$filter = "'".str_replace(";","','",$niveles)."'";
		
		$sql = "SELECT * FROM PL_PESTRATEGICOS WHERE PK_JERARQUIA IN( $filter ) ORDER BY PK_JERARQUIA";
		$rows = database::getRows($sql);
		
		foreach($rows as $row){
	    $this->planese[] = $row;
        }
		
		
	}
	
	
	function getPlanes($plane,$jerarquia){
		$this->planes = array();
		
		$sql = "SELECT *  FROM PL_POPERATIVOS WHERE PK_PESTRATEGICO = '$plane' AND PK_JERARQUIA IN('$jerarquia') ORDER BY PK_JERARQUIA  ";
		$rows = database::getRows($sql);
		
		foreach($rows as $row){
	    $this->planes[] = $row;
        }
		
		
	}
	
	
	
	function getLineas($plan){
		
		$this->lineas = array();
		
		$sql  ="SELECT PK1,LINEA, ORDEN FROM PL_PESTRATEGICOS_LINEASE WHERE PK_PESTRATEGICO = '$plan' ORDER BY ORDEN";
		
		$rows = database::getRows($sql);
		foreach($rows as $row){
	    $this->lineas[] = $row;
        }
	}
	
	
	function getResultados($plan,$linea){
		
		$this->resultados = array();
		
		$sql  ="SELECT * FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_POPERATIVO = '$plan' AND PK_LESTRATEGICA= '$linea' ORDER BY ORDEN";
		
		$rows = database::getRows($sql);
		foreach($rows as $row){
	    $this->resultados[] = $row;
        }
		
		
	}
	
	  function getObjetivoEst($id){
        $sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK1 = '$id' ";	
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
     	}
     	
	
	function getEvidencias($plan,$linea,$resultado){
		
		$this->evidencias = array();
		
		$sql  ="SELECT * FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_POPERATIVO = '$plan' AND PK_LESTRATEGICA = '$linea' AND PK_OTACTICO = '$resultado' ORDER BY ORDEN";
		
		$rows = database::getRows($sql);
		foreach($rows as $row){
	    $this->evidencias[] = $row;
        }
		
		
	}
	
	
	
	function getPeriodos($plan){
		
		$this->periodos = array();
		
		$sql  ="SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$plan' ORDER BY ORDEN";
		
		$rows = database::getRows($sql);
		foreach($rows as $row){
	    $this->periodos[] = $row;
        }
		
		
	}
	
	
	
	function getAvanceResultado($resultado,$periodo){
		
		$sql = "SELECT PORCENTAJE FROM PL_POPERATIVOS_OBJETIVOST_AVANCES WHERE PK_OTACTICO='$resultado' AND PK_PERIODO = '$periodo'";
		
		$row = database::getRow($sql);
		
		if($row){
			return $row['PORCENTAJE'];
		}else{
			return 0;
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
	
	
	
	
	function getComentarios($id){
		
		$this->comentarios = array();
		$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST_COMENTARIOS WHERE PK_OTACTICO = '$id' ORDER BY FECHA_R DESC";	
	    
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->comentarios[] = $row;
		
        }
        }
        
        
	

   
    
    
   

}

?>