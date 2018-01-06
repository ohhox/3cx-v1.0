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
        
        <!-- Custom Scrollbar-->
        
        <!-- theme stylesheet-->        
        
        <link rel="stylesheet" href="css/radioStyle.css"> 
        <link rel="shortcut icon" href="favicon.png"> 
        
        <style>
            .login-page{
                width: 450px;
                margin: auto;
            }
            .logo{
                padding: 30px;
                text-align: center;
                font-size:1.3rem;
            }
            .copyrights{
                padding: 30px;
                color: #b5b5b5;
            }
        </style>
    </head>
    <body>
        <div class="page login-page">
            <div  >
                <div  >
                    <div  style=" padding: 20px;margin-top:100px;">
                        <div class="logo text-uppercase">
                            <span>3CX</span><strong class="text-primary"> WEB REPORT SYSTEM.</strong>
                        </div>

                        <form id="login-form" action="system.php?op=login" method="post">
                            <div class="form-group">
                                <label for="login-username" class="label-custom">User Name</label>
                                <input id="login-username" class="form-control" type="text" name="loginUsername" required="">
                            </div>
                            <div class="form-group">
                                <label for="login-password" class="label-custom">Password</label>
                                <input id="login-password" class="form-control" type="password" name="loginPassword" required="">
                            </div>
<!--                            <div  >
                                <label>  
                                    <input style="background: #ffffff;" type="radio" name="type" value="admin"> <span> Admin </span> &nbsp;&nbsp;&nbsp;
                                </label>
                                <label>
                                    <input type="radio" name="type" value="callcenter">
                                    <span> Call Center </span>
                                </label>
                            </div>-->
                            <div >
                                
                            <button class="btn btn-primary btn-lg">Login</button> 
                            </div>

                        </form>
                    </div>
                    <div class="copyrights text-center">
                        <p>&COPY; 3CX  WEB REPORT SYSTEM.</p>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- Javascript files-->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="vendor/jquery.cookie/jquery.cookie.js"></script>
        <script src="js/grasp_mobile_progress_circle-1.0.0.min.js"></script>
        <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
        <script src="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="js/front.js"></script>

    </body>
</html>