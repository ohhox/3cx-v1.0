<?php

include './conf.php';
$fn = new functionx();
$list = $fn->getCallBack();

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
        . ' | Queue Number : ' . (isset($_GET['Queue']) ? $_GET['Queue'] : '.................')
        . ' | DayOrNight : ' . (isset($_GET['DayOrNight']) ? $fn->dayNight[$_GET['DayOrNight']] : '................')
        . ' | Only Leave Number: ' . (isset($_GET['Leave']) ? "Yes" : "NO" )
        , '0', 1, 'L', 0);
$pdf->ln();
///-----------------Headder--------------------------------------------------////////////

$pdf->Cell(30, 5, 'Date', 'LT', 0, 'C', 0);   // empty cell with left,top, and right borders
$pdf->Cell(30, 5, 'Time', 'LT', 0, 'C', 0);
$pdf->Cell(30, 5, 'Call Number', 'LT', 0, 'C', 0);
$pdf->Cell(30, 5, 'Leave Number', 'LT', 0, 'C', 0);  // cell with left and right borders
$pdf->Cell(30, 5, 'Queue Number', 'LT', 0, 'C', 0);
$pdf->Cell(30, 5, 'DID(VDN)', 'LTR', 0, 'C', 0);

foreach ($list as $key => $value) {
    $pdf->ln();
    $pdf->Cell(30, 5, $fn->redate($value['DateLeave']), 'LT', 0, 'L', 0);   // empty cell with left,top, and right borders
    $pdf->Cell(30, 5, $fn->retime($value['TimeLeave']), 'LT', 0, 'L', 0);
    $pdf->Cell(30, 5, $value['CallNum'], 'LT', 0, 'L', 0);
    $pdf->Cell(30, 5, $value['LeaveNum'], 'LT', 0, 'L', 0);  // cell with left and right borders
    $pdf->Cell(30, 5, $value['FromQueue'], 'LT', 0, 'C', 0);
    $pdf->Cell(30, 5, $value['Project'], 'LTR', 0, 'C', 0);
}
$pdf->ln();
$pdf->Cell(30, 5, '', 'T', 0, 'C', 0);   // empty cell with left,top, and right borders
$pdf->Cell(30, 5, '', 'T', 0, 'C', 0);
$pdf->Cell(30, 5, '', 'T', 0, 'C', 0);
$pdf->Cell(30, 5, '', 'T', 0, 'C', 0);  // cell with left and right borders
$pdf->Cell(30, 5, '', 'T', 0, 'C', 0);
$pdf->Cell(30, 5, '', 'T', 0, 'C', 0);
$pdf->Output();
