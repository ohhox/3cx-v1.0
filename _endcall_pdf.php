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
$pdf->Cell(180, 5, 'Report Call Back', '0', 1, 'C', 0);
$pdf->SetFont('angsa', '', 14);
$pdf->Cell(180, 5, 'DATA DATE: ' . (isset($_GET['date']) ? $_GET['date'] : ''), '0', 1, 'L', 0);
$pdf->Cell(180, 5, 'Project : ' . ( ($_GET['Project'] != 'all') ? $project['Name'] : '.................')
        . ' | Did Number : ' . (isset($_GET['Did']) ? $_GET['Did'] : '.................')
        . ' | Agent Number : ' . (isset($_GET['Agent']) ? $_GET['Agent'] : '.................')
        //  . ' | Queue Number : ' . (isset($_GET['Queue']) ? $_GET['Queue'] : '.................')
        . ' | report Type : ' . (isset($_GET['report']) ? (($_GET['report'] == 'sum')? ' Average Score' : 'Total Score') : '.................')
        
        . ' | Rate Score: ' . ((isset($_GET['scorestrat'])) ? $_GET['scorestrat'] : 1 ) . ' - ' . ((isset($_GET['scoreend'])) ? $_GET['scoreend'] : 5)
        , '0', 1, 'L', 0);
$pdf->ln();
///-----------------Headder--------------------------------------------------////////////
if (isset($_GET['report']) && !empty($_GET['report']) && $_GET['report'] == 'sum') {

    $pdf->Cell(60, 5, 'Agent Number', 'LT', 0, 'C', 0);
    $pdf->Cell(60, 5, 'DID(VDN)', 'LTR', 0, 'C', 0);
    $pdf->Cell(60, 5, 'Score', 'LTR', 0, 'C', 0);
    foreach ($list as $key => $value) {
        $pdf->ln();

        $pdf->Cell(60, 5, $value['agent'], 'LT', 0, 'C', 0);  // cell with left and right borders
        $pdf->Cell(60, 5, $value['DIDNumber'], 'LTR', 0, 'C', 0);
        $pdf->Cell(60, 5,  number_format($value['score'],2), 'LTR', 0, 'C', 0);
    }
    $pdf->ln();

    $pdf->Cell(60, 5, '', 'T', 0, 'C', 0);  // cell with left and right borders
    $pdf->Cell(60, 5, '', 'T', 0, 'C', 0);
    $pdf->Cell(60, 5, '', 'T', 0, 'C', 0);
} else {
    $pdf->Cell(30, 5, 'Date', 'LT', 0, 'C', 0);   // empty cell with left,top, and right borders
    $pdf->Cell(30, 5, 'Time', 'LT', 0, 'C', 0);
    $pdf->Cell(30, 5, 'Customer Number', 'LT', 0, 'C', 0);
    $pdf->Cell(30, 5, 'Agent Number', 'LT', 0, 'C', 0);
    $pdf->Cell(30, 5, 'DID(VDN)', 'LTR', 0, 'C', 0);
    $pdf->Cell(30, 5, 'Score', 'LT', 0, 'C', 0);


    foreach ($list as $key => $value) {
        $pdf->ln();
        $pdf->Cell(30, 5, $fn->redate($value['DateLeave']), 'LT', 0, 'L', 0);   // empty cell with left,top, and right borders
        $pdf->Cell(30, 5, $fn->retime($value['time']), 'LT', 0, 'L', 0);
        $pdf->Cell(30, 5, $value['customernumber'], 'LT', 0, 'L', 0);
        $pdf->Cell(30, 5, $value['agent'], 'LT', 0, 'L', 0);  // cell with left and right borders
        $pdf->Cell(30, 5, $value['DIDNumber'], 'LTR', 0, 'C', 0);
        $pdf->Cell(30, 5, number_format($value['score'],2), 'LT', 0, 'C', 0);
    }
    $pdf->ln();
    $pdf->Cell(30, 5, '', 'T', 0, 'C', 0);   // empty cell with left,top, and right borders
    $pdf->Cell(30, 5, '', 'T', 0, 'C', 0);
    $pdf->Cell(30, 5, '', 'T', 0, 'C', 0);
    $pdf->Cell(30, 5, '', 'T', 0, 'C', 0);  // cell with left and right borders
    $pdf->Cell(30, 5, '', 'T', 0, 'C', 0);
    $pdf->Cell(30, 5, '', 'T', 0, 'C', 0);
}
$pdf->Output();
