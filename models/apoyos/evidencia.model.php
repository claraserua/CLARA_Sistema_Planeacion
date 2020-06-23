<?php

class evidenciaModel {
	
    var $comentarios;
	
	
	function __construct() {
		
	}
     
	 
	 function getRecurso($id){
		
		$sql = "SELECT * FROM PL_APOYOS WHERE PK1 = '$id' ";   
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}
	 
	 
    

  



   
			 
			 
			 
			 
	  function getComentarios($id){
		
		$this->comentarios = array(); 
		$sql = "SELECT * FROM PL_APOYOS_COMENTARIOS WHERE PK_APOYO = '$id' ORDER BY FECHA_R DESC";	
	   // $result = database::executeQuery($sql);
		
	  // while ($row =  mssql_fetch_array($result, MSSQL_ASSOC)) {
	  foreach(database::getRows($sql) as $row){
	  
	    $this->comentarios[] = $row;
        }
     	}
	 
			 
			 
			 
			 
			function insertarComentario($comentario,$id){
	   	   		
			$fechar = date("Y-m-d H:i:s");
		    $usuario = $_SESSION['session']['user'];
			
			$this->campos = array('COMENTARIO'=>$comentario,
							               'PK_APOYO'=>$id,
										   'PK_USUARIO'=>$usuario,
							               'FECHA_R'=>$fechar,
							               );
	
		   database::insertRecords("PL_PL_APOYOS",$this->campos);
			
		
		 $sql = "SELECT TOP 1 PK1 FROM PL_PESTRATEGICOS_ADJUNTOS_COMENTARIOS WHERE PK_USUARIO = '$usuario' AND PK_APOYO = '$id' AND FECHA_R = '$fechar' ";  
		
		 
		 $row = database::getRow($sql); 
	 
		
	   		if(!empty($row))
	   		{
	    		$data = $row['PK1'];
				return $data;
         	}
       
   }
   
   
   function getImagen($id){
		$sql = "SELECT * FROM PL_USUARIOS WHERE PK1 = '$id'";   
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
	}
	
}

?>