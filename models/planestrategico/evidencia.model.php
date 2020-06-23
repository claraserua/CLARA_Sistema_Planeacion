<?php

class evidenciaModel {
	
    var $comentarios;
	
	
	function __construct() {
		
	}
     
	 
	 function getRecurso($id){
		
		$sql = "SELECT * FROM PL_PESTARTEGICOS_ADJUNTOS WHERE PK1 = '$id' ";   
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}
	 
	 
    function getPlan($id){
		
		$sql = "SELECT * FROM PL_PESTRATEGICOS WHERE PK1 = '$id' ";   
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}

  



    function getLineas(){
		
	 
		$html = "";
		$id = $_GET['IDPlan'];
		$sql = "SELECT * FROM PL_PESTRATEGICOS_LINEASE WHERE PK_PESTRATEGICO = '$id' ORDER BY ORDEN";
		
		
      //  $result = database::executeQuery($sql);
		
		
		$i=1;
	 // while($row = mssql_fetch_array($result, MSSQL_ASSOC)){
	 foreach(database::getRows($sql) as $row){
		  
		  
		       $html .= '<fieldset>
							<legend>'.$i.'.   '.htmlentities($row['LINEA'], ENT_QUOTES, "ISO-8859-1").'</legend>';
				
					 
					 $html .= $this->getObjetivos($row['PK1']);
				
							  
				 $html .= '</fieldset>';
			   $i++;
			   
			   
		  }	
		
		
		return $html;
		}
	
	
	  function getObjetivos($idlinea){
	  	$html = "";
		$sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$idlinea'  ORDER BY ORDEN";
		  
		
       // $result = database::executeQuery($sql);
		  $i=1;
		//    while($row = mssql_fetch_array($result, MSSQL_ASSOC)){
		foreach(database::getRows($sql) as $row){
		  
		   $html .= '	<div class="controls">'.$i.'.  '.htmlentities($row['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</div>';
			$i++;
			}
			 
			 return $html;
			 }
			 
			 
			 
			 
	  function getComentarios($id){
		
		$this->comentarios = array(); 
		$sql = "SELECT * FROM PL_PESTRATEGICOS_ADJUNTOS_COMENTARIOS WHERE PK_ADJUNTO = '$id' ORDER BY FECHA_R DESC";	
	 //   $result = database::executeQuery($sql);
		
	 //  while ($row =  mssql_fetch_array($result, MSSQL_ASSOC)) {
	 foreach(database::getRows($sql) as $row){
	    $this->comentarios[] = $row;
        }
     	}
	 
			 
			 
			 
			 
			function insertarComentario($comentario,$id){
	   	   		
			$fechar = date("Y-m-d H:i:s");
		    $usuario = $_SESSION['session']['user'];
			
			$this->campos = array('COMENTARIO'=>$comentario,
							               'PK_ADJUNTO'=>$id,
										   'PK_USUARIO'=>$usuario,
							               'FECHA_R'=>$fechar,
							               );
	
		   database::insertRecords("PL_PESTRATEGICOS_ADJUNTOS_COMENTARIOS",$this->campos);
			
		
		 $sql = "SELECT TOP 1 PK1 FROM PL_PESTRATEGICOS_ADJUNTOS_COMENTARIOS WHERE PK_USUARIO = '$usuario' AND PK_ADJUNTO = '$id' AND FECHA_R = '$fechar' ";  
		
		 
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