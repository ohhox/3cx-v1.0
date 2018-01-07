<?php
include './conf.php';
$fn = new functionx();
$project = $fn->getProject();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $list = $fn->getAgent($_GET['id']);
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
    <body data-id="Agent">
        <?php include './_sidebar.php'; ?>
        <div class="page home-page">
            <!-- navbar-->
            <?php include './_head.php'; ?>    
            <div class="breadcrumb-holder">   
                <div class="container-fluid">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li  class="breadcrumb-item"><a href="manage_agent.php"> Agent Lists </a></li>
                        <li class="breadcrumb-item active">Agent Form</li>
                    </ul>
                </div>
            </div>
            <section class="charts">
                <div class="container-fluid">
                    <?php
                    include './_TapFake.php';
                    ?>
                    <div  id="porjectDetail">
                        <h1 class="page-header"> Agent Form</h1>
                        <div class="row"> 
                            <div class="card col-8">                             
                                <div class="card-body">
                                    <form    class="form" action="_op_main.php?op=<?= isset($list) ? 'editAgent&id=' . $_GET['id'] : 'saveAgent' ?>" method="post">                                        
                                        <div class="form-group">
                                            <label>Agent Code * </label>
                                            <div>
                                                <input type="text" class="form-control" name="agent_code" value="<?= isset($list) ? $list['agent_code'] : '' ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Gender.</label>
                                            <div style="padding-left: 20px;">
                                                <div>
                                                    <label>
                                                        <input type="radio" name="gender"  value="male" <?= (isset($list) && $list['gender'] == 'male') ? 'checked' : '' ?> required> Male 
                                                    </label>
                                                </div>
                                                <div>
                                                    <label>
                                                        <input type="radio" name="gender"  value="female" <?= (isset($list) && $list['gender'] == 'female') ? 'checked' : '' ?> required> Female
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Name * </label>
                                            <div>
                                                <input type="text" class="form-control" name="name" value="<?= isset($list) ? $list['name'] : '' ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Lastname * </label>
                                            <div>
                                                <input type="text" class="form-control" name="lastname" value="<?= isset($list) ? $list['lastname'] : '' ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Phone * </label>
                                            <div>
                                                <input type="text" class="form-control" name="tel" value="<?= isset($list) ? $list['tel'] : '' ?>" required>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label>Description </label>
                                            <div>
                                                <textarea  class="form-control"   rows="5" name="AGDescription"><?= isset($list) ? $list['AGDescription'] : '' ?></textarea>
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