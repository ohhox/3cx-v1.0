<?php
include './conf.php';
$fn = new functionx();
 
$project = $fn->getEndCallkProject();
 
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
        <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
        <!-- Custom stylesheet - for your changes-->

        <!-- Favicon-->
        <link rel="shortcut icon" href="favicon.png">
        <link rel="stylesheet" href="css/radioStyle.css">
        <link rel="stylesheet" href="css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="bootstrap-daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="css/custom.css">
    </head>
    <body>
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
                <div class="container-fluid">
                    <header id="formSearc"> 
                        <h1 class="h3">End Call Survey Reports</h1>
                        <form id="Sform">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Date Rang</label>
                                    <input type="text" class="form-control" id="date" name="date">
                                </div>
                                <div class="col-md-3">
                                    <label>Project</label>
                                    <select class=" form-control" name="Project" >
                                        <option value="all">ALL</option>
                                        <?php
                                        foreach ($project AS $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['Project']; ?>" <?= @($_GET['Project'] == $value['Project']) ? 'selected' : '' ?>>  <?php echo $value['Project']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Agent</label>
                                    <select class=" form-control" name="Agent" >
                                        <option value="all">ALL</option>
                                        <?php
                                        foreach ($agent AS $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['agent']; ?>" <?= @($_GET['Agent'] == $value['agent']) ? 'selected' : '' ?>>  <?php echo $value['agent']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>                               
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <label>Queue Number</label>
                                    <select class=" form-control" name="Queue" >
                                        <option value="all">ALL</option>

                                    </select>
                                </div>
                                <div class="col-md-3">

                                    <label>Score Rate </label>   <br/>
                                    <input type="number" min="0" max="5" value="<?= (isset($_GET['scorestrat'])) ? $_GET['scorestrat'] : 1 ?>" name="scorestrat" class="SmallTextBox" > -
                                    <input type="number" min="0" max="5" value="<?= (isset($_GET['scoreend'])) ? $_GET['scoreend'] : 5 ?>" name="scoreend" class="SmallTextBox">
                                </div> 
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary btn-lg"> Export </button> 
                                    OR  &nbsp;&nbsp;

                                    <a href="_endcall_excel.php" class="extranalLink"><i class="fa fa-file-excel-o fa-2x"></i> </a> &nbsp;
                                    <a href="_endcall_pdf.php" class="extranalLink"><i class="fa fa-file-pdf-o fa-2x"></i> </a> &nbsp;
                                    <a href="_endcall_print.php" class="extranalLink"><i class="fa fa-print fa-2x"></i> </a>


                                </div>


                            </div>
                        </form>
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
                                                <td></td>
                                                <td><?= $value['score']; ?></td>
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

            <?php include './_foot.php'; ?>   

        </div>
        <!-- Javascript files-->
        <script src="js/jquery-3.2.1.min.js"></script> 
        <script src="js/popper.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script> 
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="bootstrap-daterangepicker/moment.min.js"></script>
        <script src="bootstrap-daterangepicker/daterangepicker.js"></script>
        <script src="js/front.js"></script>
        <script src="js/customs.js"></script>
         
    </body>
</html>