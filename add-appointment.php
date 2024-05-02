<?php

session_start();
error_reporting(0);
include('includes/db.php');

if(strlen($_SESSION['damsid'])==0){
    header('location:logout.php');
}else{
// Assuming you have already established a connection to your MySQL database


$msg='';
if(isset($_POST['submit'])) {
    $date=$_POST['date'];
    $time=$_POST['time'];
    $cdate = date('Y-m-d');

    if($date <= $cdate) {
        $msg='Appointment date should be greater than todays date !';

    }else{
        if($_POST['fname']!='' && $_POST['lname']!=''&&$_POST['phone']!=''){
        $name=$_POST['fname'].' '.$_POST['lname'];
        $phone=$_POST['phone'];
        $patientID = uniqid();

        $sql=mysqli_query($con,"insert into tblpatient(patientID,Name,MobileNumber) values('$patientID','$name','$phone')");
        if($sql){
            $sql=mysqli_query($con,"insert into tblappointment(AppointmentDate,AppointmentTime,patientID) values('$date','$time','$patientID')");
            if($sql){
                $msg='Patient and Appointment Added Successfully !';
            }else{
                $msg='Something went wrong.Try Again !';
            }
        }else{
                $msg='Something went wrong.Try Again !';

        }
    }else if($_POST['patient']!=''){
        $patient=$_POST['patient'];
            $sql=mysqli_query($con,"insert into tblappointment(AppointmentDate,AppointmentTime,patientID) values('$date','$time','$patient')");
            if($sql){
                $msg="Appointment Successfully Added for Patient id : $patient";
            }else{
                $msg='Something went wrong.Try Again !';
            }
    }  
    }
     

}






?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CabiNet - Patient</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="asset/images/favicon.ico">

    <!-- App css -->
    <link href="asset/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="asset/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="asset/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style">

</head>
<style>
.hidden {
    display: none;
}
</style>
<body class="loading"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <?php include("includes/sideBar.php") ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <?php include("includes/topBar.php") ?>

                <!-- end Topbar -->

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Patients</a></li>
                                        <li class="breadcrumb-item active">Add</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Add Patient</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <?php if($msg!=''){ ?>
                            <div class="alert <?php echo $sql ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                                <i class="dripicons-<?php echo $sql ? 'checkmark' : 'cross'; ?> me-2"></i>
                                <?php echo $msg; ?>
                            </div>
                            <?php }?>
                            <div class="card">
                                <div class="card-body">




                                    <form method="post" name="submit">
                                        <div class="row">
                                            <div class="col-xl-6 mb-3">
                                                <label for="example-date" class="form-label">Appointment
                                                    Date</label>
                                                <input class="form-control" required id="example-date" type="date"
                                                    name="date" id="date">
                                            </div>
                                            <div class="col-xl-6 mb-3">
                                                <label for="project-overview" class="form-label">Time</label>

                                                <?php
                                                    $availableTimes = array();
                                                    for ($hour = 9; $hour <= 16; $hour++) {
                                                        for ($minute = 0; $minute < 60; $minute += 60) {
                                                            $time = sprintf('%02d:%02d:00', $hour, $minute);
                                                            $availableTimes[] = $time;
                                                        }
                                                    }
                                                    ?>

                                                <select class="form-select" required name="time">
                                                    <option selected value>Open this select menu</option>
                                                    <?php foreach ($availableTimes as $time) {?>
                                                    <option value="<?php echo $time ?>"><?php echo $time ?></option>
                                                    <?php }?>

                                                </select>
                                            </div>
                                            <div class="col-xl-12 mb-3">
                                                <label for="patientType" class="form-label">Select Appointment
                                                    Type</label>

                                                <select id="patientType" name="patientType"
                                                    onchange="togglePatientFields()" required class="form-select mb-3">
                                                    <option selected value="">Open this select menu</option>

                                                    <option value="existing">Existing Patient</option>
                                                    <option value="new">New Patient</option>
                                                </select>

                                            </div>

                                            <div id="newPatientFields" class="hidden mb-3">
                                                <div class="col-xl-6">
                                                    <label for="fname" class="form-label">First Name</label>
                                                    <input type="text" name="fname" id="fname" class="form-control"
                                                        placeholder="Enter patient first name">
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="lname" class="form-label">Last Name</label>
                                                    <input type="text" type="telephone" name="lname" id="lname"
                                                        class="form-control" placeholder="Enter patient last name"
                                                        maxlength="8">
                                                </div>

                                                <div class="col-xl-12 ">
                                                    <label for="phone" class="form-label">Phone Number</label>
                                                    <input type="number" name="phone" id="phone" class="form-control"
                                                        placeholder="Enter phone number">
                                                </div>
                                            </div>
                                            <!-- Single Select -->
                                            <div id="existingPatientFields" class="hidden">
                                                <label for="sel" class="form-label">Select Existing
                                                    Patient</label>

                                                <select class="form-control select2 col-xl-6" id="sel"
                                                    data-toggle="select2" name="patient">
                                                    <optgroup label="Patient">
                                                        <?php $fetch_patient=mysqli_query($con,"select * from tblpatient");
                                                        while($row=mysqli_fetch_assoc($fetch_patient)){
                                                        ?>
                                                        <option value="<?php echo $row['patientID'] ?>">
                                                            <?php echo $row['Name'] ?></option>
                                                        <?php }?>
                                                    </optgroup>

                                                </select>
                                            </div>
                                            <div class="mb-3 mt-3">
                                                <button type="submit" name="submit"
                                                    class="btn btn-xs btn-success">Submit</button>
                                            </div>

                                    </form>



                                    <!-- Preview -->
                                    <div class="dropzone-previews mt-3" id="file-previews"></div>
                                    <div class="mb-3">

                                        <!-- file preview template -->
                                        <div class="d-none" id="uploadPreviewTemplate">
                                            <div class="card mt-1 mb-0 shadow-none border">
                                                <div class="p-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <img data-dz-thumbnail="" src="#"
                                                                class="avatar-sm rounded bg-light" alt="">
                                                        </div>
                                                        <div class="col ps-0">
                                                            <a href="javascript:void(0);" class="text-muted fw-bold"
                                                                data-dz-name=""></a>
                                                            <p class="mb-0" data-dz-size=""></p>
                                                        </div>
                                                        <div class="col-auto">
                                                            <!-- Button -->
                                                            <a href="" class="btn btn-link btn-lg text-muted"
                                                                data-dz-remove="">
                                                                <i class="dripicons-cross"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- end file preview template -->
                                    </div>


                                </div> <!-- end col-->
                            </div>

                            <!-- end row -->

                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div>
            <!-- end row-->

        </div> <!-- container -->

    </div> <!-- content -->

    <!-- Footer Start -->
    <?php include("includes/footer.php"); ?>
    <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->


    <!-- Right Sidebar -->
    <?php include("includes/rightBar.php"); ?>


    <div class="rightbar-overlay"></div>
    <!-- /End-bar -->
    <script>
    function togglePatientFields() {
        var patientType = document.getElementById("patientType").value;
        var existingPatientFields = document.getElementById("existingPatientFields");
        var newPatientFields = document.getElementById("newPatientFields");

        if (patientType === "existing") {
            existingPatientFields.classList.remove("hidden");
            newPatientFields.classList.add("hidden");
        } else if (patientType === "new") {
            existingPatientFields.classList.add("hidden");
            newPatientFields.classList.remove("hidden");
        }
    }
    </script>


    <!-- bundle -->
    <script src="asset/js/vendor.min.js"></script>
    <script src="asset/js/app.min.js"></script>

    <!-- plugin js -->
    <script src="asset/js/vendor/dropzone.min.js"></script>
    <!-- init js -->
    <script src="asset/js/ui/component.fileupload.js"></script>

</body>
</html>

<?php }?>