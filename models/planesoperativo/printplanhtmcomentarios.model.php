<?php

class printplanhtmcomentariosModel {
	

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
		
		

		


	function getLogo($id){
	
	    $sql = "SELECT * FROM PL_JERARQUIAS WHERE PK1 = '$id'";   
		$row = database::getRow($sql);
	
		if($row){
			if($row['ADJUNTO']=="NULL" || $row['ADJUNTO']==""){
			   $imagen= "media/imagenes/redanahuac.png";
			}else{$imagen ="media/jerarquias/".$id."/".$row['ADJUNTO'];}
			
			return $imagen;
		
		}else{
			return FALSE;
		}
	

     }	
	
	
   function getComentarios(){
   
      
   
   if(isset($_GET['IDPlan'])){
			$plan = $this->getPlan($_GET['IDPlan']);
			$id = $_GET['IDPlan'];
		}else{
            $planes =  explode("/",$_GET['execute']);
			$plan = $planes[0];		
			$plan = $this->getPlan($plan);
		}
		
		$logo = '';
		//$logo =  $this->getLogo($plan['PK_JERARQUIA']);
		
		$html = '<img src="'.$logo .'" />';
		$html .= "<div align=\"center\"><h1>".htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1")."</h1></div><br/>";
		
		$html .="<table width='97%'>";
		
		$html .= '<tr><td colspan="2" bgcolor="#F8991D" style="color:#fff; padding:5px; background-color: #F8991D; font-size:12px;"><strong>Comentarios Generales</strong></td></tr>';
		
		
		$sql = "SELECT COMENTARIO, FECHA_R, (SELECT CONCAT(TITULO,' ',NOMBRE,' ',APELLIDOS) FROM PL_USUARIOS WHERE PL_USUARIOS.PK1 = PL_POPERATIVOS_COMENTARIOS.PK_USUARIO) AS NOMBRE,(SELECT IMAGEN FROM PL_USUARIOS WHERE PL_USUARIOS.PK1 = PL_POPERATIVOS_COMENTARIOS.PK_USUARIO) AS IMAGEN FROM PL_POPERATIVOS_COMENTARIOS WHERE PK_POPERATIVO = '$id' ORDER BY FECHA_R"; 
        $rows = database::getRows($sql);
		
		$num=1;
		foreach($rows as $row){
		
		   
		  $html .= '<tr><td style="width:10%" align="center"><img src="media/usuarios/thum_40x40_'.$row["IMAGEN"].'"  class="big_face" /></td><td   style="color:#000; width:90%; padding:5px;  font-size:11px;">'.htmlentities($row["NOMBRE"], ENT_QUOTES, "ISO-8859-1").'<br>'.htmlentities($row["COMENTARIO"], ENT_QUOTES, "ISO-8859-1").'<br>'.$row["FECHA_R"]->format('Y-m-d').'</td></tr>';
		   
		}
		
		
		
		
		$html .="</table>";	
		
		return $html;
   
   
   
   }
	
	
    function getLineas(){
		
		if(isset($_GET['IDPlan'])){
			$plan = $this->getPlan($_GET['IDPlan']);
		}else{
            $planes =  explode("/",$_GET['execute']);
			$plan = $planes[0];		
			$plan = $this->getPlan($plan);
		}
		
		$logo = '';
		//$logo =  $this->getLogo($plan['PK_JERARQUIA']);
		
		$html = '<img src="'.$logo .'" />';
		$html .= "<div align=\"center\"><h1>".htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1")."</h1></div><br/>";
		
		$html .="<table width='97%'>";
		
		
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
			   <tr><td colspan="5" bgcolor="#F8991D" style="color:#fff; padding:5px; background-color: #F8991D; font-size:12px;"><strong>'.$i.'. Línea Estratégica:</strong>&nbsp;<strong>'.htmlentities($row['LINEA'], ENT_QUOTES, "ISO-8859-1").'</strong></td></tr>';
			   
			   $html .= '<tr><td></td><td></td><td></td><td></td></tr>';	  
					  
			   $html .= $this->getObjetivosTacticos($row['PK1'],$i);
			   
			   $html .= '<tr><td></td><td></td><td></td><td></td></tr>';	
			   $i++;
			   
		  }
		  
		$html .="</table>";	
		
		return $html;
		}
	
	
	
	function getObjetivosTacticos($idlinea,$linea){
		
		
		
		if(isset($_GET['IDPlan'])){
			$id = $_GET['IDPlan'];
		}else{
            $planes =  explode("/",$_GET['execute']);
			$id = $planes[0];		
		}
		
		
		
		$html = "";
		$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_POPERATIVO = '$id' AND PK_LESTRATEGICA = '$idlinea'  ORDER BY ORDEN";
		  
         
		 
		  $cont=1;
		  $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		  //RESULTADOS
		  
		   $html .= '<tr><td></td><td colspan="2"  bgcolor="#D9D9D9" style="color:#000; padding:5px; background-color: #D9D9D9; font-size:12px; font-weight: bold;">Resultado</td><td width="350px;" bgcolor="#D9D9D9"  style="color:#000; background-color: #D9D9D9; padding:5px; font-size:12px; font-weight: bold;">Objetivo Estratégico</td><td width="200px;" bgcolor="#D9D9D9" style="color:#000; padding:5px; background-color: #D9D9D9; font-size:12px; font-weight: bold;">Responsable</td></tr>';
		   $html .= '<tr><td style="color:#000; padding:5px;  font-size:11px;">'.$linea.'.'.$cont.'</td><td colspan="2"  style="color:#000; padding:5px;  font-size:11px;">'.htmlentities($row["OBJETIVO"], ENT_QUOTES, "ISO-8859-1").'</td><td style="color:#000;  padding:5px; font-size:11px;">'.htmlentities($this->getObjetivoEstrategico($row["PK_OESTRATEGICO"]), ENT_QUOTES, "ISO-8859-1").'</td><td  style="color:#000; padding:5px;  font-size:11px;">'.htmlentities($this->getResponsable($row['PK_RESPONSABLE']), ENT_QUOTES, "ISO-8859-1").'</td></tr>';
		  
		  //MEDIOS
		  
		    $html .= $this->getMedios($row["PK1"],$cont,$linea);
			
			$html .= $this->getEvidencias($row["PK1"],$cont,$linea);
			
		  
		  
		  $cont++;	
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
	 
	 
	 
	 function getMedios($id,$resultado,$linea){
		
		
		$html ="";
        $sql = "SELECT * FROM PL_POPERATIVOS_MEDIOS WHERE PK_OTACTICO = '$id' ORDER BY ORDEN";	
	  
		
		$html .= '<tr><td></td><td width="100px;"></td><td colspan="2" bgcolor="#D9D9D9"  style="color:#000; background-color: #D9D9D9; padding:5px; font-size:12px; font-weight: bold;">Medios</td><td bgcolor="#D9D9D9" style="color:#000; padding:5px; background-color: #D9D9D9; font-size:12px; font-weight: bold;">Responsable</td></tr>';
		
		$medio=1;
	   $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    /*$html .="<tr>";
		$html .="<td style='font-size:12px;'>".htmlentities($row['MEDIO'])."  </td>";
		$html .="</tr>";*/
		
		$html .= '<tr><td></td><td  align="right" style="color:#000; float:right;  padding:5px; font-size:11px; ">'.$linea.'.'.$resultado.'.'.$medio.'</td><td colspan="2"  style="color:#000;  padding:5px; font-size:11px; ">'.htmlentities($row['MEDIO'], ENT_QUOTES, "ISO-8859-1").'</td><td  style="color:#000; padding:5px;  font-size:11px; ">'.htmlentities($this->getResponsable($row['PK_RESPONSABLE']), ENT_QUOTES, "ISO-8859-1").'</td></tr>';
		
		$medio++;
		
        }
		
		//$html .="</table>";
		return $html;
		
     	}
		
		
		
		function getEvidencias($id,$resultado,$linea){
		
		$html ="";
        $sql = "SELECT * FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_OTACTICO = '$id' ORDER BY ORDEN";	
	   
	    
		$html .= '<tr><td></td><td width="100px;"></td><td colspan="2" bgcolor="#D9D9D9"  style="color:#000; background-color: #D9D9D9; padding:5px; font-size:12px; font-weight: bold;">Evidencias</td><td></td></tr>';
		
		$evidencia=1;
		
	   $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
		$html .= '<tr><td></td><td  align="right" style="color:#000; float:right;  padding:5px; font-size:11px; ">'.$linea.'.'.$resultado.'.'.$evidencia.'</td><td colspan="2"  style="color:#000;  padding:5px; font-size:11px; ">'.htmlentities($row['EVIDENCIA'], ENT_QUOTES, "ISO-8859-1").'</td><td  style="color:#000; padding:5px;  font-size:11px; "></td></tr>';
	    $evidencia++;
        }
     	
		
		
		return $html;
		
		}
		
		
		function getResponsable($id){
	 	
		$sql = "SELECT CONCAT(TITULO,' ',NOMBRE,' ',APELLIDOS) AS RESPONSABLE FROM PL_USUARIOS WHERE PK1 = '$id'";

        $row = database::getRow($sql);
		
		if($row){
			return $row['RESPONSABLE'];
		}else{
			return FALSE;
		}
	 	
	 }
		
	 
}

?>