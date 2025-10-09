<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['damsid'] == 0)) {
    header('location:logout.php');
    exit();
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>DAMS - Dashboard</title>

    <link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
    <link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
    <link rel="stylesheet" href="libs/bower/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/core.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">

    <style>
        body.menubar-left {
            background: linear-gradient(120deg, #0077b6, #00b4d8, #90e0ef);
            background-size: 400% 400%;
            animation: gradientBG 20s ease infinite;
            font-family: 'Raleway', sans-serif;
        }
        @keyframes gradientBG {
            0% {background-position:0% 50%;}
            50% {background-position:100% 50%;}
            100% {background-position:0% 50%;}
        }
        .app-header {
            background: linear-gradient(135deg,#0077b6,#00b4d8);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            color: #ffffff !important;
            font-weight: 600;
        }
        .app-header a { color: #ffffff; transition: 0.3s; }
        .app-header a:hover { color: #ffec99; text-shadow: 0 0 8px rgba(255,255,153,0.7); }
        .menubar-light .menubar-scroll-inner .active a {
            background: linear-gradient(135deg,#00b4d8,#90e0ef);
            color: #fff !important;
            border-radius: 10px;
        }
        .widget.stats-widget {
            border-radius: 20px;
            padding: 25px;
            color: #fff;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            background: linear-gradient(135deg, #0077b6, #00b4d8);
        }
        .widget.stats-widget:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.3);
        }
        .widget.stats-widget h3 {
            font-size: 36px;
            font-weight: 700;
            color: #fff;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
        }
        .widget.stats-widget small {
            font-size: 14px;
            letter-spacing: 0.5px;
            color: #e0f7fa;
        }
        .small-chart span {
            background: linear-gradient(135deg,#00b4d8,#90e0ef,#0077b6);
            border-radius: 2px;
        }
        .app-content {
            background: rgba(255,255,255,0.08);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .counter { font-weight: bold; }
        a:hover {
            text-shadow: 0 0 8px #00b4d8, 0 0 16px #0077b6;
            color: #ffffff;
        }
        @media (max-width: 768px){
            .widget.stats-widget h3 { font-size: 28px; }
            .widget.stats-widget small { font-size: 12px; }
        }
    </style>

    <script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
    <script> Breakpoints(); </script>
</head>
<body class="menubar-left menubar-unfold menubar-light theme-primary">

<?php include_once('includes/header.php');?>
<?php include_once('includes/sidebar.php');?>

<main id="app-main" class="app-main">
  <div class="wrap">
    <section class="app-content">
        <div class="row">
            <?php 
            $docid = $_SESSION['damsid'];
            $role = isset($_SESSION['role']) ? $_SESSION['role'] : 'doctor'; // fallback to doctor if not set

            // Define base query condition
            $condition = ($role === 'admin') ? "" : "WHERE Doctor = :docid";

            // New Appointments
            $sql = "SELECT * FROM tblappointment WHERE Status IS NULL " . ($role !== 'admin' ? "AND Doctor = :docid" : "");
            $query = $dbh->prepare($sql);
            if ($role !== 'admin') $query->bindParam(':docid', $docid, PDO::PARAM_STR);
            $query->execute();
            $totnewapt = $query->rowCount();

            // Approved Appointments
            $sql = "SELECT * FROM tblappointment WHERE Status = 'Approved' " . ($role !== 'admin' ? "AND Doctor = :docid" : "");
            $query = $dbh->prepare($sql);
            if ($role !== 'admin') $query->bindParam(':docid', $docid, PDO::PARAM_STR);
            $query->execute();
            $totappapt = $query->rowCount();

            // Cancelled Appointments
            $sql = "SELECT * FROM tblappointment WHERE Status = 'Cancelled' " . ($role !== 'admin' ? "AND Doctor = :docid" : "");
            $query = $dbh->prepare($sql);
            if ($role !== 'admin') $query->bindParam(':docid', $docid, PDO::PARAM_STR);
            $query->execute();
            $totncanapt = $query->rowCount();

            // Total Appointments
            $sql = "SELECT * FROM tblappointment " . ($role !== 'admin' ? "WHERE Doctor = :docid" : "");
            $query = $dbh->prepare($sql);
            if ($role !== 'admin') $query->bindParam(':docid', $docid, PDO::PARAM_STR);
            $query->execute();
            $totapt = $query->rowCount();
            ?>

            <!-- Widgets -->
            <div class="col-md-6 col-sm-6">
                <div class="widget stats-widget">
                    <div class="widget-body clearfix">
                        <div class="pull-left">
                            <h3 class="widget-title text-warning"><span class="counter"><?php echo htmlentities($totnewapt);?></span></h3>
                            <small>Total New Appointment<?php if($role==='admin'){ echo ' (All Doctors)'; } ?></small>
                        </div>
                    </div>
                    <footer>
                        <a href="new-appointment.php"><small>View Detail</small></a>
                        <span class="small-chart pull-right" data-plugin="sparkline" data-options="[4,3,5,2,1], { type: 'bar', barColor: '#ffffff', barWidth: 5, barSpacing: 2 }"></span>
                    </footer>
                </div>
            </div>

            <div class="col-md-6 col-sm-6">
                <div class="widget stats-widget" style="background: linear-gradient(135deg,#00b4d8,#90e0ef);">
                    <div class="widget-body clearfix">
                        <div class="pull-left">
                            <h3 class="widget-title text-success"><span class="counter"><?php echo htmlentities($totappapt);?></span></h3>
                            <small>Total Approved<?php if($role==='admin'){ echo ' (All Doctors)'; } ?></small>
                        </div>
                    </div>
                    <footer>
                        <a href="approved-appointment.php"><small>View Detail</small></a>
                        <span class="small-chart pull-right" data-plugin="sparkline" data-options="[1,2,3,5,4], { type: 'bar', barColor: '#ffffff', barWidth: 5, barSpacing: 2 }"></span>
                    </footer>
                </div>
            </div>

            <div class="col-md-6 col-sm-6">
                <div class="widget stats-widget" style="background: linear-gradient(135deg,#0077b6,#90e0ef);">
                    <div class="widget-body clearfix">
                        <div class="pull-left">
                            <h3 class="widget-title text-danger"><span class="counter"><?php echo htmlentities($totncanapt);?></span></h3>
                            <small>Cancelled Appointment<?php if($role==='admin'){ echo ' (All Doctors)'; } ?></small>
                        </div>
                    </div>
                    <footer>
                        <a href="cancelled-appointment.php"><small>View Detail</small></a>
                        <span class="small-chart pull-right" data-plugin="sparkline" data-options="[2,4,3,4,3], { type: 'bar', barColor: '#ffffff', barWidth: 5, barSpacing: 2 }"></span>
                    </footer>
                </div>
            </div>

            <div class="col-md-6 col-sm-6">
                <div class="widget stats-widget" style="background: linear-gradient(135deg,#00b4d8,#0077b6);">
                    <div class="widget-body clearfix">
                        <div class="pull-left">
                            <h3 class="widget-title text-primary"><span class="counter"><?php echo htmlentities($totapt);?></span></h3>
                            <small>Total Appointment<?php if($role==='admin'){ echo ' (All Doctors)'; } ?></small>
                        </div>
                    </div>
                    <footer>
                        <a href="all-appointment.php"><small>View Detail</small></a>
                        <span class="small-chart pull-right" data-plugin="sparkline" data-options="[5,4,3,5,2],{ type: 'bar', barColor: '#ffffff', barWidth: 5, barSpacing: 2 }"></span>
                    </footer>
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
<script src="libs/bower/moment/moment.js"></script>
<script src="libs/bower/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="assets/js/fullcalendar.js"></script>

</body>
</html>
<?php } ?>
