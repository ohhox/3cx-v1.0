<?php
include './conf.php';
$fn = new functionx();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $list = $fn->getAuxType($_GET['id']);
    $list = $fn->ThaiTextToutf($list);
}
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
    <body data-active="project" data-id="Auxtime">
        <?php include './_sidebar.php'; ?>
        <div class="page home-page">
            <!-- navbar-->
            <?php include './_head.php'; ?>    
            <div class="breadcrumb-holder">   
                <div class="container-fluid">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li  class="breadcrumb-item"><a href="manage_auxtime.php"> Auxilary Type</a></li>
                        <li class="breadcrumb-item active">Auxilary Type Form</li>
                    </ul>
                </div>
            </div>
            <section class="charts">
                <div class="container-fluid">
                    <?php
                    include './_TapFake.php';
                    ?>
                    <div  id="porjectDetail">
                        <h1 class="page-header"> Auxilary Type Form</h1>
                        <div class="row"> 
                            <div class="card col-8">                             
                                <div class="card-body">
                                    <form  class="form" id="AuxTypeForm"action="_op_main.php?op=<?= isset($list) ? 'editAuxTimet&id=' . $_GET['id'] : 'saveAuxTime' ?>" method="post">                                        
                                        <div class="form-group">
                                            <label>Auxilary Number* </label>
                                            <div>
                                                <input type="number" aid="<?= isset($list) ?  $_GET['id'] : '' ?>" class="form-control" data-check="" id="aux_number" name="aux_number" value="<?= isset($list) ? $list['aux_number'] : '' ?>" required placeholder="Auxilary Number">
                                                <div class="text-danger" id="auxAlert"></div>
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <label>Auxilary Description * </label>
                                            <div>
                                                <input type="text" class="form-control" name="aux_description" value="<?= isset($list) ? $list['aux_description'] : '' ?>" required placeholder="Auxilary Description">
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <button class="btn btn-sm btn-success"> <i class="fa fa-save"></i> Save </button>
                                        </div>
                                    </form>

                                </div>
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
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="bootstrap-daterangepicker/moment.min.js"></script>
        <script src="bootstrap-daterangepicker/daterangepicker.js"></script>
        <script src="js/front.js"></script>
        <script src="js/customs.js"></script>
        

    </body>
</html>