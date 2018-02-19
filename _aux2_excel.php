<?php

include './conf.php';
$fn = new functionx();
$project = array();
if ($_GET['Project'] != 'all') {
    $project = $fn->getProject($_GET['Project']);
}

if (isset($_GET['date']) && !empty($_GET['date'])) {
    $date = explode('-', $_GET['date']);

    $stardate = trim($date[2]) . '-' . $date[1] . '-' . $date[0];
    $enddate = trim($date[5]) . '-' . $date[4] . '-' . ltrim(trim($date[3]));
} else {
    $enddate = $stardate = date('Y-m-d');
}
$list = $fn->getAuxtime2();

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once 'Classes/PHPExcel.php';
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();


$begin = new DateTime($stardate);
$end = new DateTime($enddate);

// --------------------------------- BEGIN SHEET 0 ----------------------------
$objPHPExcel->createSheet(0)->setTitle("Summary ");
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Auxiliary Time Report')
        ->setCellValue('A2', 'Date Rang : ' . ( isset($_GET['date']) ? $_GET['date'] : ''))
        ->setCellValue('A3', 'Project')->setCellValue('B3', !empty($project) ? $project['Name'] : '' )
        ->setCellValue('A4', 'DID Number')->setCellValue('B4', isset($_GET['Did']) ? $_GET['Did'] : '' )
        ->setCellValue('A5', 'Queue Number')->setCellValue('B5', isset($_GET['Queue']) ? $_GET['Queue'] : '' )
        ->setCellValue('A6', 'Time Option')->setCellValue('B6', (isset($_GET['timeOption']) && $_GET['timeOption'] == 'all' ) ? " All Time." : ' Custom Time. (' . $_GET['timeStart'] . ' - ' . $_GET['timeEnd'] . ')' )
        ->setCellValue('A7', 'Agent Option ')->setCellValue('B7', (isset($_GET['agentOption']) && $_GET['agentOption'] == 'name' ) ? " Agent Name : ({$_GET['Cusnum']})" : ' Agent Number. (' . $_GET['Agent'] . ')')
        ->setCellValue('A8', 'Auxiliary Number ')->setCellValue('B8', (isset($_GET['aux']) && $_GET['aux'] == 'all' ) ? " ALL " : $_GET['aux'] );


$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A11', 'NO.')
        ->setCellValue('B11', 'Agent')
        ->setCellValue('C11', 'Staff Time')
        ->setCellValue('D11', 'Total Available')
        ->setCellValue('E11', 'Total Wrap')
        ->setCellValue('F11', 'Total Aux Time')
        ->setCellValue('G11', 'Coaching')
        ->setCellValue('H11', 'Contact Person')
        ->setCellValue('I11', 'Computer Down')
        ->setCellValue('J11', 'Restroom')
        ->setCellValue('K11', 'Call out')
        ->setCellValue('L11', 'Audit')
        ->setCellValue('M11', 'Follow Up Case')
        ->setCellValue('N11', 'Lunch')
        ->setCellValue('O11', 'Email')
        ->setCellValue('P11', 'Undefined AuxTime');
$row = 12;
$countrow = 1;
foreach ($list AS $key => $value) {
    $TTwrap = $value['Coaching'] + $value['Contact Person'] + $value['Computer Down'] + $value['Restroom'] + $value['Call out'] + $value['Audit'] + $value['Follow Up Case'] + $value['Lunch'] + $value['Email'];
    $valuex = $fn->ThaiTextToutf($value);

    $tttime = ($value['Available'] + $value['Wrap'] + $TTwrap );
    if ($tttime > 0) {
        // $tttime = $tttime - 3600;
    }

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $row, $countrow++)
            ->setCellValue('B' . $row, $valuex['Agent'])
            ->setCellValue('C' . $row, $fn->calcDate($tttime))
            ->setCellValue('D' . $row, !empty($valuex['Available']) ? $fn->calcDate($valuex['Available']) : '00:00:00' )
            ->setCellValue('E' . $row, !empty($valuex['Wrap']) ? $fn->calcDate($valuex['Wrap']) : '00:00:00')
            ->setCellValue('F' . $row, $fn->calcDate($TTwrap))
            ->setCellValue('G' . $row, !empty($valuex['Coaching']) ? $fn->calcDate($valuex['Coaching']) : '00:00:00' )
            ->setCellValue('H' . $row, !empty($valuex['Contact Person']) ? $fn->calcDate($valuex['Contact Person']) : '00:00:00')
            ->setCellValue('I' . $row, !empty($valuex['Computer Down']) ? $fn->calcDate($valuex['Computer Down']) : '00:00:00')
            ->setCellValue('J' . $row, !empty($valuex['Restroom']) ? $fn->calcDate($valuex['Restroom']) : '00:00:00')
            ->setCellValue('K' . $row, !empty($valuex['Call out']) ? $fn->calcDate($valuex['Call out']) : '00:00:00')
            ->setCellValue('L' . $row, !empty($valuex['Audit']) ? $fn->calcDate($valuex['Audit']) : '00:00:00')
            ->setCellValue('M' . $row, !empty($valuex['Follow Up Case']) ? $fn->calcDate($valuex['Follow Up Case']) : '00:00:00')
            ->setCellValue('N' . $row, !empty($valuex['Lunch']) ? $fn->calcDate($valuex['Lunch']) : '00:00:00')
            ->setCellValue('O' . $row, !empty($valuex['Email']) ? $fn->calcDate($valuex['Email']) : '00:00:00')
            ->setCellValue('P' . $row, !empty($valuex['Undefined AuxTime']) ? $fn->calcDate($valuex['Undefined AuxTime']) : '00:00:00');

    $row++;
}
// --------------------------------- END SHEET 0 ----------------------------


$count = 1;
$begin = new DateTime($stardate);
$end = new DateTime($enddate);

for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
    $today = $i->format('Y-m-d');
    $objPHPExcel->createSheet($count)->setTitle($today);
    $objPHPExcel->setActiveSheetIndex($count)
            ->setCellValue('A1', 'Date Of Result. ' . $today)
            ->setCellValue('A2', 'NO.')
            ->setCellValue('B2', 'Agent')
            ->setCellValue('C2', 'Staff Time')
            ->setCellValue('D2', 'Total Available')
            ->setCellValue('E2', 'Total Wrap')
            ->setCellValue('F2', 'Total Aux Time')
            ->setCellValue('G2', 'Coaching')
            ->setCellValue('H2', 'Contact Person')
            ->setCellValue('I2', 'Computer Down')
            ->setCellValue('J2', 'Restroom')
            ->setCellValue('K2', 'Call out')
            ->setCellValue('L2', 'Audit')
            ->setCellValue('M2', 'Follow Up Case')
            ->setCellValue('N2', 'Lunch')
            ->setCellValue('O2', 'Email')
            ->setCellValue('P2', 'Undefined AuxTime');

    $row = 3;
    $countrow = 1;
    foreach ($list AS $k => $v) {

        $sql = "SELECT   Agent, [Available], [Wrap], [Restroom], [Email], [Lunch] ,[Call out],[Follow Up Case],[Coaching],[Contact Person],[Audit],[Computer Down],
                 ([Available]+[Wrap]+[Restroom]+ [Email] + [Lunch] +[Call out]+[Follow Up Case]+[Coaching]+[Contact Person]+[Audit]+[Computer Down]) AS AllTime , 
                  ([Restroom]+ [Email] + [Lunch] +[Call out]+[Follow Up Case]+[Coaching]+[Contact Person]+[Audit]+[Computer Down]) AS AllAux,[login]
		FROM   
		(
			SELECT Agent, AuxDes, (
             ( DATEPART(hh, AuxDuration) * 3600 ) +
             ( DATEPART(mi, AuxDuration) * 60 ) +
               DATEPART(ss, AuxDuration)
          )    AS AuxDuration 
			FROM [dbo].[AuxTime]
			WHERE DATEADD(year,-543,convert(date,DateAux)) = '$today' and Agent = '{$v['Agent']}'

		) UP
		PIVOT
		(
   			SUM(AuxDuration)
			FOR AuxDes IN ([Available], [Wrap], [Restroom], [Email], [Lunch] ,[Call out],[Follow Up Case],[Coaching],[Contact Person],[Audit],[Computer Down],[login])
		) AS P";


        $value = $fn->query($sql);
        if (!empty($value))
            $value = $value[0];


        @$TTwrap = $value['Coaching'] + $value['Contact Person'] + $value['Computer Down'] + $value['Restroom'] + $value['Call out'] + $value['Audit'] + $value['Follow Up Case'] + $value['Lunch'] + $value['Email'];
        @$valuex = $fn->ThaiTextToutf($value);

        @$tttime = ($value['Available'] + $value['Wrap'] + $TTwrap );
        if ($tttime > 0) {
            //  $tttime = $tttime - 3600;
        }

        $objPHPExcel->setActiveSheetIndex($count)
                ->setCellValue('A' . $row, $countrow++)
                ->setCellValue('B' . $row, $v['Agent'])
                ->setCellValue('C' . $row, $fn->calcDate($tttime))
                ->setCellValue('D' . $row, !empty($valuex['Available']) ? $fn->calcDate($valuex['Available']) : '00:00:00' )
                ->setCellValue('E' . $row, !empty($valuex['Wrap']) ? $fn->calcDate($valuex['Wrap']) : '00:00:00')
                ->setCellValue('F' . $row, $fn->calcDate($TTwrap))
                ->setCellValue('G' . $row, !empty($valuex['Coaching']) ? $fn->calcDate($valuex['Coaching']) : '00:00:00' )
                ->setCellValue('H' . $row, !empty($valuex['Contact Person']) ? $fn->calcDate($valuex['Contact Person']) : '00:00:00')
                ->setCellValue('I' . $row, !empty($valuex['Computer Down']) ? $fn->calcDate($valuex['Computer Down']) : '00:00:00')
                ->setCellValue('J' . $row, !empty($valuex['Restroom']) ? $fn->calcDate($valuex['Restroom']) : '00:00:00')
                ->setCellValue('K' . $row, !empty($valuex['Call out']) ? $fn->calcDate($valuex['Call out']) : '00:00:00')
                ->setCellValue('L' . $row, !empty($valuex['Audit']) ? $fn->calcDate($valuex['Audit']) : '00:00:00')
                ->setCellValue('M' . $row, !empty($valuex['Follow Up Case']) ? $fn->calcDate($valuex['Follow Up Case']) : '00:00:00')
                ->setCellValue('N' . $row, !empty($valuex['Lunch']) ? $fn->calcDate($valuex['Lunch']) : '00:00:00')
                ->setCellValue('O' . $row, !empty($valuex['Email']) ? $fn->calcDate($valuex['Email']) : '00:00:00')
                ->setCellValue('P' . $row, !empty($valuex['Undefined AuxTime']) ? $fn->calcDate($valuex['Undefined AuxTime']) : '00:00:00');

        $row++;
    }
    $count++;
}


// Redirect output to a clientâ€™s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Auxiliary Time Report.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 10, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 110107 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . $fn->calcDate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
