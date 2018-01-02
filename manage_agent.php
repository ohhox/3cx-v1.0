<?php
include './conf.php';
$fn = new functionx();

$list = $fn->getDIDQueues();
$project = $fn->getProjectList();

$did = array();
$Queue = array();
if (isset($_GET['Project']) && $_GET['Project'] != 'all') {

    $did = $fn->getDid($_GET['Project']);
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
    <body data-id="Agent">
        <?php include './_sidebar.php'; ?>
        <div class="page home-page">
            <!-- navbar-->
            <?php include './_head.php'; ?>    
            <div class="breadcrumb-holder">   
                <div class="container-fluid">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active"> Agent Lists</li>
                    </ul>
                </div>
            </div>
            <section class="charts">
                <div class="container-fluid">
                    <?php
                    include './_TapFake.php';
                    ?>
                    <div  id="porjectDetail">
                        <h1 class="page-header">Agent Lists. <a class="pull-right btn btn-sm btn-success" href="#">
                                <i class="fa fa-plus"></i> New Agent
                            </a>
                        </h1>



                        <form id="Sform" class="Search-form">
                            <div class="row"> 
                                <div class="col-md-5">
                                    <label>Search </label>
                                    <input type="search" autocomplete name="text" class="form-control" placeholder=" ? " value="<?= isset($_GET['text']) ? $_GET['text'] : '' ?>">
                                </div>
                                <!--                                    <div class="col-md-3">
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
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label>DID (VDN)</label>
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
                                                                    </div>-->
                                <div class="col-md-3">

                                    <div style="padding-top: 35px;">
                                        <button type="submit" class="btn btn-primary btn-sm"> <i class="fa fa-search"></i> search </button>  
                                    </div>
                                </div>


                            </div>
                        </form> 


                        <div class="clear"></div>


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

        <script>
            //            $('#tablex').DataTable({
            //                "pageLength": 25,
            //                "searching": false
            //
            //            });
        </script>

    </body>
</html>