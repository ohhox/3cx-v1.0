<?php
include './conf.php';
$fn = new functionx();
$list = $fn->getCallBack();

$project = $fn->getProjectList();
$did = array();
if (isset($_GET['Project']) && $_GET['Project'] != 'all') {
    $did = $fn->getDid($_GET['Project']);
}




if (isset($_GET['date']) && !empty($_GET['date'])) {
    $date = explode('-', $_GET['date']);

    $d = array(
        '1' => $date[0] . '-' . $date[1] . '-' . trim($date[2]),
        '2' => $date[3] . '-' . $date[4] . '-' . trim($date[5]),
    );
} else {
    $d = array(
        '1' => date('d-m-Y'),
        '2' => date('d-m-Y'),
    );
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
    <body>
        <?php include './_sidebar.php'; ?>
        <div class="page home-page">
            <!-- navbar-->
            <?php include './_head.php'; ?>    
            <div class="breadcrumb-holder">   
                <div class="container-fluid">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Call Back Reports</li>
                    </ul>
                </div>
            </div>

            <section class="charts">
                <div class="container-fluid">
                    <header id="formSearc"  > 
                        <h1 class="h3">Call Back Reports</h1>
                        <form id="Sform">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Date Rang</label>
                                    <input type="text" class="form-control" id="date" name="date">
                                </div>
                                <div class="col-md-3">
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
                                </div>
                                <div class="col-md-3">
                                    <label>Queue Number</label>
                                    <select class=" form-control" name="Queue" id="Queue" >
                                        <option value="all">ALL</option>
                                        <?php
                                        foreach ($did AS $key => $value) {
                                            ?>
                                            <option data-status="remove"  value="<?php echo $value['QueueNumber']; ?>" <?= @($_GET['Queue'] == $value['QueueNumber']) ? 'selected' : '' ?>> 
                                                <?php echo $value['QueueNumber']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>                               
                                <div class="col-md-3">

                                    <label>                                        
                                        <input type="radio" name="DayOrNight" <?= @($_GET['DayOrNight'] == '1') ? 'checked' : '' ?> value="1"> <span>Day &nbsp;&nbsp;</span>
                                    </label>
                                    <label>                                        
                                        <input type="radio" name="DayOrNight" <?= @($_GET['DayOrNight'] == '2') ? 'checked' : '' ?> value="2"> <span> Night &nbsp;&nbsp;</span>
                                    </label>
                                    <label>                                        
                                        <input type="radio" value="all" <?= empty($_GET['DayOrNight']) ? "checked" : "" ?>  name="DayOrNight" <?= @($_GET['DayOrNight'] == 'all') ? 'checked' : '' ?>> <span> All </span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label>
                                        <input type="checkbox" name="Leave" value="1" <?= !empty($_GET['Leave']) ? "checked" : "" ?>>
                                        <span>Only Leave Number</span>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary btn-lg"> Export </button> 
                                    OR  &nbsp;&nbsp;
                                    <a href="_callback_excel.php" class="extranalLink"><i class="fa fa-file-excel-o fa-2x"></i> </a> &nbsp;
                                    <a href="_callback_pdf.php" class="extranalLink"><i class="fa fa-file-pdf-o fa-2x"></i> </a> &nbsp;
                                    <a href="_callback_print.php" class="extranalLink"><i class="fa fa-print fa-2x"></i> </a>

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

            $(function () {
                $('#date').daterangepicker({
                    locale: {
                        format: 'DD-MM-YYYY'
                    },
                    "alwaysShowCalendars": true,
                    "startDate": "<?php echo $d[1]; ?>",
                    "endDate": "<?php echo $d[2]; ?>",

                    "ranges": {
                        "Today": [
                            "<?php echo date('d-m-Y') ?>",
                            "<?php echo date('d-m-Y') ?>"
                        ],
                        "Yesterday": [
                            "<?php echo date('d-m-Y', strtotime("-1 day")) ?>",
                            "<?php echo date('d-m-Y', strtotime("-1 day")) ?>"
                        ],
                        "Last 7 Days": [
                            "<?php echo date('d-m-Y', strtotime("-1 week +1 day")) ?>",
                            "<?php echo date('d-m-Y') ?>"
                        ],
                        "Last 30 Days": [
                            "<?php echo date('d-m-Y', strtotime("-30 day")) ?>",
                            "<?php echo date('d-m-Y') ?>"
                        ],
                        "This Month": [
                            "<?php echo date('d-m-Y', strtotime("first day of this month")) ?>",
                            "<?php echo date('d-m-Y') ?>"
                        ],
                        "Last Month": [
                            "<?php echo date('d-m-Y', strtotime("first day of previous month")) ?>",
                            "<?php echo date('d-m-Y', strtotime("last day of previous month")) ?>"
                        ]
                    },
                });

                $('#tablex').DataTable({
                    "pageLength": 25
                });
            });
        </script>
    </body>
</html>