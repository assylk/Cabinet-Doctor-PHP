<?php
session_start();
error_reporting(0);
include('includes/db.php');
if (strlen($_SESSION['damsid']==0)) {
  header('location:index.php');
  } else{
    

    // Code for Deletion
if(isset($_GET['del']))
{
mysqli_query($con,"delete from tblpatient where id = '".$_GET['id']."'");
$msg="Patient deleted!";
}







?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CabiNet - Patients</title>
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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Patients</a></li>
                                        <li class="breadcrumb-item active">See All</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Patients</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <a href="add-patient.php" class="btn btn-danger mb-2"><i
                                                    class="mdi mdi-plus-circle me-2"></i> Add Patient</a>

                                        </div>

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
                                                    <th>Patient Name</th>
                                                    <th>Phone</th>
                                                    <th>CIN</th>
                                                    <th>CNSS</th>
                                                    <th>Date de Naiss</th>
                                                    <th>Date de Naiss</th>
                                                    <th style="width: 75px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $result=mysqli_query($con,"SELECT * FROM tblpatient");
                                                while($row=mysqli_fetch_assoc($result)){?>
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
                                                        <img src="images/patientImg/patient.png" alt="table-user"
                                                            class="me-2 rounded-circle">
                                                        <a href="javascript:void(0);"
                                                            class="text-body fw-semibold"><?php echo $row['Name'] ?></a>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['MobileNumber'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['CIN'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['CNSS'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['dob'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['dob'] ?>
                                                    </td>


                                                    <td>
                                                        <a href="editPatient.php?id=<?php echo $row['patientID']; ?>"
                                                            class="action-icon"> <i
                                                                class="mdi mdi-square-edit-outline"></i></a>



                                                        <a class="action-icon"
                                                            onclick="confirmDelete(<?php echo $row['id']; ?>)">
                                                            <i class="mdi mdi-delete"></i></a>
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

            <!-- Signup modal-->



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
    <script>
    function confirmDelete(userId) {
        if (confirm('Are you sure to delete this user?')) {
            // If the user confirms, redirect to the delete action with the user ID
            window.location.href = 'all-patients.php?id=' + userId + '&del=delete';
        }
    }
    </script>
    <!-- demo app -->
    <script src="asset/js/pages/demo.customers.js"></script>
    <!-- end demo js-->

</body>
</html>
<?php }?>