<?php

class printplanhtmModel {
	

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
		   $html .= '<tr>
						<td style="color:#000; padding:5px;  font-size:11px;">'.$linea.'.'.$cont.'</td>
						<td colspan="2"  style="color:#000; padding:5px;  font-size:11px;">'.htmlentities($row["OBJETIVO"], ENT_QUOTES, "ISO-8859-1").'</td>
						<td style="color:#000;  padding:5px; font-size:11px;">'.htmlentities($this->getObjetivoEstrategico($row["PK_OESTRATEGICO"]), ENT_QUOTES, "ISO-8859-1").'</td>
						<td  style="color:#000; padding:5px;  font-size:11px;">'.htmlentities($this->getResponsable($row['PK_RESPONSABLE']), ENT_QUOTES, "ISO-8859-1").'</td>
					</tr>';
		  
		  //MEDIOS
		  	$html .= $this->getIndicadoresO($row["PK1"],$row["PK_OESTRATEGICO"],$cont,$linea);

		  	$html .= $this->getIndicadoresR($row["PK1"],$cont,$linea);

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
	 function getIndicadoresO($idObT,$id,$resultado,$linea){
		
		
		$html ="";
        $sql = "SELECT INDICADOR,META 
				FROM PL_PESTRATEGICOS_OBJETIVOSE_INDICADORESMETAS AS A,
				PL_POPERATIVOS_OBJETIVOS_INDICADORES AS B
				WHERE A.PK1 = B.PK_INDICADORMETA
				AND A.PK_OESTRATEGICO = '$id'
				AND B.PK_OTACTICO = '$idObT'";	
	  
		
		$html .= '<tr>
					<td></td>
					<td width="100px;"></td><td colspan="2" bgcolor="#D9D9D9"  style="color:#000; background-color: #D9D9D9; padding:5px; font-size:12px; font-weight: bold;">Indicadores de Objetivo</td>
					<td bgcolor="#D9D9D9" style="color:#000; padding:5px; background-color: #D9D9D9; font-size:12px; font-weight: bold;">Meta al 2024</td>
				  </tr>';
		
		$medio=1;
	   $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    /*$html .="<tr>";
		$html .="<td style='font-size:12px;'>".htmlentities($row['MEDIO'])."  </td>";
		$html .="</tr>";*/
		
		$html .= '<tr><td></td><td  align="right" style="color:#000; float:right;  padding:5px; font-size:11px; ">'.$linea.'.'.$resultado.'.'.$medio.'</td><td colspan="2"  style="color:#000;  padding:5px; font-size:11px; ">'.htmlentities($row['INDICADOR'], ENT_QUOTES, "ISO-8859-1").'</td><td  style="color:#000; padding:5px;  font-size:11px; ">'.htmlentities($row['META'], ENT_QUOTES, "ISO-8859-1").'</td></tr>';
		
		$medio++;
		
		}
		//$html .="</table>";
		return $html;
		
     	}
	 function getIndicadoresR($id,$resultado,$linea){
		
		
		$html ="";
        $sql = "SELECT * FROM PL_POPERATIVOS_INDICADORESMETAS WHERE PK_OTACTICO = '$id' ORDER BY ORDEN";	
	  
		
		$html .= '<tr>
					<td></td>
					<td width="100px;"></td><td colspan="2" bgcolor="#D9D9D9"  style="color:#000; background-color: #D9D9D9; padding:5px; font-size:12px; font-weight: bold;">Indicadores de Resultado</td>
					<td bgcolor="#D9D9D9" style="color:#000; padding:5px; background-color: #D9D9D9; font-size:12px; font-weight: bold;">Meta Anual</td>
				  </tr>';
		
		$medio=1;
	   $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    /*$html .="<tr>";
		$html .="<td style='font-size:12px;'>".htmlentities($row['MEDIO'])."  </td>";
		$html .="</tr>";*/
		
		$html .= '<tr><td></td><td  align="right" style="color:#000; float:right;  padding:5px; font-size:11px; ">'.$linea.'.'.$resultado.'.'.$medio.'</td><td colspan="2"  style="color:#000;  padding:5px; font-size:11px; ">'.htmlentities($row['INDICADOR'], ENT_QUOTES, "ISO-8859-1").'</td><td  style="color:#000; padding:5px;  font-size:11px; ">'.htmlentities($row['META'], ENT_QUOTES, "ISO-8859-1").'</td></tr>';
		
		$medio++;
		
		}
		//$html .="</table>";
		return $html;
		
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