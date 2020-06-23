<?php

class rolesadminModel {
	
	var $articulos;
	var $tutoriales;
	var $lineamientos;
	var $links;
	var $roles;
	var $noticias;
	var $totalnum;
	var $totalPag;
	
	
	var $idrol;
	var $rol;
	VAR $tipo;
	var $descripcion;

	
	
	function __construct() {
		
	}

   function buscarRoles(){
		
       $this->roles = array();
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
		
			
				
	    $sql ="SELECT  *
FROM    ( SELECT ROW_NUMBER() OVER ( ORDER BY $order ) AS RowNum, *
          FROM      PL_ROLES
         
        ) AS RowConstrainedResult
WHERE   RowNum > $offset
    AND RowNum <= $limit 
ORDER BY $order";	
		
			
		
	if(isset($_GET['q']) && $_GET['q']!= ""){ 
			$sql .= "AND (ROLE LIKE '%".$_GET['q']."%') ";	
		}
		
		
       // $result = database::executeQuery($sql);
	
        $total = database::getNumRows($sql);      
	    $this->totalnum = $total;
	
	    $rows = database::getRows($sql);
	
	   foreach($rows as $row){
		
	   $this->roles[] = $row;
		
        }
		
		
	//CALCULAMOS EL TOTAL DE PAGINAS
	$this->totalPag = ceil($total/$limit);

     	}
		
		
		function Insertar(){
		
		$this->campos = array('PK1'=>strtoupper(uniqid('R')),
	                         'ROLE'=>$this->rol,
							 'TIPO'=>$this->tipo,
							 'DESCRIPCION'=>$this->descripcion,
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 );
		
		$result = database::insertRecords("PL_ROLES",$this->campos);
		
		return TRUE;	
	   }
		
		
		
		
		function ActualizarRol(){
			
		 $this->campos = array('ROLE'=>$this->rol,
		                       'TIPO'=>$this->tipo,
		                       'DESCRIPCION'=>$this->descripcion,
							   'FECHA_M'=>date("Y-m-d H:i:s"),
							   'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
				   
	    $condition = "PK1='".$this->idrol."'";
		 
		database::updateRecords("PL_ROLES",$this->campos,$condition);
		
	    return TRUE;			
		}
		
		
		
 
     	
     function Eliminar($id){
		
        $sql = "DELETE FROM PL_ROLES WHERE PK1 = '$id' ";
        $result = database::executeQuery($sql);
	
	    if($result){
     	if($this->EliminarRolesPermisos($id)){return TRUE;}else{return FALSE;}
		}else {
		return FALSE;
		}
     	}
		
		
	
     	function EliminarRolesPermisos($id){
	    
	$sql = "DELETE FROM PL_ROLES_PERMISOS WHERE PK_ROL = '$id' ";	
    $result = database::executeQuery($sql);
	
	    if($result){
			return TRUE;
		}else {
			return FALSE;
		}
			
		}
	
}

?>