<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['damsid']==0)) {
  header('location:logout.php');
  } else{

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>DAMS - Appointment Between Dates Report</title>

  <link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
  <link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
  <link rel="stylesheet" href="libs/bower/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/css/core.css">
  <link rel="stylesheet" href="assets/css/app.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
  <script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
  <script>Breakpoints();</script>

  <style>
    body {
      background: linear-gradient(135deg, #f6f9fc, #eaf1ff);
      font-family: 'Raleway', sans-serif;
    }

    .widget {
      background: #ffffff;
      border-radius: 15px;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
      transition: all 0.3s ease-in-out;
    }

    .widget:hover {
      transform: translateY(-4px);
      box-shadow: 0px 8px 16px rgba(0,0,0,0.15);
    }

    .widget-header {
      background: linear-gradient(90deg, #007bff, #6610f2);
      color: #fff;
      padding: 18px;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
      text-align: center;
      animation: fadeInDown 0.8s ease;
    }

    .widget-title {
      font-size: 1.6rem;
      font-weight: 700;
      margin: 0;
      color: #fff !important;
    }

    .widget-body {
      padding: 30px 40px;
      animation: fadeInUp 1s ease;
    }

    .form-control {
      border-radius: 10px;
      border: 1px solid #ccc;
      padding: 10px;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: #007bff;
      box-shadow: 0 0 8px rgba(0,123,255,0.3);
    }

    label {
      color: #333;
      font-weight: 600;
      font-size: 1rem;
    }

    .btn-success {
      background: linear-gradient(90deg, #28a745, #20c997);
      border: none;
      padding: 10px 25px;
      border-radius: 8px;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    .btn-success:hover {
      transform: scale(1.05);
      box-shadow: 0px 4px 10px rgba(32,201,151,0.4);
    }

    footer {
      background: #007bff;
      color: #fff !important;
      text-align: center;
      padding: 15px 0;
      font-weight: 500;
    }

    @keyframes fadeInDown {
      0% { opacity: 0; transform: translateY(-20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
  
<body class="menubar-left menubar-unfold menubar-light theme-primary">

<?php include_once('includes/header.php');?>
<?php include_once('includes/sidebar.php');?>

<main id="app-main" class="app-main">
  <div class="wrap">
    <section class="app-content">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="widget">
            <header class="widget-header">
              <h3 class="widget-title">Search Appointments Between Dates</h3>
            </header>
            <div class="widget-body">
              <form class="form-horizontal" method="post" name="bwdatesreport" action="appointment-bwdates-reports-details.php">
                <div class="form-group">
                  <label for="fromdate" class="col-sm-3 control-label">From Date:</label>
                  <div class="col-sm-9">
                    <input type="date" class="form-control" id="fromdate" name="fromdate" required>
                  </div>
                </div>
                <div class="form-group mt-3">
                  <label for="todate" class="col-sm-3 control-label">To Date:</label>
                  <div class="col-sm-9">
                    <input type="date" class="form-control" id="todate" name="todate" required>
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-sm-9 col-sm-offset-3 text-center">
                    <button type="submit" class="btn btn-success" name="submit">Submit</button>
                  </div>
                </div>
              </form>
            </div>
          </div><!-- .widget -->
        </div><!-- .col -->
      </div><!-- .row -->
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
<?php }  ?>