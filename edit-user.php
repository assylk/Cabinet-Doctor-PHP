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
mysqli_query($con,"delete from tbldoctor where ID = '".$_GET['id']."'");
$msg="User deleted!";
$sql=true;
      }
$msg='';
    $id=$_GET['id'];
    $sql=mysqli_query($con,"select * from tbldoctor where ID='$id'");
    while($row=mysqli_fetch_assoc($sql)){
        $existingFullName=$row['FullName'];
        $name = explode(' ', $existingFullName);
        $existingfname = $name[0]; // First name
        $existinglname = $name[1]; // Last name
        $existingMobileNumber=$row['MobileNumber'];
        $existingEmail=$row['Email'];
        $existingRole=$row['Role'];

    }


if (isset($_POST['submit'])) {
        date_default_timezone_set("Africa/Tunis");
        $date=date("Y-m-d h:i:s");

        // Retrieve submitted values

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $fullname= $fname . " " . $lname;
        
        $MobileNumber = $_POST['phone'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $changes = array();
        if ($existingFullName != $fullname) {
            $changes[] = "FullName='$fullname'";
        }
        
        if ($existingMobileNumber != $MobileNumber) {
            $changes[] = "MobileNumber='$MobileNumber'";
        }
        if ($existingEmail != $email) {
            $changes[] = "Email='$email'";
        }
        if ($existingRole != $role) {
            $changes[] = "Role='$role'";
        }

        
        
        


        $msg='';
   // If there are changes, update the database
if (!empty($changes)) {
    $f = implode(', ', $changes);
    $update_query = "UPDATE tbldoctor SET " . implode(', ', $changes) . ",UpdationDate='$date' WHERE ID='$id'";
    $sql = mysqli_query($con, $update_query);
    if ($sql) {
        $msg = 'User information updated successfully, Please reload page to see changes';
    } else {
        $msg = 'User not updated';
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
    <title>CabiNet - User</title>
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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                                        <li class="breadcrumb-item active">Edit</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Edit User</h4>
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
                                                    <a href="edit-user.php?id=<?php echo $id?>&del=delete"
                                                        class="btn btn-danger">Delete</a>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    <form method="post" name="submit">

                                        <div class="row">
                                            <div class="col-xl-6 mb-3">
                                                <label for="existing">First Name</label>
                                                <input type="text" value="<?php echo $existingfname ?>" name="fname"
                                                    class="form-control" id="fname" placeholder="Enter first name">
                                            </div>
                                            <div class="col-xl-6 mb-3">
                                                <label for="lname">Last Name</label>
                                                <input type="text" value="<?php echo $existinglname ?>" name="lname"
                                                    class="form-control" id="lname" placeholder="Enter last name">
                                            </div>
                                            <div class="col-xl-6 mb-3">
                                                <label for="role">Role</label>
                                                <select id="role" name="role" class="form-select mb-3">
                                                    <option selected value="<?php echo $existingRole ?>">
                                                        <?php echo $existingRole ?>
                                                    </option>
                                                    <option value="doctor">Doctor</option>
                                                    <option value="secretaire">Secretaire</option>
                                                </select>

                                            </div>
                                            <div class="col-xl-6 mb-3">
                                                <label for="phone">Phone Number</label>
                                                <input type="number" value="<?php echo $existingMobileNumber ?>"
                                                    name="phone" class="form-control" id="phone"
                                                    placeholder="Enter phone number">
                                            </div>
                                            <div class="col-xl-12 mb-3">
                                                <label for="email">Email</label>
                                                <input type="email" value="<?php echo $existingEmail ?>" name="email"
                                                    class="form-control" id="email" placeholder="Enter email">
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