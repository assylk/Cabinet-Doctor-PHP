<?php
session_start();
error_reporting(0);
include('./../includes/dbconnection.php');
if (strlen($_SESSION['damsid']==0)) {
  header('location:logout.php');
  } else{



  ?>


<?php
$eid=$_SESSION['damsid'];
$sql="SELECT FullName,Email,Role from  tbldoctor where ID=:eid";
$query = $dbh -> prepare($sql);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

foreach($results as $row)
{    
$role=$row->Role=="doctor"?"Doctor":"Secretaire";
$email=$row->Email;   
$fname=$row->FullName;     
}   ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <title>CabiNet - Dashboard</title>

    <link rel="stylesheet" href="./../libs/bower/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="./../libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
    <!-- build:css assets/css/app.min.css -->
    <link rel="stylesheet" href="./../libs/bower/animate.css/animate.min.css">
    <link rel="stylesheet" href="./../libs/bower/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="./../libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="./../assets/css/bootstrap.css">
    <link rel="stylesheet" href="./../assets/css/core.css">
    <link rel="stylesheet" href="./../assets/css/app.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.19.0/dist/css/uikit.min.css" />
    <!-- endbuild -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
    <script src="./../libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
    <script>
    Breakpoints();
    </script>
</head>

<body class="menubar-left menubar-unfold menubar-light theme-primary">
    <!--============= start main area -->


    <?php include_once('includes/header.php');?>

    <?php include_once('includes/sidebar.php');?>



    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <table
                style="box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;background-color:white;margin-bottom:15px;padding:5px;width:100%">
                <tr>

                    <td colspan="1">
                        <p
                            style="font-size: 33px;padding-left:12px;padding-top:15px;font-weight: 600;margin-left:20px;">
                            <?php echo $role ?> | Dashboard</p>

                    </td>
                    <td width="25%">

                    </td>
                    <td width="6%" style="padding:10px">
                        <p style="font-size: 12px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p style="padding: 0;margin: 0;">
                            <?php 
                                date_default_timezone_set('Africa/Tunisia');
        
                                $today = date('Y-m-d');
                                echo $today;


                                ?>
                        </p>
                    </td>
                    <td width="4%">
                        <button class="btn-label"
                            style="display: flex;justify-content: center;align-items: center;"><img
                                src="../images/calendar.svg" width="100%"></button>
                    </td>
            </table>
            <section class="app-content">
                <div class="uk-inline">
                    <img src="../home/img/video-bg.jpg" style="width:200vh;height: 400px" alt="">
                    <div class="uk-overlay uk-overlay-primary uk-position-bottom">
                        <p>Welcome Back <?php  echo $fname ;?></p>
                    </div>
                </div>

                <div class="row" style="margin-top:50px">

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="widget stats-widget">
                                <div class="widget-body clearfix">
                                    <?php 
						 $docid=$_SESSION['damsid'];;
$sql ="SELECT * from  tblappointment where Status is null && Doctor=:docid ";
$query = $dbh -> prepare($sql);
$query-> bindParam(':docid', $docid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$totnewapt=$query->rowCount();
?>
                                    <div class="pull-left">
                                        <h3 class="widget-title text-warning"><span class="counter"
                                                data-plugin="counterUp"><?php echo htmlentities($totnewapt);?></span>
                                        </h3>
                                        <small class="text-color">Total New Appointment</small>
                                    </div>
                                    <span class="pull-right big-icon watermark"><i class="fa fa-paperclip"></i></span>
                                </div>
                                <footer class="widget-footer bg-warning">
                                    <a href="new-appointment.php"><small> View Detail</small></a>
                                    <span class="small-chart pull-right" data-plugin="sparkline"
                                        data-options="[4,3,5,2,1], { type: 'bar', barColor: '#ffffff', barWidth: 5, barSpacing: 2 }"></span>
                                </footer>
                            </div><!-- .widget -->
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="widget stats-widget">
                                <div class="widget-body clearfix">
                                    <?php 
						 $docid=$_SESSION['damsid'];
$sql ="SELECT * from  tblappointment where Status='Approved' && Doctor=:docid ";
$query = $dbh -> prepare($sql);
$query-> bindParam(':docid', $docid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$totappapt=$query->rowCount();
?>
                                    <div class="pull-left">
                                        <h3 class="widget-title text-success"><span class="counter"
                                                data-plugin="counterUp"><?php echo htmlentities($totappapt);?></span>
                                        </h3>
                                        <small class="text-color">Total Approved</small>
                                    </div>
                                    <span class="pull-right big-icon watermark"><i class="fa fa-ban"></i></span>
                                </div>
                                <footer class="widget-footer bg-success">
                                    <a href="approved-appointment.php"><small> View Detail</small></a>
                                    <span class="small-chart pull-right" data-plugin="sparkline"
                                        data-options="[1,2,3,5,4], { type: 'bar', barColor: '#ffffff', barWidth: 5, barSpacing: 2 }"></span>
                                </footer>
                            </div><!-- .widget -->
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="widget stats-widget">
                                <div class="widget-body clearfix">
                                    <div class="pull-left">
                                        <?php 
						 $docid=$_SESSION['damsid'];;
$sql ="SELECT * from  tblappointment where Status='Cancelled' && Doctor=:docid ";
$query = $dbh -> prepare($sql);
$query-> bindParam(':docid', $docid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$totncanapt=$query->rowCount();
?>
                                        <h3 class="widget-title text-danger"><span class="counter"
                                                data-plugin="counterUp"><?php echo htmlentities($totncanapt);?></span>
                                        </h3>
                                        <small class="text-color">Cancelled Appointment</small>
                                    </div>
                                    <span class="pull-right big-icon watermark"><i class="fa fa-unlock-alt"></i></span>
                                </div>
                                <footer class="widget-footer bg-danger">
                                    <a href="cancelled-appointment.php"><small> View Detail</small></a>
                                    <span class="small-chart pull-right" data-plugin="sparkline"
                                        data-options="[2,4,3,4,3], { type: 'bar', barColor: '#ffffff', barWidth: 5, barSpacing: 2 }"></span>
                                </footer>
                            </div><!-- .widget -->
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="widget stats-widget">
                                <div class="widget-body clearfix">

                                    <div class="pull-left">
                                        <?php 
						 $docid=$_SESSION['damsid'];;
$sql ="SELECT * from  tblappointment where Doctor=:docid ";
$query = $dbh -> prepare($sql);
$query-> bindParam(':docid', $docid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$totapt=$query->rowCount();
?>
                                        <h3 class="widget-title text-primary"><span class="counter"
                                                data-plugin="counterUp"><?php echo htmlentities($totapt);?></span></h3>
                                        <small class="text-color">Total Appointment</small>
                                    </div>
                                    <span class="pull-right big-icon watermark"><i class="fa fa-file-text-o"></i></span>
                                </div>
                                <footer class="widget-footer bg-primary">
                                    <a href="all-appointment.php"><small> View Detail</small></a>
                                    <span class="small-chart pull-right" data-plugin="sparkline"
                                        data-options="[5,4,3,5,2],{ type: 'bar', barColor: '#ffffff', barWidth: 5, barSpacing: 2 }"></span>
                                </footer>
                            </div><!-- .widget -->
                        </div>
                    </div><!-- .row -->



                    <div class="row">

            </section><!-- #dash-content -->
        </div><!-- .wrap -->
        <!-- APP FOOTER -->
        <?php include_once('includes/footer.php');?>
        <!-- /#app-footer -->
    </main>
    <!--========== END app main -->

    <?php include_once('includes/customizer.php');?>


    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.19.0/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.19.0/dist/js/uikit-icons.min.js"></script>
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