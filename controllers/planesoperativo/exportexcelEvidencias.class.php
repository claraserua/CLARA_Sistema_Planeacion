<?php
//include "controllers/planesoperativo/reportes/evidencias.class.php";

include "models/planesoperativo/exportexcelEvidencias.model.php";

class exportexcelEvidencias{
		
     //var $claseReporte; 
	 var $Model;
 
	function exportexcelEvidencias() {
	
			 
	   $this->Model = new exportexcelEvidenciasModel();	
       $this->loadPage();
          
						 
	}	
	
		
  function loadPage(){	 	
	 	// create excel document
	 	$fechaActual= date("dmY");
		$id_plan = $_GET['IDPlan'];
		$titulo = $this->Model->getPlanOperativo($id_plan);
	 	
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=Evidencias_POA_".$titulo.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		
	   $evidencias = $this->Model->getEvidencias($id_plan);
	   
	   
	    $numevidencias  = sizeof($evidencias);
		
		$html = '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="5" align="center" ><font size="5">EVIDENCIAS - '.$titulo.'</font></td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<td><font size="3"><b>No.</b></font></td>';
		$html .= '<td><font size="3"><b>RESULTADO</b></font></td>';
		$html .= '<td><font size="3"><b>LINEA</b></font></td>';
		$html .= '<td><font size="3"><b>EVIDENCIA</b></font></td>';
		$html .= '<td><font size="3"><b>ADJUNTO</b></font></td>';
		
		$html .= '</tr>';
		$num = 1;
		foreach ($evidencias as $row) {
		
		$html .= '<tr>';
		$html .= '<td  align="center">'.$num++.'</td>';
		$html .= '<td>'.$row['LINEA'].'</td>';
		$html .= '<td>'.$row['OBJETIVO'].'</td>';
		$html .= '<td>'.$row['EVIDENCIA'].'</td>';
		
		if($row['ADJUNTO']=="" || $row['ADJUNTO'] == "NULL"){ $html .= '<td align="center">NO</td>';}else{$html .= '<td align="center">SI</td>';}
		
		
		
		$html .= '</tr>';
		
		}
		
		$html .= '<table>';
		
		echo $html;
			
  }
	
		  
	  
}