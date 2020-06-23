<?php

class evidenciaModel {
	
    var $comentarios;
	
	
	function __construct() {
		
	}
     
	 
	 function getRecurso($id){
		
		$sql = "SELECT * FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK1 = '$id' ";   
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
		
		
        $rows = database::getRows($sql);
		
	
		$i=1;
	  foreach($rows as $row){
		  
		  
		       $html .= '<fieldset>
							<legend>'.$i.'.   '.htmlentities($row['LINEA'], ENT_QUOTES, "ISO-8859-1").'</legend>';
				
					 
					 $html .= $this->getObjetivos($row['PK1']);
				
							  
				 $html .= '</fieldset>';
			   $i++;
			   
			   
		  }	
		
		
		return $html;
		}
	
	
	   function obtenerEstadoPlan($idplan){
			
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$idplan'";
		$total = database::getNumRows($sql);      
		
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$idplan' AND ENVIADO = '3'";
		$terminados = database::getNumRows($sql);      
		
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$idplan' AND ENVIADO = '1'";
		$enviados = database::getNumRows($sql);      
		
		
		if($total==$terminados){
	    	return '';		
		}else{
			 if($enviados>0){
				return "R";
			 }else{
				return "E";
			 }
		}
		}
	
	
	
	  function getObjetivos($idlinea){
	  	$html = "";
		$sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$idlinea'  ORDER BY ORDEN";
		  
		$rows = database::getRows($sql);
        
		  $i=1;
		    foreach($rows as $row){
		  
		   $html .= '	<div class="controls">'.$i.'.  '.htmlentities($row['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</div>';
			$i++;
			}
			 
			 return $html;
			 }
			 
			 
			 
			 
	  function getComentarios($id){
		
		$this->comentarios = array(); 
		$sql = "SELECT * FROM PL_POPERATIVOS_EVIDENCIAS_COMENTARIOS WHERE PK_EVIDENCIA = '$id' ORDER BY FECHA_R DESC";	
	    
		$rows = database::getRows($sql);
		
	   foreach($rows as $row){
	    $this->comentarios[] = $row;
        }
     	}
	 
			 
			 
			 
			 
			function insertarComentario($comentario,$id){
	   	   		
			$fechar = date("Y-m-d H:i:s");
		    $usuario = $_SESSION['session']['user'];
			
			$this->campos = array('COMENTARIO'=>$comentario,
							               'PK_EVIDENCIA'=>$id,
										   'PK_USUARIO'=>$usuario,
							               'FECHA_R'=>$fechar,
							               );
	
		   database::insertRecords("PL_POPERATIVOS_EVIDENCIAS_COMENTARIOS",$this->campos);
			
		
		 $sql = "SELECT TOP 1 PK1 FROM PL_POPERATIVOS_EVIDENCIAS_COMENTARIOS WHERE PK_USUARIO = '$usuario' AND PK_EVIDENCIA = '$id' AND FECHA_R = '$fechar' ";  
		
		 
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