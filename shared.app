<?php



 $planes =  explode("/",$_GET['execute']);
 $id = $planes[2];

  switch($id){
  	
	case "PE":
	include "models/planestrategico/printplan.model.php";
	break;
	
	
	case "PO":
	include "models/planesoperativo/printplan.model.php";
	break;
	
  }




require('libs/fpdf/fpdf.php');

require_once('libs/pdf/config/lang/eng.php');
require_once('libs/pdf/tcpdf.php');

require 'core/dbaccess.php';
require 'core/constants.php';



class printplan {

	var $Model;
		
		
	function printplan() {
	
		
	 $this->Model = new printplanModel(); 
     $this->loadPage();		
						 
	}
	
	
function loadPage(){
	
	
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Red de Universidades Anahuac');
$pdf->SetTitle('Plan Operativo');
$pdf->SetSubject('Plan Operativo');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
//$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'N', 11);

// add a page
$pdf->AddPage();

$pdf->SetY(5);
$html = "
<!-- EXAMPLE OF CSS STYLE -->
<style>  
	td{
	border:1px solid #666;
	}
	
	td.title{
	background:#E5E5E5;
	padding:10px;
	}
   
</style> <br />";
 
$html .= $this->Model->getLineas();


// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

//Close and output PDF document
$pdf->Output('plan.pdf', 'I');
		
	 }
	 
	 
	  
	  
	function getPlan(){
	
	
	$plan =  explode("/",$_GET['execute']);
	
	$row = $this->Model->getPlan($plan[0]);
	
	return $row['TITULO'];
			
	}
	  
	
}


class MYPDF extends TCPDF {
     
    var $titulo;
	
    //Page header
    public function Header() {
        // Logo
        $image_file = 'skins/default/img/red.jpg';
        $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 200, '', false, false, 0, false, false, false);
        // Set font
        //$this->SetFont('helvetica', 'B', 20);
        // Title
       // $this->SetY(10);
       // $this->Cell(0, 25, "Red de Universidades Anáhuac", 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}



 $planes =  explode("/",$_GET['execute']);
 $id = $planes[2];

  switch($id){
  	
	case "PE":
	$compartir = new printplan();
	break;
	
	
	case "PO":
	$compartir = new printplan();
	break;
	
  }




?>