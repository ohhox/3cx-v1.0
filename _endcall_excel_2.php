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
ini_set('memory_limit', '-1');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once 'Classes/PHPExcel.php';
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$objPHPExcel->createSheet(0)->setTitle("End Call Survey Report "); //ภาพรวม By agent
$objPHPExcel->createSheet(1)->setTitle("ภาพรวม By agent "); //ภาพรวม By agent;
$objPHPExcel->createSheet(2)->setTitle("By Agent"); //ภาพรวม By agent;



$objPHPExcel->getProperties()->setCreator("3CX WEB REPORT SYSTEM.")
        ->setLastModifiedBy("3CX WEB REPORT SYSTEM.")
        ->setTitle("End Call Survey Reports.")
        ->setSubject("End Call Survey Reports.")
        ->setDescription("End Call Survey Reports.")
        ->setKeywords("End Call Survey Reports.")
        ->setCategory("Report.");

//$objPHPExcel->getActiveSheet()->setTitle('EndCallSurveyReports');


/* * *************PAGE 3 ************ */
$objPHPExcel->setActiveSheetIndex(2)
        ->setCellValue('A1', 'No.')
        ->setCellValue('B1', 'Date')
        ->setCellValue('C1', 'Time')
        ->setCellValue('D1', 'Tel No.')
        ->setCellValue('E1', 'Login')
        ->setCellValue('F1', 'ชื่อ Agent')
        ->setCellValue('G1', 'Score')
        ->setCellValue('I1', 'ชื่อ Agent')
        ->setCellValue('J1', 'จำนวนที่ส่งเข้าประเมิน');

$i = 2;
$data = array();
foreach ($list AS $key => $value) {
    $score = "";
    if (empty($value['score'])) {
        if ($value['score'] === "0") {
            $score = $value['score'];
        } else {
            $score = "NULL";
        }
    } else {
        $score = $value['score'];
    }
    $objPHPExcel->setActiveSheetIndex(2)
            ->setCellValue("A$i", ($i - 1))
            ->setCellValue("B$i", $fn->redate($value['DateLeave'], 'no'))
            ->setCellValue("C$i", $fn->retime($value['time']))
            ->setCellValue("D$i", $value['customernumber'])
            ->setCellValue("E$i", $value['agent'])
            ->setCellValue("F$i", $value['name'] . ' ' . $value['lastname'])
            ->setCellValue("G$i", $score);

    if (empty($data[$value['agent']])) {
        $data[$value['agent']] = array(
            "name" => $value['name'] . ' ' . $value['lastname'],
            'agent' => $value['agent'],
            'count' => 1,
            'score' => array(
                "NULL" => 0, 0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0
            )
        );
        $data[$value['agent']]['score'][$score] ++;
    } else {
        $data[$value['agent']]['count'] ++;
        $data[$value['agent']]['score'][$score] ++;
    }
    $i++;
}

$x = 2;
foreach ($data as $key => $value) {
    $objPHPExcel->setActiveSheetIndex(2)
            ->setCellValue("I$x", $value['name'])
            ->setCellValue("J$x", $value['count']);
    $x++;
}
$objPHPExcel->setActiveSheetIndex(2)->getStyle('A1:K1')->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(2)->getStyle("A1:K$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

/* * ************* END PAGE 3 ************ */

/* * ************* PAGE 2 ************ */
 
if (($_GET['Project']) == 2) {
    $objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A1', 'Name Agent')
            ->setCellValue('B1', 'Log in ID')
            ->setCellValue('C1', 'จำนวนสายที่รับได้ทั้งหมด')
            ->setCellValue('D1', 'จำนวนโอนสายประเมิน')
            ->setCellValue('E1', '% สายที่โอนประเมิน')
            ->setCellValue('F1', 'จำนวนสายลูกค้าวางสายไปก่อนประเมินเสร็จ (3CX)')
            ->setCellValue('G1', 'จำนวนสายลูกค้ากดประเมิน')
            ->setCellValue('H1', 'ผลการประเมิน');
    $objPHPExcel->setActiveSheetIndex(1)
            ->mergeCells('A1:A2')
            ->mergeCells('B1:B2')
            ->mergeCells('C1:C2')
            ->mergeCells('D1:D2')
            ->mergeCells('E1:E2')
            ->mergeCells('F1:F2')
            ->mergeCells('G1:G2')
            ->mergeCells('H1:N1');
    $objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('H2', 'Pess 1')
            ->setCellValue('I2', '%')
            ->setCellValue('J2', 'Pess 2')
            ->setCellValue('K2', '%')
            ->setCellValue('L2', 'Pess 3')
            ->setCellValue('M2', '%')
            ->setCellValue('N2', '% ความพึงพอใจ');



    $x = 3;
    foreach ($data as $key => $value) {
        $all = $value['score'][1] + $value['score'][2] + $value['score'][3] + $value['score']['NULL'];
        $objPHPExcel->setActiveSheetIndex(1)
                ->setCellValue("A$x", $value['name'])
                ->setCellValue("B$x", $value['agent'])
                ->setCellValue("D$x", $value['count'])
                ->setCellValue("F$x", $value['score']['NULL'])
                ->setCellValue("G$x", $value['score'][1] + $value['score'][2] + $value['score'][3])
                ->setCellValue("H$x", $value['score'][1])
                ->setCellValue("J$x", $value['score'][2])
                ->setCellValue("L$x", $value['score'][3]);
        $x++;
    }
} else if ($_GET['Project'] == 3) {
    $objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A1', 'Name Agent')
            ->setCellValue('B1', 'Log in ID')
            ->setCellValue('C1', 'จำนวนสายที่รับได้ทั้งหมด')
            ->setCellValue('D1', 'จำนวนโอนสายประเมิน')
            ->setCellValue('E1', '% สายที่โอนประเมิน')
            ->setCellValue('F1', 'จำนวนสายลูกค้าวางสายไปก่อนประเมินเสร็จ (3CX)')
            ->setCellValue('G1', 'จำนวนสายลูกค้ากดประเมิน')
            ->setCellValue('H1', 'ผลการประเมิน');
    $objPHPExcel->setActiveSheetIndex(1)
            ->mergeCells('A1:A2')
            ->mergeCells('B1:B2')
            ->mergeCells('C1:C2')
            ->mergeCells('D1:D2')
            ->mergeCells('E1:E2')
            ->mergeCells('F1:F2')
            ->mergeCells('G1:G2')
            ->mergeCells('H1:L1');
    $objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('H2', 'พึงพอใจ')
            ->setCellValue('I2', '%')
            ->setCellValue('J2', 'ไม่พึงพอใจ')
            ->setCellValue('K2', '%')
            ->setCellValue('L2', '% ความพึงพอใจ');
     $x = 3;
    foreach ($data as $key => $value) {
        $all = $value['score'][1] + $value['score'][2] + $value['score'][3] + $value['score']['NULL'];
        $objPHPExcel->setActiveSheetIndex(1)
                ->setCellValue("A$x", $value['name'])
                ->setCellValue("B$x", $value['agent'])
                ->setCellValue("D$x", $value['count'])
                ->setCellValue("F$x", $value['score']['NULL'])
                ->setCellValue("G$x", $value['score'][1]+ $value['score'][0])
                ->setCellValue("H$x", $value['score'][1])
                ->setCellValue("J$x", $value['score'][0]);
        $x++;
    }
}
 
/* * ************* END PAGE 2 ************ */
// Redirect output to a clientâ€™s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="EndCallSurveyReports.xlsx"');
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
