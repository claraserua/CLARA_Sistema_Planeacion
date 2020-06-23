<?php

class reportesModel {
	
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
	var $resultados;
	var $evidencias;
	var $comentarios;
	var $medios;
	var $objestra;
	var $periodos;
	
	
	var $campos;
	

	
	
	function __construct() {
		
	}
	
	
	 function getPeriodos($id){
		
		
		$this->periodosall = array();       
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$id'  ORDER BY ORDEN";	
	   /* $result = database::executeQuery($sql);
		
	    while ($row =  mssql_fetch_array($result, MSSQL_ASSOC)) {
		
	    $this->periodos[] = $row;
		
        }*/
		
		
	   $rows = database::getRows($sql);
	  
	   foreach($rows as $row){
		
	    $this->periodos[] = $row;
		
        }	
		
		
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
	
	
	function getPlanes($niveles,$anos){
		
		$filano = "";
		if($anos != "all"){	$filano = "AND year(FECHA_I) = '".$anos."'";	}
		
		
		$filter = "'".str_replace(";","','",$niveles)."'";
		
		$sql = "SELECT * FROM PL_POPERATIVOS WHERE PK_JERARQUIA IN( $filter ) $filano ORDER BY PK_JERARQUIA";
		$rows = database::getRows($sql);
		
		foreach($rows as $row){
	    $this->planes[] = $row;
        }
		
		
	}
	
	function getEstado($idPO){	
		
		 $sql = "SELECT ESTADO FROM PL_POPERATIVOS WHERE PK1 = '$idPO' ";	
		 $row = database::getRow($sql);
		if($row){
			return $row['ESTADO'];
		}else{
			return FALSE;
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
	
	
	function getMedios($resultado){
		
			$this->medios = array();
		
		$sql  ="SELECT * FROM PL_POPERATIVOS_MEDIOS WHERE PK_OTACTICO = '$resultado'  ORDER BY ORDEN";
		
		$rows = database::getRows($sql);
		foreach($rows as $row){
	    $this->medios[] = $row;
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
        
        
         function getObjetivoEst($id){
        $sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK1 = '$id' ";	
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
     	}
     	
     	function getObjetivoEstrate($idle){
        $sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$idle' ";	
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
     	}
     	
     	
     	
     	
    /* function getObjetivoEstrate($id){
     	 	
     	 	$this->objestra = array();
       $sql  ="SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$id' ORDER BY ORDEN";
		
		$rows = database::getRows($sql);
		foreach($rows as $row){
	    $this->objestra[] = $row;
     	}	

    }*/
    
    
      function getResponsable($id){
		$sql = "SELECT * FROM PL_USUARIOS WHERE PK1 = '$id' ";	
		$row = database::getRow($sql);
		if($row){
			return $row['APELLIDOS']." ".$row['NOMBRE'];
		}else{
			return FALSE;
		}
	 }
	 
	 
	 function obtenerEvidencias($id){
		
		$evidencias = "";
        $sql = "SELECT * FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_OTACTICO = '$id' ORDER BY ORDEN";	
	    
	//	$result = database::executeQuery($sql);
	    
		
		/* $cont=1;
	   while ($row =  mssql_fetch_array($result, MSSQL_ASSOC)) {
		
		$evidencias .= $cont;
		$evidencias .=". ".htmlentities($row['EVIDENCIA'], ENT_QUOTES, "ISO-8859-1");
		$evidencias .=" ";
	    $cont++;
        }*/
		
		
	  $rows = database::getRows($sql);
	  $cont=1;
	   foreach($rows as $row){
		
	    $evidencias .= $cont;
		$evidencias .=". ".htmlentities($row['EVIDENCIA'], ENT_QUOTES, "ISO-8859-1");
		$evidencias .=" ";
	    $cont++;
		
        }		
     	
	
		return $evidencias;
		
		}
    
    
   

}

?>