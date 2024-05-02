<?php
session_start();
include('./../includes/dbconnection.php');
    if(isset($_POST['submit']))
  {
 $name=$_POST['name'];
  $mobnum=$_POST['phone'];
 $email=$_POST['email'];
 $appdate=$_POST['date'];
 $aaptime=$_POST['time'];

 $message=$_POST['message'];
 $aptnumber=mt_rand(100000000, 999999999);
 $cdate=date('Y-m-d');

if($appdate<=$cdate){
       echo '<script>alert("Appointment date must be greater than todays date")</script>';
} else {
$sql="insert into tblappointment(AppointmentNumber,Name,MobileNumber,Email,AppointmentDate,AppointmentTime,Message)values(:aptnumber,:name,:mobnum,:email,:appdate,:aaptime,:message)";
$query=$dbh->prepare($sql);
$query->bindParam(':aptnumber',$aptnumber,PDO::PARAM_STR);
$query->bindParam(':name',$name,PDO::PARAM_STR);
$query->bindParam(':mobnum',$mobnum,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':appdate',$appdate,PDO::PARAM_STR);
$query->bindParam(':aaptime',$aaptime,PDO::PARAM_STR);

$query->bindParam(':message',$message,PDO::PARAM_STR);

 $query->execute();
   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {
    echo '<script>alert("Your Appointment Request Has Been Send. We Will Contact You Soon")</script>';
echo "<script>window.location.href ='today-appointment.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
}
if (strlen($_SESSION['damsid']==0)) {
  header('location:logout.php');
  } else{



  ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <title>CabiNet || Cancelled Appointment Detail</title>

    <link rel="stylesheet" href="./../libs/bower/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="./../libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
    <!-- build:css assets/css/app.min.css -->
    <link rel="stylesheet" href="./../libs/bower/animate.css/animate.min.css">
    <link rel="stylesheet" href="./../libs/bower/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="./../libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="./../assets/css/bootstrap.css">
    <link rel="stylesheet" href="./../assets/css/core.css">
    <link rel="stylesheet" href="./../assets/css/app.css">

    <!-- endbuild -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
    <script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
    <script>
    Breakpoints();
    </script>
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

<body class="menubar-left menubar-unfold menubar-light theme-primary">
    <!--============= start main area -->



    <?php include_once('includes/header.php');?>

    <?php include_once('includes/sidebar.php');?>



    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">

                    <!-- DOM dataTable -->
                    <div class="col-md-12">
                        <table style="background-color:white;margin-bottom:15px;padding:5px">
                            <tr>


                                <td></td>
                                <td width="1%" style="padding:10px">
                                    <p
                                        style="font-size: 12px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: left;">
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
                            </tr>
                        </table>
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Take Action</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered table-hover data-tables">

                                            <form method="post" name="submit">

                                                <tr>
                                                    <th>Full Name :</th>
                                                    <td><input type="text" name="name" id="name" class="form-control"
                                                            placeholder="Full name" required='true'>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <th>Email :</th>
                                                    <td>
                                                        <input type="email" name="email" id="email"
                                                            pattern="[^ @]*@[^ @]*" class="form-control"
                                                            placeholder="Email address" required='true'>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Phone Number :</th>
                                                    <td>
                                                        <input type="telephone" name="phone" id="phone"
                                                            class="form-control" placeholder="Enter Phone Number"
                                                            maxlength="10">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Appointment Date :</th>
                                                    <td>
                                                        <input type="date" name="date" id="date" value=""
                                                            class="form-control">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Appointment Hour :</th>
                                                    <td>
                                                        <input type="time" name="time" id="time" value=""
                                                            class="form-control">

                                                    </td>


                                                </tr>

                                                <tr>
                                                    <th>Message :</th>
                                                    <td>
                                                        <textarea class="form-control" rows="5" id="message"
                                                            name="message" placeholder="Additional Message"></textarea>


                                                    </td>
                                                </tr>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" name="submit" class="btn btn-primary">Update</button>

                                        </form>


                                    </div>


                                </div>
                            </div>

                        </div>
                        <div class="widget">
                            <header class="widget-header">
                                <h4 class="widget-title">Cancelled Appointment</h4>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <div class="table-responsive">
                                    <table
                                        class="table table-bordered table-hover js-basic-example dataTable table-custom">
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
                                             // Check if the table is reserved for the selected time
                        date_default_timezone_set('Africa/Tunisia'); // Set the time zone to Tunisia

                        $selectedDate = date("Y-m-d"); // Get the current date, you can change this to your selected date
                        $endTime = date("H:i:s"); // Get the current time, you can change this to your selected time

                        // Calculate the end time of the 20-minute range
                        $startTime = date("H:i:s", strtotime($endTime) / (21 * 60));
              $docid=$_SESSION['damsid'];
$sql="SELECT * from  tblappointment where Status='Approved' AND AppointmentDate='$selectedDate'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                                            <tr>
                                                <td><?php echo htmlentities($cnt);?></td>
                                                <td><?php  echo htmlentities($row->AppointmentNumber);?></td>
                                                <td><?php  echo htmlentities($row->Name);?></td>
                                                <td><?php  echo htmlentities($row->MobileNumber);?></td>
                                                <td><?php  echo htmlentities($row->Email);?></td>
                                                <?php if($row->Status==""){ ?>

                                                <td><?php echo "Not Updated Yet"; ?></td>
                                                <?php } else { ?> <td><?php  echo htmlentities($row->Status);?>
                                                </td>
                                                <?php } ?>

                                                <td><a href="view-appointment-detail.php?editid=<?php echo htmlentities ($row->ID);?>&&aptid=<?php echo htmlentities ($row->AppointmentNumber);?>"
                                                        class="btn btn-primary">View</a></td>

                                            </tr>
                                            <?php $cnt=$cnt+1;}}
                                            else{ ?>
                                            <tr>
                                                <td colspan=7>No Appointement Now <?php echo $selectedDate ?></td>
                                            </tr>
                                            <?php   }?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Appointment Number</th>
                                                <th>Patient Name</th>
                                                <th>Mobile Number</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div><!-- .widget-body -->
                        </div><!-- .widget -->
                    </div><!-- END column -->


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