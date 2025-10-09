<?php
session_start();
// IMPORTANT: Ensure 'doctor/includes/dbconnection.php' has the correct database credentials.
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
    
    // Use Unix timestamps for reliable date and time comparison.
    $currentTimeStamp = time(); 
    $appointmentDateTime = $appdate . ' ' . $aaptime;
    $appointmentTimeStamp = strtotime($appointmentDateTime);
    
    // 1. Validate appointment date (must be today or later)
    if($appdate < $cdate) {
        echo '<script>alert("Appointment date must be today or later")</script>';
    } 
    // 2. Validate time (must be later than the current time)
    elseif($appointmentTimeStamp <= $currentTimeStamp) {
        echo '<script>alert("❌ Please select a valid time. Time must be later than the current time.")</script>';
    } else {
        // Database insertion logic (GOES TO tblappointment)
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
        
        if ($query->execute()) {
            $LastInsertId=$dbh->lastInsertId();
            if ($LastInsertId>0) {
                // REDIRECTION FIX: Guaranteed redirect after successful DB save
                header('Location: successfully-booked.php?aptid=' . $aptnumber); 
                exit(); 
            } else {
                echo '<script>alert("❌ Something Went Wrong. Please try again")</script>';
            }
        } else {
             echo '<script>alert("❌ Database error during insertion.")</script>';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Appointment Management System | Home</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">

    <link href="css/templatemo-medic-care.css" rel="stylesheet">

    <style>
    :root{
        --primary-1: #0077b6;
        --primary-2: #00b4d8;
        --accent: #6a4c93;
        --muted: #6b7280;
        --card-shadow: 0 10px 30px rgba(2,46,90,0.08);
    }

    body {
        font-family: 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        background: linear-gradient(180deg, #f7fbff 0%, #ffffff 50%);
        color: #0f1724;
        margin: 0;
        padding-top: 72px; /* offset for fixed navbar */
    }

    /* NAVBAR */
    .navbar {
        transition: all 0.3s ease;
        background: linear-gradient(90deg,var(--primary-2),var(--primary-1));
        padding: 14px 0;
        box-shadow: none;
        border-bottom: 0;
    }
    .navbar.shrink {
        padding: 8px 0;
        box-shadow: 0 6px 22px rgba(3,74,111,0.12);
        backdrop-filter: blur(6px);
    }
    .navbar .navbar-brand { font-family: 'Montserrat', sans-serif; font-weight:700; color: #fff !important; letter-spacing: .4px; font-size: 1.25rem;}
    .nav-link { color: rgba(255,255,255,0.95) !important; font-weight:600; margin-right: 8px; }
    .nav-link:hover { transform: translateY(-3px); color: #e6fbff !important; }

    .login-btn {
        background: #fff;
        color: var(--primary-1) !important;
        padding: 6px 16px;
        border-radius: 22px;
        font-weight:700;
        box-shadow: 0 6px 18px rgba(0,180,216,0.12);
    }
    .login-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,180,216,0.18); color:#fff !important; background: linear-gradient(90deg,var(--primary-1),var(--accent)) }

    /* HERO and visuals */
    .hero { position: relative; padding: 36px 0 24px; overflow: visible; }
    .hero-inner { display:flex; gap: 30px; align-items:center; justify-content:space-between; flex-wrap:wrap; }
    .hero-card { flex: 1 1 520px; min-width: 300px; }
    .hero-visual { flex: 1 1 480px; min-width: 260px; display:flex; align-items:center; justify-content:center; position: relative; }
    .hero-visual img { width:100%; max-width:720px; height:460px; object-fit:cover; border-radius: 18px; box-shadow: var(--card-shadow); transform-origin:center; transition: transform 12s ease-in-out; animation: floatZoom 10s ease-in-out infinite; }
    @keyframes floatZoom { 0% { transform: translateY(0) scale(1); } 50% { transform: translateY(-10px) scale(1.02); } 100% { transform: translateY(0) scale(1); } }
    .hero-title { font-family: 'Montserrat', sans-serif; font-size: 2.05rem; line-height:1.05; margin-bottom: 12px; color: #04263b; }
    .hero-sub { color: var(--muted); font-size: 1rem; margin-bottom: 18px; }
    .cta-row { display:flex; gap:12px; align-items:center; }
    .btn-cta { padding: 12px 18px; border-radius: 14px; font-weight:700; color: #fff; background: linear-gradient(90deg,var(--primary-2),var(--primary-1)); box-shadow: 0 12px 30px rgba(0,119,182,0.18); }

    /* Sections & cards */
    section.section { padding: 64px 0; }
    .card-spot { background: #fff; border-radius: 16px; padding: 26px; box-shadow: var(--card-shadow); }
    h3.section-heading { font-family: 'Montserrat', sans-serif; color: var(--primary-1); margin-bottom: 14px; }

    /* Booking form */
    .booking-form { background: linear-gradient(180deg,#ffffff, #fbfdff); padding: 28px; border-radius: 14px; box-shadow: var(--card-shadow); }
    .form-control { border-radius: 10px; border: 1px solid #e6eef6; padding: 12px 14px; font-size: 15px; }
    .form-control:focus { outline:none; border-color: var(--primary-2); box-shadow: 0 8px 22px rgba(0,180,216,0.08); }

    .submit-wrap { display:flex; justify-content:center; }
    #submit-button { width:100%; max-width: 220px; border-radius: 12px; padding: 12px 18px; border:none; color:#fff; font-weight:700; background: linear-gradient(90deg,var(--primary-1),var(--accent)); }

    /* Footer */
    footer.site-footer { background: linear-gradient(90deg,var(--primary-1),var(--primary-2)); color: #fff; padding: 28px 0; margin-top: 40px; }
    footer .footer-inner { display:flex; gap: 20px; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; }
    footer p, footer a { color: rgba(255,255,255,0.92); font-size: 14px; margin:6px 0; }

    /* responsive tweaks */
    @media (max-width: 991px) { .hero-inner { gap:18px; } .hero-visual img { height:340px; } .hero-title { font-size:1.6rem; } }
    @media (max-width: 576px) { .hero-visual img { height:260px; } .hero-title { font-size:1.25rem;} .navbar { padding: 10px 0; } }

    /* scroll animation helpers */
    [data-animate] { opacity:0; transform: translateY(18px); transition: all 0.66s cubic-bezier(.16,1,.3,1); }
    [data-animate].in-view { opacity:1; transform: translateY(0); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">Hospital Appointment System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navMenu">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="check-appointment.php">Check Appointment</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
        <li class="nav-item ms-2"><a class="nav-link login-btn" href="doctor/login.php">Login</a></li>
      </ul>
    </div>
  </div>
</nav>

<header class="hero">
  <div class="container">
    <div class="hero-inner">
      <div class="hero-card" data-animate>
        <div style="max-width:620px;">
          <div class="badge" style="display:inline-block;background:linear-gradient(90deg,var(--primary-2),var(--primary-1));color:#fff;padding:8px 12px;border-radius:999px;font-weight:700;margin-bottom:12px;">
            Smart Scheduling
          </div>
          <h1 class="hero-title">Fast. Reliable. Universal Appointment Management.</h1>
          <p class="hero-sub">A simple online platform for hospitals and clinics to manage appointments, reduce waiting time and improve patient experience.</p>

          <div class="cta-row">
            <a href="#booking" class="btn-cta">Book Appointment</a>
            <a href="admin/login.php" class="btn-outline">Admin Login</a>
          </div>

          <div style="margin-top:18px;display:flex;gap:14px;align-items:center;">
            <div style="display:flex;align-items:center;gap:8px;">
              <div style="width:10px;height:10px;border-radius:50%;background:var(--primary-2);box-shadow:0 6px 14px rgba(0,180,216,0.14)"></div>
              <small style="color:var(--muted)">24/7 booking & SMS confirmation</small>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
              <div style="width:10px;height:10px;border-radius:50%;background:var(--accent);box-shadow:0 6px 14px rgba(106,76,147,0.12)"></div>
              <small style="color:var(--muted)">Works with any hospital setup</small>
            </div>
          </div>
        </div>
      </div>

      <div class="hero-visual" data-animate>
        <img src="images/slider/appointment_image.png" alt="Appointment system visual">
      </div>
    </div>
  </div>
</header>

<section id="about" class="section" data-animate>
  <div class="container">
    <div class="row align-items-center gy-4">
      <div class="col-lg-6">
        <div class="card-spot">
          <h3 class="section-heading">Why choose this system?</h3>
          <p>Our Appointment Management System centralizes bookings, provides appointment numbers, sends confirmations, and helps staff manage daily schedules. Built to be simple, secure and extensible.</p>
          <ul style="margin-top:12px;color:var(--muted);">
            <li>Easy booking for patients (online & in-person)</li>
            <li>Doctor schedule & specialization mapping</li>
            <li>Automated appointment numbers & basic reporting</li>
          </ul>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card-spot">
          <h3 class="section-heading">Key features</h3>
          <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:12px;">
            <div style="flex:1;min-width:140px;background:#fbfdff;padding:12px;border-radius:12px;box-shadow:0 8px 20px rgba(2,46,90,0.03);">
              <strong>Patient Portal</strong><br><small style="color:var(--muted)">Book & track visits</small>
            </div>
            <div style="flex:1;min-width:140px;background:#fbfdff;padding:12px;border-radius:12px;box-shadow:0 8px 20px rgba(2,46,90,0.03);">
              <strong>Admin Dashboard</strong><br><small style="color:var(--muted)">Manage doctors & slots</small>
            </div>
            <div style="flex:1;min-width:140px;background:#fbfdff;padding:12px;border-radius:12px;box-shadow:0 8px 20px rgba(2,46,90,0.03);">
              <strong>SMS Notifications</strong><br><small style="color:var(--muted)">Confirmations & reminders</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="booking" class="section" data-animate>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="booking-form shadow-lg p-4 rounded-4" style="background:#fff;">
          <h3 class="section-heading text-center mb-3" style="font-family:'Poppins', sans-serif; font-weight:600;">Book an Appointment</h3>
          <p class="text-center" style="color:var(--muted);margin-bottom:20px;">Fill in the form below. Appointments will get an appointment number and a confirmation page.</p>

       <form id="appointmentForm" method="POST" action="submit-appointment.php">
              <div class="col-md-6">
                <input type="text" name="name" id="name" class="form-control" placeholder="Full Name" required>
              </div>

              <div class="col-md-6">
                <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" required>
              </div>

              <div class="col-md-6">
                <input type="tel" name="phone" id="phone" class="form-control" placeholder="Phone Number" maxlength="15" required>
              </div>

              <div class="col-md-6">
                <input type="date" name="date" id="date" class="form-control" required>
              </div>

              <div class="col-md-6">
                <input type="time" name="time" id="time" class="form-control" required>
              </div>

              <div class="col-md-6">
                <select onchange="getdoctors(this.value);" name="specialization" id="specialization" class="form-control" required>
                  <option value="">Select Specialization</option>
                  <?php
                  $sql="SELECT * FROM tblspecialization";
                  $stmt=$dbh->query($sql);
                  $stmt->setFetchMode(PDO::FETCH_ASSOC);
                  while($row =$stmt->fetch()) { ?>
                      <option value="<?php echo $row['ID'];?>"><?php echo htmlentities($row['Specialization']);?></option>
                  <?php }?>
                </select>
              </div>

              <div class="col-md-12">
                <select name="doctorlist" id="doctorlist" class="form-control" required>
                  <option value="">Select Doctor</option>
                  <?php
                  $sql="SELECT * FROM tbldoctor";
                  $stmt=$dbh->query($sql);
                  $stmt->setFetchMode(PDO::FETCH_ASSOC);
                  while($row =$stmt->fetch()) { ?>
                      <option value="<?php echo $row['ID'];?>"><?php echo htmlentities($row['FullName']);?></option>
                  <?php }?>
                </select>
              </div>

              <div class="col-12">
                <textarea class="form-control" rows="4" id="message" name="message" placeholder="Additional Message (optional)"></textarea>
              </div>

              <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary px-5 py-2 mt-3 rounded-pill fw-semibold">
                  Book Now
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
document.getElementById("appointmentForm").addEventListener("submit", function(e) {
    // We prevent default submission to run custom validation
    e.preventDefault();

    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const date = document.getElementById("date").value;
    const time = document.getElementById("time").value;
    const specialization = document.getElementById("specialization").value;
    const doctorlist = document.getElementById("doctorlist").value;

    // Simplified regex validation (assuming these are what you intended)
    const nameRegex = /^[A-Za-z\s]{3,50}$/;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/;
    const phoneRegex = /^\+?[0-9]{7,15}$/;

    let valid = true;
    let message = "";

    if (!nameRegex.test(name)) {
        valid = false;
        message += "❌ Enter a valid full name (letters only, min 3 chars).\n";
    }

    if (!emailRegex.test(email)) {
        valid = false;
        message += "❌ Enter a valid email address.\n";
    }

    if (!phoneRegex.test(phone)) {
        valid = false;
        message += "❌ Enter a valid phone number (7–15 digits).\n";
    }

    if (!date) {
        valid = false;
        message += "❌ Select a valid appointment date.\n";
    }

    if (!time) {
        valid = false;
        message += "❌ Select a valid appointment time.\n";
    }

    if (!specialization) {
        valid = false;
        message += "❌ Please select a specialization.\n";
    }

    if (!doctorlist) {
        valid = false;
        message += "❌ Please select a doctor.\n";
    }

    if (!valid) {
        alert(message);
        return false;
    }

    // *** CRITICAL STEP ***: If validation passes, manually submit the form to the PHP backend
    // This allows the PHP script at the top of the file to run and handle DB insertion/redirection.
    e.target.submit();
});
</script>


</section>

<section id="contact" class="section" data-animate>
  <div class="container">
    <div class="row align-items-center gy-4">
      <div class="col-md-6">
        <div class="card-spot contact-card">
          <h3 class="section-heading">Contact Us</h3>
          <p style="color:var(--muted)">Questions? Need integration help? Reach out and our team will help you get set up quickly.</p>
          <p style="margin-top:12px;"><strong>Email:</strong> info@hospital.com<br><strong>Phone:</strong> +977-9861444367</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card-spot">
          <h3 class="section-heading">Office</h3>
          <p style="color:var(--muted)">123 Hospital Street, Kathmandu, Nepal</p>
         <div style="height:160px;border-radius:10px;overflow:hidden;box-shadow:var(--card-shadow);">
  <iframe
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.3497284477023!2d85.3239603!3d27.717245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb190c1b5c0b7b%3A0x3e5d9bb7a2de5b06!2sPatan%20Durbar%20Square%2C%20Lalitpur%2044500%2C%20Nepal!5e0!3m2!1sen!2snp!4v1707230000000!5m2!1sen!2snp"
    width="100%" height="160" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
  </iframe>
</div>

        </div>
      </div>
    </div>
  </div>
</section>

<footer class="site-footer">
  <div class="container">
    <div class="footer-inner">
      <div class="footer-col">
        <h4 style="margin-bottom:8px;font-weight:700;">Hospital Appointment System</h4>
        <p>Universal appointment manager for hospitals & clinics. Simple, secure & fast.</p>
      </div>

      <div class="footer-col">
        <h5 style="font-weight:700;">Contact</h5>
        <p><strong>Address:</strong> 123 Hospital Street, Kathmandu, Nepal</p>
        <p><strong>Email:</strong> info@hospital.com</p>
        <p><strong>Phone:</strong> +977-9861444367</p>
      </div>

      <div class="footer-col">
        <h5 style="font-weight:700;">Follow</h5>
        <div class="social-icons" style="margin-top:8px;">
          <a href="#" aria-label="facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" aria-label="twitter"><i class="bi bi-twitter"></i></a>
          <a href="#" aria-label="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>
        <p style="margin-top:12px;font-size:13px;opacity:0.95;">© <?php echo date('Y'); ?> Hospital Appointment Management System</p>
      </div>
    </div>
  </div>
</footer>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
/* Navbar shrink on scroll */
(function(){
  const nav = document.querySelector('.navbar');
  function handleNav(){
    if(window.scrollY > 50) nav.classList.add('shrink');
    else nav.classList.remove('shrink');
  }
  handleNav();
  window.addEventListener('scroll', handleNav);
})();

/* scroll reveal for elements with data-animate */
(function(){
  const els = document.querySelectorAll('[data-animate]');
  const onScroll = () => {
    els.forEach(el=>{
      const rect = el.getBoundingClientRect();
      if(rect.top < (window.innerHeight - 90)) el.classList.add('in-view');
    });
  };
  onScroll();
  window.addEventListener('scroll', onScroll);
})();

/* Ajax to load doctors on specialization change */
function getdoctors(val) {
    if(!val) { document.getElementById('doctorlist').innerHTML = '<option value="">Select Doctor</option>'; return; }
    $.ajax({
        type: "POST",
        url: "get_doctors.php",
        data: { sp_id: val },
        success: function(data){
            $("#doctorlist").html(data);
        },
        error: function(){
            $("#doctorlist").html('<option value="">Unable to load</option>');
        }
    });
}

/* Smooth scroll for anchor links */
document.querySelectorAll('a[href^="#"]').forEach(anchor=>{
    anchor.addEventListener('click', function(e){
        const target = document.querySelector(this.getAttribute('href'));
        if(target){
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});
</script>

</body>
</html>