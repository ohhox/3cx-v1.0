<?php
include './conf.php';
$fn = new functionx();

$list = $fn->getDidAgent($_GET['id']);
$DID = $fn->getDIDQueues($_GET['id']);
$project = $fn->getProject($DID['ProjectID']);

$agent = $fn->getNotDidAgent($_GET['id']);
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
    <body data-active="project" data-id="DIDQ">
        <?php include './_sidebar.php'; ?>
        <div class="page home-page">
            <!-- navbar-->
            <?php include './_head.php'; ?>    
            <div class="breadcrumb-holder">   
                <div class="container-fluid">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="manage_queses.php"> DID & Queues Lists</a></li>
                        <li class="breadcrumb-item active">Agent management.</li>
                    </ul>
                </div>
            </div>
            <section class="charts">
                <div class="container-fluid">
                    <?php
                    include './_TapFake.php';
                    ?>
                    <div  id="porjectDetail">
                        <h1 class="page-header">Agent management. 
                            <a class="pull-right btn btn-sm btn-success"  id="openAgentName">
                                <i class="fa fa-plus"></i> Add Agent
                            </a>
                        </h1>
                        <div id="appdex" >
                            <div class="row" >
                                
                                <div class="col-md-12 ">
                                    <form action="_op_main.php?op=saveAgentDid&id=<?= $_GET['id'] ?>" method="post">
                                        <div id="ListAgentForadd">
                                            <p>Choose Agent </p>
                                            <div id="ListNmae" class="row">
                                                <?php
                                                $i = 1;
                                                if (!empty($agent)) {
                                                    foreach ($agent as $key => $value) {
                                                        $value = $fn->ThaiTextToutf($value);
                                                        ?>
                                                <div class="col-md-3">
                                                            <label>
                                                                <input type="checkbox" name="agent_id[]" value="<?= $value['agent_id'] ?>" class="CheckAgent">
                                                                <?= $value['agent_code'] . " : " . $value['name'] . " " . $value['lastname'] ?> 
                                                            </label>
                                                        </div>
                                                        <?php
                                                    }
                                                } else {
                                                    echo "Not found Agent.";
                                                }
                                                ?>
                                            </div>
                                            <div style="margin-top: 20px;">
                                                <a class="btn btn-default btn-sm" > <input type="checkbox" id="CheckALl"> Check All</a>
                                                <button type="submit" class="btn btn-success btn-sm" ><i class="fa fa-save"></i> Save <span id="AddAgentBage" class="badge badge-light"></span></button>
                                                <button type="reset" onclick=" $('#AddAgentBage').text('');"  class="btn btn-warning btn-sm" ><i class="fa fa-resistance"></i>  Reset</button>
                                                <button type="reset" class="btn btn-danger btn-sm"  onclick="$('#appdex').slideToggle(); $('#AddAgentBage').text('');"><i class="fa fa-close"></i>  Close</button>
                                            </div>
                                        </div>

                                    </form>

                                </div>

                            </div>
                        </div>
                        <div class="agentMageDispalu">
                            <div > <label>Project :</label> <?= (isset($project) && !empty($project) ? $project['Code'] . " " . $project['Name'] : ' Not found Project.') ?></div>
                            <div > <label>DID Number : </label> <?= $DID['DIDNumber'] ?></div>
                            <div > <label>Queues Number : </label> <?= $DID['QueueNumber'] ?></div>
                            <div > <label>Total Agent : </label> <?= count($list) ?></div>
                            <div class="clearfix"></div>
                        </div>


                        <div class="clear"></div>
                        <div style="padding-top: 20px;">
                            <table class="table" id="tablex" >
                                <thead>
                                    <tr>
                                        <th>Agent Number</th>
                                        <th>Agent Name</th> 
                                        <th>manage</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (!empty($list)) {
                                        foreach ($list AS $key => $value) {
                                            $value = $fn->ThaiTextToutf($value);
                                            ?>
                                            <tr>               
                                                <td><?= $value['agent_code']; ?></td>
                                                <td><?= $value['name'] . $value['lastname']; ?></td> 
                                                <td>                                                    
                                                    <a class="btn btn-danger btn-sm removeAlert"  href="_op_main.php?op=removeDidAgent&id=<?= $value['agent_id']; ?>&didid=<?= $_GET['id'] ?>"> 
                                                        <i class="fa fa-remove"></i> 
                                                    </a>
                                                </td>

                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>               
                                            <td colspan="6" class="text-center text-danger">Not found Agent. </td> 

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

        <script>
//            $('#tablex').DataTable({
//                "pageLength": 25,
//                "searching": false
//
//            });
        </script>

    </body>
</html>