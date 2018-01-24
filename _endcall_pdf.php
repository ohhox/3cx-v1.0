<?php

include './conf.php';
$fn = new functionx();
$list = $fn->getEndCall();
$project = array();
if ($_GET['Project'] != 'all') {
    $project = $fn->getProject($_GET['Project']);
}
require('./FPDF/fpdf.php');
require('./FPDI/fpdi.php');

$pdf = new FPDI();
$pdf->addPage("P", "A4", '0');
$pdf->AddFont('angsa', '', 'angsa.php');
$pdf->AddFont('angsab', '', 'angsab.php');
$pdf->SetFont('angsa', '', 16);
$pdf->Cell(180, 5, 'End Call Survey Reports', '0', 1, 'C', 0);
$pdf->SetFont('angsa', '', 14);
$pdf->Cell(180, 5, 'DATA DATE: ' . (isset($_GET['date']) ? $_GET['date'] : ''), '0', 1, 'L', 0);
$pdf->Cell(180, 5, 'Project : ' . ( ($_GET['Project'] != 'all') ? $project['Name'] : '.................')
        . ' | DID Number : ' . (isset($_GET['Did']) ? $_GET['Did'] : '.................')
        . ' | Agent Number : ' . (isset($_GET['Agent']) ? $_GET['Agent'] : '.................')
        . ' | Report Type : ' . (isset($_GET['report']) ? (($_GET['report'] == 'sum') ? ' Average Score' . ($_GET['calc'] == 'all' ? ' (With / WithOut Score)' : ' (With Score)') : 'Total Score') : '.................')
        . ' | Rate Score: ' . ((isset($_GET['scorestrat'])) ? $_GET['scorestrat'] : 1 ) . ' - ' . ((isset($_GET['scoreend'])) ? $_GET['scoreend'] : 5)
        , '0', 1, 'L', 0);

$pdf->Cell(180, 5, 'Time Option: ' . (((isset($_GET['timeStart'])) ? $_GET['timeStart'] : 'NULL' ) . " - " . ((isset($_GET['timeEnd'])) ? $_GET['timeEnd'] : 'NULL' ))
        . ' | Customer Number: ' . ((isset($_GET['Cusnum']) && !empty($_GET['Cusnum'])) ? $_GET['Cusnum'] : "..................")
        , '0', 1, 'L', 0);
$pdf->ln();
///-----------------Headder--------------------------------------------------////////////
if (isset($_GET['report']) && !empty($_GET['report']) && $_GET['report'] == 'sum') { // คำนวน
    $pdf->Cell(40, 5, 'Agent Number', 'LT', 0, 'C', 0);
    $pdf->Cell(70, 5, 'Agent Name', 'LT', 0, 'C', 0);
    $pdf->Cell(40, 5, 'DID. (VDN.)', 'LTR', 0, 'C', 0);
    $pdf->Cell(40, 5, 'Score', 'LTR', 0, 'C', 0);

    foreach ($list as $key => $value) {
        $valuex = $fn->ThaiTextToutf($value);
        $pdf->ln();
        $pdf->Cell(40, 5, $value['agent'], 'LT', 0, 'L', 0);  // cell with left and right borders
        $pdf->Cell(70, 5, $valuex['name'] . ' ' . $valuex['lastname'], 'LTR', 0, 'L', 0);
        $pdf->Cell(40, 5, $value['DIDNumber'], 'LTR', 0, 'L', 0);
        $pdf->Cell(40, 5, number_format($value['score'], 2), 'LTR', 0, 'L', 0);
    }
    $pdf->ln();

    $pdf->Cell(40, 5, '', 'T', 0, 'C', 0);  // cell with left and right borders
    $pdf->Cell(40, 5, '', 'T', 0, 'C', 0);
    $pdf->Cell(40, 5, '', 'T', 0, 'C', 0);
    $pdf->Cell(70, 5, '', 'T', 0, 'C', 0);
} else { // ไม่คำนวน
    $pdf->Cell(22, 5, 'Date', 'LT', 0, 'C', 0);   // empty cell with left,top, and right borders
    $pdf->Cell(15, 5, 'Time', 'LT', 0, 'C', 0);
    $pdf->Cell(30, 5, 'Customer Number', 'LT', 0, 'C', 0);
    $pdf->Cell(25, 5, 'Agent Number', 'LT', 0, 'C', 0);
    $pdf->Cell(60, 5, 'Agent Name', 'LT', 0, 'C', 0);
    $pdf->Cell(20, 5, 'DID. (VDN.)', 'LT', 0, 'C', 0);
    $pdf->Cell(15, 5, 'Score', 'LTR', 0, 'C', 0);


    foreach ($list as $key => $value) {
        $valuex = $fn->ThaiTextToutf($value);
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
        $pdf->ln();
        $pdf->Cell(22, 5, $fn->redate($value['DateLeave'], 'No'), 'LT', 0, 'L', 0);   // empty cell with left,top, and right borders
        $pdf->Cell(15, 5, $fn->retime($value['time']), 'LT', 0, 'L', 0);
        $pdf->Cell(30, 5, $value['customernumber'], 'LT', 0, 'L', 0);
        $pdf->Cell(25, 5, $value['agent'], 'LT', 0, 'L', 0);
        $pdf->Cell(60, 5, $valuex['name'] . ' ' . $valuex['lastname'], 'LT', 0, 'L', 0);
        $pdf->Cell(20, 5, $value['DIDNumber'], 'LTR', 0, 'L', 0);
        $pdf->Cell(15, 5, $score, 'LTR', 0, 'L', 0);
    }
    $pdf->ln();
    $pdf->Cell(22, 5, '', 'T', 0, 'C', 0);   // empty cell with left,top, and right borders
    $pdf->Cell(15, 5, '', 'T', 0, 'C', 0);
    $pdf->Cell(30, 5, '', 'T', 0, 'C', 0);
    $pdf->Cell(30, 5, '', 'T', 0, 'C', 0);  // cell with left and right borders
    $pdf->Cell(40, 5, '', 'T', 0, 'C', 0);
    $pdf->Cell(25, 5, '', 'T', 0, 'C', 0);
    $pdf->Cell(25, 5, '', 'T', 0, 'C', 0);
}
$pdf->Output();
