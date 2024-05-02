<?php

session_start();
error_reporting(0);
include('includes/db.php');
include('includes/dbconnection.php');

if(strlen($_SESSION['damsid'])==0){
    header('location:logout.php');
}else{
// Assuming you have already established a connection to your MySQL database


$msg='';
if(isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $name=$fname." ".$lname;
    $cin = $_POST['cin'];
    $cnss = $_POST['cnss'];
    $dob = $_POST['dob'];
    $mobnum = $_POST['phone'];
    $email = $_POST['email'];
    $appdate = $_POST['date'];
    $aaptime = $_POST['time'];
    $region = $_POST['region'];
    $patientID = uniqid();
    $cdate = date('Y-m-d');

    if($dob >= $cdate) {
        $msg='Patient bearth date must be before todays date';

    } else {
        $sql=mysqli_query($con,"select * from tblpatient where CIN='$cin'");
        $num=mysqli_num_rows($sql);
        if($num>0) {
            $msg="This CIN : $cin is already registered";
        } else {
        $result = mysqli_query($con,"INSERT INTO tblpatient (patientID, Name, CIN, CNSS, dob, MobileNumber, Email,Region) VALUES ('$patientID', '$name', '$cin', '$cnss', '$dob' ,'$mobnum', '$email','$region')");

        if ($result) {
            $lastInsertId = mysqli_insert_id($con);
            if ($lastInsertId > 0) {
                $msg='Patient Added Successfully !';

            } else {
                $msg= 'Something went wrong while Adding Patient Please try again later';

            }
        } else {
            
            $msg='Error : '.mysqli_error($con);
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
                            <div class="alert <?php echo $result ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                                <i class="dripicons-<?php echo $result ? 'checkmark' : 'cross'; ?> me-2"></i>
                                <?php echo $msg; ?>
                            </div>
                            <?php }?>
                            <div class="card">
                                <div class="card-body">




                                    <form method="post" name="submit" class="needs-validation" novalidate>
                                        <div class="row">
                                            <div class="col-xl-6 mb-3">
                                                <label class="form-label" for="validationCustom01">First name</label>
                                                <input type="text" class="form-control" id="validationCustom01"
                                                    name="fname" placeholder="First name" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>

                                            </div>
                                            <div class="col-xl-6 mb-3">
                                                <label for="lname" class="form-label">Last Name</label>
                                                <input type="text" required id="lname" name="lname" class="form-control"
                                                    placeholder="Enter patient last name">
                                            </div>
                                            <div class="col-xl-6 mb-3">
                                                <label for="cin" class="form-label">CIN</label>
                                                <input type="text" required name="cin" id="cin" class="form-control"
                                                    placeholder="Enter patient cin">
                                            </div>
                                            <div class="col-xl-6 mb-3">
                                                <label for="cnss" class="form-label">CNSS</label>
                                                <input type="text" required name="cnss" id="cnss" class="form-control"
                                                    placeholder="Enter patient cnss">
                                            </div>
                                            <div class="col-xl-6 mb-3">
                                                <label for="phone" class="form-label">Phone Number</label>
                                                <input type="text" required type="telephone" name="phone" id="phone"
                                                    class="form-control" placeholder="Enter patient phone number"
                                                    maxlength="8">
                                            </div>
                                            <div class="col-xl-6 mb-3">
                                                <label for="dob" class="form-label">Date of Bearth</label>
                                                <input class="form-control" required id="example-date" type="date"
                                                    name="dob" id="dob">
                                            </div>
                                            <div class="col-xl-6 mb-3">
                                                <label for="projectname" class="form-label">Email</label>
                                                <input type="email" required name="email" id="email"
                                                    pattern="[^ @]*@[^ @]*" id="projectname" class="form-control"
                                                    placeholder="Enter patient email">
                                            </div>
                                            <div class="col-xl-6 mb-3">
                                                <label for="region" class="form-label">Region</label>
                                                <input type="text" required name="region" id="region" id="projectname"
                                                    class="form-control" placeholder="Enter patient region">
                                            </div>

                                            <div class="mb-3">
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