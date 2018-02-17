<?php

include './conf.php';
$fn = new functionx();
$list = $fn->getAuxtime();

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
$pdf->Cell(180, 5, 'Auxiliary Time Reports', '0', 1, 'C', 0);
$pdf->SetFont('angsa', '', 15);
$pdf->Cell(180, 5, 'DATA DATE: ' . (isset($_GET['date']) ? $_GET['date'] : ''), '0', 1, 'L', 0);
$pdf->Cell(180, 5, 'Project : ' . ( ($_GET['Project'] != 'all') ? $project['Name'] : '.................')
        . ' | DID Number : ' . (isset($_GET['Did']) ? $_GET['Did'] : '.................')
        . ' | Queue Number : ' . (isset($_GET['Queue']) ? $_GET['Queue'] : '.................')
        . ' | Time Option : ' . ((isset($_GET['timeOption']) && $_GET['timeOption'] == 'all' ) ? " All Time." : ' Custom Time. (' . $_GET['timeStart'] . ' - ' . $_GET['timeEnd'] . ')')
        , '0', 1, 'L', 0);

$pdf->Cell(180, 5, ''
        . 'Agent Option : ' . ((isset($_GET['agentOption']) && $_GET['agentOption'] == 'name' ) ? " Agent Name : ({$_GET['Cusnum']})" : ' Agent Number. (' . $_GET['Agent'] . ')')
        . ' |  Auxiliary Number : ' . ((isset($_GET['aux']) && $_GET['aux'] == 'all' ) ? " ALL " : $_GET['aux'] )
        , '0', 1, 'L', 0);
$pdf->ln();
///-----------------Headder--------------------------------------------------////////////
$pdf->Cell(10, 5, 'NO.', 'LT', 0, 'C', 0);
$pdf->Cell(20, 5, 'Date', 'LT', 0, 'C', 0);   // empty cell with left,top, and right borders
$pdf->Cell(15, 5, 'Time', 'LT', 0, 'C', 0);
$pdf->Cell(22, 5, 'Agent Number', 'LT', 0, 'C', 0);
$pdf->Cell(60, 5, 'Agent Name', 'LT', 0, 'C', 0);  // cell with left and right borders
$pdf->Cell(20, 5, 'Line In / out', 'LT', 0, 'C', 0);
$pdf->Cell(20, 5, 'Aux Number', 'LTR', 0, 'C', 0);
$pdf->Cell(25, 5, 'Aux Description', 'LTR', 0, 'C', 0);

$i = 1;
$page = 1;
$count = 1;
foreach ($list as $key => $value) {
    $pdf->ln();
    $valuex = $fn->ThaiTextToutf($value);

    $pdf->Cell(10, 5, $i++, 'LT', 0, 'L', 0);
    $pdf->Cell(20, 5, $fn->redate($value['date']), 'LT', 0, 'L', 0);   // empty cell with left,top, and right borders
    $pdf->Cell(15, 5, $fn->retime($value['TimeAux']), 'LT', 0, 'L', 0);
    $pdf->Cell(22, 5, $value['Agent'], 'LT', 0, 'L', 0);
    $pdf->Cell(60, 5, $valuex['name'] . ' ' . $valuex['lastname'], 'LT', 0, 'L', 0);  // cell with left and right borders
    $pdf->Cell(20, 5, $value['Loginout'], 'LT', 0, 'L', 0);
    $pdf->Cell(20, 5, $value['AuxNum'], 'LTR', 0, 'L', 0);
    $pdf->Cell(25, 5, $value['AuxDes'], 'LTR', 0, 'L', 0);
    $count++;
    if (($count == 47 && $page == 1) || ($count == 53 && $page > 1)) {
        $count = 1;
        $page++;
        $pdf->ln();
        $pdf->Cell(10, 5, '', 'T', 0, 'C', 0);
        $pdf->Cell(25, 5, '', 'T', 0, 'C', 0);   // empty cell with left,top, and right borders
        $pdf->Cell(25, 5, '', 'T', 0, 'C', 0);
        $pdf->Cell(25, 5, '', 'T', 0, 'C', 0);
        $pdf->Cell(25, 5, '', 'T', 0, 'C', 0);  // cell with left and right borders
        $pdf->Cell(25, 5, '', 'T', 0, 'C', 0);
        $pdf->Cell(57, 5, '', 'T', 0, 'C', 0);
    }
}
$pdf->ln();
$pdf->Cell(10, 5, '', 'T', 0, 'C', 0);
$pdf->Cell(25, 5, '', 'T', 0, 'C', 0);   // empty cell with left,top, and right borders
$pdf->Cell(25, 5, '', 'T', 0, 'C', 0);
$pdf->Cell(25, 5, '', 'T', 0, 'C', 0);
$pdf->Cell(25, 5, '', 'T', 0, 'C', 0);  // cell with left and right borders
$pdf->Cell(25, 5, '', 'T', 0, 'C', 0);
$pdf->Cell(57, 5, '', 'T', 0, 'C', 0);
$pdf->Output();
