<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['damsid']==0)) {
  header('location:logout.php');
} else{
    if(isset($_POST['submit']))
    {
        $did=$_SESSION['damsid'];
        $name=$_POST['fname'];
        $mobno=$_POST['mobilenumber'];
        $email=$_POST['email'];
        $sid=$_POST['specializationid'];

        $sql="UPDATE tbldoctor SET FullName=:name, MobileNumber=:mobilenumber, Email=:email, Specialization=:sid WHERE ID=:did";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name',$name,PDO::PARAM_STR);
        $query->bindParam(':email',$email,PDO::PARAM_STR);
        $query->bindParam(':mobilenumber',$mobno,PDO::PARAM_STR);
        $query->bindParam(':sid',$sid,PDO::PARAM_STR);
        $query->bindParam(':did',$did,PDO::PARAM_STR);
        $query->execute();

        echo '<script>alert("Profile has been updated")</script>';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>DAMS - Doctor Profile</title>

    <!-- CSS Links -->
    <link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
    <link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/core.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">

    <script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
    <script>
        Breakpoints();
    </script>

    <style>
        /* Page background gradient */
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Raleway', sans-serif;
        }

        /* Main content fade-in */
        #app-main {
            animation: fadeInPage 1s ease-in;
            padding-top: 20px;
        }
        @keyframes fadeInPage {
            from {opacity: 0; transform: translateY(20px);}
            to {opacity:1; transform: translateY(0);}
        }

        /* Widget styling */
        .widget {
            background-color: #ffffffcc;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 15px 25px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .widget::before {
            content: '';
            position: absolute;
            top: -50px; left: -50px;
            width: 100px; height: 100px;
            background: rgba(52, 152, 219,0.1);
            border-radius: 50%;
            animation: float 6s infinite ease-in-out alternate;
        }

        .widget::after {
            content: '';
            position: absolute;
            bottom: -50px; right: -50px;
            width: 120px; height: 120px;
            background: rgba(46, 204, 113,0.1);
            border-radius: 50%;
            animation: float 8s infinite ease-in-out alternate-reverse;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(20px) rotate(20deg);}
            100% { transform: translateY(0px);}
        }

        /* Header styling */
        .widget-title {
            color: #2c3e50;
            font-weight: 700;
            position: relative;
        }
        .widget-title::after {
            content: '';
            width: 50px;
            height: 3px;
            background: #3498db;
            display: block;
            margin-top: 5px;
            border-radius: 2px;
        }

        /* Form labels */
        .form-horizontal .control-label {
            color: #34495e;
            font-weight: 500;
        }

        /* Inputs */
        .form-control {
            border-radius: 8px;
            border: 1px solid #bdc3c7;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 8px rgba(52,152,219,0.3);
        }

        /* Buttons */
        .btn-success {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-success:hover {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            transform: scale(1.05);
        }

        /* Floating icons/animation on form fields */
        .form-group {
            position: relative;
            animation: fadeInField 0.8s ease forwards;
        }
        .form-group:nth-child(1) { animation-delay: 0.2s;}
        .form-group:nth-child(2) { animation-delay: 0.4s;}
        .form-group:nth-child(3) { animation-delay: 0.6s;}
        .form-group:nth-child(4) { animation-delay: 0.8s;}
        @keyframes fadeInField {
            from {opacity:0; transform: translateX(-20px);}
            to {opacity:1; transform: translateX(0);}
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
                            <h3 class="widget-title">Doctor Profile</h3>
                        </header>
                        <hr class="widget-separator">
                        <div class="widget-body">
                        <?php
                            $did=$_SESSION['damsid'];
                            $sql="SELECT tbldoctor.*,tblspecialization.ID as sid,tblspecialization.Specialization as sssp FROM tbldoctor JOIN tblspecialization ON tblspecialization.ID=tbldoctor.Specialization WHERE tbldoctor.ID=:did";
                            $query = $dbh -> prepare($sql);
                            $query->bindParam(':did',$did,PDO::PARAM_STR);
                            $query->execute();
                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                            if($query->rowCount() > 0){
                                foreach($results as $row){
                        ?>
                            <form class="form-horizontal" method="post">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Full Name:</label>
                                    <div class="col-sm-9">
                                        <input id="fname" type="text" class="form-control" name="fname" required value="<?php echo $row->FullName;?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Email:</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" name="email" required value="<?php echo $row->Email;?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Contact Number:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="mobilenumber" required maxlength="10" value="<?php echo $row->MobileNumber;?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Specialization:</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="specializationid">
                                            <option value="<?php echo htmlentities($row->ID);?>"><?php echo htmlentities($row->sssp);?></option>
                                            <?php
                                                $sql1="SELECT * FROM tblspecialization";
                                                $query1 = $dbh -> prepare($sql1);
                                                $query1->execute();
                                                $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                                                if($query1->rowCount() > 0){
                                                    foreach($results1 as $row1){
                                            ?>
                                            <option value="<?php echo htmlentities($row1->ID);?>"><?php echo htmlentities($row1->Specialization);?></option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Registration Date:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="<?php echo $row->CreationDate;?>" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <button type="submit" class="btn btn-success" name="submit">Update Profile</button>
                                    </div>
                                </div>
                            </form>
                        <?php }} ?>
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

</body>
</html>
<?php } ?>
