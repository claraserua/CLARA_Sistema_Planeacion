<?php

class exportexcelModel {
	//local

	var $idplan;
	var $lineas;
	var $objetivos;
	var $medios;
	var $metanual;
	var $areas;
	var $fortalezas;
	var $objetivose;
	var $comentariosg;
	var $comentariosr;
	var $comentariosd;
	var $periodos;
	var $comentariosp;	
	
	var $oportunidades;
	var $amenazas;
	
	
	function __construct() {
		
	}
	
	
	function getAvanceMedio($idperiodo,$idmedio){
		
		$sql ="SELECT PORCENTAJE FROM PL_POPERATIVOS_MEDIOS_AVANCES WHERE PK_PERIODO = '$idperiodo' AND PK_MEDIO = '$idmedio'";
		
		
		$row = database::getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		
	}
	
	
	function getAvanceResultado($idperiodo,$idresultado){
		
		
		$sql = "SELECT PORCENTAJE FROM PL_POPERATIVOS_OBJETIVOST_AVANCES WHERE PK_PERIODO = '$idperiodo' AND PK_OTACTICO = '$idresultado'";
		
		$row = database::getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		
		
		
	}
	
	
	function getPeriodos($id){
		
		$this->periodos = array();
		
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$id' ORDER BY ORDEN";
		
		$rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->periodos[] = $row;
		
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

     function getJerarquia($id){
	 	$sql = "SELECT * FROM PL_JERARQUIAS WHERE PK1='$id'";   
		$row = database::getRow($sql);
	
		if($row){
			return $row['NOMBRE'];
		}else{
			return FALSE;
		}
	 	
	 }

     function getLineas(){
		
		$this->lineas = array();
		$id = $_GET['IDPlanE'];
		$sql = "SELECT * FROM PL_PESTRATEGICOS_LINEASE WHERE PK_PESTRATEGICO = '$id' ORDER BY ORDEN";
		
       $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->lineas[] = $row;
		
        }
		
		}
	
	
	    function getAreas($plan){
			
		$this->areas = array();
		
		$sql = "SELECT * FROM PL_POPERATIVOS_AREAS WHERE PK_POPERATIVO = '$plan' ORDER BY ORDEN";
		
        $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->areas[] = $row;
		
        }
			
		}
		
		
		function getFortalezas($plan){
			
		$this->fortalezas = array();
		
		$sql = "SELECT * FROM PL_POPERATIVOS_FORTALEZAS WHERE PK_POPERATIVO = '$plan' ORDER BY ORDEN";
		
       $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->fortalezas[] = $row;
		
        }
			
		}
		
		
	function getOportunidades($plan){
			
		$this->oportunidades = array();
		
		$sql = "SELECT * FROM PL_POPERATIVOS_OPORTUNIDADES WHERE PK_POPERATIVO = '$plan' ORDER BY ORDEN";	
		
        $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->oportunidades[] = $row;
		
        }
			
	}
	
	
	
	  function getAmenazas($plan){
			
		$this->amenazas = array();
		
		$sql = "SELECT * FROM PL_POPERATIVOS_AMENAZAS WHERE PK_POPERATIVO = '$plan' ORDER BY ORDEN";
		
        $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->amenazas[] = $row;
		
        }
			
	 }
		
		
		
		
	
	
	
	 function getObjetivosTacticos($plan,$idlinea){
		
		$this->objetivos = array();
			
		$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_POPERATIVO = '$plan' AND PK_LESTRATEGICA = '$idlinea'  ORDER BY ORDEN";
		  
        $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->objetivos[] = $row;
		
        }
			 
		}
	
	
	 function getObjetivosEstrategicos($linea){
	  
	  $this->objetivose = array();
	  $sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$linea' ORDER BY ORDEN";
	  
	  $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->objetivose[] = $row;
		
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
	 
	 
	 function getResponsable($id){
	 	
		$sql = "SELECT CONCAT(TITULO,' ',NOMBRE,' ',APELLIDOS) AS RESPONSABLE FROM PL_USUARIOS WHERE PK1 = '$id'";

        $row = database::getRow($sql);
		
		if($row){
			return $row['RESPONSABLE'];
		}else{
			return FALSE;
		}
	 	
	 }
	 
	 
	 
	 
	 function getMedios($id){
		
		$this->medios = array();
		
        $sql = "SELECT * FROM PL_POPERATIVOS_MEDIOS WHERE PK_OTACTICO = '$id' ORDER BY ORDEN";	
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->medios[] = $row;
		
        }
		
     	}
		
		
		
		function getEvidencias($id){
		
		$evidencias = "";
        $sql = "SELECT * FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_OTACTICO = '$id' ORDER BY ORDEN";	

		$cont=1;
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
		$evidencias .= $cont;
		$evidencias .=". ".$row['EVIDENCIA'];
		$evidencias .=" ";
	    $cont++;
        }
     	
	
		return $evidencias;
		
		}

		function getObjEstrategicosToExl($num,$idTacti,$idObj){
		
			$indicadores = "";
			$metas = "";
			$sql = "SELECT p2.ORDEN,p2.INDICADOR,p2.META
					FROM PL_POPERATIVOS_OBJETIVOS_INDICADORES as p1
					LEFT JOIN	PL_PESTRATEGICOS_OBJETIVOSE_INDICADORESMETAS as p2
					ON  p1.PK_INDICADORMETA = p2.PK1
					WHERE p1.PK_OTACTICO = '$idTacti'
					AND p1.PK_OESTRATEGICO = '$idObj'
					ORDER BY P2.ORDEN ASC";	
	
			
			$rows = database::getRows($sql);
			
		   	foreach($rows as $row){	
				   $valornum = 	intval($row['ORDEN']) +1;	
				$indicadores .= $num.".".$valornum;
				$indicadores .=" ".utf8_encode($row['INDICADOR']);
				$indicadores .="\n";

				$metas .= $num.".".$valornum;
				$metas .=" ".utf8_encode($row['META']);
				$metas .="\n";
			}
			$array = [
				"indicadores" => $indicadores,
				"metas" => $metas
			];
			return $array;
			
		}
		function getIndicadoresMetas($id){
		
			$this->metanual = array();
		   
			$sql = "SELECT * FROM PL_POPERATIVOS_INDICADORESMETAS WHERE PK_OTACTICO = '$id' ORDER BY ORDEN";	
			$rows = database::getRows($sql);
			
			foreach($rows as $row){
				$this->metanual[] = $row;	
			}
		}
		
		
		
		function getComentariosResultadoPeriodo($idresultado,$idperiodo){
			
			$this->comentariosp = array();
			$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST_COMENTARIOS_PERIODOS where PK_OTACTICO = '$idresultado' AND PK_PERIODO = '$idperiodo' ORDER BY FECHA_R DESC";
			$rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	         $this->comentariosp[] = $row;
		
            }
	        
		}
		
		
		
		function getComentariosResultado($idresultado){
			
			$this->comentariosr = array();
			$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST_COMENTARIOS WHERE PK_OTACTICO = '$idresultado' ORDER BY FECHA_R DESC";
			$rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	         $this->comentariosr[] = $row;
		
            }
	        
		}
		
		
		function getComentariosDiagnostico($idplan){
			
			$this->comentariosd = array();
			$sql = "SELECT * FROM PL_POPERATIVOS_RESUMENE_COMENTARIOS WHERE PK_POPERATIVO = '$idplan' ORDER BY FECHA_R DESC";
			$rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	         $this->comentariosd[] = $row;
		
            }
	        
		}
		
		
		function getComentariosGenerales($idplan){
			
			$this->comentariosg = array();
			$sql = "SELECT * FROM PL_POPERATIVOS_COMENTARIOS WHERE PK_POPERATIVO = '$idplan' ORDER BY FECHA_R DESC";
			$rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	         $this->comentariosg[] = $row;
		
            }
	        
		}
	
}

?>