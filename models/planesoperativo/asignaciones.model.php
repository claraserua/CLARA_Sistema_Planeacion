<?php

class asignacionesModel {
	
	var $articulos;
	var $tutoriales;
	var $lineamientos;
	var $links;
	var $usuarios;
	var $noticias;
	var $totalnum;
	var $totalPag;
	var $ids;

	
	
	function __construct() {
		
	}

   		
	function buscarUsuarios(){
		
		$this->usuarios = array();
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
		
		$busqueda='';
		if(isset($_GET['q']) && trim($_GET['q'])!= ""){
			$sub = utf8_decode(trim($_GET['q']));
			$busqueda = " AND (NOMBRE LIKE '%".$sub."%' OR APELLIDOS LIKE '%".$sub."%') ";
		}
		
		
		$plan = $_GET['IDPlan'];
		
		$sql_inner = "
			SELECT  A.PK1 AS ID,U.IMAGEN,U.PK1,U.NOMBRE,U.APELLIDOS,U.EMAIL,U.PK_JERARQUIA,U.DISPONIBLE,A.PK_USUARIO,A.PK_POPERATIVO,A.ROL, 
				ROW_NUMBER() OVER ( ORDER BY U.FECHA_R ) AS RowNum
			FROM PL_POPERATIVOS_ASIGNACIONES A, PL_USUARIOS U
			WHERE   U.PK1 = A.PK_USUARIO AND A.PK_POPERATIVO = '$plan' $busqueda
		";
		
		$sql = "WITH CTE AS ($sql_inner)
			SELECT * FROM CTE 
			WHERE RowNum >= $offset AND RowNum <= $limit";
		
		
        $total = database::getNumRows($sql_inner);
	    $this->totalnum = $total;
		
		
	
		echo '<input type="hidden" value="'.$total.','.strlen($sql_inner).','.'0'.','.$sql.'"></input>';
	
		$rows = database::getRows($sql);
		foreach($rows as $row){
			$this->usuarios[] = $row;
        }
		
	    //CALCULAMOS EL TOTAL DE PAGINAS
	    $this->totalPag = ceil($total/$limit);

	}
		
		
	function Eliminar(){
		
        
		foreach($this->ids as $id){
				
		$sql = "DELETE FROM PL_POPERATIVOS_ASIGNACIONES WHERE PK1 = '$id' ";
        $result = database::executeQuery($sql);
				
				}

	   

     	}
	    
		
		
		function getRol($id){
			
		$sql = "SELECT * FROM PL_ROLES WHERE PK1 = '$id'";   
		$row = database::getRow($sql);
		if($row){
			return $row['ROLE'];
		}else{
			return FALSE;
		}
		
		}
		
	
}

?>