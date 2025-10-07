<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['login'])) 
{
    $email=$_POST['email'];
    $password=md5($_POST['password']);
    $sql ="SELECT ID,Email FROM tbldoctor WHERE Email=:email and Password=:password";
    $query=$dbh->prepare($sql);
    $query->bindParam(':email',$email,PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
    {
        foreach ($results as $result) {
            $_SESSION['damsid']=$result->ID;
            $_SESSION['damsemailid']=$result->Email;
        }
        $_SESSION['login']=$_POST['email'];
        echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
    } 
    else
    {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>DAMS - Login Page</title>
    <link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/core.css">
    <link rel="stylesheet" href="assets/css/misc-pages.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
    <style>
        body.simple-page {
            background: linear-gradient(135deg, #0077b6, #00b4d8, #90e0ef);
            overflow-x: hidden;
            font-family: 'Raleway', sans-serif;
        }

        /* Back to home button */
        #back-to-home a {
            color: #0077b6;
            font-weight: 600;
        }

        .simple-page-wrap {
            position: relative;
            max-width: 400px;
            margin: 80px auto;
            padding: 40px 30px;
            background: rgba(255,255,255,0.1);
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        /* Login Form */
        #login-form h4 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 30px;
            color: #fff;
            text-align: center;
        }

        #login-form .form-control {
            border-radius: 25px;
            padding: 12px 20px;
            margin-bottom: 20px;
            border: 1px solid #cfd8dc;
            font-size: 16px;
        }

        #login-form .btn-primary {
            width: 100%;
            padding: 12px 0;
            border-radius: 25px;
            font-weight: 600;
            font-size: 18px;
            background: linear-gradient(135deg, #ff6f61, #ffca3a, #6a4c93, #ff6f61);
            background-size: 400% 400%;
            animation: buttonGradient 6s ease infinite;
            border: none;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        #login-form .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.3);
        }

        @keyframes buttonGradient {
            0%{background-position:0% 50%;}
            50%{background-position:100% 50%;}
            100%{background-position:0% 50%;}
        }

        /* Footer */
        .simple-page-footer {
            text-align: center;
            margin-top: 20px;
        }

        .simple-page-footer a {
            color: #fff;
            text-decoration: underline;
            transition: all 0.3s ease;
        }

        .simple-page-footer a:hover {
            color: #ffca3a;
            transform: scale(1.05);
        }

        /* Animated doctor icon */
        .doctor-icon {
            position: absolute;
            font-size: 50px;
            color: #fff;
            bottom: 10px;
            left: 0;
            animation: moveDoctor 6s linear infinite;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
        }

        @keyframes moveDoctor {
            0% {left: 0;}
            50% {left: calc(100% - 50px);}
            100% {left: 0;}
        }

        @media (max-width: 480px) {
            .simple-page-wrap {margin: 50px 20px; padding: 30px 20px;}
            .doctor-icon {font-size: 35px;}
        }
    </style>
</head>
<body class="simple-page">
    <div id="back-to-home">
        <a href="../index.php" class="btn btn-outline btn-default">Home</a>
    </div>

    <div class="simple-page-wrap">
        <h4 class="form-title m-b-xl text-center">Login</h4>

        <form method="post" name="login" id="login-form">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Enter Registered Email ID" required name="email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password" required>
            </div>
            <input type="submit" class="btn btn-primary" name="login" value="Sign IN">
        </form>

        <hr>
        <a href="signup.php" style="color: white; display: block; text-align: center;">Signup/Registration</a>

        <div class="simple-page-footer">
            <p><a href="forgot-password.php">FORGOT YOUR PASSWORD ?</a></p>
        </div>

        <!-- Animated doctor icon -->
        <i class="fa fa-user-md doctor-icon" aria-hidden="true"></i>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
