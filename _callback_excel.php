<?php

include './conf.php';
$fn = new functionx();
$strExcelFileName = "ReportCallBack.xls";
//header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
//header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
//header("Pragma:no-cache");


$list = $fn->getCallBack();
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
        ->setTitle("Call Back Report.")
        ->setSubject("Call Back Report.")
        ->setDescription("Call Back Report.")
        ->setKeywords("Call Back Report.")
        ->setCategory("Report.");


// Add some data

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Call Back Reports')
        ->setCellValue('A2', 'Date Rang : ' . ( isset($_GET['date']) ? $_GET['date'] : ''))
        ->setCellValue('A3', 'Project')->setCellValue('B3', !empty($project) ? $project['Name'] : '' )
        ->setCellValue('A4', 'DID Number')->setCellValue('B4', isset($_GET['Did']) ? $_GET['Did'] : '' )
        ->setCellValue('A5', 'Queue Number')->setCellValue('B5', isset($_GET['Queue']) ? $_GET['Queue'] : '' )
        ->setCellValue('A6', 'Day Or Night')->setCellValue('B6', isset($_GET['DayOrNight']) ? $fn->dayNight[$_GET['DayOrNight']] : '' )
        ->setCellValue('A7', 'Only Leave Number')->setCellValue('B7', isset($_GET['Leave']) ? "Yes" : "NO" );




// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Call Back Report');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A9', 'NO.')
        ->setCellValue('B9', 'Date')
        ->setCellValue('C9', 'Time')
        ->setCellValue('D9', 'Call Number')
        ->setCellValue('E9', 'Leave Number')
        ->setCellValue('F9', 'Queue Number')
        ->setCellValue('G9', 'DID. (VDN.)');

$i = 10;
$count = 1;
foreach ($list AS $key => $value) {
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$i", $count++)
            ->setCellValue("B$i", $fn->redate($value['DateLeave']))
            ->setCellValue("C$i", $fn->retime($value['TimeLeave']))
            ->setCellValue("D$i", $value['CallNum'])
            ->setCellValue("E$i", $value['LeaveNum'])
            ->setCellValue("F$i", $value['FromQueue'])
            ->setCellValue("G$i", $value['Project']);
    $i++;
}

$objPHPExcel->getActiveSheet()->getStyle('A1:A7')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A9:G9')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("A1:A1")->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->getStyle("A1:G$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Redirect output to a clientâ€™s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="CallBackReport.xlsx"');
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
