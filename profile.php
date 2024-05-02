<?php
session_start();
include("includes/db.php");
$sql=mysqli_query($con,"select * from tbldoctor where ID='".$_SESSION['damsid']."'");
while($row=mysqli_fetch_assoc($sql)){
    $exist_fullname=$row['FullName'];
    $nameParts=explode(' ', $exist_fullname);
    $exist_fname=$nameParts[0];
    $exist_lname = $nameParts[1];
    $exist_email=$row['Email'];
    $exist_num=$row['MobileNumber'];
    $exist_Role=$row['Role'];
    $exist_Password=$row['Password'];
    $exist_Specialization=$row['Specialization'];
    $exist_pic=$row['pic'];
}

if (isset($_POST['submit'])) {
    $target_dir = "uploads/";
        $id= $_GET['id'];
        date_default_timezone_set("Africa/Tunis");
        $date=date("Y-m-d h:i:s");
        
        
        // Retrieve submitted values
        $appusername=$_POST["username"]; 
        $appfname= $_POST['fname']; 
        $applname= $_POST['lname']; 
        $appEmail = $_POST['email'];
        $appassword = $_POST['password'];
        $appcpass = $_POST['cpass'];
        $appnum = $_POST['num'];
        $changes = array();
    

        // Check if a file is selected
    if($_FILES["pic"]["error"] == UPLOAD_ERR_OK) {
        $timestamp = time(); // Current timestamp
        $target_file = $target_dir . $timestamp . "_" . basename($_FILES["pic"]["name"]);

        // Check file size (limit to 5MB)
        $max_file_size = 5 * 1024 * 1024; // 5MB in bytes
        if ($_FILES["pic"]["size"] > $max_file_size) {
            $msg="Sorry, your file is too large (max 5MB).";
            
        }

        // Check file type
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($file_extension, $allowed_types)) {
            $msg="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $msg="Sorry, file already exists.";
            
        }

        // Upload file
        if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) {
            // Save file path to database
            $image_path = $target_file;
            $changes[] = "image='$image_path'";
        } else {
            $msg="Sorry, there was an error uploading your file.";
        }
    } else {
        $msg="No image selected.";
    }





        if ($exist_fullname != $appusername) {
            $changes[] = "FullName='$appusername'";
        }
        
        if ($exist_email != $appEmail) {
            $changes[] = "Email='$appEmail'";
        }
        
        if($appcpass!=''){
        if ($exist_num != $appnum) {
            $changes[] = "MobileNumber='$appnum'";
        }

        if ($exist_Password == md5($appassword)) {
            if($appassword==$appcpass){
                $msg="Password and Confirm Password are not match !";
            }else{
                $appasswordhash=md5($appcpass);
                $changes[] = "Password='$appasswordhash'";
            }
        }
        }
        
        
        


   // If there are changes, update the database
if (!empty($changes)) {
    $f = implode(', ', $changes);
    $update_query = "UPDATE tbldoctor SET " . implode(', ', $changes) . ",UpdationDate='$date' WHERE ID='".$_SESSION['damsid']."'";
    $sql = mysqli_query($con, $update_query);
    if ($sql) {
        $msg = 'Doctor information updated successfully, Please reload page to see changes';
    } else {
        $msg = 'Doctor not updated';
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
    <title>CabiNet - Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
                                        <li class="breadcrumb-item active">Profile</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-xl-12">
                            <?php if($msg!=''){ ?>
                            <div class="alert <?php echo $sql ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                                <i class="dripicons-<?php echo $sql ? 'checkmark' : 'cross'; ?> me-2"></i>
                                <?php echo $msg; ?>
                            </div>
                            <?php }?>
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="header-title mb-3">Profile</h4>

                                    <form method="post" enctype="multipart/form-data">
                                        <div id="progressbarwizard">

                                            <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                                <li class="nav-item">
                                                    <a href="#account-2" data-bs-toggle="tab" data-toggle="tab"
                                                        class="nav-link rounded-0 pt-2 pb-2 active">
                                                        <i class="mdi mdi-account-circle me-1"></i>
                                                        <span class="d-none d-sm-inline">Account</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#profile-tab-2" data-bs-toggle="tab" data-toggle="tab"
                                                        class="nav-link rounded-0 pt-2 pb-2">
                                                        <i class="mdi mdi-face-profile me-1"></i>
                                                        <span class="d-none d-sm-inline">Profile</span>
                                                    </a>
                                                </li>

                                            </ul>

                                            <div class="tab-content b-0 mb-0">



                                                <div class="tab-pane active" id="account-2">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="email">Email</label>
                                                                <div class="col-md-9">
                                                                    <input type="email" id="email" name="email"
                                                                        class="form-control"
                                                                        value="<?php echo $exist_email ?>">
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-md-3 col-form-label" for="password">
                                                                    Password</label>
                                                                <div class="col-md-9">
                                                                    <input type="password" autocomplete="off"
                                                                        id="password" name="password"
                                                                        class="form-control"
                                                                        placeholder="Enter current password">
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-md-3 col-form-label" for="cpass">New
                                                                    Password</label>
                                                                <div class="col-md-9">
                                                                    <input type="password" id="cpass"
                                                                        placeholder="Enter new password" name="cpass"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->
                                                </div>

                                                <div class="tab-pane" id="profile-tab-2">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="username">User name</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control"
                                                                        id="username" name="username"
                                                                        value="<?php echo $exist_fullname ?>">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label class="col-md-3 col-form-label" for="num">
                                                                    Mobile Number</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" id="num" name="num"
                                                                        class="form-control"
                                                                        value="<?php echo $exist_num ?>">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label class="col-md-3 col-form-label" for="pic">
                                                                    Profile image</label>
                                                                <div class="col-md-9">
                                                                    <input type="file" id="pic" name="pic"
                                                                        class="form-control"
                                                                        value="<?php echo $exist_pic ?>">
                                                                </div>
                                                            </div>


                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->
                                                </div>

                                                <div class="tab-pane" id="finish-2">
                                                    <div class="row">

                                                    </div>
                                                </div>

                                                <ul class="list-inline mb-0 wizard">

                                                    <li class="next list-inline-item float-end">
                                                        <button type="submit" name="submit"
                                                            class="btn btn-info">Save</button>
                                                    </li>
                                                </ul>

                                            </div> <!-- tab-content -->
                                        </div> <!-- end #progressbarwizard-->
                                    </form>

                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->

                    </div>
                    <!-- end page title -->

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
    <?php include("includes/rightBar.php") ?>

    <div class="rightbar-overlay"></div>
    <!-- /End-bar -->

    <!-- plugin js -->
    <script src="asset/js/vendor/dropzone.min.js"></script>
    <!-- init js -->
    <script src="asset/js/ui/component.fileupload.js"></script>

    <!-- bundle -->
    <script src="asset/js/vendor.min.js"></script>
    <script src="asset/js/app.min.js"></script>

</body>
</html>