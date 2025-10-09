<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['damsid']==0)) {
  header('location:logout.php');
} else {

  if(isset($_POST['submit'])) { 
    $eid = $_GET['editid'];
    $aptid = $_GET['aptid'];
    $status = $_POST['status'];
    $remark = $_POST['remark'];

    $sql = "update tblappointment set Status=:status, Remark=:remark where ID=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':remark', $remark, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();

    echo '<script>alert("Appointment details updated successfully!");</script>';
    echo "<script>window.location.href ='all-appointment.php'</script>";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>DAMS || View Appointment Detail</title>
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
</head>

<body class="menubar-left menubar-unfold menubar-light theme-primary">

<?php include_once('includes/header.php');?>
<?php include_once('includes/sidebar.php');?>

<main id="app-main" class="app-main">
  <div class="wrap">
    <section class="app-content">
      <div class="row">
        <div class="col-md-12">
          <div class="widget">
            <header class="widget-header">
              <h4 class="widget-title" style="color: blue">Appointment Details</h4>
            </header>
            <hr class="widget-separator">
            <div class="widget-body">
              <div class="table-responsive">
                <?php
                  $eid = $_GET['editid'];
                  $sql = "SELECT * FROM tblappointment WHERE ID=:eid";
                  $query = $dbh->prepare($sql);
                  $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);

                  if($query->rowCount() > 0) {
                    foreach($results as $row) {
                ?>
                <form method="post">
                  <table border="1" class="table table-bordered mg-b-0">
                    <tr>
                      <th>Appointment Number</th>
                      <td><?php echo htmlentities($row->AppointmentNumber); ?></td>
                      <th>Patient Name</th>
                      <td><?php echo htmlentities($row->Name); ?></td>
                    </tr>

                    <tr>
                      <th>Mobile Number</th>
                      <td><?php echo htmlentities($row->MobileNumber); ?></td>
                      <th>Email</th>
                      <td><?php echo htmlentities($row->Email); ?></td>
                    </tr>

                    <tr>
                      <th>Appointment Date</th>
                      <td><?php echo htmlentities($row->AppointmentDate); ?></td>
                      <th>Appointment Time</th>
                      <td><?php echo htmlentities($row->AppointmentTime); ?></td>
                    </tr>

                    <tr>
                      <th>Apply Date</th>
                      <td><?php echo htmlentities($row->ApplyDate); ?></td>
                      <th>Status</th>
                      <td>
                        <select name="status" class="form-control" required>
                          <option value="">Select</option>
                          <option value="Approved" <?php if($row->Status=="Approved") echo "selected"; ?>>Approved</option>
                          <option value="Cancelled" <?php if($row->Status=="Cancelled") echo "selected"; ?>>Cancelled</option>
                          <option value="Pending" <?php if($row->Status=="Pending") echo "selected"; ?>>Pending</option>
                        </select>
                      </td>
                    </tr>

                    <tr>
                      <th>Remark</th>
                      <td colspan="3">
                        <textarea name="remark" rows="4" class="form-control" placeholder="Enter remark here..."><?php echo htmlentities($row->Remark); ?></textarea>
                      </td>
                    </tr>

                    <tr>
                      <td colspan="4" align="center">
                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                      </td>
                    </tr>
                  </table>
                </form>
                <?php } } ?>
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
