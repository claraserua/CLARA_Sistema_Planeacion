<?php

class printplanModel {
	

	var $idplan;
	
	function __construct() {
		
	}
    

    function getPlan($id){
		
		$sql = "SELECT * FROM PL_POPERATIVOS WHERE PK1 = '$id'";   
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}



    function getLineas(){
		
		if(isset($_GET['IDPlan'])){
			$plan = $this->getPlan($_GET['IDPlan']);
		}else{
            $planes =  explode("/",$_GET['execute']);
			$plan = $planes[0];		
			$plan = $this->getPlan($plan);
		}
		
		$html = "<div align=\"center\"><h2>".htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1")."</h2></div><br/>";
		
		$html .="<table>";
		
		
		if(isset($_GET['IDPlanE'])){
			$id = $_GET['IDPlanE'];
		}else{
            $planes =  explode("/",$_GET['execute']);
			$id = $planes[1];		
		}
		
		
		
		$sql = "SELECT * FROM PL_PESTRATEGICOS_LINEASE WHERE PK_PESTRATEGICO = '$id' ORDER BY ORDEN";
		
		
		$i=1;
	  $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		    
		       $html .= '	   
			   <tr><td bgcolor="#F8991D" style="color:#7C430B;"><strong>'.$i.'. Línea Estratégica:</strong></td></tr>';
			   
			   $html .= '<tr><td><strong>'.htmlentities($row['LINEA'], ENT_QUOTES, "ISO-8859-1").'</strong></td></tr>';
			   
			   $html .= '<tr><td><br /></td></tr>';	  
					  
			   $html .= $this->getObjetivosTacticos($row['PK1']);
			   
			   $html .= '<tr><td><br /></td></tr>';	
			   $i++;
			   
		  }
		  
		$html .="</table>";	
		
		return $html;
		}
	
	
	
	function getObjetivosTacticos($idlinea){
		
		
		
		if(isset($_GET['IDPlan'])){
			$id = $_GET['IDPlan'];
		}else{
            $planes =  explode("/",$_GET['execute']);
			$id = $planes[0];		
		}
		
		
		
		$html = "";
		$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_POPERATIVO = '$id' AND PK_LESTRATEGICA = '$idlinea'  ORDER BY ORDEN";
		  
		 
		  $i=1;
		 $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		  
		   $html .= '	<tr><td bgcolor="#F8991D" style="color:#7C430B;"><strong>Objetivo Estratégico:</strong></td></tr>';
		   
		    $html .= '	<tr><td><strong>'.htmlentities($this->getObjetivoEstrategico($row["PK_OESTRATEGICO"]), ENT_QUOTES, "ISO-8859-1").'</strong></td></tr>';
			
			 $html .= '<tr><td><br /></td></tr>';	
		   
		   
		  $html .= '	<tr><td bgcolor="#F8991D" style="color:#7C430B;"><strong>Resultado:</strong></td></tr>';
		  
		   $html .= '	<tr><td><strong>'.htmlentities($row["OBJETIVO"],ENT_QUOTES, "ISO-8859-1").'</strong></td></tr>';
		 
		  $html .= '<tr><td><br /></td></tr>';	
		  
		  
		  $html .= '	<tr><td><strong>Responsable del Resultado:</strong></td></tr>';
		  $html .= '<tr><td> '.htmlentities($this->getResponsable($row["PK_RESPONSABLE"]),ENT_QUOTES, "ISO-8859-1").'   </td></tr>';
		   
		  $html .= '<tr><td><br /></td></tr>';
		  
		  
		  
		  
		  
		  $html .= '<tr><td> '.$this->getMedios($row["PK1"]).'   </td></tr>';	
		  
		  
		  $html .= '<tr><td><br /></td></tr>';
		  
		   $html .= '<tr><td> '.$this->getEvidencias($row["PK1"]).'   </td></tr>';
		   
		   
		   $html .= '<tr><td><br /></td></tr>';
		   
		   
		 
		   
		   
		   
		  
		  $i++;	
		  }
			 
		return $html;
			 }
	
	
	
	
	  function getObjetivoEstrategico($id){
		
		$sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK1 = '$id'  ORDER BY ORDEN";

        $row = database::getRow($sql);
		
		if($row){
			return $row['OBJETIVO'];
		}else{
			return FALSE;
		}
	
     }
	 
	  function getResponsable($id){
		$sql = "SELECT * FROM PL_USUARIOS WHERE PK1 = '$id' ";	
		$row = database::getRow($sql);
		if($row){
			return $row['APELLIDOS']." ".$row['NOMBRE'];
		}else{
			return FALSE;
		}
		 }
	 
	 function getMedios($id){
		
		
		$html ="<table>";
        $sql = "SELECT * FROM PL_POPERATIVOS_MEDIOS WHERE PK_OTACTICO = '$id' ORDER BY ORDEN";	
	    
		$html .="<tr><td><strong>Medios:</strong></td></tr>";
		
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $html .="<tr><td></td></tr><tr>";
		$html .="<td>".htmlentities($row['MEDIO'], ENT_QUOTES, "ISO-8859-1")."</td>";
		$html .="</tr>";
		
		$html .="<tr><td><strong>Responsable del Medio:</strong></td></tr>";
		$html .="<tr>";
		$html .="<td>".htmlentities($this->getResponsable($row['PK_RESPONSABLE']),ENT_QUOTES, "ISO-8859-1")."  </td>";
		$html .="</tr>";
		
		
		
        }
		
		$html .="</table>";
		return $html;
		
     	}
		
		
		
		function getEvidencias($id){
		
		$html ="<table>";
        $sql = "SELECT * FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_OTACTICO = '$id' ORDER BY ORDEN";	
	   
	    
		$html .="<tr><td><strong>Evidencias:</strong></td></tr>";
		
	   $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
		$html .="<tr>";
		$html .="<td>  ".htmlentities($row['EVIDENCIA'], ENT_QUOTES, "ISO-8859-1")."  </td>";
		$html .="</tr>";
	    
        }
     	
		$html .="</table>";
		
		return $html;
		
		}
		
	 
}

?>