<?php

//header($strExcelFileName);
unset($_GET['scorestrat']);
unset($_GET['scoreend']);
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
$NullValue = array();
$Page3Data = array(
    'success' => 0,
    'dontSuccess' => 0,
    'score' => array(
        "NULL" => 0, 0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0
    )
);
foreach ($list AS $key => $value) {
    $score = "";
    if (empty($value['score'])) {
        if ($value['score'] === "0") {
            $score = $value['score'];
        } else {
            $score = "NULL";
        }
        $Page3Data['dontSuccess'] ++;
    } else {
        $score = $value['score'];
    }
    if ($score !== 'NULL') {
        $Page3Data['success'] ++;
        $Page3Data['score'][$score] ++;
    }
    if ($score === "0" || $score == 3) {
        $NullValue[$i] = $value;
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
                ->setCellValue("H$x", $value['score'][1])->setCellValue("I$x", "=(H{$x}/G{$x})")
                ->setCellValue("J$x", $value['score'][2])->setCellValue("K$x", "=(J{$x}/G{$x})")
                ->setCellValue("L$x", $value['score'][3])->setCellValue("M$x", "=(L{$x}/G{$x})")
                ->setCellValue("N$x", "=((H$x*1)+(J$x*0.5)+(L$x*0))/G$x");


        $objPHPExcel->setActiveSheetIndex(1)->getStyle("N$x")
                ->getNumberFormat()->applyFromArray(
                array(
                    'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                )
        );
        $objPHPExcel->setActiveSheetIndex(1)->getStyle("I$x")
                ->getNumberFormat()->applyFromArray(
                array(
                    'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                )
        );
        $objPHPExcel->setActiveSheetIndex(1)->getStyle("K$x")
                ->getNumberFormat()->applyFromArray(
                array(
                    'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                )
        );
        $objPHPExcel->setActiveSheetIndex(1)->getStyle("M$x")
                ->getNumberFormat()->applyFromArray(
                array(
                    'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                )
        );
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
                ->setCellValue("G$x", $value['score'][1] + $value['score'][0])
                ->setCellValue("H$x", $value['score'][1])->setCellValue("I$x", "=(H{$x}/G{$x})")
                ->setCellValue("J$x", $value['score'][0])->setCellValue("K$x", "=(J{$x}/G{$x})")
                ->setCellValue("L$x", "=((H$x*1)+(J$x*0))/G$x");

        $objPHPExcel->setActiveSheetIndex(1)->getStyle("I$x")
                ->getNumberFormat()->applyFromArray(
                array(
                    'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                )
        );
        $objPHPExcel->setActiveSheetIndex(1)->getStyle("K$x")
                ->getNumberFormat()->applyFromArray(
                array(
                    'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                )
        );
        $objPHPExcel->setActiveSheetIndex(1)->getStyle("L$x")
                ->getNumberFormat()->applyFromArray(
                array(
                    'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                )
        );
        $x++;
    }
}

/* * ************* END PAGE 2 ************ */

/* * ************* PAGE 1 ************ */
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', ' รายงานความพึงพอใจลูกค้าด้านบริการ ' . $project['Name'])
        ->setCellValue('A2', 'จำนวนสายที่ Contact Center ให้บริการทั้งหมด (ACD+Transection)')
        ->setCellValue('B2', 'จำนวนสาย ที่พนักงานส่งเข้าประเมิน')
        ->setCellValue('C2', 'สาเหตุที่ไม่ส่งสายประเมิน')
        ->setCellValue('C3', 'ลูกค้าไม่สะดวกประเมิน')
        ->setCellValue('D3', 'ลูกค้าวางสายไปทันทีเมื่อได้รับข้อมูลเรียบร้อยแล้ว')
        ->setCellValue('E3', 'พนักงานพฤกษาติดต่อเข้ามา / โอนสายระหว่างศูนย์')
        ->setCellValue('F3', 'ลูกค้า Eng')
        ->setCellValue('G3', 'สายหลุด / สายเงียบ /โทรผิด โรคจิต')
        ->setCellValue('H2', '% การส่งสายเข้าประเมิน')
        ->setCellValue('I2', '% ที่ไม่ส่งสายเข้าประเมิน')
        ->setCellValue('J2', 'จำนวนสายที่ประเมินผลได้สำเร็จ')
        ->setCellValue('K2', 'จำนวนสายที่วางไปก่อนประเมินแล้วเสร็จ')
        ->setCellValue('B4', $Page3Data['success'] + $Page3Data['dontSuccess'])
        ->setCellValue('J4', $Page3Data['success'])
        ->setCellValue('K4', $Page3Data['dontSuccess']);


$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('A2:A3')
        ->mergeCells('B2:B3')
        ->mergeCells('C2:G2')
        ->mergeCells('H2:H3')
        ->mergeCells('I2:I3')
        ->mergeCells('J2:J3')
        ->mergeCells('K2:K3');



$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A6', ' คะแนนความพึงพอใจลูกค้าต่อการบริการ  ' . $project['Name'])
        ->setCellValue('A7', 'จำนวนสายที่ประเมินผลได้สำเร็จ')
        ->setCellValue('B7', 'ภาพรวมการให้บริการทุกประเภท');
if (($_GET['Project']) == 2) {

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C2', 'สาเหตุที่ไม่ส่งสายประเมิน')
            ->setCellValue('B8', 'Press 1')
            ->setCellValue('C8', 'Press 2')
            ->setCellValue('D8', 'Press 3')
            ->setCellValue('E8', '% ความพึงพอใจ');

    $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A7:A8')
            ->mergeCells('B7:E7');

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B9', $Page3Data['score'][1])
            ->setCellValue('C9', $Page3Data['score'][2])
            ->setCellValue('D9', $Page3Data['score'][3])
            ->setCellValue('E9', '=((B9*1)+(C9*0.5)+(D9*0))/J4');
    $objPHPExcel->setActiveSheetIndex(0)->getStyle("E9")
            ->getNumberFormat()->applyFromArray(
            array(
                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
            )
    );
} else if (($_GET['Project']) == 3) {

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', 'สาเหตุที่ไม่ส่งสายประเมิน')
            ->setCellValue('B8', 'พอใจ')
            ->setCellValue('C8', 'ไม่พอใจ')
            ->setCellValue('D8', '% ความพึงพอใจ');

    $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A7:A8')
            ->mergeCells('B7:D7');


    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B9', $Page3Data['score'][1])
            ->setCellValue('C9', $Page3Data['score'][0])
            ->setCellValue('D9', '=((B9*1))/J4');
    $objPHPExcel->setActiveSheetIndex(0)->getStyle("D9")
            ->getNumberFormat()->applyFromArray(
            array(
                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
            )
    );
}




$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A11', 'รายละเอียดสายที่ลูกค้าประเมิน "ไม่พึงพอใจ"')
        ->setCellValue('A12', 'No.')
        ->setCellValue('B12', 'Date')
        ->setCellValue('C12', 'Time')
        ->setCellValue('D12', 'Tel No.')
        ->setCellValue('E12', 'Agent name');
$i = 13;

foreach ($NullValue AS $k => $v) {

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$i", $i - 12)
            ->setCellValue("B$i", $fn->redate($v['DateLeave']))
            ->setCellValue("C$i", $fn->retime($v['time']))
            ->setCellValue("D$i", $v['customernumber'])
            ->setCellValue("E$i", $v['name']);
    $i++;
}





/* * ************* END PAGE 1 ************ */


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
