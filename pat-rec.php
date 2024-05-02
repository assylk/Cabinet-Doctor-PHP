<?php
session_start();
error_reporting(0);
include('includes/db.php');
if (strlen($_SESSION['damsid']==0)) {
  header('location:index.php');
  }
  $id=$_GET['id'];
$sql=mysqli_query($con,"select * from tblfiche where id='$id'");

while($row=mysqli_fetch_assoc($sql)){
        $gender=$row['gender'];
        $observations=$row['observations'];
        $age=$row['age'];
        $weight=$row['weight'];
        $pathologie=$row['pathologie'];

        
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
    $result = mysqli_query($con, $update_query);
    if ($result) {
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
    <title>CabiNet - Records </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="asset/images/favicon.ico">

    <!-- App css -->
    <link href="asset/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="asset/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="asset/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style">

</head>
<style>
/* before adding the photo to the div with the "card-photo" class, in the css clear the styles for .card-photo and remove .card-photo::before and .card-photo::after, then set the desired styles for .card- photo. */

.card {
    --font-color: #323232;
    --font-color-sub: #666;
    --bg-color: #fff;
    --main-color: #323232;
    width: 200px;
    height: 254px;
    background: var(--bg-color);
    border: 2px solid var(--main-color);
    box-shadow: 4px 4px var(--main-color);
    border-radius: 5px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.card-photo {
    /* clear and add new css */
    transform: scale(0.3) translate(220px, 230px);
    width: 200px;
    height: 200px;
    margin-left: -125px;
    margin-top: -125px;
}

.card-photo img {
    width: 230px;
}




.card-title {
    text-align: center;
    color: var(--font-color);
    font-size: 20px;
    font-weight: 400;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

.card-title span {
    font-size: 15px;
    color: var(--font-color-sub);
}

.card-socials {
    display: flex;
    height: 0;
    opacity: 0;
    margin-top: 20px;
    gap: 20px;
    transition: 0.5s;
}

.card-socials-btn {
    width: 25px;
    height: 25px;
    border: none;
    background: transparent;
    cursor: pointer;
}

.card-socials-btn svg {
    width: 100%;
    height: 100%;
    fill: var(--main-color);
}

.card:hover>.card-socials {
    opacity: 1;
    height: 35px;
}

.card-socials-btn:hover {
    transform: translateY(-5px);
    transition: all 0.15s;
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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Records</a></li>
                                        <li class="breadcrumb-item active">All</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">All Records</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row mx-md-n5">
                        <?php $sql=mysqli_query($con,"select tblfiche.id as id,tblpatient.Name as name from tblfiche INNER JOIN tblpatient ON tblfiche.patientID=tblpatient.patientID ");
                        if(mysqli_num_rows($sql)==0){?>
                        <div class="col-12 ">
                            <span>No Records Available For now</span>
                        </div>
                        <?php
                        }
                        while($row=mysqli_fetch_array($sql)) { 
                        ?>
                        <div class="col-2 px-md-5">
                            <div class="card">
                                <div class="card-photo">
                                    <img src="images/doctor.png" alt="">
                                </div>
                                <div class="card-title mt-3"><?php echo $row['name'] ?> <br>
                                    <span>Patient Record</span>
                                </div>
                                <div class="card-socials">
                                    <a href="print.php?id=<?php echo $row['id'] ?>"><button
                                            class="btn btn-primary">Print <i class="uil-file-download"></i>
                                        </button></a>
                                    <a href="edit-rec.php?id=<?php echo $row['id'] ?>"><button
                                            class="btn btn-secondary">Edit
                                            <i class="uil-file-edit-alt"></i>
                                        </button></a>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                        <!-- Multiple modal -->
                        <form method="post">

                            <div id="multiple-one" class="modal fade" style="background:#717cf53b" tabindex="-1"
                                role="dialog" aria-labelledby="multiple-oneModalLabel" aria-hidden="true">
                                <div class="modal-dialog" style="border:3px solid black">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="multiple-oneModalLabel">Modal Heading</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="gender">Gender</label>
                                                <select id="gender" name="gender" required class="form-select mb-3">
                                                    <option selected value="">Open this select menu</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="age">Age</label>
                                                <input type="number" name="age" class="form-control" id="age"
                                                    placeholder="Enter Age" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="weight">Weight</label>
                                                <input type="number" name="weight" class="form-control" id="weight"
                                                    placeholder="Enter weight" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="observations">Observations</label>
                                                <input type="text" name="observations" class="form-control"
                                                    id="observations" placeholder="Enter observations" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pathologie">Pathologie</label>
                                                <input type="text" name="pathologie" class="form-control"
                                                    id="pathologie" placeholder="Enter pathologie" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="editrec" class="btn btn-primary">Save</button>
                                            <button type="button" class="btn btn-primary" data-bs-target="#multiple-two"
                                                data-bs-toggle="modal" data-bs-dismiss="modal">Next</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        </form>
                        <!-- Modal -->
                        <div id="multiple-two" class="modal fade" style="background:#717cf53b" tabindex="-1"
                            role="dialog" aria-labelledby="multiple-twoModalLabel" aria-hidden="true">
                            <div class="modal-dialog" style="border:3px solid black">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="multiple-twoModalLabel">Add Visit info</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-hidden="true"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="notes">Notes</label>
                                            <textarea name="notes" rows="4" class="form-control" id="notes"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="resaon">Reason</label>
                                            <textarea name="resaon" rows="4" class="form-control"
                                                id="resaon"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="visitdate">Visit Date</label>
                                            <input type="date" name="visitdate" class="form-control" id="visitdate">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="addvisit" class="btn btn-primary"
                                            data-bs-dismiss="modal">Add</button>
                                        <button type="button" class="btn btn-primary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    </div>
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

</body>
</html>