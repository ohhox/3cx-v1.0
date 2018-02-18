<?php
include './conf.php';
$fn = new functionx();
$list = $fn->getAuxtime2();


$project = $fn->getProjectList();
$thisProject = "";

$projectId = "";
$DIDID = "";
$QueuesID = "";
if (isset($_GET['Project'])) {
    $projectId = $_GET['Project'];
    $thisProject = $fn->getProject($_GET['Project']);
}
if (isset($_GET['Did'])) {
    $DIDID = $_GET['Did'];
}
if (isset($_GET['Queue'])) {
    $QueuesID = $_GET['Queue'];
}
$wh = $fn->getWorkhoursX($projectId, $DIDID, $QueuesID);
if (!empty($projectId)) {
    $agent = $fn->getAgentForProjectDID($projectId, $DIDID, $QueuesID);
} else {
    $agent = array();
}


$did = array();
$Queue = array();
if (isset($_GET['Project']) && $_GET['Project'] != 'all') {

    $did = $fn->getDid($_GET['Project']);
}
if (isset($_GET['Did']) && $_GET['Did'] != 'all') {
    $Queue = $fn->getQueue($_GET['Did']);
}
if (isset($_GET['date']) && !empty($_GET['date'])) {
    $date = explode('-', $_GET['date']);

    $d = array(
        '1' => $date[0] . '-' . $date[1] . '-' . trim($date[2]),
        '2' => $date[3] . '-' . $date[4] . '-' . trim($date[5]),
    );
} else {
    $d = array(
        '1' => date('d-m-Y'),
        '2' => date('d-m-Y'),
    );
}

$AuxType = $fn->getAuxType();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>3CX WEB REPORT SYSTEM.</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="all,follow">
        <!-- Bootstrap CSS-->
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome CSS-->
        <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
        <!-- Custom icon font-->
        <link rel="stylesheet" href="css/fontastic.css">
        <!-- Google fonts - Roboto -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
        <!-- jQuery Circle-->
        <link rel="stylesheet" href="css/grasp_mobile_progress_circle-1.0.0.min.css">
        <!-- Custom Scrollbar-->
        <link rel="stylesheet" href="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
        <!-- theme stylesheet-->
        <link rel="stylesheet" href="node_modules/timepicker/jquery.timepicker.min.css">
        <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
        <!-- Custom stylesheet - for your changes-->

        <!-- Favicon-->
        <link rel="shortcut icon" href="favicon.png">
        <link rel="stylesheet" href="css/radioStyle.css">
        <link rel="stylesheet" href="css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="bootstrap-daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="css/custom.css">
    </head>
    <body data-active="Auxtime2"  style="overflow: auto;">
        <?php include './_sidebar.php'; ?>
        <div class="page home-page">
            <!-- navbar-->
            <?php include './_head.php'; ?>    
            <div class="breadcrumb-holder">   
                <div class="container-fluid">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Report Auxiliary Time</li>
                    </ul>
                </div>
            </div>

            <section class="charts">
                <div class="container-fluid" id="MainPosion">
                    <header id="formSearc"  > 
                        <h1 class="h3">Auxilary Time Report</h1>
                        <form id="Sform">
                            <div class="row">

                                <div class="col-md-3">
                                    <label>Date Rang</label>
                                    <input type="text" class="form-control" id="date" name="date">
                                </div>

                                <div class="col-md-3">
                                    <label>Project</label>
                                    <select class=" form-control" name="Project" id="Project">
                                        <option value="all">ALL</option>
                                        <?php
                                        foreach ($project AS $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['ProjectID']; ?>" <?= @($_GET['Project'] == $value['ProjectID']) ? 'selected' : '0' ?>> 
                                                <?php echo $value['Name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <div id="AllertMage"></div>
                                </div>
                                <div class="col-md-3">
                                    <label>DID. (VDN.)</label>
                                    <select class=" form-control" name="Did" id="Did" >
                                        <option value="all">ALL</option>
                                        <?php
                                        foreach ($did AS $key => $value) {
                                            ?>
                                            <option data-status="remove" value="<?php echo $value['DIDNumber']; ?>" <?= @($_GET['Did'] == $value['DIDNumber']) ? 'selected' : '0' ?>> 
                                                <?php echo $value['DIDNumber']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <div id="AllertMage2"></div>
                                </div>
                                <div class="col-md-3">
                                    <label>Queue Number</label>
                                    <select class=" form-control" name="Queue" id="Queue" >
                                        <option value="all">ALL</option>
                                        <?php
                                        foreach ($Queue AS $key => $value) {
                                            ?>
                                            <option data-status="remove"  value="<?php echo $value['QueueNumber']; ?>" <?= @($_GET['Queue'] == $value['QueueNumber']) ? 'selected' : '0' ?>> 
                                                <?php echo $value['QueueNumber']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>      
                                <div class="col-md-3" >
                                    <label>Time Option. </label> 
                                    <div > 
                                        <div>
                                            <label style="margin-left: 25px;margin-bottom: 5px;">
                                                <input type="radio" class="timeCheck" name="timeOption" value="all" <?php echo (isset($_GET['timeOption']) && $_GET['timeOption'] == 'all') ? 'checked' : ((!isset($_GET['timeOption'])) ? 'checked' : '0') ?> > All Time.                                            
                                            </label>
                                        </div>
                                        <!--                                        <label style="margin-left: 25px;margin-bottom: 5px;">
                                                                                    <input type="radio" class="timeCheck" id="whTime" checkDid="<?= empty($wh) ? 'No' : 'Yes' ?>" name="timeOption" value="workHours" 
                                        <?php echo (isset($_GET['timeOption']) && $_GET['timeOption'] == 'workHours') ? 'checked' : "" ?> > Work Hours <span id="QnumberaAlert" class="errorMsg  text-danger"></span>
                                                                                    <div  style="display: flex;flex-direction: row;flex: 1;justify-content: flex-start;align-items: stretch;">
                                                                                        <div class="timeRate">
                                                                                            <span>Begin<br/> <input type="text" readonly id="whStart" name="whs" class="form-control TimeSelectBox workhours" value="<?= (isset($_GET['whs']) && !empty($_GET['whs'])) ? $_GET['whs'] : (!empty($wh) ? $wh['timeStart'] : '00:00') ?>"  ></span>
                                                                                        </div>
                                                                                        <div class="timeRate">
                                                                                            <span>End<br/> <input type="text" readonly id="whend" name="whe" class="form-control TimeSelectBox workhours"  value="<?= (isset($_GET['whe']) && !empty($_GET['whe'])) ? $_GET['whe'] : (!empty($wh) ? $wh['timeEnd'] : '00:00') ?>"  ></span>
                                                                                        </div>
                                                                                    </div> 
                                                                                </label>-->

                                        <label style="margin-left: 25px;margin-bottom: 5px;">
                                            <input class="timeCheck" type="radio" name="timeOption" value="Custom" <?php echo (isset($_GET['timeOption']) && $_GET['timeOption'] == 'Custom') ? 'checked' : "" ?> > Custom Time.
                                            <div  style="display: flex;flex-direction: row;flex: 1;justify-content: flex-start;align-items: stretch;">
                                                <div class="timeRate">
                                                    <span>Begin<br/> <input type="text" id="timeStart" name="timeStart" value="<?= (isset($_GET['timeStart']) && !empty($_GET['timeStart'])) ? $_GET['timeStart'] : '00:00' ?>" class="form-control TimeSelectBox" ></span>
                                                </div>
                                                <div class="timeRate">
                                                    <span>End<br/> <input type="text" id="timeEnd" name="timeEnd" value="<?= (isset($_GET['timeEnd']) && !empty($_GET['timeEnd'])) ? $_GET['timeEnd'] : '23:59' ?>"  class="form-control TimeSelectBox" ></span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                </div>

                               <div class="col-md-3">   
                                    <label>Agent  Option. </label>    
                                    <div style="display: flex;flex-direction: column;flex: 1;justify-content: flex-start;align-items: stretch;"> 
                                        <label style="margin-left: 25px;margin-bottom: 5px;">
                                            <input class="AgentCheck" type="radio" name="agentOption" value="number" <?php echo (isset($_GET['agentOption']) && $_GET['agentOption'] == 'number') ? 'checked' : ((!isset($_GET['agentOption'])) ? 'checked' : '') ?> > Agent  Number
                                            <div class="Padding-left20">
                                                <select class=" form-control" name="Agent" id="Agent" <?= (isset($_GET['agentOption']) && $_GET['agentOption'] == 'name' )   ? 'disabled' : '' ?>>
                                                    <option value="all">ALL</option>
                                                    <?php
                                                    foreach ($agent AS $key => $value) {
                                                        ?>
                                                        <option data-status='remove' value="<?php echo $value['agent_code']; ?>" <?= @($_GET['Agent'] == $value['agent_code']) ? 'selected' : '' ?>>  <?php echo $value['agent_code']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </label>
                                        <label style="margin-left: 25px;margin-bottom: 5px;">
                                            <input type="radio" class="AgentCheck" name="agentOption" value="name" <?php echo (isset($_GET['agentOption']) && $_GET['agentOption'] == 'name') ? 'checked' : '' ?> > Agent Name
                                            <div class="Padding-left20"> 
                                                <input id="AgentName" type="text" name="Cusnum"  placeholder="Agent Name" class="form-control" value="<?= (isset($_GET['Cusnum'])) ? $_GET['Cusnum'] : "" ?>" <?= isset($_GET['agentOption']) && $_GET['agentOption'] == 'name' || ((!isset($_GET['agentOption'])) ? 'checked' : '') ? 'disabled' : '' ?>>
                                            </div>
                                        </label>
                                        
                                    </div> 
                                </div>  
                                <div class="col-md-3">
                                    <label>Auxilary  Type</label>
                                    <select class=" form-control" name="aux" id="Queue" >
                                        <option value="all">ALL</option>
                                        <?php
                                        foreach ($AuxType AS $key => $value) {
                                            $valuex = $fn->ThaiTextToutf($value);
                                            ?>
                                            <option data-status="remove"  value="<?php echo $value['aux_number']; ?>" <?= @($_GET['aux'] == $value['aux_number']) ? 'selected' : '0' ?>> 
                                                <?php echo $value['aux_number']; ?> : <?php echo $valuex['aux_description']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    Total Work Hours : <span id="TotalWH">.......</span> <br/>
                                    Total Lunch Hours : <span id="TotalLH">......</span>
                                </div>
                                <div class="col-md-12" style="height: 0px;margin: 0px;"> 
                                    <div class="btn-group   pull-right" role="group" aria-label="Button group with nested dropdown" style="margin-right:30px;margin-top:-65px;">
                                        <button type="submit" class="btn btn-primary btn-lg">Generate</button>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Export
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
<!--                                                <a class="dropdown-item extranalLink"  href="_callback_excel.php"><i class="fa fa-file-excel-o"></i> Excel</a>
                                                <a class="dropdown-item extranalLink" href="_callback_pdf.php"><i class="fa fa-file-pdf-o"></i> PDF</a>
                                                <a class="dropdown-item extranalLink" href="_callback_print.php"><i class="fa fa-print"></i> Print</a>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </header> 
                    <div class="row" id="DetailPabel"> 
                        <div class=" col-12">                             
                            <div class="">
                                <table class="table table-bordered table-hover" id="tablex">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class=" ">No.</th>
                                            <th rowspan="2" class="">Agent</th>
                                            <th rowspan="2" class="bg-successP2y">Staff Time</th>
                                            <th rowspan="2" class="">Total Available</th>
                                            <th rowspan="2" class="">Total Wrap</th>
                                            <th rowspan="2" class="bg-successP2y">Total Aux Time</th>
                                            <th colspan="9" class=" text-center">Aux Time</th>
                                            <th rowspan="2" class="bg-successP2y">Undefined AuxTime</th>
                                        </tr>
                                        <tr>
                                            <th class="">Coaching</th>
                                            <th class="">Contact Person</th>
                                            <th class="">Computer Down</th>
                                            <th class="">Restroom</th> 
                                            <th class="">Call out</th> 
                                            <th class="">Audit</th> 
                                            <th class="">Follow Up Case</th> 
                                            <th class="">Lunch</th> 
                                            <th class="">Email</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $array = array(
                                            'Coaching', 'Contact Person', 'Computer Down', 'Restroom', 'Call out',
                                            'Audit', 'Follow Up Case', 'Lunch', 'Email'
                                        );
                                        foreach ($list AS $key => $value) {
                                            $TTwrap = $value['Coaching'] + $value['Contact Person'] + $value['Computer Down'] + $value['Restroom'] + $value['Call out'] + $value['Audit'] + $value['Follow Up Case'] + $value['Lunch'] + $value['Email'];
                                            $valuex = $fn->ThaiTextToutf($value);

                                            $tttime = ($value['Available'] + $value['Wrap'] + $TTwrap );
                                            if ($tttime > 0) {
                                                $tttime = $tttime - 3600;
                                            }
                                            ?>
                                            <tr>
                                                <td scope="row"><?= $i++ ?></td>                                            
                                                <td ><?= $value['Agent']; ?></td>
                                                <td class="bg-successP2y"><?= gmdate("H:i:s", $tttime); ?></td>
                                                <td><?= !empty($valuex['Available']) ? gmdate("H:i:s", $valuex['Available']) : '00:00:00' ?></td>
                                                <td><?= !empty($valuex['Wrap']) ? gmdate("H:i:s", $valuex['Wrap']) : '00:00:00' ?></td>
                                                <td class="bg-successP2y"><?= gmdate("H:i:s", $TTwrap); ?></td>
                                                <?php
                                                foreach ($array as $k => $v) {
                                                    ?>
                                                    <td><?= !empty($valuex[$v]) ? gmdate("H:i:s", $valuex[$v]) : '00:00:00' ?></td> 
                                                    <?php
                                                }
                                                ?>
                                                <td class="bg-successP2y">
                                                    <?= !empty($valuex['login']) ? gmdate("H:i:s", $valuex['login']) : '00:00:00' ?> 
                                                </td>


                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php include './_foot.php'; ?>   

        </div>
        <!-- Javascript files-->
        <script src="js/jquery-3.2.1.min.js"></script> 
        <script src="js/popper.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script> 
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="bootstrap-daterangepicker/moment.min.js"></script>
        <script src="bootstrap-daterangepicker/daterangepicker.js"></script>
        <script src="node_modules/timepicker/jquery.timepicker.min.js"></script> 
        <script src="js/front.js"></script>
        <script src="js/auxTime.js"></script>
        <script src="js/customs.js"></script>
        <script src="js/endcal.js"></script>
        <script>

            $(function () {
                $('#timeStart,#timeEnd').timepicker({'timeFormat': 'H:i', show2400: true});
                $('#date').daterangepicker({
                    locale: {
                        format: 'DD-MM-YYYY'
                    },
                    "alwaysShowCalendars": true,
                    "startDate": "<?php echo $d[1]; ?>",
                    "endDate": "<?php echo $d[2]; ?>",

                    "ranges": {
                        "Today": [
                            "<?php echo date('d-m-Y') ?>",
                            "<?php echo date('d-m-Y') ?>"
                        ],
                        "Yesterday": [
                            "<?php echo date('d-m-Y', strtotime("-1 day")) ?>",
                            "<?php echo date('d-m-Y', strtotime("-1 day")) ?>"
                        ],
                        "Last 7 Days": [
                            "<?php echo date('d-m-Y', strtotime("-1 week +1 day")) ?>",
                            "<?php echo date('d-m-Y') ?>"
                        ],
                        "Last 30 Days": [
                            "<?php echo date('d-m-Y', strtotime("-30 day")) ?>",
                            "<?php echo date('d-m-Y') ?>"
                        ],
                        "This Month": [
                            "<?php echo date('d-m-Y', strtotime("first day of this month")) ?>",
                            "<?php echo date('d-m-Y') ?>"
                        ],
                        "Last Month": [
                            "<?php echo date('d-m-Y', strtotime("first day of previous month")) ?>",
                            "<?php echo date('d-m-Y', strtotime("last day of previous month")) ?>"
                        ]
                    },
                });

//                $('#tablex').DataTable({
//                    "pageLength": 25
//                });
            });
        </script>
    </body>
</html>