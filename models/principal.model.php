<?php

class principalModel {
	

	var $planes;
	var $totalnum;
	var $totalPag;

	
	
	function __construct() {
		
	}

   
   function buscarPlanesEstrategicos(){
		
		$this->planes = array();
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
		
	
	
	    if(isset($_GET['q']) && $_GET['q']!= ""){ 
			$buscar = "AND (TITULO LIKE '%".$_GET['q']."%') ";	
		}else{
			$buscar = "";
		}
				
				
	    $sql ="SELECT  *
FROM    ( SELECT ROW_NUMBER() OVER ( ORDER BY $order ) AS RowNum, *
          FROM      PL_PESTRATEGICOS
          WHERE     PK_JERARQUIA IN( $filter ) AND HISTORICO = 0 $buscar
        ) AS RowConstrainedResult
WHERE   RowNum > $offset
    AND RowNum <= $limit 
ORDER BY $order";	
				
	
		
		$sqlcount = "SELECT PK1
                     FROM PL_PESTRATEGICOS WHERE PK_JERARQUIA IN( $filter ) ";
		
	
        $total = database::getNumRows($sqlcount);      
	    $this->totalnum = $total;
	
	
	   $rows = database::getRows($sql);
		
		foreach($rows as $row){
		
	    $this->planes[] = $row;
		
        }
		
	    //CALCULAMOS EL TOTAL DE PAGINAS
     	$this->totalPag = ceil($total/$limit);

     	}
		
		
		function Archivar($id){
		
        $sql = "UPDATE PL_PESTRATEGICOS SET HISTORICO = 1 WHERE PK1 = '$id'";
        $result = database::executeQuery($sql);
			
	    if($result){
		    return TRUE;
			//if($this->EliminarRolesUsuario($id)){return TRUE;}else{return FALSE;}
		}else{
			return FALSE;
		}

     	}
		
		
		
     	function Eliminar($id){
		
        $sql = "DELETE FROM PL_PESTRATEGICOS WHERE PK1 = '$id'";
        $result = database::executeQuery($sql);
			
	    if($result){
			//if($this->EliminarRolesUsuario($id)){return TRUE;}else{return FALSE;}
		}else{
			return FALSE;
		}

     	}
		
   	
}

?>