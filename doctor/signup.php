<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit']))
{
    $fname=$_POST['fname'];
    $mobno=$_POST['mobno'];
    $email=$_POST['email'];
    $sid=$_POST['specializationid'];
    $password=md5($_POST['password']);

    $ret="select Email from tbldoctor where Email=:email";
    $query= $dbh -> prepare($ret);
    $query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);

    if($query -> rowCount() == 0)
    {
        $sql="Insert Into tbldoctor(FullName,MobileNumber,Email,Specialization,Password)Values(:fname,:mobno,:email,:sid,:password)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname',$fname,PDO::PARAM_STR);
        $query->bindParam(':email',$email,PDO::PARAM_STR);
        $query->bindParam(':mobno',$mobno,PDO::PARAM_INT);
        $query->bindParam(':sid',$sid,PDO::PARAM_INT);
        $query->bindParam(':password',$password,PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId)
        {
            echo "<script>alert('You have signed up successfully');</script>";
        }
        else
        {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    }
    else
    {
        echo "<script>alert('Email-id already exists. Please try again');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>DAMS - Sign Up</title>

    <link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/core.css">
    <link rel="stylesheet" href="assets/css/misc-pages.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">

    <style>
        body.simple-page {
            background: linear-gradient(135deg, #1abc9c, #16a085);
            font-family: 'Raleway', sans-serif;
        }
        .simple-page-wrap {
            background: rgba(255, 255, 255, 0.05);
            padding: 50px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
            position: relative;
            overflow: hidden;
        }
        /* Animated Logo */
        .logo-wrap {
            margin-bottom: 30px;
            text-align: center;
        }
        .animated-logo {
            width: 90px;
            height: 90px;
            display: block;
            margin: 0 auto 20px;
            animation: bounceLogo 2s infinite;
        }
        @keyframes bounceLogo {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px) scale(1.05); }
        }
        .form-title {
            color: #fff;
            font-weight: 600;
            margin-bottom: 25px;
            text-shadow: 1px 1px 6px rgba(0,0,0,0.5);
        }
        .form-control {
            border-radius: 50px;
            padding: 12px 20px;
            border: none;
            background: rgba(255,255,255,0.15);
            color: #fff;
            box-shadow: 0 2px 15px rgba(0,0,0,0.2);
        }
        .form-control::placeholder {
            color: rgba(255,255,255,0.7);
        }
        .btn-primary {
            background: linear-gradient(45deg, #1abc9c, #16a085);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 25px rgba(0,0,0,0.3);
        }
        .simple-page-footer p {
            color: rgba(255,255,255,0.8);
            margin-top: 20px;
        }
        .simple-page-footer a {
            color: #fff;
            text-decoration: underline;
        }
        /* Floating icons */
        .floating-icon {
            position: absolute;
            width: 40px;
            height: 40px;
            opacity: 0.2;
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(180deg); }
            100% { transform: translateY(0) rotate(360deg); }
        }
    </style>
</head>
<body class="simple-page">
    <div id="back-to-home">
        <a href="../index.php" class="btn btn-outline btn-default">Home</a>
    </div>

    <div class="simple-page-wrap">
        <!-- Animated SVG Logo -->
        <div class="logo-wrap">
            <svg class="animated-logo" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                <circle cx="32" cy="32" r="30" fill="url(#gradientLogo)" stroke="#fff" stroke-width="2"/>
                <path d="M32 16v16M24 24h16" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                <circle cx="32" cy="32" r="5" fill="#fff"/>
                <defs>
                    <radialGradient id="gradientLogo" cx="50%" cy="50%" r="50%">
                        <stop offset="0%" stop-color="#1abc9c" stop-opacity="1"/>
                        <stop offset="100%" stop-color="#16a085" stop-opacity="0.5"/>
                    </radialGradient>
                </defs>
            </svg>
        </div>

        <!-- Sign Up Form -->
        <div id="login-form">
            <h4 class="form-title m-b-xl text-center">Sign Up</h4>
            <form action="" method="post">
                <div class="form-group">
                    <input id="fname" type="text" class="form-control" placeholder="Full Name" name="fname" required="true">
                </div>
                <div class="form-group">
                    <input id="email" type="email" class="form-control" placeholder="Email" name="email" required="true">
                </div>
                <div class="form-group">
                    <input id="mobno" type="text" class="form-control" placeholder="Mobile" name="mobno" maxlength="10" pattern="[0-9]+" required="true">
                </div>
                <div class="form-group">
                    <select class="form-control" name="specializationid" required>
                        <option value="">Choose Specialization</option>
                        <?php
                        $sql1="SELECT * from tblspecialization";
                        $query1 = $dbh -> prepare($sql1);
                        $query1->execute();
                        $results1=$query1->fetchAll(PDO::FETCH_OBJ);

                        $cnt=1;
                        if($query1->rowCount() > 0)
                        {
                            foreach($results1 as $row1)
                            { ?>
                                <option value="<?php echo htmlentities($row1->ID);?>"><?php echo htmlentities($row1->Specialization);?></option>
                        <?php $cnt=$cnt+1;}} ?> 
                    </select>
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control" placeholder="Password" name="password" required="true">
                </div>
                <input type="submit" class="btn btn-primary btn-block" value="Register" name="submit">
            </form>
        </div><!-- #login-form -->

        <div class="simple-page-footer text-center">
            <p>
                <small>Do you have an account?</small>
                <a href="login.php">SIGN IN</a>
            </p>
        </div>

        <!-- Floating icons for design -->
        <img src="assets/icons/stethoscope.svg" class="floating-icon" style="top:10%; left:5%;">
        <img src="assets/icons/heart.svg" class="floating-icon" style="top:50%; right:10%;">
        <img src="assets/icons/medicine.svg" class="floating-icon" style="top:80%; left:40%;">
    </div><!-- .simple-page-wrap -->
</body>
</html>
