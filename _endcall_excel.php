<?php

//header($strExcelFileName);
include './conf.php';
$fn = new functionx();
$strExcelFileName = "ReportEndCall.xls";
$list = $fn->getEndCall();

$project = array();
if ($_GET['Project'] != 'all') {
    $project = $fn->getProject($_GET['Project']);
}

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once 'Classes/PHPExcel.php';
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("3CX WEB REPORT SYSTEM. ")
        ->setLastModifiedBy("3CX WEB REPORT SYSTEM.")
        ->setTitle("End Call Survey Reports.")
        ->setSubject("End Call Survey Reports.")
        ->setDescription("End Call Survey Reports.")
        ->setKeywords("End Call Survey Reports.")
        ->setCategory("Report.");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'End Call Survey Reports')
        ->setCellValue('A2', 'Date Rang  ')->setCellValue('B2', isset($_GET['date']) ? $_GET['date'] : '' )
        ->setCellValue('A3', 'Project')->setCellValue('B3', isset($_GET['Project']) ? $_GET['Project'] : '' )
        ->setCellValue('A4', 'Did Number!')->setCellValue('B4', isset($_GET['Did']) ? $_GET['Did'] : '' )
        ->setCellValue('A5', 'Agent Number!')->setCellValue('B5', isset($_GET['Agent']) ? $_GET['Agent'] : '' )
        ->setCellValue('A6', 'Report Type')->setCellValue('B6', isset($_GET['report']) ? (($_GET['report'] == 'sum') ? ' Average Score' : 'Total Score') : '')
        ->setCellValue('A7', 'Score Rate')->setCellValue('B7', (isset($_GET['scorestrat'])) ? $_GET['scorestrat'] : 1 . " - " . (isset($_GET['scoreend'])) ? $_GET['scoreend'] : 5 )
        ->setCellValue('A8', 'Customer Number')->setCellValue('B8', (isset($_GET['Cusnum']) && !empty($_GET['Cusnum'])) ? $_GET['Cusnum'] : "..............." );
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('EndCallSurveyReports');

if (isset($_GET['report']) && !empty($_GET['report']) && $_GET['report'] == 'sum') { // Average 
    $objPHPExcel->setActiveSheetIndex(0) 
            ->setCellValue('A9', 'Agent Number')
            ->setCellValue('B9', 'Agent Name')
            ->setCellValue('C9', 'DID(VDN)')
            ->setCellValue('D9', 'Score(AVG)');

    $i = 10;
    foreach ($list AS $key => $value) {
        $objPHPExcel->setActiveSheetIndex(0) 
                ->setCellValue("A$i", $value['agent'])
                ->setCellValue("B$i", $value['name'] . ' ' . $value['lastname'])
                ->setCellValue("C$i", $value['DIDNumber'])
                ->setCellValue("D$i", $value['score']);
        $i++;
    }
} else {
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A9', 'Date')
            ->setCellValue('B9', 'Time')
            ->setCellValue('C9', 'Customer Number')
            ->setCellValue('D9', 'Agent Number')
            ->setCellValue('E9', 'Agent Name')
            ->setCellValue('F9', 'DID(VDN)')
            ->setCellValue('G9', 'Score');

    $i = 10;
    foreach ($list AS $key => $value) {
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A$i", $fn->redate($value['DateLeave'], 'no'))
                ->setCellValue("B$i", $fn->retime($value['time']))
                ->setCellValue("C$i", $value['customernumber'])
                ->setCellValue("D$i", $value['agent'])
                ->setCellValue("E$i", $value['name'] . ' ' . $value['lastname'])
                ->setCellValue("F$i", $value['DIDNumber'])
                ->setCellValue("G$i", $value['score']);
        $i++;
    }
}

// Redirect output to a clientâ€™s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="01simple.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
