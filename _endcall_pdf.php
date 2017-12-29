<?php

include './conf.php';
$fn = new functionx();
$list = $fn->getEndCall();

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
$pdf->Cell(180, 5, 'Project : ' . (isset($_GET['Project']) ? $_GET['Project'] : '.................')
        . ' | Agent Number : ' . (isset($_GET['Agent']) ? $_GET['Agent'] : '.................')
        . ' | Queue Number : ' . (isset($_GET['Queue']) ? $_GET['Queue'] : '.................')
        . ' | Rate Score: ' . ((isset($_GET['scorestrat'])) ? $_GET['scorestrat'] : 1 ) . ' - ' . ((isset($_GET['scoreend'])) ? $_GET['scoreend'] : 5)
        , '0', 1, 'L', 0);
$pdf->ln();
///-----------------Headder--------------------------------------------------////////////

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
    $pdf->Cell(30, 5, $value['score'], 'LT', 0, 'C', 0);    
    
}
$pdf->ln();
$pdf->Cell(30, 5, '', 'T', 0, 'C', 0);   // empty cell with left,top, and right borders
$pdf->Cell(30, 5, '', 'T', 0, 'C', 0);
$pdf->Cell(30, 5, '', 'T', 0, 'C', 0);
$pdf->Cell(30, 5, '', 'T', 0, 'C', 0);  // cell with left and right borders
$pdf->Cell(30, 5, '', 'T', 0, 'C', 0);
$pdf->Cell(30, 5, '', 'T', 0, 'C', 0);
$pdf->Output();
