<?php

session_start();
error_reporting(0);
include('includes/db.php');

if(strlen($_SESSION['damsid'])==0){
    header('location:logout.php');
}else{


$msg='';


if(isset($_POST['submit'])){
    $patientID=$_POST['patient'];
    $med=$_POST['medication'];
    $docID=$_SESSION['damsid'];
    $sql=mysqli_query($con,"insert into tblordonnance(patientID,medic,doctorID) values('$patientID','$med','$docID')");
    if($sql){
        $msg='Perscription Added Successfully to Patient ID : '.$patientID;
    }else{
        $msg="Error in Adding Prescription";
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

    <!-- SimpleMDE css -->
    <link href="asset/css/vendor/simplemde.min.css" rel="stylesheet" type="text/css" />



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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Perscription</a></li>
                                        <li class="breadcrumb-item active">Add</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Add Perscription</h4>
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




                                    <form method="post" name="submit" class="needs-validation" novalidate>
                                        <div class="row">
                                            <div class="col-xl-12 mb-3">
                                                <label for="sel" class="form-label">Select Existing
                                                    Patient</label>

                                                <select class="form-control select2 col-xl-6" required id="sel"
                                                    data-toggle="select2" name="patient">
                                                    <option value="">Please Select a patient</option>
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
                                            <div class="col-xl-12 ">
                                                <label for="sel" class="form-label">Add Patient Medicament</label>
                                                <textarea id="simplemde1" name="medication"></textarea>
                                            </div>



                                            <div class="">
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
    <!-- SimpleMDE js -->
    <script src="asset/js/vendor/simplemde.min.js"></script>
    <!-- SimpleMDE demo -->
    <script src="asset/js/pages/demo.simplemde.js"></script>



</body>
</html>

<?php }?>