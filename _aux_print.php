<?php
include './conf.php';
$fn = new functionx();
$list = $fn->getAuxtime();

$project = array();
if ($_GET['Project'] != 'all') {
    $project = $fn->getProject($_GET['Project']);
}

$AuxType = $fn->getAuxType();
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
                width: 100%;
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
    <body data-active="Auxtime" >

        <div class="row" id="DetailPabel"> 
            <header id="formSearc"   > 
                <h1 class="h3">Auxiliary Time Report</h1>
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
                        <label>Time Option: </label>  <?= (isset($_GET['timeOption']) && $_GET['timeOption'] == 'all' ) ? " All Time." : ' Custom Time. (' . $_GET['timeStart'] . ' - ' . $_GET['timeEnd'] . ')' ?>  
                    </div>
                    <div class="col-md-3">
                        <label>Agent Option : </label>  <?= (isset($_GET['agentOption']) && $_GET['agentOption'] == 'name' ) ? " Agent Name : ({$_GET['Cusnum']})" : ' Agent Number. (' . $_GET['Agent'] . ')' ?>  
                    </div>
                    <div class="col-md-3">
                        <label>Auxiliary Number : </label>  <?= (isset($_GET['aux']) && $_GET['aux'] == 'all' ) ? " ALL " : $_GET['aux'] ?>  
                    </div>
                </div>

            </header>
            <div class=" col-12">                             
                <div class="">
                    <table class="table" id="tablex">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Date</th>
                                <th>Time</th>

                                <th>Agent Number</th>

                                <th>Agent Name</th>
                                <th>Line In / out</th>
                                <th>Aux Number</th>
                                <th>Aux Description</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($list AS $key => $value) {
                                $valuex = $fn->ThaiTextToutf($value);
                                ?>
                                <tr>
                                    <td scope="row"><?= $i++ ?></td>
                                    <td><?= $fn->redate($value['date']); ?></td>
                                    <td><?= $fn->retime($value['TimeAux']); ?></td>                                                
                                    <td><?= $value['Agent']; ?></td>
                                    <td><?= $valuex['name'] . ' ' . $valuex['lastname']; ?></td> 
                                    <td><?= $value['Loginout']; ?></td>
                                    <td><?= $value['AuxNum']; ?></td>
                                    <td><?= $value['AuxDes']; ?></td> 
                                </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
            window.print();
        </script>

    </body>
</html>