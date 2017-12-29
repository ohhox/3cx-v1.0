<?php
include './conf.php';
$fn = new functionx();
$strExcelFileName = "ReportEndCall.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");
$list = $fn->getEndCall();
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
                        <h1 class="h3">End Call Survey Reports</h1>

                        <div class="row" style="padding:10px;">
                            <div class="col-md-3">
                                <label>Date Rang :</label>
                                <?= isset($_GET['date']) ? $_GET['date'] : '' ?>
                            </div>
                            <div class="col-md-3">
                                <label>Project</label>: <?= isset($_GET['Project']) ? $_GET['Project'] : '' ?>                                        

                            </div>
                            <div class="col-md-3">
                                <label>Agent Number: </label> <?= isset($_GET['Agent']) ? $_GET['Agent'] : '' ?>     

                            </div>
                            <div class="col-md-3">
                                <label>Queue Number: </label> <?= isset($_GET['Queue']) ? $_GET['Queue'] : '' ?>     

                            </div>

                            <div class="col-md-3">
                                <label><span>Score Rate: </span></label> <?= (isset($_GET['scorestrat'])) ? $_GET['scorestrat'] : 1 ?> - <?= (isset($_GET['scoreend'])) ? $_GET['scoreend'] : 5 ?>
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
                                            <th>Customer Number</th>
                                            <th>Agent Number</th>  
                                            <th>Queue Number</th>  
                                            <th>Score</th>
                                            <th>DID(VDN)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($list AS $key => $value) {
                                            ?>
                                            <tr>                                                
                                                 <td><?= $fn->redate($value['DateLeave'], 'no'); ?></td>
                                                <td><?= $fn->retime($value['time']); ?></td>
                                                <td><?= $value['customernumber']; ?></td>
                                                <td><?= $value['agent']; ?></td>   
                                                <td><?= $value['QueueNumber']; ?></td>
                                                <td><?= $value['score']; ?></td>
                                                <td><?= $value['DIDNumber']; ?></td>
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