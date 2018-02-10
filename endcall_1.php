<?php
include './conf.php';
$fn = new functionx();

$list = $fn->getEndCall();
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

$data = array();
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
    <body data-active="endcall">
        <?php include './_sidebar.php'; ?>
        <div class="page home-page">
            <!-- navbar-->
            <?php include './_head.php'; ?>    
            <div class="breadcrumb-holder">   
                <div class="container-fluid">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">End Call Survey Reports</li>
                    </ul>
                </div>
            </div>

            <section class="charts">
                <div class="container-fluid" id="MainPosion">
                    <header id="formSearc"> 
                        <h1 class="h3">End Call Survey Reports</h1>
                        <form id="Sform" class="endcall">
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
                                            <option value="<?php echo $value['ProjectID']; ?>" <?= @($_GET['Project'] == $value['ProjectID']) ? 'selected' : '' ?>> 
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
                                            <option data-status="remove" value="<?php echo $value['DIDNumber']; ?>" <?= @($_GET['Did'] == $value['DIDNumber']) ? 'selected' : '' ?>> 
                                                <?php echo $value['DIDNumber']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <div id="AllertMage2"></div>
                                </div>  

                                <div class="col-md-3">
                                    <label>Agent Number </label>
                                    <select class=" form-control" name="Agent" id="Agent">
                                        <option value="all">ALL</option>
                                        <?php
                                        foreach ($agent AS $key => $value) {
                                            ?>
                                            <option data-status='remove' value="<?php echo $value['agent_code']; ?>" <?= @($_GET['Agent'] == $value['agent_code']) ? 'selected' : '' ?>>  <?php echo $value['agent_code']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>                               



                                <div class="col-md-3">
                                    Report 
                                    <div>
                                        <label  style="margin-left: 25px;"> <input type="radio" name="report"  value="data" checked> Total Score </label> 
                                        <div>
                                            <label style="margin-left: 25px;"> <input type="radio"  name="report" value="sum" <?= (isset($_GET['report']) && $_GET['report'] == "sum") ? "checked" : "" ?>> Average Score</label>
                                        </div>
                                    </div>
                                    <div id="agentCalc" class="<?= (isset($_GET['report']) && $_GET['report'] == "sum") ? "show" : "" ?>" >
                                        Display Agent 
                                        <div>
                                            <label style="margin-left: 25px;"> <input type="radio" name="calc" value="indata" checked> With Score </label> 
                                            <div>
                                                <label style="margin-left: 25px;"> <input type="radio"  name="calc" value="all"  <?= (isset($_GET['calc']) && $_GET['calc'] == "all") ? "checked" : "" ?>> With / WithOut Score</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="CustermerNumberF" class="<?= (!isset($_GET['report']) || $_GET['report'] != "sum") ? "show" : "" ?>">
                                        <label>Customer Number</label>
                                        <input type="text" name="Cusnum" placeholder="Customer Number" class="form-control" value="<?= (isset($_GET['Cusnum'])) ? $_GET['Cusnum'] : "" ?>">
                                    </div>
                                </div> 

                                <div class="col-md-3" >
                                    <label>Time Option. </label>    
                                    <div  style="display: flex;flex-direction: row;flex: 1;justify-content: flex-start;align-items: stretch;">
                                        <div class="timeRate">
                                            <span>Begin<br/> <input type="text" id="timeStart" name="timeStart" value="<?= (isset($_GET['timeStart']) && !empty($_GET['timeStart'])) ? $_GET['timeStart'] : '00:00' ?>" class="form-control TimeSelectBox" ></span>
                                        </div>
                                        <div class="timeRate">
                                            <span>End<br/> <input type="text" id="timeEnd" name="timeEnd" value="<?= (isset($_GET['timeEnd']) && !empty($_GET['timeEnd'])) ? $_GET['timeEnd'] : '23:59' ?>"  class="form-control TimeSelectBox" ></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-3" >
                                    <label>Dialin  Option. </label>    
                                    <div  style="display: flex;flex-direction: column;flex: 1;justify-content: flex-start;align-items: stretch;">
                                        <label style="margin-left: 25px;margin-bottom: 5px;">
                                            <input type="radio" name="dialin" value="ALL" <?php echo (isset($_GET['dialin']) && $_GET['dialin'] == 'ALL') ? 'checked' : (!isset($_GET['dialin']) ? 'checked' : '') ?> > All
                                        </label>
                                        <label style="margin-left: 25px;margin-bottom: 5px;">
                                            <input type="radio" name="dialin" value="0" <?php echo (isset($_GET['dialin']) && $_GET['dialin'] == '0') ? 'checked' : "" ?> > Call In. 
                                        </label>
                                        <label style="margin-left: 25px;margin-bottom: 5px;">
                                            <input type="radio" name="dialin" value="1" <?php echo (isset($_GET['dialin']) && $_GET['dialin'] == '1') ? 'checked' : "" ?> >  Call Out.
                                        </label>

                                    </div>


                                </div>
<!--                                <div class="col-md-3" id="ScoreRate"   <?php
                                        if (@!isset($_GET['Project']) || $_GET['Project'] == 'all') {
                                            ?> style="display: none;"<?php
                                     }
                                     ?>>
                                    <label>Score Rate </label>  
                                    <div>
                                        <label style="margin-left: 25px;margin-bottom: 5px;">
                                            <input type="checkbox" name="scoreNull" value="yes" <?php echo (isset($_GET['scoreNull']) && $_GET['scoreNull'] == 'yes') ? 'checked' : "" ?> > Null Only
                                        </label>
                                    </div>
                                    <div  style="display: flex;flex-direction: row;flex: 1;justify-content: flex-start;align-items: stretch;">
                                        <div   class="timeRate">
                                            <span> Begin</span><br/> 
                                            <input type="number" id="score_min" min="<?= (!empty($thisProject['score_min']) ? $thisProject['score_min'] : '0') ?>" max="<?= (!empty($thisProject['score_max']) ? $thisProject['score_max'] : '0') ?>" value="<?= isset($_GET['scorestrat']) ? $_GET['scorestrat'] : (!empty($thisProject['score_min']) ? $thisProject['score_min'] : '0') ?>" name="scorestrat" class="SmallTextBox scoreRate" > 
                                        </div>
                                        <div  class="timeRate">
                                            <span>End</span> <br/> 
                                            <input type="number" id="score_max"  min="<?= (!empty($thisProject['score_min']) ? $thisProject['score_min'] : '0') ?>" max="<?= (!empty($thisProject['score_max']) ? $thisProject['score_max'] : '0') ?>" value="<?= isset($_GET['scoreend']) ? $_GET['scoreend'] : (!empty($thisProject['score_max']) ? $thisProject['score_max'] : '0') ?>" name="scoreend" class="SmallTextBox scoreRate">
                                        </div>
                                    </div>
                                </div> -->

                                <div class="clear"></div>
                                <div class="col-md-12" style="margin: 0px;"> 
                                    <div class="btn-group   pull-right" role="group" aria-label="Button group with nested dropdown" style="margin-right:30px;margin-top:-45px;">
                                        <button type="submit" class="btn btn-primary btn-lg">Generate</button>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Export
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <a class="dropdown-item extranalLink2"  href="_endcall_excel_2.php"><i class="fa fa-file-excel-o"></i> Excel</a> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>


                            </div>
                        </form>
                    </header>

                    <div class="row" id="DetailPabel"  > 
                        <div class=" col-12">                             
                            <div  >

                                <?php
                                if (isset($_GET['report']) && !empty($_GET['report']) && $_GET['report'] == 'sum') { // Average
                                    ?>
                                    <table class="table" id="tablex">
                                        <thead>
                                            <tr>  
                                                <th>#</th>  
                                                <th>Agent Number</th>  
                                                <th>Agent Name</th>

                                                <th>DID. (VDN.)</th>
                                                <th>Score(AVG)</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($list AS $key => $value) {
                                                $valuex = $fn->ThaiTextToutf($value);
                                                ?>
                                                <tr>      
                                                    <td><?= $i++ ?></td>

                                                    <td><?= $value['agent']; ?></td>   
                                                    <td><?= $valuex['name'] . ' ' . $valuex['lastname']; ?></td> 
                                                    <td><?= $value['DIDNumber']; ?></td>    
                                                    <td><?= number_format($value['score'], 2); ?></td>

                                                </tr>
                                                <?php
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                    <?php
                                } else {
                                    ?>
                                    <table class="table" id="tablex">
                                        <thead>
                                            <tr> 
                                                <th>Date</th>
                                                <th>Time</th> 
                                                <th>Customer Number</th>
                                                <th>Agent Number</th>  
                                                <th>Agent Name  </th>
                                                <th>DID. (VDN.)</th>
                                                <th>Score</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;

                                            foreach ($list AS $key => $value) {
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

                                                if (empty($data[$score])) {
                                                    $data[$score] = 1;
                                                } else {
                                                    $data[$score] += 1;
                                                }
                                                ?>
                                                <tr>                                                
                                                    <td><?= $fn->redate($value['DateLeave'], 'no'); ?></td>
                                                    <td><?= $fn->retime($value['time']); ?></td>
                                                    <td><?= $value['customernumber']; ?></td>
                                                    <td><?= $value['agent']; ?></td>   
                                                    <td><?= $valuex['name'] . ' ' . $valuex['lastname']; ?></td> 
                                                    <td><?= $value['DIDNumber']; ?></td>    
                                                    <td><?= $score ?></td>

                                                </tr>
                                                <?php
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                    <?php
                                }

                                if (isset($_GET['report']) && $_GET['report'] == 'data') {
                                    ?>

                                    <div class="row">
                                        <div class="col-md-5"  >
                                            <h3 style="padding: 0px;padding-bottom: 10px;margin: 0px;margin-top: 30px;">  More Description </h3>
                                            <table class="table table-striped" style="border-top: 2px #33b35a solid;">
                                                <thead>
                                                    <tr>
                                                        <th>Detail</th>
                                                        <th>Total</th>
                                                        <th>%</th>
                                                        <th>Score</th>
                                                        <th>%</th>
                                                    </tr>                                            
                                                </thead>

                                                <?php
                                                if (isset($_GET['Project'])) {
                                                    $all = 0;
                                                    $all += $press1 = !empty($data[1]) ? $data[1] : 0;
                                                    $all += $press2 = !empty($data[2]) ? $data[2] : 0;
                                                    $all += $press3 = !empty($data[3]) ? $data[3] : 0;
                                                    $rowPer2 = 0;


                                                    switch ($_GET['Project']) {
                                                        case 2:
                                                            ?>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Press 1 </td>
                                                                    <td><?= number_format($press1) ?></td>
                                                                    <td  class="text-info"><?= ($press1 > 0) ? $rowPer1 = number_format(($press1 * 100 ) / $all, 2) : $rowPer1 = 0 ?></td>
                                                                    <td><?= number_format($press1) ?></td>                                                            
                                                                    <td  class="text-info"><?= ($press1 > 0) ? $persent1 = number_format(($press1 * 100 ) / ($all), 2) : $persent1 = 0 ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Press 2 </td>
                                                                    <td><?= $press2 ?></td>
                                                                    <td  class="text-info"><?= ($press2 > 0) ? $rowPer2 = number_format(($press2 * 100 ) / $all, 2) : $rowPer2 = 0 ?></td>
                                                                    <td><?= number_format($press2 * 0.5, 2); ?></td>
                                                                    <td  class="text-info"><?= ($press2 > 0) ? $persent2 = number_format((($press2 * 0.5) * 100 ) / $all * 1, 2) : $persent2 = 0 ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Press 3 </td>
                                                                    <td><?= $press3 ?></td>
                                                                    <td  class="text-info"><?= ($press3 > 0) ? $rowPer3 = number_format(($press3 * 100 ) / $all, 2) : $rowPer3 = 0 ?></td>
                                                                    <td> 0 </td>
                                                                    <td  class="text-info"> 0 </td>
                                                                </tr>


                                                            </tbody>
                                                            <tfoot class="text-bold ">
                                                                <tr>
                                                                    <td>Sumary </td>
                                                                    <td><?= number_format($all); ?></td>
                                                                    <td  class="text-info"> <?= $rowPer1 + $rowPer2 + $rowPer3 ?> </td>
                                                                    <td><?= number_format($press1 + ($press2 * 0.5), 2) ?></td>
                                                                    <td  class="text-info"><?= $persent1 + $persent2 ?> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5"  >The Total Customer Satisfaction : <?= $persent1 + $persent2 ?>%</td>
                                                                </tr>
                                                            </tfoot>
                                                            <?php
                                                            break;

                                                        case 3:
                                                            $all = 0;
                                                            $all += $press1 = !empty($data[1]) ? $data[1] : 0;
                                                            $all += $press3 = !empty($data[0]) ? $data[0] : 0;
                                                            ?>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Press 1 </td>
                                                                    <td><?= number_format($press1) ?></td>
                                                                    <td  class="text-info"><?= ($press1 > 0) ? $rowPer1 = number_format(($press1 * 100 ) / $all, 2) : $rowPer1 = 0 ?></td>
                                                                    <td><?= number_format($press1) ?></td>                                                            
                                                                    <td  class="text-info"><?= ($press1 > 0) ? $persent1 = number_format(($press1 * 100 ) / ($all), 2) : $persent1 = 0 ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Press 0 </td>
                                                                    <td><?= $press3 ?></td>
                                                                    <td  class="text-info"><?= ($press3 > 0) ? $rowPer3 = number_format(($press3 * 100 ) / $all, 2) : $rowPer3 = 0 ?></td>
                                                                    <td> 0 </td>
                                                                    <td  class="text-info"> 0 </td>
                                                                </tr>


                                                            </tbody>
                                                            <tfoot class="text-bold ">
                                                                <tr>
                                                                    <td>Sumary </td>
                                                                    <td><?= number_format($all); ?></td>
                                                                    <td  class="text-info"> <?= $rowPer1 + $rowPer3 ?> </td>
                                                                    <td><?= number_format($press1) ?></td>
                                                                    <td  class="text-info"><?= $persent1 ?> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5"  >The Total Customer Satisfaction : <?= $persent1 ?>%</td>
                                                                </tr>
                                                            </tfoot>

                                                            <?php
                                                            break;
                                                    }
                                                }
                                                ?>

                                            </table>
                                        </div>
                                    </div>

                                <?php } ?>
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

                $('#tablex').DataTable({
                    "pageLength": 25
                });
            });


        </script>
    </body>
</html>