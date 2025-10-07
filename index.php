<?php
session_start();
include('doctor/includes/dbconnection.php');

if(isset($_POST['submit'])) {
    $name=$_POST['name'];
    $mobnum=$_POST['phone'];
    $email=$_POST['email'];
    $appdate=$_POST['date'];
    $aaptime=$_POST['time'];
    $specialization=$_POST['specialization'];
    $doctorlist=$_POST['doctorlist'];
    $message=$_POST['message'];
    $aptnumber=mt_rand(100000000, 999999999);
    $cdate=date('Y-m-d');

    if($appdate<=$cdate){
        echo '<script>alert("Appointment date must be greater than today\'s date")</script>';
    } else {
        $sql="INSERT INTO tblappointment(AppointmentNumber,Name,MobileNumber,Email,AppointmentDate,AppointmentTime,Specialization,Doctor,Message)
              VALUES (:aptnumber,:name,:mobnum,:email,:appdate,:aaptime,:specialization,:doctorlist,:message)";
        $query=$dbh->prepare($sql);
        $query->bindParam(':aptnumber',$aptnumber,PDO::PARAM_STR);
        $query->bindParam(':name',$name,PDO::PARAM_STR);
        $query->bindParam(':mobnum',$mobnum,PDO::PARAM_STR);
        $query->bindParam(':email',$email,PDO::PARAM_STR);
        $query->bindParam(':appdate',$appdate,PDO::PARAM_STR);
        $query->bindParam(':aaptime',$aaptime,PDO::PARAM_STR);
        $query->bindParam(':specialization',$specialization,PDO::PARAM_STR);
        $query->bindParam(':doctorlist',$doctorlist,PDO::PARAM_STR);
        $query->bindParam(':message',$message,PDO::PARAM_STR);
        $query->execute();

        $LastInsertId=$dbh->lastInsertId();
        if ($LastInsertId>0) {
            // Redirect to successfully-booked.php
          echo "<script>window.open('successfully-booked.php', '_blank');</script>";

            exit();
        } else {
            echo '<script>alert("❌ Something Went Wrong. Please try again")</script>';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Doctor Appointment Management System || Home Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/owl.carousel.min.css" rel="stylesheet">
    <link href="css/owl.theme.default.min.css" rel="stylesheet">
    <link href="css/templatemo-medic-care.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    function getdoctors(val) {
        $.ajax({
            type: "POST",
            url: "get_doctors.php",
            data:'sp_id='+val,
            success: function(data){
                $("#doctorlist").html(data);
            }
        });
    }
    </script>

    <style>
    body { font-family: 'Open Sans', sans-serif; background: #f0f7ff; color: #2c3e50; }
    h2,h3 { font-weight:700; margin-bottom:20px; }
    .hero-img { width:100%; height:600px; object-fit:cover; border-radius:15px; animation: fadeIn 2s ease; }
    #about { padding:60px 0; text-align:center; }
    #about p { max-width:800px; margin:auto; font-size:16px; line-height:1.7; }
    .hospital-facts { display:flex; flex-wrap:wrap; align-items:center; justify-content:center; margin:50px 0; background:#fff; padding:40px; border-radius:20px; box-shadow:0 8px 20px rgba(0,0,0,0.1); }
    .hospital-facts img { width:100%; max-width:600px; border-radius:15px; margin-right:40px; transition: transform 1.5s ease-in-out; }
    .hospital-facts img:hover { transform: scale(1.05) rotate(-1deg); }
    .hospital-facts .facts { max-width:500px; }
    .hospital-facts ul { list-style: disc; margin-left:20px; font-size:16px; line-height:1.7; }
    @media(max-width:768px) { .hospital-facts { flex-direction:column; text-align:center; } .hospital-facts img { margin:0 0 20px 0; } }
    .booking-form { background: #fff; border-radius: 20px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); padding: 50px 40px; margin-bottom: 50px; }
    .form-control { border-radius:12px; border:1px solid #cfd8dc; padding:12px 15px; font-size:15px; margin-bottom:20px; }
    .form-control:focus { border-color:#00b4d8; box-shadow:0 0 8px rgba(0,180,216,0.4); }
    #submit-button { background:linear-gradient(135deg,#ff6f61,#ffca3a,#6a4c93,#ff6f61); background-size:400% 400%; color:#fff; font-weight:600; border-radius:30px; border:none; padding:14px 0; font-size:16px; cursor:pointer; animation: buttonGradient 5s ease infinite; }
    #submit-button:hover { transform: translateY(-3px); box-shadow:0 6px 15px rgba(0,0,0,0.2); }
    @keyframes buttonGradient { 0%{background-position:0% 50%;} 50%{background-position:100% 50%;} 100%{background-position:0% 50%;} }
    @keyframes fadeIn { from {opacity:0;} to {opacity:1;} }
    </style>
</head>
<body id="top">
<main>
<?php include_once('includes/header.php');?>

<section class="hero" id="hero">
    <div class="container">
        <img src="images/slider/Sukraraj_Tropical_and_Infectious_Disease_Hospital__STIDH1618490030_1024.jpg" class="img-fluid hero-img" alt="Tegu Hospital">
    </div>
</section>

<section class="section-padding" id="about">
    <div class="container">
        <h2>About Our Hospital</h2>
        <p>Teku Hospital has been providing exceptional healthcare for decades, specializing in tropical and infectious diseases. Our mission is to deliver world-class medical care while training future medical professionals and conducting research to improve health outcomes across the region. We emphasize patient safety, advanced technology, and compassionate care for all.</p>
    </div>
</section>

<section class="hospital-facts">
    <img src="images/slider/Sukraraj_Tropical_and_Infectious_Disease_Hospital__STIDH1618490030_1024.jpg" alt="Tegu Hospital">
    <div class="facts">
        <h2>Hospital Facts</h2>
        <ul>
            <li>Established in 1933</li>
            <li>Specialized in tropical & infectious diseases</li>
            <li>State-of-the-art labs & ICU facilities</li>
            <li>National & international collaborations</li>
            <li>Providing patient care & research excellence</li>
        </ul>
    </div>
</section>

<section class="section-padding" id="booking">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12 mx-auto">
                <div class="booking-form">
                    <h2 class="text-center mb-4">Book an Appointment</h2>
                    <form role="form" method="post">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Full Name" required>
                            </div>
                            <div class="col-lg-6 col-12">
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" required>
                            </div>
                            <div class="col-lg-6 col-12">
                                <input type="number" name="phone" id="phone" class="form-control" placeholder="Phone Number" maxlength="10">
                            </div>
                            <div class="col-lg-6 col-12">
                                <input type="date" name="date" id="date" class="form-control">
                            </div>
                            <div class="col-lg-6 col-12">
                                <input type="time" name="time" id="time" class="form-control">
                            </div>
                            <div class="col-lg-6 col-12">
                                <select onChange="getdoctors(this.value);" name="specialization" id="specialization" class="form-control" required>
                                    <option value="">Select Specialization</option>
                                    <?php
                                    $sql="SELECT * FROM tblspecialization";
                                    $stmt=$dbh->query($sql);
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    while($row =$stmt->fetch()) { ?>
                                        <option value="<?php echo $row['ID'];?>"><?php echo $row['Specialization'];?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-lg-6 col-12">
                                <select name="doctorlist" id="doctorlist" class="form-control">
                                    <option value="">Select Doctor</option>
                                    <?php
                                    $sql="SELECT * FROM tbldoctor";
                                    $stmt=$dbh->query($sql);
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    while($row =$stmt->fetch()) { ?>
                                        <option value="<?php echo $row['ID'];?>"><?php echo $row['FullName'];?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" rows="5" id="message" name="message" placeholder="Additional Message"></textarea>
                            </div>
                            <div class="col-lg-3 col-md-4 col-6 mx-auto">
                              <button type="button" class="form-control" id="submit-button" onclick="submitForm()">Book Now</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

</main>
<?php include_once('includes/footer.php');?>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/scrollspy.min.js"></script>
<script src="js/custom.js"></script>
<script>
function submitForm() {
    const form = document.querySelector('form');
    const formData = new FormData(form);

    // Open the success page in a new tab immediately
    window.open('successfully-booked.php', '_blank');

    // Submit the form normally to the server
    form.submit();
}
</script>

</body>
</html>
