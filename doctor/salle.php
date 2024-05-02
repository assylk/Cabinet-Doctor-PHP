<?php
session_start();
error_reporting(0);
include('./../includes/dbconnection.php');
if (strlen($_SESSION['damsid']==0)) {
  header('location:logout.php');
  } else{



  ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <title>CabiNet || Approved Appointment Detail</title>

    <link rel="stylesheet" href="./../libs/bower/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="./../libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
    <!-- build:css assets/css/app.min.css -->
    <link rel="stylesheet" href="./../libs/bower/animate.css/animate.min.css">
    <link rel="stylesheet" href="./../libs/bower/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="./../libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="./../assets/css/bootstrap.css">
    <link rel="stylesheet" href="./../assets/css/core.css">
    <link rel="stylesheet" href="./../assets/css/app.css">
    <link rel="stylesheet" href="./../assets/css/style.css">

    <!-- endbuild -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
    <script src="./../libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
    <script>
    Breakpoints();
    </script>
    <style>
    h2 {
        font-size: 4em;
        text-align: center;
    }
    </style>


</head>
<body class="menubar-left menubar-unfold menubar-light theme-primary">
    <!--============= start main area -->



    <?php include_once('includes/header.php');?>

    <?php include_once('includes/sidebar.php');?>



    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <h2>Salle d'Attente</h2>
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <?php
              $docid=$_SESSION['damsid'];
$sql="SELECT * from  tblsalle ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{   
    $color=$row->status=="true"?"green":"red";      
    $status= $row->status=="true" ? "Disponible" : "Occupée";
    ?>
                    <div class="col-md-2" style="margin-bottom:5px;">
                        <div class="card" style="background-color:<?php echo $color;?>">
                            <div class="card-details">

                                <p class="text-body" style="font-size:15px;text-align:center;color:white;">
                                    ID : <?php echo $row->id ?></p>
                                <img src="images/chair.png" alt="">
                                <p class="text-body" style="font-size:14px;text-align:center;color:white;">
                                    <b>Status :</b> <?php echo $status ?>
                                </p>


                            </div>


                        </div>
                    </div><!-- END column -->
                    <?php }}?>



                </div><!-- .row -->
            </section><!-- .app-content -->
        </div><!-- .wrap -->
        <!-- APP FOOTER -->
        <?php include_once('includes/footer.php');?>
        <!-- /#app-footer -->
    </main>
    <!--========== END app main -->

    <!-- APP CUSTOMIZER -->
    <?php include_once('includes/customizer.php');?>


    <!-- build:js assets/js/core.min.js -->
    <script src="./../libs/bower/jquery/dist/jquery.js"></script>
    <script src="./../libs/bower/jquery-ui/jquery-ui.min.js"></script>
    <script src="./../libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>
    <script src="./../libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>
    <script src="./../libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script src="./../libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="./../libs/bower/PACE/pace.min.js"></script>
    <!-- endbuild -->

    <!-- build:js assets/js/app.min.js -->
    <script src="./../assets/js/library.js"></script>
    <script src="./../assets/js/plugins.js"></script>
    <script src="./../assets/js/app.js"></script>
    <!-- endbuild -->
    <script src="./../libs/bower/moment/moment.js"></script>
    <script src="./../libs/bower/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="./../assets/js/fullcalendar.js"></script>
</body>
</html>
<?php }  ?>