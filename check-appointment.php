<?php
session_start();
// The include path for dbconnection is typically '../doctor/includes/dbconnection.php' 
// if this file is in the root directory and the 'doctor' folder is also in the root.
// Adjust the path if necessary for your file structure.
include('doctor/includes/dbconnection.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hospital Appointment System || Check Appointment</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">

    <style>
    :root{
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
    }

    /* Header Style */
    header {
        background: linear-gradient(90deg, var(--primary-1), var(--primary-2));
        color: #fff;
        padding: 20px 0;
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
    #booking {
        padding: 140px 0 60px; /* Adjusted for fixed header */
    }

    .booking-form {
        background: #fff;
        border-radius: 14px;
        padding: 35px;
        box-shadow: var(--card-shadow);
        margin-bottom: 40px;
    }

    .booking-form h2 {
        font-family: 'Montserrat', sans-serif;
        color: var(--primary-1);
        font-weight: 700;
        margin-bottom: 25px;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #e6eef6;
        padding: 12px 14px;
        font-size: 15px;
        margin-bottom: 15px;
    }
    
    .form-control:focus { 
        outline:none; 
        border-color: var(--primary-2); 
        box-shadow: 0 0 0 0.25rem rgba(0, 180, 216, 0.25);
    }

    #submit-button {
        width: 100%;
        border-radius: 10px;
        padding: 12px 18px;
        border: none;
        color: #fff;
        font-weight: 600;
        background: linear-gradient(90deg, var(--primary-1), var(--primary-2));
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 6px 14px rgba(0, 119, 182, 0.2);
    }
    #submit-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 119, 182, 0.3);
    }

    /* Results Table Styling */
    h4 {
        color: var(--primary-1);
        font-weight: 600;
        margin-top: 20px;
    }

    .table-responsive {
        background: #fff;
        border-radius: 10px;
        box-shadow: var(--card-shadow);
        overflow-x: auto;
    }

    .table-custom {
        width: 100%;
        margin-bottom: 0;
    }

    .table-custom thead tr {
        background-color: var(--primary-1);
        color: #fff;
    }
    .table-custom th {
        padding: 15px 12px;
        font-weight: 600;
        border: none !important;
    }
    .table-custom td {
        padding: 12px;
        vertical-align: middle;
        border-top: 1px solid #e9ecef;
    }
    .table-custom tbody tr:nth-child(even) {
        background-color: #f8fbfc;
    }

    /* Footer Style */
    footer {
        background: linear-gradient(90deg, var(--primary-1), var(--primary-2));
        color: #fff;
        padding: 20px 0;
        text-align: center;
        margin-top: 40px;
    }

    footer p {
        margin: 0;
        font-size: 0.875rem;
    }

    footer a {
        color: #fff;
        text-decoration: underline;
    }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body id="top">
<header>
    <div class="container">
        <h1>Hospital Appointment System</h1>
        <a href="index.php" class="nav-link">
            <i class="bi bi-house-door-fill"></i> Home
        </a>
    </div>
</header>

<main>
    <section class="section-padding" id="booking">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-12 mx-auto">
                    <div class="booking-form">
                        <h2 class="text-center mb-lg-3 mb-2">Check Your Appointment</h2>

                        <form role="form" method="post">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 col-12">
                                    <input id="searchdata" type="text" name="searchdata" required="true" class="form-control" placeholder="Enter Mobile Number" pattern="[0-9]{10,15}" title="Enter a valid mobile number (10 digits)">
                                </div>
                                <div class="col-lg-4 col-md-4 col-6">
                                    <button type="submit" class="form-control" name="search" id="submit-button">Check Status</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php
                    if(isset($_POST['search'])) { 
                        $sdata = trim($_POST['searchdata']); // remove spaces

                        // Modified SQL to only search by MobileNumber (exact match for privacy)
                        $sql = "SELECT * FROM tblappointment 
                                WHERE MobileNumber = :sdata";

                        $query = $dbh->prepare($sql);
                        $query->bindParam(':sdata', $sdata, PDO::PARAM_STR);

                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                        $cnt = 1;
                        ?>
                        <h4 align="center">Search Results for Mobile Number: "<?php echo htmlentities($sdata);?>" </h4>
                        <div class="widget-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-custom">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Appointment Number</th>
                                            <th>Patient Name</th>
                                            <th>Mobile Number</th>
                                            <th>Status</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if($query->rowCount() > 0) {
                                        foreach($results as $row) { 
                                            // Determine status badge style
                                            $status = $row->Status;
                                            $status_text = $status ?: "Pending";
                                            $status_class = 'text-warning'; // Default pending
                                            
                                            if ($status == 'Approved') {
                                                $status_class = 'text-success';
                                            } elseif ($status == 'Cancelled') {
                                                $status_class = 'text-danger';
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo htmlentities($cnt); ?></td>
                                                <td><?php echo htmlentities($row->AppointmentNumber); ?></td>
                                                <td><?php echo htmlentities($row->Name); ?></td>
                                                <td><?php echo htmlentities($row->MobileNumber); ?></td>
                                                <td><strong class="<?php echo $status_class; ?>"><?php echo $status_text; ?></strong></td>
                                                <td><?php echo $row->Remark ?: "N/A"; ?></td>
                                            </tr>
                                        <?php $cnt++; }
                                    } else { ?>
                                        <tr>
                                            <td colspan="6" style="text-align:center; padding: 20px;">
                                                <strong class="text-danger">No record found for this mobile number. Please check your input.</strong>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } ?>
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
<script src="js/custom.js"></script>
</body>
</html>