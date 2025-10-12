<?php
session_start();
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    $fname = trim($_POST['fname']);
    $mobno = trim($_POST['mobno']);
    $email = trim($_POST['email']);
    $sid = $_POST['specializationid'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Upgraded to password_hash for security

    // Check if email already exists
    $ret = "SELECT Email FROM tbldoctor WHERE Email = :email";
    $query = $dbh->prepare($ret);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() == 0) {
        // Insert new doctor
        $sql = "INSERT INTO tbldoctor(FullName, MobileNumber, Email, Specialization, Password) 
                VALUES(:fname, :mobno, :email, :sid, :password)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobno', $mobno, PDO::PARAM_STR);
        $query->bindParam(':sid', $sid, PDO::PARAM_INT);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if ($lastInsertId) {
            echo "<script>alert('You have signed up successfully');</script>";
            echo "<script>window.location.href='login.php'</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    } else {
        echo "<script>alert('Email already exists. Please try a different email.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hospital Appointment System || Doctor Sign Up</title>

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
    #signup {
        padding: 40px 15px;
    }

    .signup-form {
        background: #fff;
        border-radius: 14px;
        padding: 30px;
        box-shadow: var(--card-shadow);
        max-width: 500px; /* Constrain form width */
        margin: 0 auto;
    }

    .signup-form h2 {
        font-family: 'Montserrat', sans-serif;
        color: var(--primary-1);
        font-weight: 700;
        margin-bottom: 20px;
        text-align: center;
        font-size: 1.75rem;
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

    .form-control.select-custom {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%230077b6' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px;
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

    .signup-footer {
        text-align: center;
        margin-top: 20px;
        font-size: 0.9rem;
    }

    .signup-footer a {
        color: var(--primary-2);
        font-weight: 600;
        text-decoration: none;
    }

    .signup-footer a:hover {
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

        .signup-form {
            padding: 20px;
            margin: 0 15px;
        }

        .signup-form h2 {
            font-size: 1.5rem;
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
        .signup-form {
            margin: 0 10px;
        }

        .form-group label {
            font-size: 0.85rem;
        }

        .signup-footer {
            font-size: 0.85rem;
        }
    }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body id="top">
<header>
    <div class="container">
        <h1>Hospital Appointment System</h1>
        <a href="../index.php" class="nav-link">
            <i class="bi bi-house-door-fill"></i> Home
        </a>
    </div>
</header>

<main>
    <section class="section-padding" id="signup">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="signup-form">
                        <h2>Doctor Sign Up</h2>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="fname">Full Name</label>
                                <input id="fname" type="text" class="form-control" placeholder="Enter Full Name" name="fname" required="true" pattern="[A-Za-z\s]{2,50}" title="Name should only contain letters and spaces">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" placeholder="Enter Email" name="email" required="true">
                            </div>
                            <div class="form-group">
                                <label for="mobno">Mobile Number</label>
                                <input id="mobno" type="text" class="form-control" placeholder="Enter Mobile Number" name="mobno" required="true" pattern="[0-9]{10,15}" title="Enter a valid mobile number (10-15 digits)">
                            </div>
                            <div class="form-group">
                                <label for="specializationid">Specialization</label>
                                <select class="form-control select-custom" name="specializationid" id="specializationid" required>
                                    <option value="">Choose Specialization</option>
                                    <?php
                                    $sql1 = "SELECT * FROM tblspecialization";
                                    $query1 = $dbh->prepare($sql1);
                                    $query1->execute();
                                    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                    if ($query1->rowCount() > 0) {
                                        foreach ($results1 as $row1) { ?>
                                            <option value="<?php echo htmlentities($row1->ID); ?>">
                                                <?php echo htmlentities($row1->Specialization); ?>
                                            </option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control" placeholder="Enter Password" name="password" required="true" minlength="8" title="Password must be at least 8 characters">
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Register</button>
                        </form>
                        <div class="signup-footer">
                            <p>Already have an account? <a href="login.php">Sign In</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<footer>
    <div class="container">
        <p>&copy; <?php echo date('Y'); ?> Hospital Appointment System. All rights reserved.</p>
    </div>
</footer>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>