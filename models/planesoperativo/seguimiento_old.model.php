<?php

require 'libs/PHPMailer/PHPMailerAutoload.php';

class seguimientoModel {
	

	var $titulo;
	var $descripcion;
	var $jerarquia;
    var $disponible;
	var $fechai;
	var $fechat;
    var $usuario;
	var $idplan;

	
	var $idPlanOpe;
	var $resumenejecutivo;
	var $lineas;
	var $objetivos;
	var $objetivosE;
	var $medios;
	var $evidencias;
	var $estado;
	var $idlinea;
	var $idobjetivo;
	var $idmedio;
	var $idperiodo;
	var $avance;
	var $idevidencia;
	
	
	var $comentarios;
	var $colaboradores;
	var $periodos;
	var $periodosall;

	var $campos;
	
	var $nombre;
	var $puesto;
	var $departamento;
	var $valoracion;
	var $tipo;

	
	
	function seguimientoModel() {
		
	}
	
	
	
	
	 function buscarArchivos(){
		
		$this->archivos = array();
       // maximo por pagina
        $limit = $_GET["s"];
		// pagina pedida
        $pag = (int) $_GET["p"];
        if ($pag < 1)
        {
        $pag = 1;
        }
        
		$offset = ($pag-1) * $limit;
		$limit =  ($limit * $pag);
		
        if(isset($_GET['sort'])){
		    
			switch($_GET['sort']){
				case 1:
				$order = "ORDEN ";	
				break;
			}
			
		}else{
			$order = "ORDEN ";	
		}
		   
	
	     
		$idPlanOperativo =  $_GET['IDPlan'];
	
	
	    if(isset($_GET['filter'])){
			$filter = "'".str_replace(";","','",$_GET['filter'])."'";
			$categorias = "AND TIPO IN( $filter ) ";
	
		}else{
			$categorias = "";
		}
		
		
		if(isset($_GET['objetivo'])){
			$objetivo = "AND PK_OTACTICO = '".$_GET['objetivo']."'";
		}else{
			$objetivo = "";
		}
		
		
		
		 if(isset($_GET['q']) && $_GET['q']!= ""){ 
			//$buscar = "AND (EVIDENCIA LIKE '%".$_GET['q']."%') ";	
			
$buscar = " AND REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LOWER(EVIDENCIA),'á','a'), 'é','e'),'í','i'),'ó','o'),'ú','u'),'ñ','n') LIKE  REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LOWER('%".$_GET['q']."%'),'á','a'), 'é','e'),'í','i'),'ó','o'),'ú','u'),'ñ','n') ";
			
		}else{
			
			$buscar = "";
			
		}	
					
				
	$sql ="SELECT  *
FROM    ( SELECT ROW_NUMBER() OVER ( ORDER BY FECHA_R ) AS RowNum, *
          FROM      PL_POPERATIVOS_EVIDENCIAS
          WHERE     PK_POPERATIVO = '$idPlanOperativo' $categorias  $objetivo $buscar
        ) AS RowConstrainedResult 
WHERE  RowNum >= $offset   AND RowNum <= $limit ORDER BY $order
";	

       //  echo $sql;
     //   $sqlcount = $sql;
        
    // $sql .="WHERE  RowNum >= $offset   AND RowNum <= $limit ORDER BY $order";	
	

				
		/*   if(isset($_GET['q']) && $_GET['q']!= ""){ 
			$sql .= "AND (EVIDENCIA LIKE '%".$_GET['q']."%') ";	
		}*/
		$sqlcount = "SELECT * FROM PL_POPERATIVOS_EVIDENCIAS  WHERE PK_POPERATIVO = '$idPlanOperativo' $categorias  $objetivo $buscar ";
		
       
	
        $total = database::getNumRows($sqlcount);      
	    $this->totalnum = $total;
	
	
	   $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->archivos[] = $row;
		
        }
		
	//CALCULAMOS EL TOTAL DE PAGINAS
	$this->totalPag = ceil($total/$limit);
		 
	  }
	
	
	function getNumeroEvidencias($idobjetivo){
		
		$sql = "SELECT * FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_OTACTICO = '$idobjetivo' AND ADJUNTO <> 'NULL'";
		$total = database::getNumRows($sql);      
		return $total;
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
	
	
	function getPlanOperativo($id){
		$sql = "SELECT * FROM PL_POPERATIVOS WHERE PK1='$id'";   
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
	}


	   function getLineaPlane($id){
		$sql = "SELECT * FROM PL_PESTRATEGICOS_LINEASE WHERE PK1='$id'";   
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


         function getObjetivoE($id){
        $sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK1 = '$id' ";	
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
     	
     	 function getObjetivoEst2($id){
        $sql = "SELECT OBJETIVO FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK1 = '$id' ";	
		$row = database::getRow($sql);
		if($row){
			return $row['OBJETIVO'];
		}else{
			return FALSE;
		}
     	}
		
		
		 function getObjetivosPlan($idplan,$idlinea){
		 $this->objetivos = array();
         $sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_POPERATIVO = '$idplan' AND  PK_LESTRATEGICA = '$idlinea' ORDER BY ORDEN ";	
	     $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	     $this->objetivos[] = $row;
		
         }
     	 
		 }


		  function getResultado($idplan,$idlinea,$idresultado){
		 $this->objetivos = array();
         $sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_POPERATIVO = '$idplan' AND  PK_LESTRATEGICA = '$idlinea' AND PK1  = '$idresultado' ORDER BY ORDEN ";	
	     $row = database::getRow($sql);
		
		
	    if($row){
			return $row;
		}else{
			return FALSE;
		}
     	 
		 }
		



         function getResponsable($id){
		$sql = "SELECT * FROM PL_USUARIOS WHERE PK1 = '$id' ";	
		$row = database::getRow($sql);
		if($row){
			return $row['APELLIDOS']." ".$row['NOMBRE'];
		}else{
			return FALSE;
		}
		 }


         
	    function getObjetivosTacticos($idPLAN,$idlINEA){
		
		$this->objetivos = array();
        $sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_POPERATIVO = '$idPLAN' AND PK_LESTRATEGICA = '$idlINEA' ORDER BY ORDEN";	
	  
	     
	  
	  
	   $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->objetivos[] = $row;
		
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
		
		$this->evidencias = array();
        $sql = "SELECT * FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_OTACTICO = '$id' ORDER BY ORDEN";	
	   $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->evidencias[] = $row;
		
        }
     	}

       
       
       
       function getEvidenciasPlanBusqueda($linea,$plan){
		//(EVIDENCIA LIKE '%".$linea."%')
		
	//	$buscar = " REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE( LOWER(CONVERT(VARCHAR(MAX), EVIDENCIA)),'á','a'), 'é','e'),'í','i'),'ó','o'),'ú','u'),'ñ','n') LIKE REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LOWER('%promoción%'),'á','a'), 'é','e'),'í','i'),'ó','o'),'ú','u'),'ñ','n') ";
			
		//'%promocion%'
		
		$this->evidencias = array();
		
       $sql = "SELECT * FROM PL_POPERATIVOS_EVIDENCIAS WHERE EVIDENCIA LIKE  '%".$linea."%'  AND PK_POPERATIVO = '$plan' ORDER BY ORDEN ";	
	    
	    $rows = database::getRows($sql);
		
		
		//echo $sql;
		
		//echo sizeof($rows);
		
	   foreach($rows as $row){
		
	    $this->evidencias[] = $row;
		
        }
     	}
		
       
       
       
       
       
       
     	function getEvidenciasPlan($id,$plan){
     		
     		
       if(isset($_GET['q']) && $_GET['q']!= ""){ 
			$buscar = "AND (EVIDENCIA LIKE '%".$_GET['q']."%') ";	
		}else{
			
			$buscar = "";
			
		}	
     		
     		
     		/*if($q==""){
				$search=="";
			}else{
				$search==' AND EVIDENCIA LIKE %'.$q.'%';
			}*/
     		
		
		$this->evidencias = array();
        $sql = "SELECT * FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_OTACTICO = '$id' AND PK_POPERATIVO = '$plan' $buscar ORDER BY ORDEN";	
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->evidencias[] = $row;
		
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
		
		function getPeriodosActivos($id){
		
        
		
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$id' AND ENVIADO IN ('1','2') ORDER BY ORDEN";	
	    $num = database::getNumRows($sql);  
		
		if($num==0){$num++;}	
		return $num;
		
	   
     	}
		
		function getPeriodosAll($id){
		
		
		$this->periodosall = array();       
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$id'  ORDER BY ORDEN";	
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->periodosall[] = $row;
		
        }
     	}
		
		
		function getPeriodos($id){
		
		$fecha_i = date("Y-m-d");
		
		$this->periodos = array();       
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$id' AND FECHA_I <= '$fecha_i' ORDER BY ORDEN";	
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->periodos[] = $row;
		
        }
     	}
		
		
		
		
		function getNumeroComentarios($id){
		$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST_COMENTARIOS WHERE PK_OTACTICO = '$id'";	
		$num = database::getNumRows($sql);  	
		return $num;
		}


		function getNumeroResultadosLinea($idPO,$idlinea){
           
        $sql = "SELECT  *  FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_LESTRATEGICA = '$idlinea' AND PK_POPERATIVO = '$idPO'";	
		$num = database::getNumRows($sql);  	
		return $num;

		}


		function getNumeroEvidenciasLinea($idPO,$idlinea){
           
        $sql = "SELECT  *  FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_LESTRATEGICA = '$idlinea' AND PK_POPERATIVO = '$idPO'  AND  ADJUNTO <> 'NULL'  AND  ADJUNTO <> ''";	
		$num = database::getNumRows($sql);  	
		return $num;

		}
		
		function getNumeroEvidenciasResultados($idPO,$idlinea,$resultado){
           
        $sql = "SELECT  *  FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_LESTRATEGICA = '$idlinea' AND PK_POPERATIVO = '$idPO' AND PK_OTACTICO = '$resultado' AND  ADJUNTO <> 'NULL'  AND  ADJUNTO <> '' ";	
		$num = database::getNumRows($sql);  	
		return $num;

		}


	
		
		
		function getNumeroComentariosPeriodo($id,$periodo){
		$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST_COMENTARIOS_PERIODOS WHERE PK_OTACTICO = '$id' AND PK_PERIODO = '$periodo'";
		$num = database::getNumRows($sql);  	
		return $num;
		}
		
		
		function getComentariosPeriodo($id,$periodo){
		$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST_COMENTARIOS_PERIODOS WHERE PK_OTACTICO = '$id' AND PK_PERIODO = '$periodo' ORDER BY FECHA_R DESC";	
		$rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->comentarios[] = $row;
		
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
		
		
		function getNumeroComentariosColaboradores($idoperativo,$idperiodo,$tipo){
		
		$sql = "SELECT * FROM PL_POPERATIVOS_RESUMENE_COMENTARIOS_SEGUIMIENTO WHERE PK_POPERATIVO = '$idoperativo' AND PK_PERIODO = '$idperiodo' AND TIPO = '$tipo' ";	
		
		 return database::getNumRows($sql);  	
		}
		
		
		function getComentariosResumenSeguimiento($idoperativo,$idperiodo,$tipo){
		
		$this->comentarios = array(); 
		$sql = "SELECT * FROM PL_POPERATIVOS_RESUMENE_COMENTARIOS_SEGUIMIENTO WHERE PK_POPERATIVO = '$idoperativo' AND PK_PERIODO = '$idperiodo' AND TIPO = '$tipo' ORDER BY FECHA_R DESC";	
	    
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->comentarios[] = $row;
		
        }
     	}
		
		
		
		function getColaboradores($idpan,$idperido){
		
		$this->colaboradores = array(); 
		$sql = "SELECT * FROM PL_POPERATIVOS_COLABORADORES WHERE PK_OPERATIVO = '$idpan' AND PK_PERIODO = '$idperido' ORDER BY FECHA_R DESC";	
	    
		
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->colaboradores[] = $row;
		
        }
     	}
		
		
		
		
		function getNumColaborador(){
			
			$idperiodo = $this->idperiodo;
			$idplan = $this->idPlanOpe;
			$sql = "SELECT PK1 FROM PL_POPERATIVOS_COLABORADORES WHERE  PK_OPERATIVO = '$idplan' AND PK_PERIODO = '$idperiodo' ";  
		 
		    return database::getNumRows($sql);  	
		
		}
		
		
		
		
		function insertarColaborador(){
			
			$fechar = date("Y-m-d H:i:s");
		    $usuario = $_SESSION['session']['user'];
			$idperiodo = $this->idperiodo;
			$idplan = $this->idPlanOpe;
			
			
			$this->campos = array('NOMBRE'=>$this->nombre,
							               'PUESTO'=>$this->puesto,
										   'DEPARTAMENTO'=>$this->departamento,
										   'VALORACION'=>$this->valoracion,
										   'PK_OPERATIVO'=>$this->idPlanOpe,
										   'PK_PERIODO'=>$this->idperiodo,
										   'PK_USUARIO'=>$usuario,
							               'FECHA_R'=>$fechar,
							               );
	
		   database::insertRecords("PL_POPERATIVOS_COLABORADORES",$this->campos);
		   
		    $sql = "SELECT TOP 1 PK1 FROM PL_POPERATIVOS_COLABORADORES WHERE PK_USUARIO = '$usuario' AND PK_OPERATIVO = '$idplan' AND PK_PERIODO = '$idperiodo' AND FECHA_R = '$fechar' ";  
		 
		 
		 $row = database::getRow($sql); 
	

	   		if(!empty($row))
	   		{
	    		$data=$row['PK1'];
				return $data;
         	}
		   
			
		}
		
		
		
		function insertarComentarioPeriodo($comentario,$idobjetivo,$idperiodo){
	   
	 
			$fechar = date("Y-m-d H:i:s");
		    $usuario = $_SESSION['session']['user'];
			
			$this->campos = array('COMENTARIO'=>$comentario,
							               'PK_OTACTICO'=>$idobjetivo,
										   'PK_PERIODO'=>$idperiodo,
										   'PK_USUARIO'=>$usuario,
							               'FECHA_R'=>$fechar,
							               );
	
		   database::insertRecords("PL_POPERATIVOS_OBJETIVOST_COMENTARIOS_PERIODOS",$this->campos);
			  

         $sql = "SELECT TOP 1 PK1 FROM PL_POPERATIVOS_OBJETIVOST_COMENTARIOS_PERIODOS WHERE PK_USUARIO = '$usuario' AND PK_OTACTICO = '$idobjetivo' AND PK_PERIODO = '$idperiodo' AND FECHA_R = '$fechar' ";  
		 
		 
		 $row = database::getRow($sql); 
	

	   		if(!empty($row))
	   		{
	    		$data=$row['PK1'];
				return $data;
         	}
      
   }
	
	
	
	function eliminarComentario($id_comentario)
	{
		
	    $sql = "DELETE FROM PL_POPERATIVOS_OBJETIVOST_COMENTARIOS_PERIODOS WHERE PK1 = '$id_comentario'";
	    $result = database::executeQuery($sql);
        return true;
      	       
    }
	
	
	function eliminarColaborador($id){
		
		$sql = "DELETE FROM PL_POPERATIVOS_COLABORADORES WHERE PK1 = '$id'";
	    $result = database::executeQuery($sql);
        return true;
		
	}
	
	
	function EliminarEvidencia($idevidencia){
	
		$sql = "DELETE FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK1 = '$idevidencia'";
	    database::executeQuery($sql);
        return true;
		
	}
	
	function EliminarEvidenciaArchivo($idevidencia){
	
		$sql = "UPDATE PL_POPERATIVOS_EVIDENCIAS SET ADJUNTO = '',IMAGEN = '' WHERE PK1 = '$idevidencia'";
	    database::executeQuery($sql);
        return true;
		
	}
	
	
	
	function eliminarComentarioResumenPeriodos($id_comentario){
		
		$sql = "DELETE FROM PL_POPERATIVOS_RESUMENE_COMENTARIOS_SEGUIMIENTO WHERE PK1 = '$id_comentario'";
	    $result = database::executeQuery($sql);
        return true;
	}
	
	
     function esperiodoActivo($id,$plan){
	 	
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK1='$id' AND PK_POPERATIVO = '$plan' ";
		
		$row = database::getRow($sql); 
		
		if($row['ENVIADO']==2 | ($row['ORDEN']==1 && $row['ENVIADO']=="0")  |  $row['ENVIADO']=="1"){
			return TRUE;
		}else{
			return FALSE;
		}
			
		
	 }


     function getComentariosResumen($id){
		
		$this->comentarios = array();
       
        $sql = "SELECT * FROM PL_POPERATIVOS_RESUMENE_COMENTARIOS WHERE PK_POPERATIVO = '$id' ORDER BY FECHA_R DESC";	
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){	
	    $this->comentarios[] = $row;
        }
     	}
	 
	 
	 	 
	 
	 function insertarComentarioResumenPeriodo($comentario,$idplan,$idperiodo,$tipo){
	     		
			$fechar = date("Y-m-d H:i:s");
		    $usuario = $_SESSION['session']['user'];
			
			$this->campos = array('COMENTARIO'=>$comentario,
							               'PK_POPERATIVO'=>$idplan,
										   'PK_PERIODO'=>$idperiodo,
										   'TIPO'=>$tipo,
										   'PK_USUARIO'=>$usuario,
							               'FECHA_R'=>$fechar,
							               );
	
		   database::insertRecords("PL_POPERATIVOS_RESUMENE_COMENTARIOS_SEGUIMIENTO",$this->campos);
			
		
$sql = "SELECT TOP 1 PK1 FROM PL_POPERATIVOS_RESUMENE_COMENTARIOS_SEGUIMIENTO WHERE PK_USUARIO = '$usuario' AND PK_POPERATIVO = '$idplan' AND PK_PERIODO = '$idperiodo' AND TIPO = '$tipo' AND FECHA_R = '$fechar' ";  
		
		 
		 $row = database::getRow($sql); 
	 
		
	   		if(!empty($row))
	   		{
	    		$data = $row['PK1'];
				return $data;
         	}
     
   }
	 
	 
  
	    function getResumenEjecutivo($id){
	
		$sql = "SELECT * FROM PL_POPERATIVOS_RESUMENE WHERE PK_POPERATIVO = '$id' ";	
	    $row = database::getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
     	}
	
	
	
	    function getNumeroComentariosResumenEjecutivo($id){
		$sql = "SELECT * FROM PL_POPERATIVOS_RESUMENE_COMENTARIOS WHERE PK_POPERATIVO = '$id'";	
		$num = database::getNumRows($sql);  	
		return $num; 	
	    }
	
	    
		
		function setPorcentajeObjetivo($idObjetivo,$idPeriodo,$valor){
			
			$fechar = date("Y-m-d H:i:s");
		    $usuario = $_SESSION['session']['user'];
			
			$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST_AVANCES WHERE PK_OTACTICO = '$idObjetivo' AND PK_PERIODO = '$idPeriodo' ";  
   		    $rows = database::getNumRows($sql); 
	
     		if($rows>0){
				
				$this->campos = array('PORCENTAJE'=>$valor,
										   'PK_USUARIO'=>$usuario,
							               'FECHA_M'=>$fechar,
							               );
										   
		 $condition = "PK_OTACTICO='".$idObjetivo."' AND PK_PERIODO='".$idPeriodo."'";
		 
		database::updateRecords("PL_POPERATIVOS_OBJETIVOST_AVANCES",$this->campos,$condition);
				
				
			}else{
			
			$this->campos = array('PORCENTAJE'=>$valor,
							               'PK_OTACTICO'=>$idObjetivo,
										   'PK_PERIODO'=>$idPeriodo,
										   'PK_USUARIO'=>$usuario,
							               'FECHA_R'=>$fechar,
							               );
	
		   database::insertRecords("PL_POPERATIVOS_OBJETIVOST_AVANCES",$this->campos);
           }			
		
		}
		
	
	   function setPorcentajeMedio($idMedio,$idPeriodo,$valor){
	   	
		 $fechar = date("Y-m-d H:i:s");
		 $usuario = $_SESSION['session']['user'];
		 
		 
		 $sql = "SELECT * FROM PL_POPERATIVOS_MEDIOS_AVANCES WHERE PK_MEDIO = '$idMedio' AND PK_PERIODO = '$idPeriodo' ";  
   		 $rows = database::getNumRows($sql); 
	
     	if($rows>0){
		 	
			  $this->campos = array('PORCENTAJE'=>$valor,
										   'PK_USUARIO'=>$usuario,
							               'FECHA_M'=>$fechar,
							               );
			
			 $condition = "PK_MEDIO='".$idMedio."' AND PK_PERIODO='".$idPeriodo."'";
		 
		     database::updateRecords("PL_POPERATIVOS_MEDIOS_AVANCES",$this->campos,$condition);
			 
		 	
		 }else{
		 	
			$this->campos = array('PORCENTAJE'=>$valor,
							               'PK_MEDIO'=>$idMedio,
										   'PK_PERIODO'=>$idPeriodo,
										   'PK_USUARIO'=>$usuario,
							               'FECHA_R'=>$fechar,
							               );
	
		   database::insertRecords("PL_POPERATIVOS_MEDIOS_AVANCES",$this->campos);
		   
		  }
		
	   }
	
		
		
		function getPorcentajeObjetivo($idObjetivo,$idPeriodo){
	  
		$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST_AVANCES WHERE PK_OTACTICO = '$idObjetivo' AND PK_PERIODO = '$idPeriodo'";   
		$row = database::getRow($sql);
	
		if($row){
			return $row['PORCENTAJE'];
		}else{
			return 0;
		}
     	}
		
		
		function getPorcentajeObjetivoAnterior($idObjetivo,$idplan,$orden){
	  
	  
	    $orden = (int)$orden -1;
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$idplan' AND ORDEN='$orden'";   
		$row = database::getRow($sql);
	
		if($row){
			   $idPeriodo = $row['PK1'];
			   $sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST_AVANCES WHERE PK_OTACTICO = '$idObjetivo' AND PK_PERIODO = '$idPeriodo' ";
			   $rowanterior = database::getRow($sql);
			   
			   return $rowanterior['PORCENTAJE'];
			   
		}else{
			return 0;
		}
     	}
		
		
		
		
		
		function getPorcentajeMedio($idMedio,$idPeriodo){
			
		$sql = "SELECT * FROM PL_POPERATIVOS_MEDIOS_AVANCES WHERE PK_MEDIO = '$idMedio' AND PK_PERIODO = '$idPeriodo'";
		$row = database::getRow($sql);
	
		if($row){
			return $row['PORCENTAJE'];
		}else{
			return 0;
		}
		}
	
	
	     function EnviarInforme($idplan,$plane){
		 	
	     $fechar = date("Y-m-d H:i:s");
		 $usuario = $_SESSION['session']['user'];
		
	     $sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$idplan' AND ENVIADO = '2'"; 
		 $numperiodos = database::getNumRows($sql);
		
		 
		 if($numperiodos>0){
		 	
			$sql = "UPDATE PL_POPERATIVOS_PERIODOS SET FECHA_M = '$fechar', ENVIADO = '1', PK_USUARIO = '$usuario'  WHERE PK_POPERATIVO = '$idplan' AND ENVIADO = '2'";
			database::executeQuery($sql);
		 
		 }else{
		 	
			$sql = "UPDATE PL_POPERATIVOS_PERIODOS SET FECHA_M = '$fechar', ENVIADO = '1', PK_USUARIO = '$usuario'  WHERE PK_POPERATIVO = '$idplan' AND ORDEN = '1'";
			database::executeQuery($sql);
			
		 }
		 
		
		 //////ACTUALIZAMOS EL ESTADO DEL PLAN OPERATIVO A GUARDADO///
		$this->campos = array('ESTADO'=>"I",
							  );								   
		$condition = "PK1='".$idplan."'"; 
		database::updateRecords("PL_POPERATIVOS",$this->campos,$condition);
		
	
	   
	     //Agregarmos la alerta
		$sql =  "SELECT * FROM PL_POPERATIVOS_ASIGNACIONES WHERE PK_POPERATIVO = '$idplan' ";
		
        $total = database::getNumRows($sql);      
	    
	    if($total>0){ 
	   $rows = database::getRows($sql);
		
	   foreach($rows as $row){	
		
		$passport = new Authentication();
		
		                   
			if($passport->getPrivilegioRol($row['ROL'],'P141')){ 	
					              
				$this->EnviarCorreoIE($_SESSION['session']['user'],$row['PK_USUARIO'],$idplan);
		      }
						
		                          
					 
					 if($passport->getPrivilegioRol($row['ROL'],'P116')){
	          $this->campos = array('OBJETIVO'=>"Se ha enviado un INFORME para REVISAR",
							 'TIPO'=>"ALERT",
							 'VISTO'=>'0',
			                 'URL'=>"?execute=planesoperativo/seguimiento&method=default&Menu=F2&SubMenu=SF21&IDPlan=".$idplan."&IDPlanE=".$plane."#&p=1&s=25&sort=1&q=",
							 'PK_JERARQUIA'=>NULL,
							 'PK_USUARIO'=>$row['PK_USUARIO'],
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'ENVIADO'=>$usuario,
							 );
	
		database::insertRecords("PL_NOTIFICACIONES",$this->campos);
		}
		
        }
		}
		
		}
	
          
		  
		 function RevisarInforme($idplan,$plane){
		 
		 $fechar = date("Y-m-d H:i:s");
		 $usuario = $_SESSION['session']['user'];
		
	     $sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$idplan' AND ENVIADO = '1'"; 
		 $rowperiodo = database::getRow($sql);
		
		  
	
		$sql = "UPDATE PL_POPERATIVOS_PERIODOS SET FECHA_M = '$fechar', ENVIADO = '3', PK_USUARIO = '$usuario'  WHERE PK_POPERATIVO = '$idplan' AND ENVIADO = '1'";
		
		database::executeQuery($sql);
		
		
		
		$orden = (int)$rowperiodo['ORDEN']+1;
		
        $sql = "UPDATE PL_POPERATIVOS_PERIODOS SET FECHA_M = '$fechar', ENVIADO = '2', PK_USUARIO = '$usuario'  WHERE PK_POPERATIVO = '$idplan' AND ORDEN = '$orden'";
		
        database::executeQuery($sql);
		
		
		 //////ACTUALIZAMOS EL ESTADO DEL PLAN OPERATIVO A GUARDADO///
		$this->campos = array('ESTADO'=>"S",
							  );								   
		$condition = "PK1='".$idplan."'"; 
		database::updateRecords("PL_POPERATIVOS",$this->campos,$condition);
		
		
	   
	     //Agregarmos la alerta
		$sql =  "SELECT * FROM PL_POPERATIVOS_ASIGNACIONES WHERE PK_POPERATIVO = '$idplan'";
		
        $total = database::getNumRows($sql);      
	    
	    if($total>0){ 
	   $rows = database::getRows($sql);
		
	   foreach($rows as $row){	
		
		         $passport = new Authentication();
				 
				 
				 
			if($passport->getPrivilegioRol($row['ROL'],'P142')){ 	
					              
								   $this->EnviarCorreoIR($_SESSION['session']['user'],$row['PK_USUARIO'],$idplan);
		      }
						
					 
					 if($passport->getPrivilegioRol($row['ROL'],'P115')){
	          $this->campos = array('OBJETIVO'=>"Se ha REVISADO un INFORME del Plan Operativo",
							 'TIPO'=>"ALERT",
							 'VISTO'=>'0',
			                 'URL'=>"?execute=planesoperativo/seguimiento&method=default&Menu=F2&SubMenu=SF21&IDPlan=".$idplan."&IDPlanE=".$plane."#&p=1&s=25&sort=1&q=",
							 'PK_JERARQUIA'=>NULL,
							 'PK_USUARIO'=>$row['PK_USUARIO'],
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'ENVIADO'=>$usuario,
							 );
	
		database::insertRecords("PL_NOTIFICACIONES",$this->campos);
		    }
		
        }
		}
		 
		 
		 	
		 }	
	
	     
		 function GuardarAvanceObjetivo(){
		 
		 $idObjetivo = $this->idobjetivo;
		 $idPeriodo = $this->idperiodo;
		 $avance = $this->avance;
		 
		 $fechar = date("Y-m-d H:i:s");
		 $usuario = $_SESSION['session']['user'];
		 
		          
		 $sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST_AVANCES WHERE PK_OTACTICO = '$idObjetivo' AND PK_PERIODO = '$idPeriodo' ";  
		 
   		$row = database::getRow($sql); 
	
   		if($row){
		 
	
		$sql = "UPDATE PL_POPERATIVOS_OBJETIVOST_AVANCES SET PORCENTAJE = '$avance',  FECHA_M = '$fechar', PK_USUARIO = '$usuario'  WHERE PK_OTACTICO = '$idObjetivo' AND PK_PERIODO = '$idPeriodo'";
		
		
	    $result = database::executeQuery($sql);
		 
		
		}else{
			
			$this->campos = array('PORCENTAJE'=>$avance,
							               'PK_OTACTICO'=>$idObjetivo,
										   'PK_PERIODO'=>$idPeriodo, 
										   'FECHA_R'=>$fechar,
										   'PK_USUARIO'=>$usuario,
							               );
										   
		    database::insertRecords("PL_POPERATIVOS_OBJETIVOST_AVANCES",$this->campos);
	
		}
		 	
		}
		 
		  
		function PeriodoActivo($idplan,$button,$text){
		
		$fecha_i = date("Y-m-d");
			  	
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$idplan' AND ENVIADO = '2'";
		$periodoactivo = database::getRow($sql);
		
	   
	   
		if($periodoactivo['FECHA_I']->format('Y-m-d') <= $fecha_i){
		    return '<button class="btn btn-large btn-warning" data-original-title="Periodo Activo" data-rel="tooltip"'.$button.'<span title=".icon  .icon-white  .icon-check " class="icon icon-white icon-check"></span>'.$text.'</button>';	
		}else{
			return '<button class="btn btn-large btn-warning" disabled="disabled" '.$button.'<span title="Periodo incativo" class="icon icon-white icon-clock"></span> Periodo inactivo</button>';
		}
		
		}
		  
		
		
		function obtenerEstadoPlan($idplan){
			
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$idplan'";
		$total = database::getNumRows($sql);      
		
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$idplan' AND ENVIADO = '3'";
		$terminados = database::getNumRows($sql);      
		
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$idplan' AND ENVIADO = '1'";
		$enviados = database::getNumRows($sql);      
		
		
		if($total==$terminados){
	    	return '';		
		}else{
			 if($enviados>0){
				return "R";
			 }else{
				return "E";
			 }
		}
		}
		
		
		
		
		function validarPeriodosCompletos($idplan,$passport){
		  	
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$idplan'";
		$total = database::getNumRows($sql);      
		
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$idplan' AND ENVIADO = '3'";
		$terminados = database::getNumRows($sql);      
		
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$idplan' AND ENVIADO = '1'";
		$enviados = database::getNumRows($sql);      
		
		
		if($total==$terminados){
			$fechar = date("Y-m-d H:i:s");
			$usuario = $_SESSION['session']['user'];
			$this->campos = array('ESTADO'=>"T",
						            	 'FECHA_M'=>$fechar,
						            	 'PK_USUARIO'=>$usuario,
							 );
		
		                 $condition = "PK1 = '$idplan'";
		 
		                 database::updateRecords("PL_POPERATIVOS",$this->campos,$condition);
			
			
	    	return '';		
		}else{
			
			 if($enviados>0){
			 	
			 	if($passport->getPrivilegio($idplan,'P71')){
			 	$button ='onClick="RevisarInforme(false)">';
				$text = 'Informe Revisado';
				return $this->PeriodoActivo($idplan,$button,$text);
				}
			 }else{
			 	
				if($passport->getPrivilegio($idplan,'P70')){
				$button ='onClick="EnviarInforme(false)">';
				$text = 'Enviar Informe';
				return $this->PeriodoActivo($idplan,$button,$text);
				}
			 }
				
		}
		
		
		  }
		  
		  
		  
		  function getResumenArchivoPeriodo($plano,$idPeriodo){
		  	
			
		    $sql = "SELECT * FROM PL_POPERATIVOS_RESUMENE_PERIODOS WHERE PK_POPERATIVO = '$plano' AND PK_PERIODO = '$idPeriodo' ";  
			
			$row = database::getRow($sql);
			
			if($row){
			  return $row['ADJUNTO'];
			}else{
			  return "";
			}
			
		  }
		  
		  
		  function saveFileResumenPeriodo($plano,$idPeriodo,$adjunto){
		  
		      $fechar = date("Y-m-d H:i:s");
			  $usuario = $_SESSION['session']['user'];
			  
			 $sql = "SELECT * FROM PL_POPERATIVOS_RESUMENE_PERIODOS WHERE PK_POPERATIVO = '$plano' AND PK_PERIODO = '$idPeriodo' ";  
			 $row = database::getRow($sql);
			 
			if($row){
			
			  
		      $this->campos = array('ADJUNTO'=>$adjunto,
						            	 'FECHA_M'=>$fechar,
						            	 'PK_USUARIO'=>$usuario,
							 );
		
		                 $condition = "PK_POPERATIVO = '$plano' AND PK_PERIODO = '$idPeriodo'";
		 
		                 database::updateRecords("PL_POPERATIVOS_RESUMENE_PERIODOS",$this->campos,$condition);
		    }else{
			
			$this->campos = array('RESUMEN'=>"",
							               'PK_POPERATIVO'=>$plano,
										   'PK_PERIODO'=>$idPeriodo, 
										   'FECHA_R'=>$fechar,
										   'PK_USUARIO'=>$usuario,
										   'ADJUNTO'=>$adjunto,
							               );
										   
		    database::insertRecords("PL_POPERATIVOS_RESUMENE_PERIODOS",$this->campos);
			
			
			}
		  
		  }
		  
		  
		  function EliminarAdjuntoResumen($plano,$idPeriodo){
		  
		      $fechar = date("Y-m-d H:i:s");
			  $usuario = $_SESSION['session']['user'];
			
			  
		      $this->campos = array('ADJUNTO'=>"NULL",
						            	 'FECHA_M'=>$fechar,
						            	 'PK_USUARIO'=>$usuario,
							 );
		
		                 $condition = "PK_POPERATIVO = '$plano' AND PK_PERIODO = '$idPeriodo'";
		 
		                 database::updateRecords("PL_POPERATIVOS_RESUMENE_PERIODOS",$this->campos,$condition);
		    
		  
		  }
		  
		  
		  
		  
		  
		  
		  function getResumenPeriodo($plano,$idPeriodo){
		  	
			
		    $sql = "SELECT * FROM PL_POPERATIVOS_RESUMENE_PERIODOS WHERE PK_POPERATIVO = '$plano' AND PK_PERIODO = '$idPeriodo' ";  
			
			$row = database::getRow($sql);
			
			if($row){
			  return $row['RESUMEN'];
			}else{
			  return "";
			}
			
		  }
		  
		  
		  function GuardarResumenPeriodo(){
		  	
			 $fechar = date("Y-m-d H:i:s");
		     $usuario = $_SESSION['session']['user'];
			
			 $resumen = $this->resumenejecutivo;
			 $plano = $this->idPlanOpe;
			 $idPeriodo = $this->idperiodo;
			
			
			$sql = "SELECT * FROM PL_POPERATIVOS_RESUMENE_PERIODOS WHERE PK_POPERATIVO = '$plano' AND PK_PERIODO = '$idPeriodo' ";  
			
			$row = database::getRow($sql);
			 
			if($row){
				
				 $this->campos = array('RESUMEN'=>$resumen,
						            	 'FECHA_M'=>$fechar,
						            	 'PK_USUARIO'=>$usuario,
							 );
		
		                 $condition = "PK_POPERATIVO = '$plano' AND PK_PERIODO = '$idPeriodo'";
		 
		                 database::updateRecords("PL_POPERATIVOS_RESUMENE_PERIODOS",$this->campos,$condition);
				
			
			}else{
					
			$this->campos = array('RESUMEN'=>$resumen,
							               'PK_POPERATIVO'=>$plano,
										   'PK_PERIODO'=>$idPeriodo, 
										   'FECHA_R'=>$fechar,
										   'PK_USUARIO'=>$usuario,
							               );
										   
		    database::insertRecords("PL_POPERATIVOS_RESUMENE_PERIODOS",$this->campos);
			
			}
			
			
		  }
		  
		  
		  
		  function GuardarAvanceMedio(){
		 
		 $idmedio = $this->idmedio;
		 $idPeriodo = $this->idperiodo;
		 $avance = $this->avance;
		 
		 $fechar = date("Y-m-d H:i:s");
		 $usuario = $_SESSION['session']['user'];
		 
		 $sql = "SELECT * FROM PL_POPERATIVOS_MEDIOS_AVANCES WHERE PK_MEDIO = '$idmedio' AND PK_PERIODO = '$idPeriodo' ";  
		 
		 
		 $row = database::getRow($sql);
	
		if($row){
		 
		$sql = "UPDATE PL_POPERATIVOS_MEDIOS_AVANCES SET PORCENTAJE = '$avance',  FECHA_M = '$fechar', PK_USUARIO = '$usuario'  WHERE PK_MEDIO = '$idmedio' AND PK_PERIODO = '$idPeriodo'";
		
	    $result = database::executeQuery($sql);
		
		}else{
			
			$this->campos = array('PORCENTAJE'=>$avance,
							               'PK_MEDIO'=>$idmedio,
										   'PK_PERIODO'=>$idPeriodo, 
										   'FECHA_R'=>$fechar,
										   'PK_USUARIO'=>$usuario,
							               );
										   
		    database::insertRecords("PL_POPERATIVOS_MEDIOS_AVANCES",$this->campos);
			
		}
		 
		 	
		 }
		 
		 
		 
		 function EditFile(){
		 	
			$idevidencia = $this->idevidencia;
			
			$usuario = $_SESSION['session']['user'];
		 	
			$this->campos = array('EVIDENCIA'=>$this->titulo,
							 'DESCRIPCION'=>$this->descripcion,
							 'AUTOR'=>$this->autor,
							 'TIPO'=>$this->tipo,
							 'IMAGEN'=>$this->imagen,
							 'ADJUNTO'=>$this->adjunto,
							 'PK_LESTRATEGICA'=>$this->idlinea,
							 'PK_OTACTICO'=>$this->idobjetivo,
							 'FECHA_M'=>date("Y-m-d H:i:s"),
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'PK_USUARIO'=>$usuario,
							 );
		 	
		    $condition = "PK1 = '$idevidencia' ";
		 
		    database::updateRecords("PL_POPERATIVOS_EVIDENCIAS",$this->campos,$condition);
			
		}
		 
		 
		 
		  function UploadFile(){
		
		$idplan = $this->idplan;
		$linea =  $this->idlinea;
		$objetivo = $this->idobjetivo;
		
		$sql = "SELECT * FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_POPERATIVO = '$idplan' AND PK_LESTRATEGICA = '$linea' AND PK_OTACTICO = '$objetivo'";
		
	
		$orden = database::getNumRows($sql); 
		
		$usuario = $_SESSION['session']['user'];
		
		$this->campos = array('PK1'=>uniqid($this->tipo),
	                         'EVIDENCIA'=>$this->titulo,
							 'ORDEN'=>$orden,
							 'DESCRIPCION'=>$this->descripcion,
							 'AUTOR'=>$this->autor,
							 'TIPO'=>$this->tipo,
							 'IMAGEN'=>$this->imagen,
							 'ADJUNTO'=>$this->adjunto,
							 'PK_POPERATIVO'=>$this->idplan,
							 'PK_LESTRATEGICA'=>$this->idlinea,
							 'PK_OTACTICO'=>$this->idobjetivo,
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'PK_USUARIO'=>$usuario,
							 );
	
		database::insertRecords("PL_POPERATIVOS_EVIDENCIAS",$this->campos);
		
	}
		 
		 
		 function getOrdenOtactico($id){
		  
          $sql = "SELECT ORDEN FROM PL_POPERATIVOS_OBJETIVOST WHERE PK1 = '$id'";  
		 
		  $row = database::getRow($sql);
          
          return (int)$row['ORDEN'];
          
		 }
         
         
         function getOrdenLestrategica($id){
		  
          $sql = "SELECT ORDEN FROM PL_PESTRATEGICOS_LINEASE WHERE PK1 ='$id'";  
		 
		  $row = database::getRow($sql);
          
          return (int)$row['ORDEN'];
          
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
		 
		 
		 
		 /*informe revisado*/
		 function EnviarCorreoIE($de,$para,$idplao){
		
		
	$sql = "SELECT * FROM PL_USUARIOS WHERE PK1 = '$de'";   
    $rowde = database::getRow($sql);
	
	$sql = "SELECT * FROM PL_USUARIOS WHERE PK1 = '$para'";   
    $rowpara = database::getRow($sql);
	
	
	$sql = "SELECT TITULO FROM PL_POPERATIVOS WHERE PK1 = '$idplao'";   
    $row = database::getRow($sql);
	$operativo = $row['TITULO'];
	

	
	
	$mail = new PHPMailer;

    $para = trim($rowpara['EMAIL']);


//$mail->SMTPDebug  = 2;
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.office365.com';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'planeacion@redanahuac.mx';                            // SMTP username
$mail->Password = 'Pl@neaci0n';                           // SMTP password
$mail->SMTPSecure = 'tls';
$mail->Port = '587';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'planeacion@redanahuac.mx';
$mail->FromName = 'Sistema de Planeación RUA';
$mail->addAddress($para);  // Add a recipient
//$mail->addAddress('jose.ruiz@redanahuac.mx');               // Name is optional
//$mail->addReplyTo('planeacion@redanahuac.mx');
//$mail->addCC('cc@example.com');
$mail->addBCC('planeacion@redanahuac.mx');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Informe enviado para revisión';
$mail->Body    = '
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin titulo</title>

<style>
	table td {border-collapse:collapse;margin:0;padding:0;}
</style>
</head>

<body>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" width="50%"></td>
		<td valign="top">
		

<table width="640" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="1" style="background:#E66500; border-top:1px solid #e3e3e3;"></td>
		<td width="24" style="background:#E66500; border-top:1px solid #e3e3e3;">&nbsp;</td>
		<td width="365" align="left" valign="middle" style="background:#E66500; border-top:1px solid #e3e3e3; color:#ffffff; padding:18px 0;">
<h1 style="font-family:Segoe UI, Tahoma, sans-serif; margin:0px; font-size:12pt; line-height:19px; color:#072B60; font-weight:normal;color:#ffffff;">Se ha enviado un informe de seguimiento del plan operativo para su revisi&oacute;n</h1>
<p style="margin:0;font-size:11pt;font-family:Segoe UI, Tahoma, sans-serif;color:#000;color:#ffffff;">Ahora puede ingresar y revisar el informe</p>
		</td>
		<td width="15" style="background:#E66500; border-top:1px solid #e3e3e3;">&nbsp;</td>
		<td width="205" align="right" valign="middle" style="background:#E66500; border-top:1px solid #e3e3e3; padding:18px 0; line-height:1px;">
<img src="http://redanahuac.mx/app/planeacion/skins/default/img/logo_anahuac.png"  alt="Red de Universidades Anahuac" border="0">
		</td>
		<td width="29" style="background:#E66500; border-top:1px solid #e3e3e3;">&nbsp;</td>
		<td width="1" style="background:#E66500; border-top:1px solid #e3e3e3;"></td>
	</tr>
</table>
<!---->

<table width="640" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="1" style="background:#e3e3e3;"></td>
		<td width="24">&nbsp;</td>
		<td width="585" valign="top" colspan="2" style="border-bottom:1px solid #e3e3e3; padding:20px 0;">
		
			<table width="585" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
<p style="margin-top:20px;font-family:Segoe UI, Tahoma, sans-serif;color:#000;font-size:10pt;">

<p style="font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;">El  informe de seguimiento del periodo del plan operativo: <strong>'.$operativo.'</strong> ha  sido enviado para su revisi&oacute;n por el usuario: </p>


<!-- START AMPSCRIPT  -->
<table cellpadding="0" cellspacing="0" border="0" style="font-family:\'Segoe UI\', Tahoma, sans-serif; font-size:10pt; margin:0px;">

	<tr>
		
		<td><img src="http://redanahuac.mx/app/planeacion/media/usuarios/'.$rowde['IMAGEN'].'" height="40"  widht="40" />  </td>
		
		<td style="font-family:\'Segoe UI\', Segoe, Tahoma, sans-serif; font-size:10pt; line-height:15px; color:#000000;">
		<strong> &nbsp;'.$rowde['NOMBRE'].' '.$rowde['APELLIDOS'].'</strong></td>
        
        
	</tr>
	
	<!---->
</table>
<!-- END AMPSCRIPT -->
<div style="margin-top:20px;font-family:\'Segoe UI\', Tahoma, sans-serif; font-size:10pt; line-height:13pt; color:#000;"> 


                  <p style="color:#000; font-size:10pt;font-family:Segoe UI, Tahoma, sans-serif;">Tenga en cuenta que:</p>

                  <ul style="font-family:Segoe UI, Tahoma, sans-serif;color:#000;font-size:10pt;">
                  <li>Puede  comentar en cada resultado del plan y ver las evidencias de cumplimiento.</li>
                    <li>Los  usuarios que tengan permiso pueden comentar en el resumen ejecutivo.</li>

                    <li>S&oacute;lo  los usuarios que tengan permiso podr&aacute;n enviar el informe revisado al centro.</li>
                  </ul>


<br><p style="font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;">Por favor vaya a la p&aacute;gina de inicio de sesi&oacute;n del Sistema de Planeaci&oacute;n e ingrese con su usuario y contrase&ntilde;a:  </p>

  <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;">
	<tr>

	  <td style="font-family:Segoe UI, Tahoma, sans-serif; font-size:12pt; text-align:center; color:#557eb9; padding:5px 0px 5px 15px;">&nbsp;</td>
	
	  <td style="padding:0px 15px; font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;"><a href="http://redanahuac.mx/app/planeacion/"  title="http://redanahuac.mx/app/planeacion/" style="color:#072b60;">http://redanahuac.mx/app/planeacion/</a>.</td>
	</tr>
  </table>



<p style="font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;">Atentamente, <br />Direcci&oacute;n de Estrategia y Desarrollo Corporativo <br/>
Secretar&iacute;a Ejecutiva de la Red de Universidades An&aacute;huac
</p>
					</td>
				</tr>
			</table>

		</td>
		<td width="29">&nbsp;</td>
		<td width="1" style="background:#e3e3e3;"></td>
	</tr>
	<tr>
		<td width="1" style="background:#e3e3e3; border-bottom:1px solid #e3e3e3;"></td>
		<td width="24" style="border-bottom:1px solid #e3e3e3;">&nbsp;</td>
		<td width="585" valign="top" colspan="2" style="border-bottom:1px solid #e3e3e3; padding:20px 0;">
		
			<table cellpadding="0" cellspacing="0" border="0" width="585">
				<tr>
					<td width="438">
						<p style="font-family:Segoe UI, Tahoma, sans-serif; margin:0px 0px 0px 5px; color:#000; font-size:10px;">Red de Universidades An&agrave;huac | &copy; Copyright 2013. Todos los derechos reservados. <br /> Este mensaje se ha enviado desde una direcci&oacute;n de correo electr&oacute;nico no supervisada. No responda a este mensaje.<br /> <span style="color:#072B60;"><a href="#"  title="Privacidad" style="color:#072B60; text-decoration:none">Privacidad</a> | <a href="#"  title="Informaci&oacute;n legal" style="color:#072B60; text-decoration:none">Informaci&oacute;n legal</a></span></p>
					</td>
					<td width="20">&nbsp;</td>
					<td width="127"><img src="http://redanahuac.mx/portal/img/logo.png"  alt="Red de Universidades Anáhuac" border="0"></td>
				</tr>
			</table>
		
		</td>
		<td width="29" style="border-bottom:1px solid #e3e3e3;">&nbsp;</td>
		<td width="1" style="background:#e3e3e3; border-bottom:1px solid #e3e3e3;"></td>
	</tr>
</table>

<!--  -->

		</td>
		<td valign="top" width="50%"></td>
	</tr>
</table>

</body>
</html>

';
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


$mail->send();
//if(!$mail->send()) {
  // echo 'Message could not be sent.';
  // echo 'Mailer Error: ' . $mail->ErrorInfo;
  // exit;
//}
		
		
		
	}
		 
		 
		  /*informe enviado*/
		 function EnviarCorreoIR($de,$para,$idplao){
		
		
	$sql = "SELECT * FROM PL_USUARIOS WHERE PK1 = '$de'";   
    $rowde = database::getRow($sql);
	
	$sql = "SELECT * FROM PL_USUARIOS WHERE PK1 = '$para'";   
    $rowpara = database::getRow($sql);
	
	
	$sql = "SELECT TITULO FROM PL_POPERATIVOS WHERE PK1 = '$idplao'";   
    $row = database::getRow($sql);
	$operativo = $row['TITULO'];
		
	$mail = new PHPMailer;

    $para = trim($rowpara['EMAIL']);


//$mail->SMTPDebug  = 2;
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.office365.com';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'planeacion@redanahuac.mx';                            // SMTP username
$mail->Password = 'Pl@neaci0n';                           // SMTP password
$mail->SMTPSecure = 'tls';
$mail->Port = '587';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'planeacion@redanahuac.mx';
$mail->FromName = 'Sistema de Planeación RUA';
$mail->addAddress($para);  // Add a recipient
//$mail->addAddress('jose.ruiz@redanahuac.mx');               // Name is optional
//$mail->addReplyTo('planeacion@redanahuac.mx');
//$mail->addCC('cc@example.com');
$mail->addBCC('planeacion@redanahuac.mx');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Informe enviado para revisión';
$mail->Body    = '
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin tÃƒÂ­tulo</title>

<style>
	table td {border-collapse:collapse;margin:0;padding:0;}
</style>
</head>

<body>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" width="50%"></td>
		<td valign="top">
		

<table width="640" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="1" style="background:#E66500; border-top:1px solid #e3e3e3;"></td>
		<td width="24" style="background:#E66500; border-top:1px solid #e3e3e3;">&nbsp;</td>
		<td width="365" align="left" valign="middle" style="background:#E66500; border-top:1px solid #e3e3e3; color:#ffffff; padding:18px 0;">
<h1 style="font-family:Segoe UI, Tahoma, sans-serif; margin:0px; font-size:12pt; line-height:19px; color:#072B60; font-weight:normal;color:#ffffff;">Se ha enviado un informe de seguimiento del plan operativo revisado</h1>
<p style="margin:0;font-size:11pt;font-family:Segoe UI, Tahoma, sans-serif;color:#000;color:#ffffff;">Ahora puede ingresar y ver los comentarios.</p>
		</td>
		<td width="15" style="background:#E66500; border-top:1px solid #e3e3e3;">&nbsp;</td>
		<td width="205" align="right" valign="middle" style="background:#E66500; border-top:1px solid #e3e3e3; padding:18px 0; line-height:1px;">
<img src="http://redanahuac.mx/app/planeacion/skins/default/img/logo_anahuac.png"  alt="Red de Universidades Anahuac" border="0">
		</td>
		<td width="29" style="background:#E66500; border-top:1px solid #e3e3e3;">&nbsp;</td>
		<td width="1" style="background:#E66500; border-top:1px solid #e3e3e3;"></td>
	</tr>
</table>
<!---->

<table width="640" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="1" style="background:#e3e3e3;"></td>
		<td width="24">&nbsp;</td>
		<td width="585" valign="top" colspan="2" style="border-bottom:1px solid #e3e3e3; padding:20px 0;">
		
			<table width="585" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
<p style="margin-top:20px;font-family:Segoe UI, Tahoma, sans-serif;color:#000;font-size:10pt;">

<p style="font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;">El  informe de seguimiento del periodo del plan operativo: <strong>'.$operativo.'</strong> ha  sido revisado por el usuario: </p>


<!-- START AMPSCRIPT  -->
<table cellpadding="0" cellspacing="0" border="0" style="font-family:\'Segoe UI\', Tahoma, sans-serif; font-size:10pt; margin:0px;">

	<tr>
		
		<td><img src="http://redanahuac.mx/app/planeacion/media/usuarios/'.$rowde['IMAGEN'].'" height="40"  widht="40" />  </td>
		
		<td style="font-family:\'Segoe UI\', Segoe, Tahoma, sans-serif; font-size:10pt; line-height:15px; color:#000000;">
		<strong> &nbsp;'.$rowde['NOMBRE'].' '.$rowde['APELLIDOS'].'</strong></td>
        
        
	</tr>
	
	<!---->
</table>
<!-- END AMPSCRIPT -->
<div style="margin-top:20px;font-family:\'Segoe UI\', Tahoma, sans-serif; font-size:10pt; line-height:13pt; color:#000;"> 


                  <p style="color:#000; font-size:10pt;font-family:Segoe UI, Tahoma, sans-serif;">Tenga en cuenta que:</p>

                  <ul style="font-family:Segoe UI, Tahoma, sans-serif;color:#000;font-size:10pt;">
                  <li>Todos  los usuarios del centro pueden ver los comentarios y as&iacute; mismo comentar en  respuesta.</li>

                    <li>S&oacute;lo  los usuarios con permiso pueden ver el resumen ejecutivo..</li>
                  </ul>


<p style="font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;">El plan estará listo para la elaboración del informe del siguiente periodo según el calendario de la RUA.</p>
<p style="font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;">Por favor vaya a la página de inicio de sesión del Sistema de Planeación e ingrese con su usuario y contraseña:  </p>

  <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;">
	<tr>

	  <td style="font-family:Segoe UI, Tahoma, sans-serif; font-size:12pt; text-align:center; color:#557eb9; padding:5px 0px 5px 15px;">&nbsp;</td>
	
	  <td style="padding:0px 15px; font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;"><a href="http://redanahuac.mx/app/planeacion/"  title="http://redanahuac.mx/app/planeacion/" style="color:#072b60;">http://redanahuac.mx/app/planeacion/</a>.</td>
	</tr>
  </table>



<p style="font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;">Atentamente, <br />Dirección de Estrategia y Desarrollo Corporativo <br/>
Secretaría Ejecutiva de la Red de Universidades Anáhuac
</p>
					</td>
				</tr>
			</table>

		</td>
		<td width="29">&nbsp;</td>
		<td width="1" style="background:#e3e3e3;"></td>
	</tr>
	<tr>
		<td width="1" style="background:#e3e3e3; border-bottom:1px solid #e3e3e3;"></td>
		<td width="24" style="border-bottom:1px solid #e3e3e3;">&nbsp;</td>
		<td width="585" valign="top" colspan="2" style="border-bottom:1px solid #e3e3e3; padding:20px 0;">
		
			<table cellpadding="0" cellspacing="0" border="0" width="585">
				<tr>
					<td width="438">
						<p style="font-family:Segoe UI, Tahoma, sans-serif; margin:0px 0px 0px 5px; color:#000; font-size:10px;">Red de Universidades An&agrave;huac | &copy; Copyright 2013. Todos los derechos reservados. <br /> Este mensaje se ha enviado desde una direcci&oacute;n de correo electr&oacute;nico no supervisada. No responda a este mensaje.<br /> <span style="color:#072B60;"><a href="#"  title="Privacidad" style="color:#072B60; text-decoration:none">Privacidad</a> | <a href="#"  title="Informaci&oacute;n legal" style="color:#072B60; text-decoration:none">Informaci&oacute;n legal</a></span></p>
					</td>
					<td width="20">&nbsp;</td>
					<td width="127"><img src="http://redanahuac.mx/portal/img/logo.png"  alt="Red de Universidades Anáhuac" border="0"></td>
				</tr>
			</table>
		
		</td>
		<td width="29" style="border-bottom:1px solid #e3e3e3;">&nbsp;</td>
		<td width="1" style="background:#e3e3e3; border-bottom:1px solid #e3e3e3;"></td>
	</tr>
</table>

<!--  -->

		</td>
		<td valign="top" width="50%"></td>
	</tr>
</table>

</body>
</html>


';
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


$mail->send();
//if(!$mail->send()) {
  // echo 'Message could not be sent.';
  // echo 'Mailer Error: ' . $mail->ErrorInfo;
  // exit;
//}
		
		
		
	}
		 
}

?>