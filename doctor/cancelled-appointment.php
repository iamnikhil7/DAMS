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
    <title>DAMS || Cancelled Appointment Detail</title>

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

        /* Header styling */
        .app-header {
            background: linear-gradient(135deg,#0077b6,#00b4d8);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            color: #fff !important;
            font-weight: 600;
        }
        .app-header a { color:#fff; transition:0.3s; }
        .app-header a:hover { color:#ffec99; text-shadow: 0 0 8px rgba(255,255,153,0.7); }

        /* Table styling */
        .table-custom {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            background: rgba(255,255,255,0.05);
        }
        .table-custom th {
            background: linear-gradient(135deg,#0077b6,#00b4d8);
            color: #fff;
            font-weight: 600;
            text-align: center;
        }
        .table-custom td {
            text-align: center;
            vertical-align: middle;
            font-weight: 500;
            color: #000000ff;
        }
        .table-custom tbody tr:hover {
            background: rgba(255,255,255,0.15);
            transform: scale(1.02);
            transition: all 0.3s ease;
        }

        /* Widget header styling */
        .widget-header h4 {
            font-weight: 700;
            color: #fff;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.3);
        }

        /* Action button animation */
        .btn-primary {
            background: linear-gradient(135deg,#00b4d8,#0077b6);
            border: none;
            font-weight: 600;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.4);
            background: linear-gradient(135deg,#0077b6,#90e0ef);
        }

        /* Neon row animation */
        .table-custom tbody tr {
            animation: fadeSlide 0.8s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        @keyframes fadeSlide {
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive adjustments */
        @media (max-width: 768px){
            .table-custom td, .table-custom th { font-size: 13px; }
        }

    </style>

    <script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
    <script>
        Breakpoints();
    </script>
</head>
<body class="menubar-left menubar-unfold menubar-light theme-primary">

<?php include_once('includes/header.php');?>
<?php include_once('includes/sidebar.php');?>

<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
    <div class="wrap">
        <section class="app-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget">
                        <header class="widget-header">
                            <h4 class="widget-title" style="color:black;">Cancelled Appointment</h4>
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
                                        $sql="SELECT * from tblappointment where Status='Cancelled' && Doctor=:docid";
                                        $query = $dbh -> prepare($sql);
                                        $query-> bindParam(':docid', $docid, PDO::PARAM_STR);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt=1;
                                        if($query->rowCount() > 0)
                                        {
                                        foreach($results as $row)
                                        {
                                        ?>
                                        <tr>
                                            <td><?php echo htmlentities($cnt);?></td>
                                            <td><?php echo htmlentities($row->AppointmentNumber);?></td>
                                            <td><?php echo htmlentities($row->Name);?></td>
                                            <td><?php echo htmlentities($row->MobileNumber);?></td>
                                            <td><?php echo htmlentities($row->Email);?></td>
                                            <td><?php echo ($row->Status=="") ? "Not Updated Yet" : htmlentities($row->Status);?></td>
                                            <td>
                                                <a href="view-appointment-detail.php?editid=<?php echo htmlentities ($row->ID);?>&&aptid=<?php echo htmlentities ($row->AppointmentNumber);?>" class="btn btn-primary">View</a>
                                            </td>
                                        </tr>
                                        <?php $cnt++; } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- .widget -->
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
