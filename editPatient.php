<?php
session_start();
error_reporting(0);
include("includes/db.php");
$id=$_GET['id'];
$sql=mysqli_query($con,"select * from tblpatient where patientID='$id'");
if(strlen($_SESSION['damsid'])==0){
    $_SESSION["msgerr"]='Page Not Found'; 
    header("location:index.php" );
}
elseif(!$sql){
    $_SESSION["msgerr"]='Patient is Not Available';
    header('Location:all-patients.php');
}else{

    while($row=mysqli_fetch_assoc($sql)){
        $username=$row['Name'];
        $nameParts = explode(' ', $username);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1];
        $email=$row['Email'];
        $patientID=$row['patientID'];
        $CIN=$row['CIN'];
        $CNSS=$row['CNSS'];
        $mobnum=$row['MobileNumber'];
        $adresse=$row['adresse'];
        $region=$row['region'];
        $image=$row['image'];
        
    }
// Check if the form is submitted
if (isset($_POST['addPic'])) {
    // Check if a file is selected
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
        // Define the directory where the file will be uploaded
        $uploadDirectory = "images/patientImg/";
        
        // Get the file name and extension
        $fileName = basename($_FILES["fileToUpload"]["name"]);
        
        // Generate a unique name to prevent overwriting existing files
        $uniqueFileName = uniqid() . '_' . $fileName;
        
        // Concatenate the directory and file name
        $targetFilePath = $uploadDirectory . $uniqueFileName;
        
        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFilePath)) {
            // File uploaded successfully
            
         
            
            // SQL statement to update the database with the file path
            $sql = "UPDATE tblpatient SET image = '$targetFilePath' WHERE patientID = '".$_GET['id']."'";
            
            // Execute SQL statement
            if (mysqli_query($con, $sql)) {
                // Record updated successfully
                $msg= "File uploaded successfully.";
            } else {
                // Failed to update record
                $msg= "Error updating record: " . mysqli_error($conn);
            }
            
           
        } else {
            // Failed to move the uploaded file
            $msg= "Sorry, there was an error uploading your file.";
        }
    } else {
        // No file selected or an error occurred during upload
        $msg= "Please select a file to upload.";
    }
}

if (isset($_POST['update'])) {
        $id= $_GET['id'];
        date_default_timezone_set("Africa/Tunis");
        $date=date("Y-m-d h:i:s");
        // Retrieve existing values from the database
        $existing_course = mysqli_query($con, "SELECT * FROM tblpatient WHERE patientID='$id'");
        $row = mysqli_fetch_assoc($existing_course);
        $existing_appName = $row['Name'];
        $existing_appEmail = $row['Email'];
        $existing_appCin = $row['CIN'];
        $existing_appCnss = $row['CNSS'];
        $existing_adresse = $row['adresse'];
        $existing_region = $row['region'];
        $existing_dob= $row['dob'];
        $existing_MobileNumber = $row['MobileNumber'];

        // Retrieve submitted values

        $appName= $_POST['firstname'] . ' ' . $_POST['lastname']; 
        $appEmail = $_POST['email'];
        $appCin = $_POST['cin'];
        $appCnss = $_POST['cnss'];
        $appRegion = $_POST['region'];
        $appAdresse = $_POST['adresse'];
        $appnNum = $_POST['num'];
        $appnDob = $_POST['dob'];
        $changes = array();
        if ($existing_appName != $appName) {
            $changes[] = "Name='$appName'";
        }
        
        if ($existing_appEmail != $appEmail) {
            $changes[] = "Email='$appEmail'";
        }
        if ($existing_appCin != $appCin) {
            $changes[] = "CIN='$appCin'";
        }

        if ($existing_appCnss != $appCnss) {
            $changes[] = "CNSS='$appCnss'";
        }
      
        if ($existing_region != $appRegion) {
            $changes[] = "region='$appRegion'";
        }
        if ($existing_adresse != $appAdresse) {
            $changes[] = "adresse='$appAdresse'";
        }
        if ($existing_MobileNumber != $appnNum) {
            $changes[] = "MobileNumber='$appnNum'";
        }
        


        $msg='';
   // If there are changes, update the database
if (!empty($changes)) {
    $f = implode(', ', $changes);
    $update_query = "UPDATE tblpatient SET " . implode(', ', $changes) . ",UpdationDate='$date' WHERE patientID='$id'";
    $sql = mysqli_query($con, $update_query);
    if ($sql) {
        $msg = 'Patient information updated successfully, Please reload page to see changes';
    } else {
        $msg = 'Patient not updated';
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
    <title>CabiNet - Patients</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="asset/images/favicon.ico">

    <!-- App css -->
    <!-- Quill css -->
    <link href="assets/css/vendor/quill.core.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/vendor/quill.snow.css" rel="stylesheet" type="text/css" />


    <link href="asset/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="asset/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="asset/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style">

</head>
<style>
.custom-file-upload {
    cursor: pointer;
}

/* Style the label to have a background color and border similar to a button */
.custom-file-upload {
    display: inline-block;
    padding: 6px 12px;
    color: #fff;
    background-color: #28a745;
    border: 1px solid #28a745;
    border-radius: 4px;
    transition: all 0.3s ease;
}

/* Change the background color and border color when hovered over */
.custom-file-upload:hover {
    background-color: #218838;
    border-color: #218838;
}
</style>

<body class="loading"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <?php include("includes/sideBar.php"); ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <?php include("includes/topBar.php"); ?>

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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">All Patients</a></li>
                                        <li class="breadcrumb-item active">Edit Patient</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Patient Detail</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">



                        <div class="col-xl-4 col-lg-5">
                            <form method="post" enctype="multipart/form-data">

                                <div class="card text-center">
                                    <div class="card-body" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                                        <?php if($image==Null){ ?>
                                        <img id="preview-image" src="images/patient.png"
                                            class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                                        <?php }else{?>
                                        <img id="preview-image" src="<?php echo $image; ?>"
                                            class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                                        <?php }?>
                                        <h4 class="mb-0 mt-2"><?php echo $username; ?></h4>
                                        <p class="text-muted font-14">Patient</p>

                                        <!-- Your existing form fields -->
                                        <input type="submit" value="save" class="btn btn-primary btn-sm mb-2"
                                            name="addPic">
                                        <input id="file-upload" type="file" name="fileToUpload" style="display:none;"
                                            accept="image/*" required>
                                        <label for="file-upload" class="btn btn-danger btn-sm mb-2">
                                            <i class="fas fa-cloud-upload-alt"></i> Add Profile Picture
                                        </label>

                                        <div class="text-start mt-3">
                                            <h4 class="font-13 text-uppercase">About Me :</h4>
                                            <p class="text-muted font-13 mb-3">
                                                Hey, I'm <?php echo $username ?>. Passionate about health and wellness.
                                                Let's embark on this journey together, striving for balance and vitality
                                                in every aspect of life.
                                            </p>
                                            <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span
                                                    class="ms-2"><?php echo $username ?></span></p>
                                            <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span
                                                    class="ms-2">(+216) <?php echo $mobnum; ?></span></p>
                                            <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span
                                                    class="ms-2 "><?php echo $email; ?></span></p>
                                            <p class="text-muted mb-1 font-13"><strong>Location :</strong> <span
                                                    class="ms-2"><?php echo $region; ?></span></p>
                                        </div>
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </form>

                        </div> <!-- end col-->

                        <div class="col-xl-8 col-lg-7">
                            <div class="card" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                                <div class="card-body">
                                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                        <li class="nav-item">
                                            <a href="#settings" data-bs-toggle="tab" aria-expanded="false"
                                                class="nav-link rounded-0 active">
                                                Settings
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#aboutme" data-bs-toggle="tab" aria-expanded="false"
                                                class="nav-link rounded-0">
                                                History
                                            </a>
                                        </li>


                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane" id="aboutme">



                                            <h5 class="mb-3 mt-4 text-uppercase"><i
                                                    class="mdi mdi-cards-variant me-1"></i>
                                                Last Appointments</h5>
                                            <div class="table-responsive">
                                                <table class="table table-borderless table-nowrap mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Doctor</th>
                                                            <th>Remark</th>
                                                            <th>AppointmentDate</th>
                                                            <th>ApplyDate</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php  $sql=mysqli_query($con,"select tbldoctor.image as docpic,tblpatient.Name as Name,tblappointment.Remark as Remark,tblappointment.Status as Status,tblappointment.AppointmentDate as AppointmentDate,tblappointment.ApplyDate as ApplyDate,tbldoctor.FullName as docname from tblappointment inner join tblpatient  on tblpatient.patientID=tblappointment.patientID inner join tbldoctor on tbldoctor.FullName=tblappointment.Doctor where tblappointment.patientID='".$_GET['id']."'");
                                                        if(mysqli_num_rows($sql)>0){
                                                            $cnt=1;
                                                            while ($row= mysqli_fetch_assoc($sql)) { 
                                                                // Convert the datetime string to a Unix timestamp
                                                        $timestamp = strtotime($row['ApplyDate']);

                                                        // Format the timestamp to retrieve only the date
                                                        $dateOnly = date('Y-m-d', $timestamp);
                                                        ?>

                                                        <tr>
                                                            <td><?php echo $cnt ?></td>
                                                            <td><img src="<?php echo $row['docpic'] ?>" alt="table-user"
                                                                    class="me-2 rounded-circle"
                                                                    height="24"><?php echo $row['docname'] ?></td>
                                                            <td><?php echo $row['Remark'] ?></td>
                                                            <td><?php echo $row['AppointmentDate'] ?></td>
                                                            <td><?php echo $dateOnly ?></td>
                                                            <td><span
                                                                    class="badge <?php echo $row['Status'] == 'Approved' ? 'badge-success-lighten' : ($row['Status'] == 'Cancelled' ? 'badge-danger-lighten' : 'badge-warning-lighten');?>">
                                                                    <?php echo $row['Status'] == 'Approved' ? 'Approved' : ($row['Status'] == 'Cancelled' ? 'Cancelled' : 'Pending');?>
                                                                </span></td>
                                                        </tr>
                                                        <?php }
                                                    $cnt++;
                                                    }else{?>
                                                        <tr>
                                                            <td colspan="6">
                                                                <center>Patient has no appointment yet!.</center>
                                                            </td>
                                                        </tr>
                                                        <?php }?>


                                                    </tbody>
                                                </table>
                                            </div>

                                        </div> <!-- end tab-pane -->
                                        <!-- end about me section content -->


                                        <div class="tab-pane show active" id="settings">
                                            <form method="post">
                                                <h5 class="mb-4 text-uppercase"><i
                                                        class="mdi mdi-account-circle me-1"></i> Personal Info</h5>
                                                <?php if($msg!=''){ ?>
                                                <div class="alert <?php echo $sql ? 'alert-success' : 'alert-danger'; ?>"
                                                    role="alert">
                                                    <i
                                                        class="dripicons-<?php echo $sql ? 'checkmark' : 'cross'; ?> me-2"></i>
                                                    <?php echo $msg; ?>
                                                </div>
                                                <?php }?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="firstname" class="form-label">First Name</label>
                                                            <input type="text" value="<?php echo $firstName ?>"
                                                                class="form-control" name="firstname" id="firstname"
                                                                placeholder="Enter first name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="lastname" class="form-label">Last Name</label>
                                                            <input type="text" value="<?php echo $lastName ?>"
                                                                class="form-control" name="lastname" id="lastname"
                                                                placeholder="Enter last name">
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="cin" class="form-label">Cin</label>
                                                            <input type="text" value="<?php echo $CIN ?>"
                                                                class="form-control" name="cin" id="cin"
                                                                placeholder="Enter patient cin">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="cnss" class="form-label">Cnss</label>
                                                            <input type="text" value="<?php echo $CNSS ?>"
                                                                class="form-control" name="cnss" id="cnss"
                                                                placeholder="Enter patient cnss">
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email
                                                                Address</label>
                                                            <input type="email" name="email"
                                                                value="<?php echo $email ?>" class="form-control"
                                                                id="email" placeholder="Enter email">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 p-1">
                                                        <div class="mb-3">
                                                            <label for="num" class="form-label">Mobile Number</label>
                                                            <input type="text" value="<?php echo $mobnum ?>"
                                                                class="form-control" name="num" id="num"
                                                                placeholder="Enter patient mobile number">
                                                        </div>
                                                    </div> <!-- end row -->
                                                    <h5 class="mb-3 text-uppercase bg-light p-2"><i
                                                            class="mdi mdi-office-building me-1"></i> Coordination Info
                                                    </h5>
                                                    <div class="row">

                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label for="region" class="form-label">Region</label>
                                                                <textarea class="form-control" name="region" id="region"
                                                                    rows="4"
                                                                    placeholder="Write something..."><?php echo $region ?></textarea>
                                                            </div>

                                                        </div>
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label for="adresse" class="form-label">Adresse</label>
                                                                <textarea class="form-control" name="adresse"
                                                                    id="adresse" rows="4"
                                                                    placeholder="Write something..."><?php echo $adresse ?></textarea>
                                                            </div>

                                                        </div>
                                                    </div> <!-- end row -->

                                                    <div class="text-end">
                                                        <button type="submit" name="update"
                                                            class="btn btn-success mt-2"><i
                                                                class="mdi mdi-content-save"></i> Save</button>
                                                    </div>

                                                </div> <!-- end row -->

                                        </div> <!-- end col -->
                                    </div> <!-- end row -->




                                    </form>
                                </div>
                                <!-- end settings content-->

                            </div> <!-- end tab-content -->
                        </div> <!-- end card body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row-->

        </div>
        <!-- container -->

    </div>
    <!-- content -->

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
    document.getElementById('file-upload').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('preview-image').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    </script>
    <!-- quill js -->
    <script src="assets/js/vendor/quill.min.js"></script>
    <!-- quill Init js-->
    <script src="assets/js/pages/demo.quilljs.js"></script>


    <!-- bundle -->
    <script src="asset/js/vendor.min.js"></script>
    <script src="asset/js/app.min.js"></script>

</body>
</html>
<?php }?>