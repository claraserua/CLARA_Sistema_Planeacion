<?php
require_once 'Spreadsheet/Excel/Writer.php';

$workbook = new Spreadsheet_Excel_Writer();
$worksheet =& $workbook->addWorksheet();

// put text at the top
$format_top =& $workbook->addFormat();
$format_top->setHAlign('top');
$format_top->setTextWrap(1);

// center the text horizontally
$format_center =& $workbook->addFormat();
$format_center->setHAlign('center');

// put text at the top and center it horizontally
$format_top_center =& $workbook->addFormat();
$format_top_center->setHAlign('top');
$format_top_center->setHAlign('center');

$worksheet->write(0, 0, 'On top of the world!',
                  $format_top);
$worksheet->write(1, 0, 'c', $format_center);
$worksheet->write(2, 0, 'tc', $format_top_center);

$workbook->send('align.xls');
$workbook->close();
?>