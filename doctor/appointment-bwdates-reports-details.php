<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['damsid']==0)) {
  header('location:logout.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>DAMS || B/W Dates Appointment Detail</title>

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
  <script>
    Breakpoints();
  </script>

  <style>
    /* Fade-in for main content */
    #app-main { 
      animation: fadeInMain 0.8s ease-in;
    }
    @keyframes fadeInMain {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Widget header */
    .widget-header h4 {
      color: #2c3e50;
      font-weight: 600;
    }

    /* Table styling */
    .table-custom {
      border: 1px solid #ddd;
      background-color: #fff;
    }

    .table-custom th {
      background-color: #3498db;
      color: #fff;
      font-weight: 600;
      text-align: center;
    }

    .table-custom td {
      text-align: center;
      vertical-align: middle;
      color: #34495e;
    }

    /* Table row fade-in animation */
    .table-custom tbody tr {
      opacity: 0;
      animation: fadeInRows 0.5s forwards;
    }
    .table-custom tbody tr:nth-child(1) { animation-delay: 0.1s; }
    .table-custom tbody tr:nth-child(2) { animation-delay: 0.2s; }
    .table-custom tbody tr:nth-child(3) { animation-delay: 0.3s; }
    .table-custom tbody tr:nth-child(4) { animation-delay: 0.4s; }
    .table-custom tbody tr:nth-child(5) { animation-delay: 0.5s; }
    @keyframes fadeInRows {
      to { opacity: 1; }
    }

    /* Row hover effect */
    .table-custom tbody tr:hover {
      background-color: #eaf3fc;
      transform: scale(1.01);
      transition: all 0.3s ease;
    }

    /* Button styling */
    .btn-primary {
      background-color: #3498db;
      border-color: #3498db;
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #2980b9;
      border-color: #2980b9;
      transform: scale(1.05);
    }

    /* Report header color */
    h5 {
      color: #2980b9;
      font-weight: 500;
    }
  </style>
</head>

<body class="menubar-left menubar-unfold menubar-light theme-primary">

<?php include_once('includes/header.php');?>
<?php include_once('includes/sidebar.php');?>

<main id="app-main" class="app-main">
  <div class="wrap">
    <section class="app-content">
      <div class="row">
        <div class="col-md-12">
          <div class="widget animated fadeIn">
            <header class="widget-header">
              <h4 class="m-t-0 header-title">Between Dates Reports</h4>
              <?php
                $fdate=$_POST['fromdate'];
                $tdate=$_POST['todate'];
              ?>
              <h5 align="center">
                Report from <?php echo $fdate?> to <?php echo $tdate?>
              </h5>
            </header>
            <hr class="widget-separator">
            <div class="widget-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                  <thead>
                    <tr>
                      <th>S.No</th>
                      <th>Appointment Number</th>
                      <th>Patient Name</th>
                      <th>Mobile Number</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                      $docid=$_SESSION['damsid'];
                      $sql="SELECT * from tblappointment where (date(ApplyDate) between '$fdate' and '$tdate') && Doctor=:docid";
                      $query = $dbh -> prepare($sql);
                      $query-> bindParam(':docid', $docid, PDO::PARAM_STR);
                      $query->execute();
                      $results=$query->fetchAll(PDO::FETCH_OBJ);
                      $cnt=1;
                      if($query->rowCount() > 0) {
                        foreach($results as $row) { ?>
                          <tr>
                            <td><?php echo htmlentities($cnt);?></td>
                            <td><?php echo htmlentities($row->AppointmentNumber);?></td>
                            <td><?php echo htmlentities($row->Name);?></td>
                            <td><?php echo htmlentities($row->MobileNumber);?></td>
                            <td><?php echo htmlentities($row->Email);?></td>
                            <td>
                              <?php  
                                if($row->Status==''){
                                  echo "Not Updated Yet";
                                } else {
                                  echo htmlentities($row->Status);
                                } 
                              ?>
                            </td>                
                            <td>
                              <a href="view-appointment-detail.php?editid=<?php echo htmlentities ($row->ID);?>&&aptid=<?php echo htmlentities ($row->AppointmentNumber);?>" class="btn btn-primary">View</a>
                            </td>
                          </tr>
                    <?php $cnt++; } } ?> 
                  </tbody>
                </table>
              </div>
            </div>
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
