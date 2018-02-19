<?php

include './conf.php';
$fn = new functionx();
$strExcelFileName = "ReportCallBack.xls";
//header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
//header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
//header("Pragma:no-cache");


$list = $fn->getAuxtime();
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
        ->setCellValue('A1', 'Auxiliary Time Report')
        ->setCellValue('A2', 'Date Rang : ' . ( isset($_GET['date']) ? $_GET['date'] : ''))
        ->setCellValue('A3', 'Project')->setCellValue('B3', !empty($project) ? $project['Name'] : '' )
        ->setCellValue('A4', 'DID Number')->setCellValue('B4', isset($_GET['Did']) ? $_GET['Did'] : '' )
        ->setCellValue('A5', 'Queue Number')->setCellValue('B5', isset($_GET['Queue']) ? $_GET['Queue'] : '' )
        ->setCellValue('A6', 'Time Option')->setCellValue('B6', (isset($_GET['timeOption']) && $_GET['timeOption'] == 'all' ) ? " All Time." : ' Custom Time. (' . $_GET['timeStart'] . ' - ' . $_GET['timeEnd'] . ')' )
        ->setCellValue('A7', 'Agent Option ')->setCellValue('B7', (isset($_GET['agentOption']) && $_GET['agentOption'] == 'name' ) ? " Agent Name : ({$_GET['Cusnum']})" : ' Agent Number. (' . $_GET['Agent'] . ')')
        ->setCellValue('A8', 'Auxiliary Number ')->setCellValue('B8', (isset($_GET['aux']) && $_GET['aux'] == 'all' ) ? " ALL " : $_GET['aux'] );





// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Auxiliary Time Report');
 
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A10', 'NO.')
        ->setCellValue('B10', 'Date')
        ->setCellValue('C10', 'Time')
        ->setCellValue('D10', 'Agent Number')
        ->setCellValue('E10', 'Agent Name')
        ->setCellValue('F10', 'Login / Logout')
        ->setCellValue('G10', 'Aux Number')
        ->setCellValue('H10', 'Aux Description');

$i = 11;
$count = 1;
foreach ($list AS $key => $value) {
    $valuex = $fn->ThaiTextToutf($value);
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$i", $count++)
            ->setCellValue("B$i", $fn->redate($value['date']))
            ->setCellValue("C$i", $fn->retime($value['TimeAux']))
            ->setCellValue("D$i", $value['Agent'])
            ->setCellValue("E$i", $valuex['name'] . ' ' . $valuex['lastname'])
            ->setCellValue("F$i", $value['Loginout'])
            ->setCellValue("G$i", $value['AuxNum'])
            ->setCellValue("H$i", $value['AuxDes']);
    $i++;
} 
$objPHPExcel->getActiveSheet()->getStyle('A1:A8')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A10:H10')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("A1:A1")->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->getStyle("A1:H$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

// Redirect output to a clientâ€™s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Auxiliary Time Report.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 10, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 110107 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
