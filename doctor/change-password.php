<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['damsid']==0)) {
    header('location:logout.php');
} else {
    if(isset($_POST['submit'])) {
        $eid=$_SESSION['damsid'];
        $cpassword=md5($_POST['currentpassword']);
        $newpassword=md5($_POST['newpassword']);
        $sql ="SELECT ID FROM tbldoctor WHERE ID=:eid AND Password=:cpassword";
        $query= $dbh->prepare($sql);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
        $query->bindParam(':cpassword', $cpassword, PDO::PARAM_STR);
        $query->execute();

        if($query->rowCount() > 0) {
            $con="UPDATE tbldoctor SET Password=:newpassword WHERE ID=:eid";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':eid', $eid, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $chngpwd1->execute();

            echo '<script>alert("Your password has been successfully changed")</script>';
        } else {
            echo '<script>alert("Your current password is wrong")</script>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>DAMS - Change Password</title>

    <!-- CSS Links -->
    <link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
    <link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/core.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">

    <script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
    <script>
        Breakpoints();
    </script>

    <script type="text/javascript">
        function checkpass() {
            if(document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
                alert('New Password and Confirm Password field do not match');
                document.changepassword.confirmpassword.focus();
                return false;
            }
            return true;
        }   
    </script>

    <style>
        /* Premium Gradient Background */
        body {
            background: linear-gradient(135deg, #e0f7fa 0%, #c8e6c9 100%);
            font-family: 'Raleway', sans-serif;
        }

        /* Main content fade-in */
        #app-main {
            animation: fadeInPage 1s ease-in;
            padding-top: 20px;
        }
        @keyframes fadeInPage {
            from {opacity: 0; transform: translateY(20px);}
            to {opacity: 1; transform: translateY(0);}
        }

        /* Widget styling */
        .widget {
            background-color: #ffffffcc;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 15px 25px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        /* Floating decorative shapes */
        .widget::before {
            content: '';
            position: absolute;
            top: -50px; left: -50px;
            width: 100px; height: 100px;
            background: rgba(52, 152, 219,0.1);
            border-radius: 50%;
            animation: float 6s infinite ease-in-out alternate;
        }

        .widget::after {
            content: '';
            position: absolute;
            bottom: -50px; right: -50px;
            width: 120px; height: 120px;
            background: rgba(46, 204, 113,0.1);
            border-radius: 50%;
            animation: float 8s infinite ease-in-out alternate-reverse;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(20px) rotate(20deg);}
            100% { transform: translateY(0px);}
        }

        /* Header styling */
        .widget-title {
            color: #2c3e50;
            font-weight: 700;
            position: relative;
        }
        .widget-title::after {
            content: '';
            width: 50px;
            height: 3px;
            background: #3498db;
            display: block;
            margin-top: 5px;
            border-radius: 2px;
        }

        /* Form labels */
        .form-horizontal .control-label {
            color: #34495e;
            font-weight: 500;
        }

        /* Inputs */
        .form-control {
            border-radius: 8px;
            border: 1px solid #bdc3c7;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 8px rgba(52,152,219,0.3);
        }

        /* Buttons */
        .btn-success {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-success:hover {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            transform: scale(1.05);
        }

        /* Form field fade-in animation */
        .form-group {
            position: relative;
            animation: fadeInField 0.8s ease forwards;
        }
        .form-group:nth-child(1) { animation-delay: 0.2s;}
        .form-group:nth-child(2) { animation-delay: 0.4s;}
        .form-group:nth-child(3) { animation-delay: 0.6s;}
        @keyframes fadeInField {
            from {opacity:0; transform: translateX(-20px);}
            to {opacity:1; transform: translateX(0);}
        }
    </style>
</head>
<body class="menubar-left menubar-unfold menubar-light theme-primary">

<?php include_once('includes/header.php');?>
<?php include_once('includes/sidebar.php');?>

<main id="app-main" class="app-main">
    <div class="wrap">
        <section class="app-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget animated fadeIn">
                        <header class="widget-header">
                            <h3 class="widget-title">Change Password</h3>
                        </header>
                        <hr class="widget-separator">
                        <div class="widget-body">
                            <form class="form-horizontal" onsubmit="return checkpass();" name="changepassword" method="post">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Current Password:</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="currentpassword" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">New Password:</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="newpassword" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Confirm Password:</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="confirmpassword" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <button type="submit" class="btn btn-success" name="submit">Change Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include_once('includes/footer.php');?>
</main>

<?php include_once('includes/customizer.php');?>

<script src="libs/bower/jquery/dist/jquery.js"></script>
<script src="libs/bower/jquery-ui/jquery-ui.min.js"></script>
<script src="libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>
<script src="libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>
<script src="libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>
<script src="libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
<script src="libs/bower/PACE/pace.min.js"></script>

<script src="assets/js/library.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/app.js"></script>

</body>
</html>
<?php } ?>
