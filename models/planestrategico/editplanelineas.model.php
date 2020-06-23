<?php

class editplanelineasModel {
	

	var $titulo;
	var $descripcion;
	var $jerarquia;
    var $disponible;
	var $fechai;
	var $fechat;
    var $usuario;
	var $idplan;
	var $lineas;
	var $objetivosE;
	var $obj_indicador_meta;
	var $indicadores;
	
	
	var $campos;
	var $camposI;
	
	
	function __construct() {
		
	}
     
	 function getLineasPlane($id){
		
		$this->lineas = array();
   	
		$sql = "SELECT * FROM PL_PESTRATEGICOS_LINEASE WHERE PK_PESTRATEGICO = '$id' ORDER BY ORDEN";		
	   // $result = database::executeQuery($sql);
		
	  //  while ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
	  
	    $rows = database::getRows($sql);
	
	   foreach($rows as $row){
		
	   $this->lineas[] = $row;
		
        }

     	}
		
		
		function getObjetivosE($id){
		
		$this->objetivosE = array();
    
		$sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$id' ORDER BY ORDEN";	
	  
	   
	    $rows = database::getRows($sql);
	
	   foreach($rows as $row){
		
	    $this->objetivosE[] = $row;
		
        }
     	}
		
		
		
	function getObjetivos_Indicador_Metas($id){
		
		$this->obj_indicador_meta = array();
    
		$sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE_INDICADORESMETAS WHERE PK_OESTRATEGICO = '$id' ORDER BY ORDEN";	
	
	   
	    $rows = database::getRows($sql);
	
	   foreach($rows as $row){
		
	    $this->obj_indicador_meta[] = $row;
		
        }
     }

		


   function isActivo($id){
   	
	    $sql = "SELECT * FROM PL_POPERATIVOS WHERE PK_PESTRATEGICO = '$id' ";   
		$row = database::getRow($sql);

		if($row){
			return TRUE;
		}else{
			return FALSE;
		}
	
	
   }

	
	 function getPlan($id){
		
		$sql = "SELECT * FROM PL_PESTRATEGICOS WHERE PK1 = '$id' ";   
		$row = database::getRow($sql);

		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}
		
		
		
		function GuardarLinea(){
		
		$plane =  $this->idplan;
		
		$fecha = date("Y-m-d H:i:s");
		$usuario = $_SESSION['session']['user'];
		
		
		$sql = "SELECT PK1 FROM PL_PESTRATEGICOS_LINEASE WHERE PK_PESTRATEGICO = '$plane'";
	    $numolineasbase =  database::getNumRows($sql);
		
		$numlineas = sizeof($this->lineas)-1;
		
		if($numolineasbase>$numlineas){
			
		for($i=$numlineas;$i<=$numolineasbase;$i++){
		
		$sql = "SELECT PK1 FROM PL_PESTRATEGICOS_LINEASE WHERE PK_PESTRATEGICO='$plane' AND ORDEN = '$i'";   
		$row = database::getRow($sql);		
		
		$pklinea = $row['PK1'];
		$sql = "SELECT PK1 FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$pklinea'";   
		$row2 = database::getRow($sql);
		
		$pkObjE = $row2['PK1'];
		$sql = "DELETE FROM PL_PESTRATEGICOS_OBJETIVOSE_INDICADORESMETAS WHERE PK_OESTRATEGICO = '$pkObjE'";	
		database::executeQuery($sql);		
		
		
	
		$sql = "DELETE FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$pklinea'";	
		database::executeQuery($sql);
		
		
		$sql = "DELETE FROM PL_PESTRATEGICOS_LINEASE WHERE PK_PESTRATEGICO = '$plane' AND ORDEN='$i'";	
		database::executeQuery($sql);
		
		
		
			
			}
		
		}
		
		
	
		for($i=0;$i<sizeof($this->lineas)-1;$i++){
				
		$sql = "SELECT * FROM PL_PESTRATEGICOS_LINEASE WHERE PK_PESTRATEGICO='$plane' AND ORDEN = '$i'";   
		$row = database::getRow($sql);
				
	    if($row){
		
		$idlineae = $row['PK1'];
		$linea = $this->lineas[$i];
		
		 $this->campos = array('LINEA'=>$linea,
							 'FECHA_M'=>date("Y-m-d H:i:s"),
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 );
		
		 $condition = "PK_PESTRATEGICO='$plane' AND ORDEN = '$i'";
		 
		database::updateRecords("PL_PESTRATEGICOS_LINEASE",$this->campos,$condition);
		
		}else{

		$idlineae =  strtoupper(substr(uniqid('LE'), 0, 15));
	    
		$this->campos = array('PK1'=>$idlineae,
	                         'LINEA'=>$this->lineas[$i],
							 'ORDEN'=>$i,
							 'PK_PESTRATEGICO'=>$this->idplan,
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 );
	

		$result = database::insertRecords("PL_PESTRATEGICOS_LINEASE",$this->campos);
				    
		   }		
		   
		$this->GuardarObjetivos($idlineae,$i);	
			
			}
		
		
		}
	
	
	
	
	function GuardarObjetivos($idlineae,$i){
		
		$fecha = date("Y-m-d H:i:s");
		$usuario = $_SESSION['session']['user'];
	
        $objetivosestrategicos = explode("|",$this->objetivos[$i]);
		$objetivos_indicadores = explode("~",$this->indicadores[$i]);
		
		
		$sql = "SELECT PK1 FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$idlineae'";
	    $numobjetivosbase =  database::getNumRows($sql);
		
		$numobjetivos = sizeof($objetivosestrategicos)-1;
		
		if($numobjetivosbase>$numobjetivos){
			
		for($i=$numobjetivos;$i<=$numobjetivosbase;$i++){
		
		
		$sql = "SELECT PK1 FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$idlineae' AND ORDEN='$i'";   
		$row2 = database::getRow($sql);
		
		$pkObjE = $row2['PK1'];
		$sql = "DELETE FROM PL_PESTRATEGICOS_OBJETIVOSE_INDICADORESMETAS WHERE PK_OESTRATEGICO = '$pkObjE'";	
		database::executeQuery($sql);		
		
		
		$sql = "DELETE FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$idlineae' AND ORDEN='$i'";	
		database::executeQuery($sql);
		
		
		
		
			}
		
		}

		for($i=0;$i<sizeof($objetivosestrategicos)-1;$i++){
				
		$objetivo =	$objetivosestrategicos[$i];
			
	    $sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$idlineae' AND ORDEN = '$i'";
		$row = database::getRow($sql);
		
		 		
	    if($row){
		 $idobjetivo = $row['PK1']; 
			 
		 $this->campos = array('OBJETIVO'=>$objetivo,
							 'FECHA_M'=>date("Y-m-d H:i:s"),
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 );
		
		 $condition = "PK_LESTRATEGICA = '$idlineae' AND ORDEN = '$i'";
		 
		database::updateRecords("PL_PESTRATEGICOS_OBJETIVOSE",$this->campos,$condition);
		 
		 
		 
			
		}else{
				
			$idobjetivo =  strtoupper(substr(uniqid('OE'), 0, 15));
			$this->campos = array('PK1'=>$idobjetivo,
	                         'OBJETIVO'=>$objetivo,
							 'ORDEN'=>$i,
							 'PK_LESTRATEGICA'=>$idlineae,
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 );
	
		$result = database::insertRecords("PL_PESTRATEGICOS_OBJETIVOSE",$this->campos);
			}
			
			
			//AQUI PONER INDICADORES-METAS
			
				 $this->GuardarIndicadores($idobjetivo,$i,$objetivos_indicadores);			
			
			
			
			}
			
			
			
		
		}
		
		
		
		
	function GuardarIndicadores($idobjetivo,$i,$objetivos_indicadores){
		
		$fecha = date("Y-m-d H:i:s");
		$usuario = $_SESSION['session']['user'];	
		
		$indicador_meta = explode("¬",$objetivos_indicadores[$i]);	       
		
		$sql = "SELECT PK1 FROM PL_PESTRATEGICOS_OBJETIVOSE_INDICADORESMETAS WHERE PK_OESTRATEGICO = '$idobjetivo'";
	    $numobjetivos_indicadoresbase =  database::getNumRows($sql);
		
		$numobjetivos_indicadores = sizeof($indicador_meta)-1;
		
		if($numobjetivos_indicadoresbase>$numobjetivos_indicadores){
			
		for($i=$numobjetivos_indicadores;$i<=$numobjetivos_indicadoresbase;$i++){		
		
		$sql = "DELETE FROM PL_PESTRATEGICOS_OBJETIVOSE_INDICADORESMETAS WHERE PK_OESTRATEGICO = '$idobjetivo' AND ORDEN='$i'";	
		database::executeQuery($sql);		
		
		
			}
		
		}

		for($i=0;$i<sizeof($indicador_meta)-1;$i++){
				
		 $indicador = explode("|",$indicador_meta[$i]);		
			
	    $sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE_INDICADORESMETAS WHERE PK_OESTRATEGICO = '$idobjetivo' AND ORDEN = '$i'";
		$row = database::getRow($sql);
		
		 		
	    if($row){								 
							 
							   $this->camposI = array(
	                                       'INDICADOR'=>str_replace("'","''",$indicador[0]),
										   'META'=>str_replace("'","''",$indicador[1]),							            						             
							               'FECHA_M'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );							 
							 
							 
		
		 $condition = "PK_OESTRATEGICO = '$idobjetivo' AND ORDEN = '$i'";
		 
		database::updateRecords("PL_PESTRATEGICOS_OBJETIVOSE_INDICADORESMETAS",$this->camposI,$condition);		 
		 
		 
			
		}else{				
								  				
							   $this->camposI = array(
	                                       'INDICADOR'=>str_replace("'","''",$indicador[0]),
										  'META'=>str_replace("'","''",$indicador[1]),
							               'ORDEN'=>$i,
							               'PK_OESTRATEGICO'=>$idobjetivo,							             
							               'FECHA_R'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
	                      
						 database::insertRecords("PL_PESTRATEGICOS_OBJETIVOSE_INDICADORESMETAS",$this->camposI);
		 }			
			
			
			
		}			
			
			
		
	}
		
		
		
		
		
		
	
	
}

?>