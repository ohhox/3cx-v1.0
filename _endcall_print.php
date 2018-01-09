<?php
include './conf.php';
$fn = new functionx();

$list = $fn->getEndCall();
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
                    <header id="formSearc"  > 
                        <h1 class="h3">End Call Survey Reports</h1>

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
                                <label>Agent Number: </label> <?= isset($_GET['Agent']) ? $_GET['Agent'] : '' ?>
                            </div>
                            <div class="col-md-3">
                                <label>Report Type: </label> <?= isset($_GET['report']) ? (($_GET['report'] == 'sum') ? ' Average Score' : 'Total Score') : '' ?>
                            </div>

                            <!--                            <div class="col-md-3">
                                                            <label>Queue Number: </label> <?= isset($_GET['Queue']) ? $_GET['Queue'] : '' ?>     
                            
                                                        </div>-->

                            <div class="col-md-3">
                                <label><span>Score Rate: </span></label> <?= (isset($_GET['scorestrat'])) ? $_GET['scorestrat'] : 1 ?> - <?= (isset($_GET['scoreend'])) ? $_GET['scoreend'] : 5 ?>
                            </div>
                            <div class="col-md-3">
                                <label><span>Customer Number: </span></label> <?=  (isset($_GET['Cusnum']) && !empty($_GET['Cusnum'])) ? $_GET['Cusnum'] : ".................."?>
                            </div>
                        </div>

                    </header>

                    <div class="row"> 
                        <div class="card col-12">                             
                            <div class="card-body">

                                <?php
                                if (isset($_GET['report']) && !empty($_GET['report']) && $_GET['report'] == 'sum') { // Average
                                    ?>
                                    <table class="table" id="tablex" style="width: 100%;">
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
                                    <table class="table" id="tablex" style="width: 100%;">
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
                                                ?>
                                                <tr>                                                
                                                    <td><?= $fn->redate($value['DateLeave'], 'no'); ?></td>
                                                    <td><?= $fn->retime($value['time']); ?></td>
                                                    <td><?= $value['customernumber']; ?></td>
                                                    <td><?= $value['agent']; ?></td>   
                                                    <td><?= $valuex['name'] . ' ' . $valuex['lastname']; ?></td> 
                                                    <td><?= $value['DIDNumber']; ?></td>    
                                                    <td><?= $value['score']; ?></td>

                                                </tr>
                                                <?php
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                <?php } ?>
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