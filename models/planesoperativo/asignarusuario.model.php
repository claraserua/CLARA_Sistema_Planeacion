<?php

class asignarusuarioModel {
	
	var $image;
	var $titulo;
	var $nombre;
	var $apellidos;
	var $correo;
	var $usuario;
	var $password;
	var $jerarquia;
	var $rol;
	var $roles;
	var $rolesUsuario;
	var $niveles;
	var $disponible;
	var $poperativo;
	
	var $usuarios;
	
	
	var $campos;
	

	
	
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
				$order = "NOMBRE ASC ";	
				break;
			}
			
		}
		

	    
	$sql = "SELECT * 
                FROM (select PK1, NOMBRE, APELLIDOS, IMAGEN,DISPONIBLE,PK_JERARQUIA, row_number() 
                OVER (order by  $order) AS 
                RowNumber FROM PL_USUARIOS) 
                Derived WHERE RowNumber BETWEEN '$offset' AND '$limit'  ";
	
    //echo $sql;
				
		
		if(isset($_GET['q']) && $_GET['q']!= ""){ 
			$sql .= "AND (NOMBRE LIKE '%".$_GET['q']."%') ";	
		}		
	   
		
		
        
	
        $sqlcount = "SELECT PK1
                     FROM PL_USUARIOS ";
		
		$total = database::getNumRows($sqlcount);      
	    $this->totalnum = $total;
	
	
	    $rows = database::getRows($sql);
		
		foreach($rows as $row){	
	    $this->usuarios[] = $row;
        }
		
	    //CALCULAMOS EL TOTAL DE PAGINAS
	    $this->totalPag = ceil($total/$tamaño);

     	}
		
		
	function obtenerRoles(){
	 	$sql = "SELECT * FROM PL_ROLES WHERE TIPO IN('P') "; 
		$rows = database::getRows($sql);
		
		foreach($rows as $row){
		
	     $this->roles[] = $row;
		
        }
	 }	
		

	

    function GuardarUsuario(){
		
    $plan =	$this->poperativo;
	$jerarquia = $this->jerarquia;

     $sql = "SELECT TITULO FROM PL_POPERATIVOS WHERE PK1='$plan'";   
	 $row = database::getRow($sql);
     $titulo = $row['TITULO'];

	foreach($this->usuarios as $usuario){
	 	
		$sql = "SELECT * FROM PL_POPERATIVOS_ASIGNACIONES WHERE PK_USUARIO = '$usuario' AND PK_POPERATIVO = '$plan' ";   
		$row = database::getRow($sql);
		if(!$row){
				  
		$sql = "SELECT * FROM PL_USUARIOS WHERE PK1 = '$usuario' ";   
		$row = database::getRow($sql);
		
		if($row){		
		$this->campos = array('PK_POPERATIVO'=>$this->poperativo,
		                     'PK_USUARIO'=>$usuario,
	                         'ROL'=>$this->rol,
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 );
		
		$result = database::insertRecords("PL_POPERATIVOS_ASIGNACIONES",$this->campos);
		
		
		//Agregarmos la alerta
		$this->campos = array('OBJETIVO'=>"Se le ha agregado un nuevo plan operativo..",
							 'TIPO'=>"ALERT",
							 'VISTO'=>'0',
							 'URL'=>"?execute=operativo&method=default&Menu=F2&SubMenu=SF21#&p=1&s=25&sort=1&q=".$titulo."&filter=".$jerarquia."",
							 'PK_JERARQUIA'=>$jerarquia,
							 'PK_USUARIO'=>$usuario,
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'ENVIADO'=>$_SESSION['session']['user'],
							 );
	
		database::insertRecords("PL_NOTIFICACIONES",$this->campos);
		
		
		 }	
		}
		
		
		   }
		
		
		
	}
	
	

	
}

?>