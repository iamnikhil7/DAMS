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
        echo "<script>alert('❌ Invalid Details');</script>";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>DAMS - Doctor Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #00b4d8 0%, #90e0ef 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .login-container {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
            align-items: flex-start;
        }

        .login-card {
            background: #fff;
            border-radius: 18px;
            padding: 30px 25px;
            box-shadow: 0 12px 30px rgba(2,46,90,0.08);
            width: 100%;
            max-width: 350px;
            text-align: center;
            animation: fadeInUp 1s ease forwards;
            opacity: 0;
        }

        .login-card h4 {
            color: #04263b;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #e6eef6;
            padding: 12px 14px;
            margin-bottom: 16px;
            font-size: 15px;
        }

        .btn-primary {
            width: 100%;
            padding: 12px 0;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            background: linear-gradient(90deg, #0077b6, #00b4d8);
            border: none;
            color: #fff;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,180,216,0.2);
        }

        .login-footer {
            margin-top: 14px;
            font-size: 14px;
            color: #6b7280;
        }

        .login-footer a {
            color: #0077b6;
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .fact-card {
            background: rgba(255,255,255,0.2);
            padding: 20px;
            border-radius: 16px;
            max-width: 280px;
            color: #04263b;
            font-weight: 500;
            line-height: 1.4;
            animation: fadeInRight 1s ease forwards;
            opacity: 0;
        }

        .floating-icon {
            font-size: 48px;
            color: #00b4d8;
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%,100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(-10px); }
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInRight {
            0% { opacity: 0; transform: translateX(20px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>

<i class="fa fa-user-md floating-icon" aria-hidden="true"></i>

<div class="login-container">
    <div class="login-card">
        <h4>Doctor Login</h4>

        <form method="post" id="login-form" novalidate>
            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <input type="submit" name="login" class="btn btn-primary" value="Sign In">
        </form>

        <div class="login-footer">
            <a href="signup.php">Signup / Register</a> | <a href="forgot-password.php">Forgot Password?</a>
        </div>
    </div>

    <div class="fact-card">
        <h5>💡 Medical Tip</h5>
        <p>Regular hand hygiene can reduce hospital-acquired infections by up to 40%. Always remind patients about handwashing!</p>
    </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

<script>
// Strict client-side validation
document.getElementById("login-form").addEventListener("submit", function(e) {
    e.preventDefault();

    const email = this.email.value.trim();
    const password = this.password.value;

    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/;
    let valid = true;
    let message = "";

    if (!emailRegex.test(email)) {
        valid = false;
        message += "❌ Enter a valid email address.\n";
    }

    if (password.length < 6) {
        valid = false;
        message += "❌ Password must be at least 6 characters.\n";
    }

    if (!valid) {
        alert(message);
        return false;
    }

    this.submit();
});
</script>

</body>
</html>
