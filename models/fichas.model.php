<?php

class fichasModel {
	
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
		// pagina pedida
        $pag = (int) $_GET["p"];
        if ($pag < 1)
        {
        $pag = 1;
        }
        
		$offset = ($pag-1) * $limit;
		
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
		
	
         $sql = "SELECT PK1, NOMBRE, DESCRIPCION, URL, PADRE ,ORDEN,DISPONIBLE,PK_PERMISO,FECHA_R 
                FROM (select PK1, NOMBRE, DESCRIPCION, URL, PADRE ,ORDEN,DISPONIBLE,PK_PERMISO,FECHA_R, row_number() 
                OVER (order by  $order) AS 
                RowNumber FROM PL_FICHAS) 
                Derived WHERE RowNumber BETWEEN '$offset' AND '$limit' ";
			
        if(isset($_GET['q']) && $_GET['q']!= ""){ 
			$sql .= "AND (NOMBRE LIKE '%".$_GET['q']."%') ";	
		}
    
		
        
	
        $total = database::getNumRows($sql);      
	    $this->totalnum = $total;
	
	
	    $rows = database::getRows($sql);
		
		foreach($rows as $row){
		
	   $this->fichas[] = $row;
		
        }
		
	//CALCULAMOS EL TOTAL DE PAGINAS
	$this->totalPag = ceil($total/$limit);

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