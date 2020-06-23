<?php

class usuariosModel {
	
	var $articulos;
	var $tutoriales;
	var $lineamientos;
	var $links;
	var $usuarios;
	var $noticias;
	var $totalnum;
	var $totalPag;

	
	function __construct() {
		
	}

   		
	function buscarUsuarios(){
		
		$this->usuarios = array();
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
		
	
	    if(isset($_GET['filter'])){
			
			$filter = "'".str_replace(";","','",$_GET['filter'])."'";
	
		}else{
			$nivel =  $_SESSION['session']['nodo'];
			$filter = "'$nivel' ";	
		}
		
	
	
	    if(isset($_GET['q']) && $_GET['q']!= ""){ 
			$buscar = " AND (NOMBRE LIKE '%".$_GET['q']."%') OR (PK1 LIKE '%".$_GET['q']."%') ";	
		}else{
			$buscar = "";
		}

	
  		
	  $sql ="SELECT  *
FROM    ( SELECT ROW_NUMBER() OVER ( ORDER BY $order ) AS RowNum, *
          FROM      PL_USUARIOS
          WHERE     PK_JERARQUIA IN( $filter ) $buscar
        ) AS RowConstrainedResult
WHERE   RowNum > $offset
    AND RowNum <= $limit 
ORDER BY $order";	



				
	/*			
		$sql = "SELECT * 
                FROM (select *, row_number() 
                OVER (order by  $order) AS 
                RowNumber FROM PL_USUARIOS WHERE PK_JERARQUIA IN( $filter )) 
                Derived WHERE RowNumber BETWEEN '$offset' AND '$limit' ";		
		*/
		
		
		 $sqlcount = "SELECT * 
                     FROM PL_USUARIOS WHERE PK_JERARQUIA IN( $filter ) $buscar";
			
		
				
	 	
        $total = database::getNumRows($sqlcount);      
	    $this->totalnum = $total;
	
	
	    $rows = database::getRows($sql);
		
		foreach($rows as $row){	
	    $this->usuarios[] = $row;
        }
		
	   //CALCULAMOS EL TOTAL DE PAGINAS
		$this->totalPag = ceil($total/$tamaño);

     	}
		
		
		function Eliminar($id){
		
        $sql = "DELETE FROM PL_USUARIOS WHERE PK1 = '$id' ";
        $result = database::executeQuery($sql);

	    if($result){
			if($this->EliminarRolesUsuario($id)){return TRUE;}else{return FALSE;}
		}else{
			return FALSE;
		}

     	}
	    
		
		
		function EliminarRolesUsuario($id){
	    
		$sql = "DELETE FROM PL_ROLES_USUARIO WHERE PK_USUARIO = '$id'";
        $result = database::executeQuery($sql);
	
	    if($result){
			return TRUE;
		}else {
			return FALSE;
		}
			
		}
}

?>