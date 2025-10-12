<?php
session_start();
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Fetch the doctor record by email
    $sql = "SELECT ID, Email, Password FROM tbldoctor WHERE Email = :email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            // Verify password using password_verify
            if (password_verify($password, $result->Password)) {
                $_SESSION['damsid'] = $result->ID;
                $_SESSION['damsemailid'] = $result->Email;
                $_SESSION['login'] = $email;
                header("Location: dashboard.php");
                exit();
            } else {
                $error_message = "❌ Invalid Password!";
            }
        }
    } else {
        $error_message = "❌ Invalid Email!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hospital Appointmnet System || Doctor Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">

    <style>
    :root {
        --primary-1: #0077b6; /* Dark Blue */
        --primary-2: #00b4d8; /* Teal Blue */
        --accent: #6a4c93;     /* Purple Accent */
        --muted: #6b7280;
        --card-shadow: 0 10px 30px rgba(2,46,90,0.08);
    }

    body {
        font-family: 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        background: linear-gradient(180deg, #f7fbff 0%, #ffffff 50%);
        color: #0f1724;
        min-height: 100vh;
        margin: 0;
        padding-top: 80px; /* Space for fixed header */
        padding-bottom: 60px; /* Space for footer */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Header Style */
    header {
        background: linear-gradient(90deg, var(--primary-1), var(--primary-2));
        color: #fff;
        padding: 15px 0;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    header .container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    header h1 {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        margin: 0;
        font-size: 1.5rem;
    }

    header .nav-link {
        color: #fff;
        text-decoration: none;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 6px;
        transition: background 0.3s;
    }

    header .nav-link:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    /* Main Section Style */
    #login {
        padding: 40px 15px;
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-container {
        max-width: 400px; /* Constrain form width */
        width: 100%;
        margin: 0 auto;
    }

    .login-card {
        background: #fff;
        border-radius: 14px;
        padding: 30px;
        box-shadow: var(--card-shadow);
        text-align: center;
    }

    .login-card h4 {
        font-family: 'Montserrat', sans-serif;
        color: var(--primary-1);
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 1.5rem;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-size: 0.9rem;
        color: var(--primary-1);
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
        text-align: left;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #e6eef6;
        padding: 10px 12px;
        font-size: 0.95rem;
        width: 100%;
        box-sizing: border-box;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-2);
        box-shadow: 0 0 0 0.2rem rgba(0, 180, 216, 0.25);
    }

    .form-control::placeholder {
        color: var(--muted);
        opacity: 0.7;
    }

    .btn-primary {
        width: 100%;
        border-radius: 8px;
        padding: 12px;
        border: none;
        color: #fff;
        font-weight: 600;
        font-size: 1rem;
        background: linear-gradient(90deg, var(--primary-1), var(--primary-2));
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 6px 14px rgba(0, 119, 182, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 119, 182, 0.3);
    }

    .error-msg {
        color: #d32f2f;
        font-size: 0.9rem;
        margin-bottom: 15px;
        text-align: left;
    }

    .login-footer {
        margin-top: 20px;
        font-size: 0.9rem;
        text-align: center;
    }

    .login-footer a {
        color: var(--primary-2);
        font-weight: 600;
        text-decoration: none;
        margin: 0 5px;
    }

    .login-footer a:hover {
        text-decoration: underline;
    }

    /* Footer Style */
    footer {
        background: linear-gradient(90deg, var(--primary-1), var(--primary-2));
        color: #fff;
        padding: 15px 0;
        text-align: center;
        width: 100%;
    }

    footer p {
        margin: 0;
        font-size: 0.85rem;
    }

    footer a {
        color: #fff;
        text-decoration: underline;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        body {
            padding-top: 70px;
        }

        header h1 {
            font-size: 1.25rem;
        }

        header .nav-link {
            padding: 6px 12px;
            font-size: 0.9rem;
        }

        .login-card {
            padding: 20px;
            margin: 0 15px;
        }

        .login-card h4 {
            font-size: 1.25rem;
        }

        .form-control {
            font-size: 0.9rem;
            padding: 8px 10px;
        }

        .btn-primary {
            padding: 10px;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .login-container {
            margin: 0 10px;
        }

        .form-group label {
            font-size: 0.85rem;
        }

        .login-footer {
            font-size: 0.85rem;
        }
    }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</head>

<body>
<header>
    <div class="container">
        <h1>Hospital Appointmnet System</h1>
        <a href="../index.php" class="nav-link">
            <i class="bi bi-house-door-fill"></i> Home
        </a>
    </div>
</header>

<main>
    <section class="section-padding" id="login">
        <div class="login-container">
            <div class="login-card">
                <h4>Doctor Login</h4>

                <?php if (isset($error_message)) { ?>
                    <div class="error-msg"><?php echo $error_message; ?></div>
                <?php } ?>

                <form method="post" id="login-form" novalidate>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required minlength="8">
                    </div>
                    <button type="submit" name="login" class="btn btn-primary">Sign In</button>
                </form>

                <div class="login-footer">
                    <p>
                        <a href="signup.php">Signup / Register</a> |
                        <a href="forgot-password.php">Forgot Password?</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
</main>

<footer>
    <div class="container">
        <p>&copy; <?php echo date('Y'); ?> Hospital Appointmnet System. All rights reserved.</p>
    </div>
</footer>

<script>
// Client-side validation
document.getElementById("login-form").addEventListener("submit", function(e) {
    const email = this.email.value.trim();
    const password = this.password.value;

    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/;
    let valid = true;
    let message = "";

    if (!emailRegex.test(email)) {
        valid = false;
        message += "❌ Enter a valid email address.\n";
    }

    if (password.length < 8) {
        valid = false;
        message += "❌ Password must be at least 8 characters.\n";
    }

    if (!valid) {
        e.preventDefault();
        alert(message);
        return false;
    }
});
</script>
</body>
</html>