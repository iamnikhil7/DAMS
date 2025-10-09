<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT ID, Email FROM tbladmin WHERE Email = :email AND Password = :password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $_SESSION['damsid'] = $result->ID;
            $_SESSION['damsemailid'] = $result->Email;
        }
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "❌ Invalid Email or Password!";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>DAMS - Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #48cae4, #90e0ef);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 25px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 35px 28px;
            box-shadow: 0 12px 25px rgba(2,46,90,0.1);
            width: 100%;
            max-width: 360px;
            text-align: center;
            animation: fadeInUp 0.8s ease forwards;
            opacity: 0;
        }

        .login-card h4 {
            color: #023e8a;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            padding: 12px;
            margin-bottom: 15px;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #00b4d8;
            box-shadow: 0 0 0 0.15rem rgba(0,180,216,0.25);
        }

        .btn-primary {
            width: 100%;
            padding: 12px 0;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            background: linear-gradient(90deg, #0077b6, #00b4d8);
            border: none;
            color: #fff;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,119,182,0.25);
        }

        .error-msg {
            color: #d32f2f;
            margin-bottom: 12px;
            font-size: 14px;
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
            background: rgba(255, 255, 255, 0.25);
            padding: 20px 18px;
            border-radius: 14px;
            max-width: 300px;
            text-align: left;
            color: #022f4f;
            font-weight: 500;
            line-height: 1.4;
            animation: fadeInRight 0.9s ease forwards;
            opacity: 0;
        }

        .fact-card h5 {
            margin-bottom: 10px;
            color: #023e8a;
        }

        .floating-icon {
            font-size: 50px;
            color: #023e8a;
            position: absolute;
            top: 25px;
            left: 50%;
            transform: translateX(-50%);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(-10px); }
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(25px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInRight {
            0% { opacity: 0; transform: translateX(25px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        .home-link {
            display: inline-block;
            margin-top: 10px;
            font-weight: 500;
            color: #0077b6;
            text-decoration: none;
        }

        .home-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .fact-card { display: none; }
        }
    </style>
</head>
<body>

<i class="fa fa-user-shield floating-icon" aria-hidden="true"></i>

<div class="login-container">
    <div class="login-card">
        <h4>Admin Login</h4>

        <?php if (isset($error_message)) { ?>
            <div class="error-msg"><?php echo $error_message; ?></div>
        <?php } ?>

        <form method="post" id="login-form" novalidate>
            <input type="email" name="email" class="form-control" placeholder="Admin Email Address" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <input type="submit" name="login" class="btn btn-primary" value="Sign In">
        </form>

        <div class="login-footer">
            <a href="forgot-password.php">Forgot Password?</a><br>
            <a href="../index.php" class="home-link">⬅ Back to Home</a>
        </div>
    </div>

    <div class="fact-card">
        <h5>💡 Admin Insight</h5>
        <p>Efficient systems rely on consistent oversight. Keep your dashboards updated and monitor user activity regularly.</p>
    </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

<script>
// Simple client-side validation
document.getElementById("login-form").addEventListener("submit", function(e) {
    const email = this.email.value.trim();
    const password = this.password.value.trim();

    if (!email || !password) {
        e.preventDefault();
        alert("Please enter both email and password!");
    }
});
</script>

</body>
</html>
