<?php

class jerarquiaModel {
	
	
	var $niveles;
	var $totalnum;
	var $totalPag;
	
	var $idnivel;
	var $nivel;
	var $descripcion;
	var $padre;
	var $adjunto;
    
	var $jerarquias;
	
	
	function __construct() {
		
		
	}

    function buscarNiveles(){
		$this->niveles = array();
       // maximo por pagina
        $limit = $_GET["s"];
		// pagina pedida
        $pag = (int) $_GET["p"];
        if ($pag < 1)
        {
        $pag = 1;
        }
        
		$offset = ($pag-1) * $limit;
		
        $idNivel = $_GET['Nivel'];
		  	
       if(isset($_GET['sort'])){
		    
			switch($_GET['sort']){
				case 1:
				$order = "FECHA_R DESC ";	
				break;
			}
			
		}
		
		if(isset($_GET['filter'])){
			
			$filter = "'".str_replace(";","','",$_GET['filter'])."'";
	
		}else{
			$nivel =  $_SESSION['session']['nodo'];
			$filter = "'$nivel' ";	
		}
       
        /* $sql = "SELECT PK1, NOMBRE, DESCRIPCION, PADRE, DISPONIBLE ,FECHA_R,ELIMINADO 
                FROM (select PK1, NOMBRE, DESCRIPCION, PADRE, DISPONIBLE ,FECHA_R,ELIMINADO, row_number() 
                OVER (order by  ORDEN) AS 
                RowNumber FROM PL_JERARQUIAS) 
                Derived WHERE RowNumber BETWEEN '$offset' AND '$limit' AND PADRE = '$idNivel'";*/
				
				
	   $sql ="SELECT  *
FROM    ( SELECT ROW_NUMBER() OVER ( ORDER BY $order ) AS RowNum, *
          FROM      PL_JERARQUIAS
          WHERE     PADRE = '$idNivel' 
        ) AS RowConstrainedResult
WHERE   RowNum > $offset
    AND RowNum <= $limit 
ORDER BY ORDEN";
				
			
	  /*if(isset($_GET['q']) && $_GET['q']!= ""){ 
			$sql .= "AND (NOMBRE LIKE '%".$_GET['q']."%') ";	
		}*/
    
		
		//echo $sql;
	
		
        
	
        $total = database::getNumRows($sql);      
	    $this->totalnum = $total;
	
	
	    $rows = database::getRows($sql);
		
		foreach($rows as $row){
		
	    $this->niveles[] = $row;
		
        }
		
	    //CALCULAMOS EL TOTAL DE PAGINAS
	    $this->totalPag = ceil($total/$limit);
		

     	}
		
		
		function getNivel($id){
		
		$sql = "SELECT * FROM PL_JERARQUIAS WHERE PK1 = '$id'";   
		
		$row = database::getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}
		
		
		function GuardarNivel(){
			

	     $this->campos = array('PK1'=>(string)$this->idnivel,
	                         'NOMBRE'=>(string)$this->nivel,
							 'DESCRIPCION'=>(string)$this->descripcion,
							 'PADRE'=>(string)$this->padre,
							 'FECHA_R'=> date("Y-m-d H:i:s"),
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 'ADJUNTO'=>$this->adjunto,
							 );
	
	    $result = database::insertRecords("PL_JERARQUIAS",$this->campos);
     			
	    return TRUE;
			
		}
		
		
		
		
		function ActualizarNivel(){
		
		 $this->campos = array('NOMBRE'=>$this->nivel,
		                       'DESCRIPCION'=>$this->descripcion,
							   'FECHA_M'=>date("Y-m-d H:i:s"),
							   'PK_USUARIO'=>$_SESSION['session']['user'],
							   'ADJUNTO'=>$this->adjunto,
							               );
										   
		$condition = "PK1='".$this->idnivel."'";
		 
		database::updateRecords("PL_JERARQUIAS",$this->campos,$condition);
		
	    return TRUE;			
		}
		
		
		
		
		function MoverNivel(){
		
		 $this->campos = array('PADRE'=>$this->padre,
							   'FECHA_M'=>date("Y-m-d H:i:s"),
							   'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
										
		 $condition = "PK1='".$this->idnivel."'";
		 database::updateRecords("PL_JERARQUIAS",$this->campos,$condition);
	     return TRUE;			
		}
		
		
		
		function Ordenar(){
        
		$numniveles = sizeof($this->jerarquias);
        $orden = 0;
		if($numniveles != 0){
		
		foreach($this->jerarquias as $row){
		
		      $this->campos = array('ORDEN'=>$orden,
							   'FECHA_M'=>date("Y-m-d H:i:s"),
							   'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
										
		 $condition = "PK1='".$row."'";
		 database::updateRecords("PL_JERARQUIAS",$this->campos,$condition);
			
		 $orden++;
			}
		  }
		}
		
		
				
		function Eliminar($id){
	    
		$sql = "DELETE FROM PL_JERARQUIAS WHERE PK1 = '$id' OR PADRE = '$id' ";
        $result = database::executeQuery($sql);
	
	    if($result){
			return TRUE;
		}else {
			return FALSE;
		}
	}		
	
}

?>