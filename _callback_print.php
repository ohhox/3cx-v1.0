<?php
include './conf.php';
$fn = new functionx();

$list = $fn->getCallBack();
$project = array();
if ($_GET['Project'] != 'all') {
    $project = $fn->getProject($_GET['Project']);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>3CX WEB REPORT SYSTEM.</title>
        <style>
            table{
                border-spacing: 0px;
                margin-top: 25px;
            }
            table tr th, table tr td{
                border-top: 1px #999999 solid;
                border-left: 1px #999999 solid;
                border-bottom: 1px #999999 solid;
                padding-left: 5px;
            }

            table tr th:last-child,table tr td:last-child{
                border-right: 1px #999999 solid; 
            }
        </style>

    </head>
    <body>

        <div class="page home-page">
            <section class="charts">
                <div class="container-fluid">
                    <header id="formSearc" style="border: 1px #999999 solid;padding: 10px;" > 
                        <h1 class="h3">Call Back Reports</h1>
                        <div class="row" style="padding:10px;">
                            <div class="col-md-3">
                                <label>Date Rang :</label>
                                <?= isset($_GET['date']) ? $_GET['date'] : '' ?>
                            </div>
                            <div class="col-md-3">
                                <label>Project</label>: <?= ( ($_GET['Project'] != 'all') ? $project['Name'] : 'all') ?>                                        

                            </div>
                            <div class="col-md-3">
                                <label>DID Number: </label> <?= isset($_GET['Did']) ? $_GET['Did'] : '' ?>     

                            </div>
                            <div class="col-md-3">
                                <label>Queue Number: </label> <?= isset($_GET['Queue']) ? $_GET['Queue'] : '' ?>     

                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>Day Or Night: </label>  <?= isset($_GET['DayOrNight']) ? $fn->dayNight[$_GET['DayOrNight']] : '' ?>  
                            </div>
                            <div class="col-md-3">
                                <label><span>Only Leave Number: </span></label> <?= isset($_GET['Leave']) ? "Yes" : "NO" ?>
                            </div>
                        </div>

                    </header>

                    <div class="row"> 
                        <div class="card col-12">                             
                            <div class="card-body">
                                <table class="table" id="tablex" style="width: 100%;">
                                    <thead>
                                        <tr> 
                                            <th>Date</th>
                                            <th>Time</th> 
                                            <th>Call Number</th>
                                            <th>Leave Number</th>  
                                            <th>Queue Number</th>
                                            <th>DID. (VDN.)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($list AS $key => $value) {
                                            ?>
                                            <tr>                                                
                                                <td><?= $fn->redate($value['DateLeave']); ?></td>
                                                <td><?= $fn->retime($value['TimeLeave']); ?></td>
                                                <td><?= $value['CallNum']; ?></td>
                                                <td><?= $value['LeaveNum']; ?></td>                       
                                                <td><?= $value['FromQueue']; ?></td>
                                                <td><?= $value['Project']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </section>


        </div>
        <script>
            window.print();
        </script>
    </body>
</html>