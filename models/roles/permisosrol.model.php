<?php

class permisosrolModel {
	
	var $permisos;
	var $totalPag;
	var $totalnum;
	
	
	function __construct() {
		
	}

    function buscarPermisos(){
		
		$this->permisos = array();
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
				$order = "PERMISO ";	
				break;
			}
			
		}
		
		
		$tipo = $_GET['Tipo'];
		
        $sql = "SELECT * 
                FROM (select PK1, PERMISO, DESCRIPCION, FECHA_R,TIPO, row_number() 
                OVER (order by  $order) AS 
                RowNumber FROM PL_PERMISOS WHERE TIPO = '$tipo') 
                Derived WHERE RowNumber BETWEEN '$offset' AND '$limit' ";
			
	    
		//echo $sql;
		
	    $sqlcount = "SELECT PK1, PERMISO, DESCRIPCION,FECHA_R 
                     FROM PL_PERMISOS WHERE TIPO = '$tipo'";
			
		
	 if(isset($_GET['q']) && $_GET['q']!= ""){ 
			$sql .= "AND (PERMISO LIKE '%".$_GET['q']."%') ";	
		}
		
       
	
        $total = database::getNumRows($sqlcount);      
	    $this->totalnum = $total;
		
	
	    $rows = database::getRows($sql);
		
		foreach($rows as $row){
		
	    $this->permisos[] = $row;
		
        }
		
		//CALCULAMOS EL TOTAL DE PAGINAS
		$this->totalPag = ceil($total/$tamaño);
		

     	}
		
		
		
	function getRol($id){
	
    $sql = "SELECT * FROM PL_ROLES WHERE PK1 = '$id'";  
	$row = database::getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
     	}
   
   
       function permitirPermisos($rol,$permisos){
	   	
		$permisos = explode("^",$permisos,-1);
			
		foreach($permisos as $permiso){
			
		   if($this->eliminarPermiso($rol,$permiso)){
		   	
			$this->campos = array('PK_ROL'=>$rol,
							 'PK_PERMISO'=>$permiso,
							 );
			
			$result = database::insertRecords("PL_ROLES_PERMISOS",$this->campos);
			}
		
		}

	   }
   
   
        function restringirPermisos($rol,$permisos){
	   	
		$permisos = explode("^",$permisos,-1);
		foreach($permisos as $permiso){
			
		   	$sql = "DELETE FROM PL_ROLES_PERMISOS WHERE PK_ROL = '$rol'  AND PK_PERMISO = '$permiso' ";
            $result = database::executeQuery($sql);
				
		}

	   }
   
      
       
	   function eliminarPermiso($rol,$permiso){
	   	
		$sql = "DELETE FROM PL_ROLES_PERMISOS WHERE PK_ROL = '$rol' AND PK_PERMISO = '$permiso' ";
        $result = database::executeQuery($sql);

	    if($result){
			return TRUE;
		}else {
			return FALSE;
		}
	   	
		}
   
   
        function existePermiso($rol,$permiso){
		
	    $sql = "SELECT * FROM PL_ROLES_PERMISOS WHERE PK_ROL = '$rol' AND PK_PERMISO = '$permiso'";       
	    $row = database::getRow($sql);
		if($row){
			return TRUE;
		}else{
			return FALSE;
		}
			
		}
   
   
}

?>