<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('includes/db.php');

date_default_timezone_set('Africa/Tunis');


// Query for total specialization
$sql = "SELECT COUNT(*) AS totSpecialization FROM tblspecialization";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$totSpecialization = $row['totSpecialization'];

// Query for total approved appointments with Ordannance not Null
$sql = "SELECT COUNT(*) AS totClient FROM tblappointment WHERE Status='Approved' AND Ordannance IS NOT NULL";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$totClient = $row['totClient'];

// Query for total appointments
$sql = "SELECT COUNT(*) AS totPatient FROM tblappointment";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$totPatient = $row['totPatient'];
// Query for total appointments
$sql = "SELECT COUNT(*) AS doctotal FROM tbldoctor";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$totdoc = $row['doctotal'];


    if(isset($_POST['submit']))
  {
 $item_selected=$_POST['itemselected'];
 $name=$_POST['name'];
 $mobnum=$_POST['phone'];
 $cin=$_POST['cin'];
 
 $appdate=$_POST['date'];
 $aaptime=$_POST['time'];
 $specialization=$_POST['specialization'];
 $doctor=$_POST['doctor'];
 $message=$_POST['message'];
 $aptnumber=mt_rand(100000000, 999999999);
 $cdate=date('Y-m-d');

if($appdate<=$cdate){
       echo '<script>alert("Appointment date must be greater than todays date")</script>';
} else {

    $sql=mysqli_query($con,"insert into tblappointment(Name,CIN,MobileNumber,AppointmentNumber,AppointmentDate,AppointmentTime,Doctor,Message) values('$name','$cin','$mobnum','$aptnumber','$appdate','$aaptime','$doctor','$message')");
    if($sql){
        echo '<script>alert("Appointment Added Successfully !")</script>';
       // $msg="Appointment Added Successfully !";
    }
 
  }
  




}

?>







<!DOCTYPE html>
<html class="no-js" lang="zxx">
<head>
    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="style.css">
    <!-- Title -->
    <title>CabiNet || Home Page</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="asset/images/favicon.ico">


    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
        rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="home/css/bootstrap.min.css" />
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="home/css/nice-select.css" />
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="home/css/font-awesome.min.css" />
    <!-- icofont CSS -->
    <link rel="stylesheet" href="home/css/icofont.css" />
    <!-- Slicknav -->
    <link rel="stylesheet" href="home/css/slicknav.min.css" />
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="home/css/owl-carousel.css" />
    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="home/css/datepicker.css" />
    <!-- Animate CSS -->
    <link rel="stylesheet" href="home/css/animate.min.css" />
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="home/css/magnific-popup.css" />

    <!-- Medipro CSS -->
    <link rel="stylesheet" href="home/css/normalize.css" />
    <link rel="stylesheet" href="home/style.css" />
    <link rel="stylesheet" href="home/css/responsive.css" />
    <style>
    html {
        scroll-behavior: smooth;
    }
    </style>
    <script>
    function getdoctors(val) {
        //  alert(val);
        $.ajax({

            type: "POST",
            url: "get_doctors.php",
            data: 'sp_id=' + val,
            success: function(data) {

                $("#doctorlist").html(data);
            }
        });
    }
    </script>

</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="loader">
            <div class="loader-outter"></div>
            <div class="loader-inner"></div>

            <div class="indicator">
                <svg width="16px" height="12px">
                    <polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                    <polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                </svg>
            </div>
        </div>
    </div>
    <!-- End Preloader -->


    <!-- Header Area -->
    <header class="header">
        <!-- Topbar -->
        <div class="topbar dd">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-5 col-12">
                        <!-- Contact -->
                        <ul class="top-link">
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Sign Up</a></li>
                        </ul>
                        <!-- End Contact -->
                    </div>
                    <div class="col-lg-6 col-md-7 col-12">
                        <!-- Top Contact -->
                        <ul class="top-contact">
                            <li><i class="fa fa-phone"></i>+216 1234 5678</li>
                            <li>
                                <i class="fa fa-envelope"></i><a href="mailto:cabinet@gmail.com">cabinet@gmail.com</a>
                            </li>

                        </ul>
                        <!-- End Top Contact -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Topbar -->
        <!-- Header Inner -->
        <div class="header-inner">
            <div class="container">
                <div class="inner">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-12">
                            <!-- Start Logo -->
                            <div class="logo">
                                <div>
                                    <img src="home/img/favicon.png" style="vertical-align: bottom;padding-top:0;"
                                        width="40px" alt="">

                                    <button class="buttonlogo" data-text="Awesome">
                                        <span class="actual-text">&nbsp;CabiNet&nbsp;</span>
                                        <span aria-hidden="true" class="hover-text">&nbsp;CabiNet&nbsp;</span>
                                    </button>
                                </div><!-- logo -->

                            </div>
                            <!-- End Logo -->
                            <!-- Mobile Nav -->
                            <div class="mobile-nav"></div>
                            <!-- End Mobile Nav -->
                        </div>
                        <div class="col-lg-7 col-md-9 col-12">
                            <!-- Main Menu -->
                            <div class="main-menu">
                                <nav class="navigation">
                                    <ul class="nav menu">
                                        <li class="active">
                                            <a href="#">Home</a>

                                        </li>
                                        <li><a href="#services">Services </a></li>


                                    </ul>
                                </nav>
                            </div>
                            <!--/ End Main Menu -->
                        </div>
                        <div class="col-lg-2 col-12">
                            <div class="get-quote">
                                <a href="#appointmentSection" class="btn">Book Appointment</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Header Inner -->
    </header>
    <!-- End Header Area -->

    <!-- Slider Area -->
    <section class="slider">
        <div class="hero-slider">
            <!-- Start Single Slider -->
            <div class="single-slider" style="background-image: url('home/img/slider2.jpg')">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="text">
                                <h1>
                                    We Provide <span>Medical</span> Services That You Can
                                    <span>Trust!</span>
                                </h1>
                                <p>
                                    Trustworthy medical services are our promise. At our doctor cabinet system, rest
                                    assured knowing your health is in reliable hands.
                                </p>
                                <div class="button">
                                    <a href="#appointmentSection" class="btn">Get Appointment</a>
                                    <a href="#" class="btn primary">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Slider -->
            <!-- Start Single Slider -->
            <div class="single-slider" style="background-image: url('home/img/slider.jpg')">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="text">
                                <h1>
                                    We Provide <span>Medical</span> Services That You Can
                                    <span>Trust!</span>
                                </h1>
                                <p>
                                    Trustworthy medical services are our promise. At our doctor cabinet system, rest
                                    assured knowing your health is in reliable hands.
                                </p>
                                <div class="button">
                                    <a href="#appointmentSection" class="btn">Get Appointment</a>
                                    <a href="#" class="btn primary">About Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start End Slider -->
            <!-- Start Single Slider -->
            <div class="single-slider" style="background-image: url('home/img/slider3.jpg')">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="text">
                                <h1>
                                    We Provide <span>Medical</span> Services That You Can
                                    <span>Trust!</span>
                                </h1>
                                <p>
                                    Trustworthy medical services are our promise. At our doctor cabinet system, rest
                                    assured knowing your health is in reliable hands.
                                </p>
                                <div class="button">
                                    <a href="#appointmentSection" class="btn">Get Appointment</a>
                                    <a href="#" class="btn primary">Conatct Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Slider -->
        </div>
    </section>
    <!--/ End Slider Area -->

    <!-- Start Schedule Area -->
    <section class="schedule">
        <div class="container">
            <div class="schedule-inner">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12">
                        <!-- single-schedule -->
                        <div class="single-schedule first">
                            <div class="inner">

                                <div class="single-content">
                                    <span>Lorem Amet</span>
                                    <h4>Emergency Cases</h4>
                                    <p>
                                        For emergencies, rely on us. Our doctor cabinet system is prepared to provide
                                        immediate care when you need it most.
                                    </p>
                                    <a href="#">LEARN MORE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <!-- single-schedule -->
                        <div class="single-schedule middle">
                            <div class="inner">

                                <div class="single-content">
                                    <span>Fusce Porttitor</span>
                                    <h4>Doctors Timetable</h4>
                                    <p>
                                        Plan your visits hassle-free with our doctors' timetable. Easily access the care
                                        you need with our transparent schedule.
                                    </p>
                                    <a href="#">LEARN MORE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-12">
                        <!-- single-schedule -->
                        <div class="single-schedule last">
                            <div class="inner">

                                <div class="single-content">
                                    <span>Donec luctus</span>
                                    <h4>Opening Hours</h4>
                                    <ul class="time-sidual">
                                        <li class="day">
                                            Monday - Friday <span>8.00-20.00</span>
                                        </li>
                                        <li class="day">Saturday <span>9.00-18.30</span></li>
                                        <li class="day">
                                            Monday - Thusday <span>9.00-15.00</span>
                                        </li>
                                    </ul>
                                    <a href="#">LEARN MORE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/End Start schedule Area -->

    <!-- Start Feautes -->
    <section class="Feautes section" style="backgound-color:black">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>We Are Always Ready to Help You & Your Family</h2>
                        <div class="loading">
                            <svg width="64px" height="48px">
                                <polyline points="0.157 23.954, 14 23.954, 21.843 48, 43 0, 50 24, 64 24" id="back">
                                </polyline>
                                <polyline points="0.157 23.954, 14 23.954, 21.843 48, 43 0, 50 24, 64 24" id="front">
                                </polyline>
                            </svg>
                        </div>
                        <p>

                            Count on us for assistance, always. Your family's well-being is our priority, and we're here
                            to provide the support and care you need. With our dedicated team, rest assured that you're
                            in capable hands, ready to address any concerns or medical needs that arise.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-12">
                    <!-- Start Single features -->
                    <div class="single-features">
                        <div class="signle-icon">
                            <i class="icofont icofont-ambulance-cross"></i>
                        </div>
                        <h3>Emergency Help</h3>
                        <p>
                            We're Here for You.
                        </p>
                    </div>
                    <!-- End Single features -->
                </div>
                <div class="col-lg-4 col-12">
                    <!-- Start Single features -->
                    <div class="single-features">
                        <div class="signle-icon">
                            <i class="icofont icofont-medical-sign-alt"></i>
                        </div>
                        <h3>Enriched Pharmecy</h3>
                        <p>
                            Elevating Your Health Experience.
                        </p>
                    </div>
                    <!-- End Single features -->
                </div>
                <div class="col-lg-4 col-12">
                    <!-- Start Single features -->
                    <div class="single-features last">
                        <div class="signle-icon">
                            <i class="icofont icofont-stethoscope"></i>
                        </div>
                        <h3>Medical Treatment</h3>
                        <p>
                            Your Health in Expert Hands.
                        </p>
                    </div>
                    <!-- End Single features -->
                </div>
            </div>
        </div>
    </section>
    <!--/ End Feautes -->

    <!-- Start Fun-facts -->
    <div id="fun-facts" class="fun-facts section overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Fun -->
                    <div class="single-fun">
                        <i class="icofont icofont-users"></i>
                        <div class="content">
                            <span class="counter"><?php echo $totPatient;?></span>
                            <p>Total Patients</p>
                        </div>
                    </div>
                    <!-- End Single Fun -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Fun -->
                    <div class="single-fun">
                        <i class="icofont icofont-user-alt-3"></i>
                        <div class="content">
                            <span class="counter"><?php echo $totSpecialization; ?></span>
                            <p>Specialist Doctors</p>
                        </div>
                    </div>
                    <!-- End Single Fun -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Fun -->
                    <div class="single-fun">
                        <i class="icofont-simple-smile"></i>
                        <div class="content">
                            <span class="counter"><?php echo $totClient;?></span>
                            <p>Happy Patients</p>
                        </div>
                    </div>
                    <!-- End Single Fun -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Fun -->
                    <div class="single-fun">
                        <i class="icofont icofont-table"></i>
                        <div class="content">
                            <span class="counter">12</span>
                            <p>Years of Experience</p>
                        </div>
                    </div>
                    <!-- End Single Fun -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Fun-facts -->

    <!-- Start Why choose -->
    <section class="why-choose section" id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>We Offer Different Services To Improve Your Health</h2>
                        <div class="loading">
                            <svg width="64px" height="48px">
                                <polyline points="0.157 23.954, 14 23.954, 21.843 48, 43 0, 50 24, 64 24" id="back">
                                </polyline>
                                <polyline points="0.157 23.954, 14 23.954, 21.843 48, 43 0, 50 24, 64 24" id="front">
                                </polyline>
                            </svg>
                        </div>
                        <p>
                            Discover a Range of Services for Your Well-Being. At our clinic, we provide a variety ofs
                            services aimed at enhancing your health and vitality.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-12">
                    <!-- Start Choose Left -->
                    <div class="choose-left">
                        <h3>Who We Are</h3>
                        <p>
                            A Dedicated Team Committed to Your Health and Well-Being.
                        </p>
                        <p>

                            At our clinic, we're your dedicated partners in health. With a community-focused approach,
                            we deliver personalized care that surpasses expectations. Our experienced team works
                            collaboratively to tailor treatment plans to your needs, ensuring lasting wellness. With
                            compassion and integrity, we're committed to being your trusted healthcare destination.
                        </p>

                    </div>
                    <!-- End Choose Left -->
                </div>
                <div class="col-lg-6 col-12">
                    <!-- Start Choose Rights -->
                    <div class="choose-right">
                        <div class="video-image">
                            <!-- Video Animation -->
                            <div class="promo-video">
                                <div class="waves-block">
                                    <div class="waves wave-1"></div>
                                    <div class="waves wave-2"></div>
                                    <div class="waves wave-3"></div>
                                </div>
                            </div>
                            <!--/ End Video Animation -->
                            <a href="https://www.youtube.com/watch?v=RFVXy6CRVR4"
                                class="video video-popup mfp-iframe"><i class="fa fa-play"></i></a>
                        </div>
                    </div>
                    <!-- End Choose Rights -->
                </div>
            </div>
        </div>
    </section>
    <!--/ End Why choose -->

    <!-- Start Call to action -->
    <section class="call-action overlay" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="content">
                        <h2>Do you need Emergency Medical Care? Call @ +216 11 222 222</h2>
                        <p>
                            For immediate medical assistance, call us at +216 11 222 222. Our team is available 24/7 to
                            provide prompt and expert care during emergencies. Your well-being is our priority.
                        </p>
                        <div class="button">
                            <a href="#" class="btn">Contact Now</a>
                            <a href="#" class="btn second">Learn More<i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Call to action -->

    <!-- Start portfolio -->
    <section class="portfolio section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>We Maintain Cleanliness Rules Inside Our Cabinet</h2>
                        <div class="loading">
                            <svg width="64px" height="48px">
                                <polyline points="0.157 23.954, 14 23.954, 21.843 48, 43 0, 50 24, 64 24" id="back">
                                </polyline>
                                <polyline points="0.157 23.954, 14 23.954, 21.843 48, 43 0, 50 24, 64 24" id="front">
                                </polyline>
                            </svg>
                        </div>
                        <p>
                            We Uphold Strict Cleanliness Standards in Our Facility.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="owl-carousel portfolio-slider">
                        <div class="single-pf">
                            <img src="home/img/pf1.jpg" alt="#" />
                        </div>
                        <div class="single-pf">
                            <img src="home/img/pf2.jpg" alt="#" />
                        </div>
                        <div class="single-pf">
                            <img src="home/img/pf3.jpg" alt="#" />
                        </div>
                        <div class="single-pf">
                            <img src="home/img/pf4.jpg" alt="#" />
                        </div>
                        <div class="single-pf">
                            <img src="home/img/pf1.jpg" alt="#" />
                        </div>
                        <div class="single-pf">
                            <img src="home/img/pf2.jpg" alt="#" />
                        </div>
                        <div class="single-pf">
                            <img src="home/img/pf3.jpg" alt="#" />
                        </div>
                        <div class="single-pf">
                            <img src="home/img/pf4.jpg" alt="#" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End portfolio -->

    <!-- Start service -->
    <section class="services section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>We Offer Different Services To Improve Your Health</h2>
                        <div class="loading">
                            <svg width="64px" height="48px">
                                <polyline points="0.157 23.954, 14 23.954, 21.843 48, 43 0, 50 24, 64 24" id="back">
                                </polyline>
                                <polyline points="0.157 23.954, 14 23.954, 21.843 48, 43 0, 50 24, 64 24" id="front">
                                </polyline>
                            </svg>
                        </div>
                        <p>
                            At our facility, we provide an array of services aimed at improving your health and quality
                            of life.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="icofont icofont-prescription"></i>
                        <h4><a href="home/service-details.html">General Treatment</a></h4>
                        <p>
                            Trust our clinic for personalized care, from routine check-ups to managing chronic
                            conditions.
                        </p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="icofont icofont-tooth"></i>
                        <h4><a href="home/service-details.html">Teeth Whitening</a></h4>
                        <p>
                            Experience professional teeth whitening for a brighter, more confident smile.
                        </p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="icofont icofont-heart-alt"></i>
                        <h4><a href="home/service-details.html">Heart Surgery</a></h4>
                        <p>
                            Trust our experienced team for expert heart surgery, ensuring your well-being.
                        </p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="icofont icofont-listening"></i>
                        <h4><a href="home/service-details.html">Ear Treatment</a></h4>
                        <p>
                            Our clinic offers personalized care for all your ear-related concerns.
                        </p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="icofont icofont-eye-alt"></i>
                        <h4><a href="home/service-details.html">Vision Problems</a></h4>
                        <p>
                            Trust our clinic for personalized solutions to your vision concerns.
                        </p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="icofont icofont-blood"></i>
                        <h4><a href="home/service-details.html">Blood Transfusion</a></h4>
                        <p>
                            Receive expert care for blood transfusions at our facility.
                        </p>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>
    <!--/ End service -->






    <!-- Start Appointment -->
    <section class="appointment" id="appointmentSection">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>We Are Always Ready to Help You. Book An Appointment</h2>
                        <div class="loading">
                            <svg width="64px" height="48px">
                                <polyline points="0.157 23.954, 14 23.954, 21.843 48, 43 0, 50 24, 64 24" id="back">
                                </polyline>
                                <polyline points="0.157 23.954, 14 23.954, 21.843 48, 43 0, 50 24, 64 24" id="front">
                                </polyline>
                            </svg>
                        </div>
                        <p>
                            We're Here to Assist You. Schedule Your Appointment Today.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <form class="form" role="form" method="post">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <input name="name" id="name" name="name" type="text" placeholder="Name" required />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <input type="number" placeholder="Cin" name="cin" required />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <input type="telephone" name="phone" id="phone" placeholder="Phone" required />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <input type="date" name="date" id="date" required>

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">

                                <?php
                                                    $availableTimes = array();
                                                    for ($hour = 9; $hour <= 16; $hour++) {
                                                        for ($minute = 0; $minute < 60; $minute += 60) {
                                                            $time = sprintf('%02d:%02d:00', $hour, $minute);
                                                            $availableTimes[] = $time;
                                                        }
                                                    }
                                                    ?>

                                <select class="form-group" required name="time">
                                    <option selected value>Open this select menu</option>
                                    <?php foreach ($availableTimes as $time) {?>
                                    <option value="<?php echo $time ?>"><?php echo $time ?></option>
                                    <?php }?>

                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <select name="doctor" required>
                                        <option value="">Please choose a doctor</option>
                                        <?php $sql=mysqli_query($con,"select * from tbldoctor where Role!='secretaire' and Role!='admin'");
                                        while($row=mysqli_fetch_assoc($sql)) { ?>
                                        <option value="<?php echo $row['FullName'];?>"><?php echo $row['FullName']?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <textarea name="message" id="message" name="message"
                                        placeholder="Write Your Message Here....."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5 col-md-4 col-12">
                                <div class="form-group">
                                    <div class="button">
                                        <button type="submit" name="submit" id="submit-button" class="btn">
                                            Book An Appointment
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-8 col-12">
                                <p>( We will Call you to Confim )</p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="appointment-image">
                        <img src="home/img/contact-img.png" alt="#" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Appointment -->



    <!-- Footer Area -->
    <footer id="footer" class="footer">
        <!-- Footer Top -->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer">
                            <h2>About Us</h2>
                            <p>
                                We're committed to providing exceptional healthcare services tailored to your needs.
                                From routine check-ups to specialized treatments, your well-being is our priority.
                            </p>
                            <!-- Social -->
                            <ul class="social">
                                <li>
                                    <a href="#"><i class="icofont-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="icofont-google-plus"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="icofont-twitter"></i></a>
                                </li>

                            </ul>
                            <!-- End Social -->
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer">
                            <h2>Open Hours</h2>

                            <ul class="time-sidual">
                                <li class="day">Monday - Fridayp <span>8.00-20.00</span></li>
                                <li class="day">Saturday <span>9.00-18.30</span></li>
                                <li class="day">Monday - Thusday <span>9.00-15.00</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer">
                            <h2>Newsletter</h2>
                            <p>
                                Stay informed with the latest health tips and updates by subscribing to our newsletter.
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Footer Top -->

    </footer>
    <!--/ End Footer Area -->
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"
        integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous">
    </script>
    <!-- jquery Min JS -->
    <script src="home/js/jquery.min.js"></script>
    <!-- jquery Migrate JS -->
    <script src="home/js/jquery-migrate-3.0.0.js"></script>
    <!-- jquery Ui JS -->
    <script src="home/js/jquery-ui.min.js"></script>
    <!-- Easing JS -->
    <script src="home/js/easing.js"></script>
    <!-- Color JS -->
    <script src="home/js/colors.js"></script>
    <!-- Popper JS -->
    <script src="home/js/popper.min.js"></script>
    <!-- Bootstrap Datepicker JS -->
    <script src="home/js/bootstrap-datepicker.js"></script>
    <!-- Jquery Nav JS -->
    <script src="home/js/jquery.nav.js"></script>
    <!-- Slicknav JS -->
    <script src="home/js/slicknav.min.js"></script>
    <!-- ScrollUp JS -->
    <script src="home/js/jquery.scrollUp.min.js"></script>
    <!-- Niceselect JS -->
    <script src="home/js/niceselect.js"></script>
    <!-- Tilt Jquery JS -->
    <script src="home/js/tilt.jquery.min.js"></script>
    <!-- Owl Carousel JS -->
    <script src="home/js/owl-carousel.js"></script>
    <!-- counterup JS -->
    <script src="home/js/jquery.counterup.min.js"></script>
    <!-- Steller JS -->
    <script src="home/js/steller.js"></script>
    <!-- Wow JS -->
    <script src="home/js/wow.min.js"></script>
    <!-- Magnific Popup JS -->
    <script src="home/js/jquery.magnific-popup.min.js"></script>
    <!-- Counter Up CDN JS -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="home/js/bootstrap.min.js"></script>
    <!-- Main JS -->
    <script src="home/js/main.js"></script>
</body>
</html>