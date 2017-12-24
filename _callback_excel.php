<?php
include './conf.php';
$fn = new functionx();
$strExcelFileName = "ReportCallBack.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

$list = $fn->getCallBack();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>3CX WEB REPORT SYSTEM.</title>

    </head>
    <body>

        <div class="page home-page">


            <section class="charts">
                <div class="container-fluid">
                    <header id="formSearc"  > 
                        <h1 class="h3">Report Call Back</h1>

                        <div class="row" style="padding:10px;">
                            <div class="col-md-3">
                                <label>Date Rang :</label>
                                <?= isset($_GET['date']) ? $_GET['date'] : '' ?>
                            </div>
                            <div class="col-md-3">
                                <label>Project</label>: <?= isset($_GET['Project']) ? $_GET['Project'] : '' ?>                                        

                            </div>
                            <div class="col-md-3">
                                <label>Queue Number: </label> <?= isset($_GET['Queue']) ? $_GET['Queue'] : '' ?>     

                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>DayOrNight: </label>  <?= isset($_GET['DayOrNight']) ? $fn->dayNight[$_GET['DayOrNight']] : '' ?>  
                            </div>
                            <div class="col-md-3">
                                <label><span>Only Leave Number: </span></label> <?= isset($_GET['Leave']) ? "Yes" : "NO" ?>
                            </div>
                        </div>

                    </header>

                    <div class="row"> 
                        <div class="card col-12">                             
                            <div class="card-body">
                                <table class="table" id="tablex">
                                    <thead>
                                        <tr> 
                                            <th>Date</th>
                                            <th>Time</th> 
                                            <th>Call Number</th>
                                            <th>Leave Number</th>  
                                            <th>Queue Number</th>
                                            <th>DID(VDN)</th>
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
                                                <td></td>
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

    </body>
</html>