<?php

class registrosModel {
	
	var $articulos;
	var $tutoriales;
	var $lineamientos;
	var $links;
	var $fichas;
	var $noticias;
	var $totalnum;
	var $totalPag;
	var $idficha;
	var $ficha;
	var $descripcion;

	
	
	function __construct() {
		
	}

   function buscarFichas(){
		
		$this->fichas = array();
      // maximo por pagina
        $limit = $_GET["s"];
		$tamaño = $_GET["s"];
		// pagina pedida
        $pag = (int) $_GET["p"];
        if ($pag < 1)
        {
        $pag = 1;
        }
        
		$offset = ($pag-1) * $limit;
		
		$limit = $limit * $pag;
		
		if(isset($_GET['sort'])){
		    
			switch($_GET['sort']){
				case 1:
				$order = "FECHA_R DESC ";	
				break;
			}
			
		}
		
	
		/*
         $sql = "SELECT PK1, APLICACION, MODULO, MENSAJE, PK_USUARIO ,FECHA_R 
                FROM (select PK1, APLICACION, MODULO, MENSAJE, PK_USUARIO ,FECHA_R, row_number() 
                OVER (order by  $order) AS 
                RowNumber FROM PL_ACTIVIDAD_USUARIO) 
                Derived WHERE RowNumber BETWEEN '$offset' AND '$limit' ";
			
        if(isset($_GET['q']) && $_GET['q']!= ""){ 
			$sql .= "AND (APLICACION LIKE '%".$_GET['q']."%') ";	
		}
		
		*/
		
		if(isset($_GET['q']) && $_GET['q']!= ""){ 
			$buscar = "WHERE  (APLICACION LIKE '%".$_GET['q']."%') ";	
		}else{
			$buscar = "";
		}

				
	  $sql ="SELECT  *
FROM    ( SELECT ROW_NUMBER() OVER ( ORDER BY $order ) AS RowNum, *
          FROM      PL_ACTIVIDAD_USUARIO
           $buscar
        ) AS RowConstrainedResult
WHERE   RowNum > $offset
    AND RowNum <= $limit 
ORDER BY $order";	
    
		
       // $result = database::executeQuery($sql);
        
		$sqlcount = "SELECT PK1
                     FROM PL_ACTIVIDAD_USUARIO ";
		
		$total = database::getNumRows($sqlcount);      
	    $this->totalnum = $total;
	
	
	   // while ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {	
	   foreach(database::getRows($sql) as $row){
		
	   $this->fichas[] = $row;
		
        }
		
	//CALCULAMOS EL TOTAL DE PAGINAS
	$this->totalPag = ceil($total/$tamaño);

     	}	
	
	
	function ActualizarFicha(){
			
		 $this->campos = array('NOMBRE'=>$this->ficha,
		                       'DESCRIPCION'=>$this->descripcion,
							   'FECHA_M'=>date("Y-m-d H:i:s"),
							   'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
										   
		 $condition = "PK1='".$this->idficha."'";
		 
		database::updateRecords("PL_FICHAS",$this->campos,$condition);
		
	    return TRUE;			
		}
	
	
}

?>