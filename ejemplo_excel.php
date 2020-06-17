<?php
require_once 'libs/excel/excel/Classes/PHPExcel.php';



$html ='<table>

<tr><th>cabecera 1</th>
<th>cabecera 2</th>
<th>cabecera 3</th>
</tr>
<tr>
<td>dato 1</td>
<td>dato 2</td>
<td>dato 3</td></tr>
<tr>
<td>dato 2.1</td>
<td>dato 2.2</td>
<td>dato 2.3</td></tr>
<tr>
<td>dato 3.1</td>
<td>dato 3.2</td>
<td>dato 3.3</td></tr>
</table>';
    
	
/*header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ejemplo_excel"');	
	header("Pragma: no-cache");
	header("Expires: 0");
	header('Cache-Control: max-age=0');*/


//echo $html;

$filename = "DownloadReport";
$table    = $html;

// save $table inside temporary file that will be deleted later
$tmpfile = tempnam(sys_get_temp_dir(), 'html');
file_put_contents($tmpfile, $table);

// insert $table into $objPHPExcel's Active Sheet through $excelHTMLReader
$objPHPExcel     = new PHPExcel();
$excelHTMLReader = PHPExcel_IOFactory::createReader('HTML');
$excelHTMLReader->loadIntoExisting($tmpfile, $objPHPExcel);
$objPHPExcel->getActiveSheet()->setTitle('any name you want'); // Change sheet's title if you want

unlink($tmpfile); // delete temporary file because it isn't needed anymore

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
header('Content-Disposition: attachment;filename='.$filename); // specify the download file name
header('Cache-Control: max-age=0');

// Creates a writer to output the $objPHPExcel's content
$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$writer->save('php://output');
exit;
		






?>