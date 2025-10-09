<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit']))
{
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];
    $newpassword=md5($_POST['newpassword']);

    $sql ="SELECT Email FROM tbldoctor WHERE Email=:email and MobileNumber=:mobile";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);

    if($query -> rowCount() > 0)
    {
        $con="update tbldoctor set Password=:newpassword where Email=:email and MobileNumber=:mobile";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
        $chngpwd1-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $chngpwd1->execute();
        echo "<script>alert('Your Password successfully changed');</script>";
    }
    else {
        echo "<script>alert('Email id or Mobile no is invalid');</script>"; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>DAMS - Forgot Password</title>

    <link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/core.css">
    <link rel="stylesheet" href="assets/css/misc-pages.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">

    <script type="text/javascript">
        function valid() {
            if(document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
                alert("New Password and Confirm Password Field do not match  !!");
                document.chngpwd.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>

    <style>
        body.simple-page {
            background: linear-gradient(135deg, #3498db, #9b59b6);
            font-family: 'Raleway', sans-serif;
        }
        .simple-page-wrap {
            background: rgba(255, 255, 255, 0.05);
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            position: relative;
            overflow: hidden;
        }
        .logo-wrap {
            margin-bottom: 30px;
        }
        /* Animated SVG logo */
        .animated-logo {
            animation: pulseLogo 2s infinite ease-in-out;
            cursor: pointer;
            width: 80px;
            height: 80px;
            display: block;
            margin: 0 auto 20px;
        }
        .animated-logo:hover {
            transform: scale(1.1) rotate(10deg);
        }
        @keyframes pulseLogo {
            0% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.05) rotate(-5deg); }
            100% { transform: scale(1) rotate(0deg); }
        }
        .form-title {
            color: #fff;
            font-weight: 600;
            margin-bottom: 25px;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.4);
        }
        .form-control {
            border-radius: 50px;
            padding: 12px 20px;
            border: none;
            background: rgba(255,255,255,0.15);
            color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .form-control::placeholder {
            color: rgba(255,255,255,0.7);
        }
        .btn-primary {
            background: linear-gradient(45deg, #3498db, #9b59b6);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }
        .simple-page-footer p {
            color: rgba(255,255,255,0.8);
            margin-top: 20px;
        }
        .simple-page-footer a {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>
<body class="simple-page">
    <div id="back-to-home">
        <a href="../index.php" class="btn btn-outline btn-default">Home</a>
    </div>

    <div class="simple-page-wrap">
        <!-- Animated Logo -->
        <div class="logo-wrap text-center">
            <svg class="animated-logo" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                <circle cx="32" cy="32" r="30" fill="url(#gradientGlow)" stroke="#fff" stroke-width="2"/>
                <path d="M32 16v16M24 24h16" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                <circle cx="32" cy="32" r="5" fill="#fff"/>
                <defs>
                    <radialGradient id="gradientGlow" cx="50%" cy="50%" r="50%">
                        <stop offset="0%" stop-color="#3498db" stop-opacity="1"/>
                        <stop offset="100%" stop-color="#9b59b6" stop-opacity="0.5"/>
                    </radialGradient>
                </defs>
            </svg>
        </div>

        <!-- Form -->
        <div id="login-form">
            <h4 class="form-title m-b-xl text-center">Reset Your Password</h4>
            <form method="post" name="chngpwd" onSubmit="return valid();">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Email Address" required="true" name="email">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="mobile" placeholder="Mobile Number" required="true">
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="newpassword" placeholder="New Password" required="true"/>
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="confirmpassword" placeholder="Confirm Password" required="true"/>
                </div>
                <input type="submit" class="btn btn-primary btn-block" name="submit" value="RESET">
            </form>
        </div><!-- #login-form -->

        <div class="simple-page-footer text-center">
            <p>Do you have an account? <a href="login.php">SIGN IN</a></p>
        </div>
    </div><!-- .simple-page-wrap -->
</body>
</html>
