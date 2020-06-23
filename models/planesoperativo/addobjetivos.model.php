<?php

class addobjetivosModel {
	

	var $titulo;
	var $descripcion;
	var $jerarquia;
    var $disponible;
	var $fechai;
	var $fechat;
    var $usuario;
	var $idplan;
	
	var $idPlanOpe;
	var $idPlanEst;
	var $resumenejecutivo;
	var $lineas;
	var $idlinea;
	var $idResultado;
	var $idArea;
	var $idFortaleza;
	var $idEvidencia;
	var $objetivos;
	var $medios;
	var $evidencias;
	var $estado;
	var $responsables;
	var $indicadores;
	var $indicadoresByObj;

	var $campos;
	var $areas;
	var $fortalezas;
	var $debilidades;//NEW
	var $oportunidades;//NEW
	

	
	
	function __construct() {
		
	}
	
	function setActive($idplan){
		
		$user = $_SESSION['session']['user'];
		
		$sql = "SELECT * FROM PL_POPERATIVOS WHERE PK1='$idplan' AND ACTIVO = NULL";
		$row = database::getRow($sql);
	
		if($row){
			$sql = "UPDATE PL_POPERATIVOS SET ACTIVO = '$user' WHERE PK1='$idplan'";	
	        $result = database::executeQuery($sql);
		}else{
			return FALSE;
		}
		
	}
	
	function OrdenarResultados($idplanO,$resultados){
	
	$cont=0;
	$html="";
	$resultadosa = explode(",",$resultados);
	
	for($i=0;$i<sizeof($resultadosa);$i++){
	$sql = "UPDATE PL_POPERATIVOS_OBJETIVOST SET ORDEN = '$cont' WHERE PK1='".$resultadosa[$i]."'";	
	        $result = database::executeQuery($sql);
	//$html.= $sql;
	$cont++;
	    }
		
		//echo $html;
	
	}
	
	
	
	function updateResultado($id,$resultado,$objetivo,$responsable,$indicadoresS){
		
		
		$resultado = utf8_decode($resultado);
		$resultado =  str_replace("'","''",$resultado);
	
		$sql = "UPDATE PL_POPERATIVOS_OBJETIVOST SET OBJETIVO = '$resultado', PK_OESTRATEGICO = '$objetivo', PK_RESPONSABLE = '$responsable' WHERE PK1='$id'";	
		$result = database::executeQuery($sql);
	        
	    $result =$this->delIndicadoresByObj($id);
		$arrayIndicadores = explode(",", $indicadoresS);
		foreach ($arrayIndicadores as $valor) {
			$this->indicadores = array(
				'PK_OTACTICO'=>$id,
				'PK_INDICADORMETA'=>$valor,
				'PK_OESTRATEGICO'=>$objetivo,
				'PK_RESPONSABLE'=>$responsable,
				'FECHA_R'=>date("Y-m-d H:i:s"),
				'PK_USUARIO'=>$_SESSION['session']['user'],
				);	
			if($valor != "" || $valor != null ){	
				$result =database::insertRecords("PL_POPERATIVOS_OBJETIVOS_INDICADORES",$this->indicadores);
			}
		}
		echo $result;
	}
	
	
	
	function updateMedio($id,$medio,$responsable){
		
		$medio = utf8_decode($medio);
		$medio =  str_replace("'","''",$medio);
		
		$sql = "UPDATE PL_POPERATIVOS_MEDIOS SET MEDIO = '$medio',PK_RESPONSABLE = '$responsable' WHERE PK1='$id'";	
	        $result = database::executeQuery($sql);
	        
	        echo $result;
		
	}
	function updateIndicadorMeta($id,$indicadorMeta,$meta,$numOrden){
		
		$indicadorMeta = utf8_decode($indicadorMeta);
		$indicadorMeta =  str_replace("'","''",$indicadorMeta);
		$meta = utf8_decode($meta);
		$meta =  str_replace("'","''",$meta);
		
		$sql = "UPDATE PL_POPERATIVOS_INDICADORESMETAS SET INDICADOR = '$indicadorMeta',META = '$meta',ORDEN = '$numOrden' WHERE PK1='$id'";	
	        $result = database::executeQuery($sql);
	        
	        echo $result;
		
	}
	
	
	function updateEvidencia($id,$evidencia){
		
		$evidencia = utf8_decode($evidencia);
		$evidencia =  str_replace("'","''",$evidencia);
		
		$sql = "UPDATE PL_POPERATIVOS_EVIDENCIAS SET EVIDENCIA = '$evidencia' WHERE PK1='$id'";	
	        $result = database::executeQuery($sql);
	        
	        echo $result;
		
	}
	
	
	function updateArea($id,$area){
		
		$area = utf8_decode($area);
		$area =  str_replace("'","''",$area);
		
		$sql = "UPDATE PL_POPERATIVOS_AREAS SET AREA = '$area' WHERE PK1='$id'";	
	        $result = database::executeQuery($sql);
	        
	        echo $result;
		
	}
	
	
	function updateFortaleza($id,$fortaleza){
		
		
		$fortaleza = utf8_decode($fortaleza);
		$fortaleza =  str_replace("'","''",$fortaleza);
		
		$sql = "UPDATE PL_POPERATIVOS_FORTALEZAS SET FORTALEZA = '$fortaleza' WHERE PK1='$id'";	

         //echo $sql;	
		
	        $result = database::executeQuery($sql);
	        if($result===false)
			   echo 0;
			else
			   echo 1;
	}
	
	function obtenerConsecutivo_OT()
	{
		$PK_POPERATIVO = $this->idPlanOpe;
		$PK_LESTRATEGICA = $this->idlinea;
		$sql = "
			SELECT MAX(ORDEN) AS 'ORDEN'
			FROM PL_POPERATIVOS_OBJETIVOST
			WHERE PK_POPERATIVO = '$PK_POPERATIVO' AND PK_LESTRATEGICA = '$PK_LESTRATEGICA'
		";
		$rows = database::getRows($sql);
		foreach($rows as $row){
			return 1 + $row['ORDEN'];
		}
		return 0;
	}
	
	function InsertarResultado()
	{
		$orden = $this->obtenerConsecutivo_OT();
		
		$idObjT = (string)strtoupper(substr(uniqid('OT'), 0, 15));
		$this->campos = array('PK1'=>$idObjT,
				'OBJETIVO'=>"",
				'ORDEN'=>$orden,
				'PK_POPERATIVO'=>$this->idPlanOpe,
				'PK_LESTRATEGICA'=>$this->idlinea,
				'PK_OESTRATEGICO'=>"",
				'PK_RESPONSABLE'=>"",
				'FECHA_R'=>date("Y-m-d H:i:s"),
				'PK_USUARIO'=>$_SESSION['session']['user'],
				);

		database::insertRecords("PL_POPERATIVOS_OBJETIVOST",$this->campos);
		return $idObjT;
	}
	
	
	
	function InsertarMedio()
	{
		$idMedio =  strtoupper(substr(uniqid('M'), 0, 15));
		$this->camposM = array('PK1'=>$idMedio,
				'MEDIO'=>"",
				'ORDEN'=>0,
				'PK_OTACTICO'=>$this->idResultado,
				'PK_RESPONSABLE'=>"",
				'FECHA_R'=>date("Y-m-d H:i:s"),
				'PK_USUARIO'=>$_SESSION['session']['user'],
				);
	                      
		database::insertRecords("PL_POPERATIVOS_MEDIOS",$this->camposM);
		
		return $idMedio;
	}
	function InsertarIndicadorMeta()
	{
		$idIndMeta=  strtoupper(substr(uniqid('IM'), 0, 15));
		$this->camposM = array('PK1'=>$idIndMeta,
				'INDICADOR'=>"",
				'ORDEN'=>0,
				'PK_OTACTICO'=>$this->idResultado,
				'META'=>"",
				'FECHA_R'=>date("Y-m-d H:i:s"),
				'PK_USUARIO'=>$_SESSION['session']['user'],
				);
	                      
		database::insertRecords("PL_POPERATIVOS_INDICADORESMETAS",$this->camposM);
		
		return $idIndMeta;
	}

	
	
	function InsertarEvidencia(){
	
	
	$idEvidencia =  strtoupper(substr(uniqid('E'), 0, 15));				
							   $this->camposM = array('PK1'=>$idEvidencia,
	                                       'EVIDENCIA'=>"",
							               'ORDEN'=>0,
							               'PK_POPERATIVO'=>$this->idPlanOpe,
							               'PK_LESTRATEGICA'=>$this->idlinea,
							               'PK_OTACTICO'=>$this->idResultado,
							               'FECHA_R'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
	                      
						 database::insertRecords("PL_POPERATIVOS_EVIDENCIAS",$this->camposM);
			
	return $idEvidencia;
	
	}
	
	
	
	function InsertarArea(){
	
	$idArea =  strtoupper(substr(uniqid('A'), 0, 15));					
							   $this->camposM = array('PK1'=>$idArea,
	                                       'AREA'=>"",
							               'ORDEN'=>0,
							               'PK_POPERATIVO'=>$this->idPlanOpe,
							               'FECHA_R'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
	

					database::insertRecords("PL_POPERATIVOS_AREAS",$this->camposM);
			
	return $idArea;
	
	}
	
	
	
	function InsertarFortaleza(){
		
		$idFortaleza =  strtoupper(substr(uniqid('F'), 0, 15));					
							   $this->camposM = array('PK1'=>$idFortaleza,
	                                       'FORTALEZA'=>"",
							               'ORDEN'=>0,
							               'PK_POPERATIVO'=>$this->idPlanOpe,
							               'FECHA_R'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
	

						  database::insertRecords("PL_POPERATIVOS_FORTALEZAS",$this->camposM);
		
		return $idFortaleza;
		}
	
	
	
	
		/**************************nuevo edgar inicio*****/
		
		
			function InsertarOportunidades(){		
		
		
							   $this->camposM = array(
	                                       'OPORTUNIDADES'=>"",
							               'ORDEN'=>0,
							               'PK_POPERATIVO'=>$this->idPlanOpe,
							               'FECHA_R'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
	

						  database::insertRecords("PL_POPERATIVOS_OPORTUNIDADES",$this->camposM);
						  
						  
						  
		$sql="SELECT @@IDENTITY AS NewSampleId";		 
		 $rowID = database::getRow($sql); 		 
		 $IDOportunidades = $rowID['NewSampleId'];		
		
		return $IDOportunidades;
		}
		
		
		
		
		
		function updateOportunidades($id,$oportunidades){
		
		
		$oportunidades = utf8_decode($oportunidades);
		$oportunidades =  str_replace("'","''",$oportunidades);
		
		$sql = "UPDATE PL_POPERATIVOS_OPORTUNIDADES SET OPORTUNIDADES = '$oportunidades' WHERE PK1='$id'";	

         //echo $sql;	
		
	        $result = database::executeQuery($sql);
	        if($result===false)
			   echo 0;
			else
			   echo 1;
	}
	
	
	
		
		
		
		
		 function deleteOportunidades($id){
	  
	  $sql = "DELETE FROM PL_POPERATIVOS_OPORTUNIDADES WHERE PK1 = '$id' ";	
	  database::executeQuery($sql);
	  
	  }
		
		
		
		function InsertarDebilidades(){//AMENAZAS
		
		//$idFortaleza =  strtoupper(substr(uniqid('F'), 0, 15));	
		
							   $this->camposM = array(//'PK1'=>$idFortaleza,
	                                       'AMENAZAS'=>"",
							               'ORDEN'=>0,
							               'PK_POPERATIVO'=>$this->idPlanOpe,
							               'FECHA_R'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
	

						  database::insertRecords("PL_POPERATIVOS_AMENAZAS",$this->camposM);
						  
						  
						  
		$sql="SELECT @@IDENTITY AS NewSampleId";		 
		 $rowID = database::getRow($sql); 		 
		 $IDDebilidades = $rowID['NewSampleId'];		
		
		return $IDDebilidades;
		}
		
		
		
		
		
		function updateDebilidades($id,$debilidades){//AMENAZAS
		
		
		$debilidades = utf8_decode($debilidades);
		$debilidades =  str_replace("'","''",$debilidades);
		
		$sql = "UPDATE PL_POPERATIVOS_AMENAZAS SET AMENAZAS = '$debilidades' WHERE PK1='$id'";	

         //echo $sql;	
		
	        $result = database::executeQuery($sql);
	        if($result===false)
			   echo 0;
			else
			   echo 1;
	}
	
	
	 function deleteDebilidades($id){//AMENAZAS
	  
	  $sql = "DELETE FROM PL_POPERATIVOS_AMENAZAS WHERE PK1 = '$id' ";	
	  database::executeQuery($sql);
	  
	  }
	
	
		
		function getDebilidades(){//AMENAZAS
		
		$this->debilidades = array();
       
	    $planoperativo =  $_GET['IDPlan'];
		$sql = "SELECT * FROM PL_POPERATIVOS_AMENAZAS WHERE PK_POPERATIVO = '$planoperativo' ORDER BY ORDEN";	
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->debilidades[] = $row;
		
        }
     	}
		
		
		function getOportunidades(){
		
		$this->debilidades = array();
       
	    $planoperativo =  $_GET['IDPlan'];
		$sql = "SELECT * FROM PL_POPERATIVOS_OPORTUNIDADES WHERE PK_POPERATIVO = '$planoperativo' ORDER BY ORDEN";	
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->oportunidades[] = $row;
		
        }
     	}
		
		
		
		
		
		/**************************nuevo edgar fin*****/
	
	
		function getPlanOperativo($id){
		
		
		$camposM = array(
	              'APLICACION'=>'PLAN OPERATIVO',
			      'MODULO'=>'ELABORACION',
				  'MENSAJE'=>'INGRESO PLAN OPERATIVO: '.$id,
				  'PK_USUARIO'=>$_SESSION['session']['user'],
				  'FECHA_R'=>date("Y-m-d H:i:s"),
							               );
	
	    database::insertRecords("PL_ACTIVIDAD_USUARIO",$camposM);
		
		
		
		$sql = "SELECT * FROM PL_POPERATIVOS WHERE PK1 = '$id' ";   
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
	}
	


       function getLineasPlane($id){
		
			$this->lineas = array();
			$sql = "SELECT * FROM PL_PESTRATEGICOS_LINEASE WHERE PK_PESTRATEGICO = '$id' ORDER BY ORDEN";
			$rows = database::getRows($sql);
			
			foreach($rows as $row){
				$this->lineas[] = $row;		
        	}
     	}
		function getAndDelIndicadoresByObj($idResul, $idObj){
			$this->indicadoresByObj = array();
			
			$this-> delIndicadoresByObj($idResul);
			
			$sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE_INDICADORESMETAS WHERE PK_OESTRATEGICO = '$idObj' ORDER BY ORDEN";	
			$rows = database::getRows($sql);
			
			//echo '<input type="hidden" value="'.$sql.'"></input>';
			foreach($rows as $row){
				$this->indicadoresByObj[] = $row;
			}	
		}

		function delIndicadoresByObj($idResul){
			$respuesta = $sql0 = "DELETE FROM PL_POPERATIVOS_OBJETIVOS_INDICADORES WHERE PK_OTACTICO = '$idResul' ";	
			database::executeQuery($sql0);
			return $respuesta;
		}
         
	    function getObjetivosE($id){
		
		$this->objetivos = array();
        $sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$id' ORDER BY ORDEN";
        
      
	   $rows = database::getRows($sql);
		
		foreach($rows as $row){
		
	    $this->objetivos[] = $row;
		
        }
     	}
		
		
		
		 function getResponsables($planoperativo){
		
		$this->responsables = array();
        $sql = "SELECT A.ROL,U.PK1,U.APELLIDOS, U.NOMBRE  FROM PL_POPERATIVOS_ASIGNACIONES A, PL_USUARIOS U  WHERE U.PK1 = A.PK_USUARIO AND A.PK_POPERATIVO = '$planoperativo'";
       
	 
	   
	   $rows = database::getRows($sql);
		
		foreach($rows as $row){
		
	           $rol = $row['ROL'];
		       $sql = "SELECT * FROM PL_ROLES_PERMISOS WHERE PK_ROL='$rol' AND PK_PERMISO = 'P129'";
		       $rowpermiso = database::getRow($sql);
		       
			   if($rowpermiso){
			   	$this->responsables[] = $row;
			   }
		
        }
     	}
		
		
		function getAreas(){
		
		$this->areas = array();
       
	   $planoperativo =  $_GET['IDPlan'];
		$sql = "SELECT * FROM PL_POPERATIVOS_AREAS WHERE PK_POPERATIVO = '$planoperativo' ORDER BY ORDEN";	
	    $rows = database::getRows($sql);
		
		foreach($rows as $row){
		
	    $this->areas[] = $row;
		
        }
     	}
		
		
		
		function getFortalezas(){
		
		$this->fortalezas = array();
       
	    $planoperativo =  $_GET['IDPlan'];
		$sql = "SELECT * FROM PL_POPERATIVOS_FORTALEZAS WHERE PK_POPERATIVO = '$planoperativo' ORDER BY ORDEN";	
	    $rows = database::getRows($sql);
		
		foreach($rows as $row){
		
	    $this->fortalezas[] = $row;
		
        }
     	}
		
		 

    function GuardarObjetivos(){
		
		$camposM = array(
	              'APLICACION'=>'PLAN OPERATIVO',
			      'MODULO'=>'ELABORACION',
				  'MENSAJE'=>'GUARDA PLAN OPERATIVO: '.$this->idPlanOpe,
				  'PK_USUARIO'=>$_SESSION['session']['user'],
				  'FECHA_R'=>date("Y-m-d H:i:s"),
							               );
	
	    database::insertRecords("PL_ACTIVIDAD_USUARIO",$camposM);
		
		
		
	$this->EliminarObjetivos();
		

	 for($i=0;$i<sizeof($this->lineas)-1;$i++){
		
		
		$objetivos =  explode("^",$this->objetivos[$i]);
		$medios = explode("~",$this->medios[$i]);
		$evidencias = explode("~",$this->evidencias[$i]);

		          for($j=0;$j<sizeof($objetivos)-1;$j++){
		                   
						   //GUARDAMOS LOS OBJETIVOS DEL PLAN OPERATIVO
						   $idObjT =  (string)strtoupper(substr(uniqid('OT'), 0, 15));
						   $objetivo =  explode("¬",$objetivos[$j]);
						
						   $this->campos = array('PK1'=>$idObjT,
	                                       'OBJETIVO'=>str_replace("'","''",$objetivo[0]),
							               'ORDEN'=>$j,
										   'PK_POPERATIVO'=>$this->idPlanOpe,
							               'PK_LESTRATEGICA'=>$this->lineas[$i],
							               'PK_OESTRATEGICO'=>$objetivo[1],
							               'PK_RESPONSABLE'=>$objetivo[2],
							               'FECHA_R'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
	
		                   
			database::insertRecords("PL_POPERATIVOS_OBJETIVOST",$this->campos);
						   
                /////////EMPEZAMOS A GUARDAR LOS MEDIOS///////
								   
						   
					     $medios_objetivo = explode("^",$medios[$j]);
						 //print_r($medios_objetivo);
						 
						 for($k=0;$k<sizeof($medios_objetivo)-1;$k++){
						 	
							
							
						       $medio = explode("¬",$medios_objetivo[$k]);
							   $idMedio =  strtoupper(substr(uniqid('M'), 0, 15));					
							   $this->camposM = array('PK1'=>$idMedio,
	                                       'MEDIO'=>str_replace("'","''",$medio[0]),
							               'ORDEN'=>$k,
							               'PK_OTACTICO'=>$idObjT,
							               'PK_RESPONSABLE'=>$medio[1],
							               'FECHA_R'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
	                      
						 database::insertRecords("PL_POPERATIVOS_MEDIOS",$this->camposM);
											
						  }    
						  
						     /////////EMPEZAMOS A GUARDAR LAS EVIDENCIAS///////
						  
						 
						 
						 $evidencias_objetivo = explode("^",$evidencias[$j]);
						 
						 for($k=0;$k<sizeof($evidencias_objetivo)-1;$k++){
						 	
							
						       //$medio = explode("%",$medios_objetivo[$k]);
							   $idEvidencia =  strtoupper(substr(uniqid('E'), 0, 15));					
							   $this->camposM = array('PK1'=>$idEvidencia,
	                                       'EVIDENCIA'=>str_replace("'","''",$evidencias_objetivo[$k]),
							               'ORDEN'=>$k,
							               'PK_POPERATIVO'=>$this->idPlanOpe,
										   'PK_LESTRATEGICA'=>$this->lineas[$i],
										   'PK_OTACTICO'=>$idObjT,
							               'FECHA_R'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
	

						  database::insertRecords("PL_POPERATIVOS_EVIDENCIAS",$this->camposM);
											
						  } 
						 
						   						   
			     }
		
		}
		
		 
		  /////////GUARDAMOS EL RESUMEN EJECUTIVO///////
	
        for($k=0;$k<sizeof($this->areas)-1;$k++){
						 	
							   $idArea =  strtoupper(substr(uniqid('A'), 0, 15));					
							   $this->camposM = array('PK1'=>$idArea,
	                                       'AREA'=>$this->areas[$k],
							               'ORDEN'=>$k,
							               'PK_POPERATIVO'=>$this->idPlanOpe,
							               'FECHA_R'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
	

					database::insertRecords("PL_POPERATIVOS_AREAS",$this->camposM);
											
       }
       
       
       for($k=0;$k<sizeof($this->fortalezas)-1;$k++){
						 	
						       
							   $idFortaleza =  strtoupper(substr(uniqid('F'), 0, 15));					
							   $this->camposM = array('PK1'=>$idFortaleza,
	                                       'FORTALEZA'=>$this->fortalezas[$k],
							               'ORDEN'=>$k,
							               'PK_POPERATIVO'=>$this->idPlanOpe,
							               'FECHA_R'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
	

						  database::insertRecords("PL_POPERATIVOS_FORTALEZAS",$this->camposM);
											
       }
						  
						  
		 //////ACTUALIZAMOS EL ESTADO DEL PLAN OPERATIVO A GUARDADO///
		 
		$this->campos = array('ESTADO'=>$this->estado,
							               );								   
		$condition = "PK1='".$this->idPlanOpe."'"; 
		database::updateRecords("PL_POPERATIVOS",$this->campos,$condition);
		 		
	}
	
	
	
	
	  function deleteResultado($id){
	  
	  $sql = "DELETE FROM PL_POPERATIVOS_OBJETIVOST WHERE PK1 = '$id' ";	
	  database::executeQuery($sql);
	  
	  }
	  
	   function deleteMedio($id){
	  
	  $sql = "DELETE FROM PL_POPERATIVOS_MEDIOS WHERE PK1 = '$id' ";	
	  database::executeQuery($sql);
	  
	  }
	  function deleteIndicadorMeta($id){
	  
		$sql = "DELETE FROM PL_POPERATIVOS_INDICADORESMETAS WHERE PK1 = '$id' ";	
		database::executeQuery($sql);
		
		}

	  
	  
	  
	  function deleteEvidencia($id){
	  
	  $sql = "DELETE FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK1 = '$id' ";	
	  database::executeQuery($sql);
	  
	  }
	  
	  
	   function deleteArea($id){
	  
	  $sql = "DELETE FROM PL_POPERATIVOS_AREAS WHERE PK1 = '$id' ";	
	  database::executeQuery($sql);
	  
	  }
	  
	  
	  function deleteFortaleza($id){
	  
	  $sql = "DELETE FROM PL_POPERATIVOS_FORTALEZAS WHERE PK1 = '$id' ";	
	  database::executeQuery($sql);
	  
	  }
	  
	  
	
	
       function EliminarObjetivos(){
	   	
		$idplao = $this->idPlanOpe;
		$sql = "SELECT PK1 FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_POPERATIVO = '$idplao' ";	
	    $rows = database::getRows($sql);
		
		foreach($rows as $row){
			  $id = $row['PK1'];
		      $sql = "DELETE FROM PL_POPERATIVOS_MEDIOS WHERE PK_OTACTICO = '$id' ";	
	          database::executeQuery($sql);
			  
			  
			  $sql = "DELETE FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_OTACTICO = '$id' ";	
	          database::executeQuery($sql);
			  		 
		           
        }
	
		
		$sql = "DELETE FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_POPERATIVO = '$idplao' ";		
	    database::executeQuery($sql);
        
        $sql = "DELETE FROM PL_POPERATIVOS_AREAS WHERE PK_POPERATIVO = '$idplao' ";		
	    database::executeQuery($sql);
		
	    $sql = "DELETE FROM PL_POPERATIVOS_FORTALEZAS WHERE PK_POPERATIVO = '$idplao' ";		
	    database::executeQuery($sql);	
		
	   }
	
		
		function getEstadoPlanOperativo($id){
		 	
			
			$estado="";
			$sql = "SELECT ESTADO FROM PL_POPERATIVOS WHERE PK1 = '$id' ";  
		 
		 
		    $row = database::getRow($sql);
	    
		    switch(trim($row['ESTADO'])){
			  	
				case 'P':
					$estado = '<span class="label label-warning">Elaborando</span>';
			  		break;
				
				
				case "G":
					$estado = '<span class="label label-warning">Elaborando</span>';
			  		break;
				
					
			    case "E":
					$estado = '<span class="label label-revision">Revisando</span>';
					
			  		break;
					
				case "R":
					$estado = '<span class="label label-warning">Revisando Centro</span>';
			  		break;
					
					
				case "S":
					$estado = '<span class="label label-success">Elaborando Informe</span>';
			  		break;
			  	
				
				case "I":
					$estado = '<span class="label label-revision">Revisando Informe</span>';
			  		break;
					
				case "T":
					$estado = '<span class="label label-important">Terminado</span>';
			  		break;
				
			  	default:
				$estado = '<span class="label label-warning">Pendiente</span>';
			  		break;
			  }
			  
			  
			  return $estado;
			
		 }
	
	
}

?>