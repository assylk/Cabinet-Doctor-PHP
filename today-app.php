<?php
session_start();
error_reporting(0);
include('includes/db.php');
if (strlen($_SESSION['damsid']==0)) {
  header('location:index.php');
  } else{
    
    $selectedDate = date("Y-m-d"); 
$endTime = date("H:i:s"); 

    // Code for Deletion
if(isset($_GET['del']))
{
$sql=mysqli_query($con,"delete from tblappointment where ID = '".$_GET['id']."'");
if($sql){
    $msg="Appointment deleted!";
}

      }
    
    
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CabiNet - Appointment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="asset/images/favicon.ico">

    <!-- third party css -->
    <link href="asset/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css">
    <link href="asset/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css">
    <!-- third party css end -->

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
        <?php include("includes/sideBar.php"); ?>
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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Appointment</a></li>
                                        <li class="breadcrumb-item active">All</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Appointments</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <?php if($msg!=''){ ?>
                                        <div class="alert <?php echo $sql ? 'alert-success' : 'alert-danger'; ?>"
                                            role="alert">
                                            <i class="dripicons-<?php echo $sql ? 'checkmark' : 'cross'; ?> me-2"></i>
                                            <?php echo $msg; ?>
                                        </div>
                                        <?php }?>

                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                            id="products-datatable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20px;">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="customCheck1">
                                                            <label class="form-check-label"
                                                                for="customCheck1">&nbsp;</label>
                                                        </div>
                                                    </th>
                                                    <th>Patient</th>
                                                    <th>Phone</th>
                                                    <th>Appointment Date</th>
                                                    <th>Apply Date</th>
                                                    <th>Status</th>
                                                    <th style="width: 75px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $sql = mysqli_query($con, "SELECT tblappointment.*,tblappointment.id as id,tblpatient.Name as name, tblpatient.Email, tblpatient.MobileNumber FROM tblappointment INNER JOIN tblpatient ON tblappointment.patientID = tblpatient.patientID where Status='Approved' AND AppointmentDate='$selectedDate'");

                                                while($row=mysqli_fetch_assoc($sql)){ 
                                                ?>
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="customCheck2">
                                                            <label class="form-check-label"
                                                                for="customCheck2">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td class="table-user">
                                                        <img src="asset/images/users/avatar-4.jpg" alt="table-user"
                                                            class="me-2 rounded-circle">
                                                        <a href="javascript:void(0);"
                                                            class="text-body fw-semibold"><?php echo $row['name'] ?></a>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['MobileNumber'] ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $row['AppointmentDate'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['ApplyDate'] ?>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge <?php echo $row['Status'] == 'Approved' ? 'badge-success-lighten' : ($row['Status'] == 'Cancelled' ? 'badge-danger-lighten' : 'badge-warning-lighten');?>">
                                                            <?php echo $row['Status'] == 'Approved' ? 'Approved' : ($row['Status'] == 'Cancelled' ? 'Cancelled' : 'Pending');?>
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <a href="edit-app.php?id=<?php echo $row['ID'] ?>"
                                                            class="action-icon"> <i
                                                                class="mdi mdi-square-edit-outline"></i></a>
                                                        <a class="action-icon"
                                                            onclick="confirmDelete(<?php echo $row['ID']; ?>)"> <i
                                                                class="mdi mdi-delete"></i></a>
                                                    </td>

                                                </tr>
                                                <?php }?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

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

    <!-- third party js -->
    <script src="asset/js/vendor/jquery.dataTables.min.js"></script>
    <script src="asset/js/vendor/dataTables.bootstrap5.js"></script>
    <script src="asset/js/vendor/dataTables.responsive.min.js"></script>
    <script src="asset/js/vendor/responsive.bootstrap5.min.js"></script>
    <script src="asset/js/vendor/dataTables.checkboxes.min.js"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script src="asset/js/pages/demo.customers.js"></script>
    <!-- end demo js-->
    <script>
    function confirmDelete(userId) {
        if (confirm('Are you sure to delete this user?')) {
            // If the user confirms, redirect to the delete action with the user ID
            window.location.href = 'today-app.php?id=' + userId + '&del=delete';
        }
    }
    </script>
</body>
</html>

<?php }?>