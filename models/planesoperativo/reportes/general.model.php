<?php

class generalModel {
	
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
	var $comentariosp;
	var $periodos;
	var $medios;
	
	
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
        
        function getObjetivoEstrategico($id){
		
		$sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK1 = '$id'  ORDER BY ORDEN";

        $row = database::getRow($sql);
		
		if($row){
			return $row['OBJETIVO'];
		}else{
			return FALSE;
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
     	
     	
     function getComentariosResultadoPeriodo($idresultado,$idperiodo){
			
			$this->comentariosp = array();
			$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST_COMENTARIOS_PERIODOS where PK_OTACTICO = '$idresultado' AND PK_PERIODO = '$idperiodo' ORDER BY FECHA_R DESC";
			$result = database::executeQuery($sql);
			
			while  ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
		
	         $this->comentariosp[] = $row;
		
            }
	        
		}
		
		
		 function getResponsable($id){
	 	
		$sql = "SELECT CONCAT(TITULO,' ',NOMBRE,' ',APELLIDOS) AS RESPONSABLE FROM PL_USUARIOS WHERE PK1 = '$id'";

        $row = database::getRow($sql);
		
		if($row){
			return htmlentities($row['RESPONSABLE'], ENT_QUOTES, "ISO-8859-1");
		}else{
			return FALSE;
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
	
	function getNumeroEvidenciasP($plan,$linea,$resultado){
		
		//$this->evidencias = array();
		
		$sql  ="SELECT COUNT(PK1) AS NUM FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_POPERATIVO = '$plan' AND (PK_LESTRATEGICA = '$linea' OR PK_LESTRATEGICA = '') AND PK_OTACTICO = '$resultado' ";
				

		$row = database::getRow($sql);
		if($row){
			return $row['NUM'];
		}else{
			return FALSE;
		}
		
		
	}
	
	
	function getNumeroEvidenciasS($plan,$linea,$resultado){
		
		//$this->evidencias = array();
		
		$sql  ="SELECT COUNT(PK1) AS NUM FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_POPERATIVO = '$plan' AND PK_LESTRATEGICA = '$linea' AND PK_OTACTICO = '$resultado' AND ( (ADJUNTO IS NOT NULL) AND (ADJUNTO <> '') )";
				

		$row = database::getRow($sql);
		if($row){
			return $row['NUM'];
		}else{
			return FALSE;
		}
		
		
	}
	

   
    
    
   

}

?>