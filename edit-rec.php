<?php

session_start();
error_reporting(0);
include('includes/db.php');

if(strlen($_SESSION['damsid'])==0){
    header('location:logout.php');
}else{

    // Code for Deletion
if(isset($_GET['del']))
{
mysqli_query($con,"delete from tblfiche where id = '".$_GET['id']."'");
$msg="Record deleted!";
$sql=true;
      }
$msg='';
    $id=$_GET['id'];
    $sql=mysqli_query($con,"select * from tblfiche where id='$id'");
    while($row=mysqli_fetch_assoc($sql)){
        $gender=$row['gender'];
        $observations=$row['observations'];
        $age=$row['age'];
        $weight=$row['weight'];
        $pathologie=$row['pathologie'];
    }


if (isset($_POST['submit'])) {
        date_default_timezone_set("Africa/Tunis");
        $date=date("Y-m-d h:i:s");

        // Retrieve submitted values

        $appGender = $_POST['gender'];
        $appObservations = $_POST['observations'];
        $appAge = $_POST['age'];
        $appWeight = $_POST['weight'];
        $apppAthologie = $_POST['pathologie'];
        $changes = array();
        if ($existing_appName != $appName) {
            $changes[] = "Name='$appName'";
        }
        
        if ($gender != $appGender) {
            $changes[] = "gender='$appGender'";
        }
        if ($observations != $appObservations) {
            $changes[] = "observations='$appObservations'";
        }

        if ($age != $appAge) {
            $changes[] = "age='$appAge'";
        }
      
        if ($weight != $appWeight) {
            $changes[] = "weight='$appWeight'";
        }
        if ($pathologie != $apppAthologie) {
            $changes[] = "pathologie='$apppAthologie'";
        }
        
        


        $msg='';
   // If there are changes, update the database
if (!empty($changes)) {
    $f = implode(', ', $changes);
    $update_query = "UPDATE tblfiche SET " . implode(', ', $changes) . ",UpdationDate='$date' WHERE id='$id'";
    $sql = mysqli_query($con, $update_query);
    if ($sql) {
        $msg = 'Record information updated successfully, Please reload page to see changes';
    } else {
        $msg = 'Record not updated';
    }
} else {
    $msg = 'No change made';
}
//header("location:editPatient.php?id=$id");
}





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CabiNet - Record</title>
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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Records </a></li>
                                        <li class="breadcrumb-item active">Edit</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Edit Record</h4>
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
                            <div class="card" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                                <div class="card-body">

                                    <div class="col-12">
                                        <a href="add-patient.php" data-bs-toggle="modal"
                                            data-bs-target="#danger-header-modal" class="btn btn-danger mb-2"><i
                                                class="mdi mdi-delete"></i>
                                            Delete </a>
                                    </div>
                                    <div id="danger-header-modal" class="modal fade" tabindex="-1" role="dialog"
                                        aria-labelledby="danger-header-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header modal-colored-header bg-danger">
                                                    <h4 class="modal-title" id="danger-header-modalLabel">Confirm Delete
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-hidden="true"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this
                                                    Patient?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <a href="edit-rec.php?id=<?php echo $id?>&del=delete"
                                                        class="btn btn-danger">Delete</a>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    <form method="post" name="submit">

                                        <div class="row">

                                            <div class="col-xl-6 mb-3">
                                                <label for="gender">Gender</label>
                                                <select id="gender" name="gender" required class="form-select mb-3">
                                                    <option selected value="<?php echo $gender ?>"><?php echo $gender ?>
                                                    </option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>

                                            </div>
                                            <div class="col-xl-6 mb-3">
                                                <label for="age">Age</label>
                                                <input type="number" value="<?php echo $age ?>" name="age"
                                                    class="form-control" id="age" placeholder="Enter Age" required>
                                            </div>
                                            <div class="col-xl-6 mb-3">
                                                <label for="weight">Weight</label>
                                                <input type="number" value="<?php echo $weight ?>" name="weight"
                                                    class="form-control" id="weight" placeholder="Enter weight"
                                                    required>
                                            </div>
                                            <div class="col-xl-6 mb-3">
                                                <label for="observations">Observations</label>
                                                <input type="text" value="<?php echo $observations ?>"
                                                    name="observations" class="form-control" id="observations"
                                                    placeholder="Enter observations" required>
                                            </div>
                                            <div class="col-xl-6 mb-3 mt-3">
                                                <label for="pathologie">Pathologie</label>
                                                <input type="text" value="<?php echo $pathologie ?>" name="pathologie"
                                                    class="form-control" id="pathologie" placeholder="Enter pathologie"
                                                    required>
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