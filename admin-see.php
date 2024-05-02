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
mysqli_query($con,"delete from tbldoctor where ID = '".$_GET['id']."'");
$msg="User deleted!";
$sql=true;
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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                                        <li class="breadcrumb-item active">See All</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Users</h4>
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
                                            <a href="add-user.php" class="btn btn-danger mb-2"><i
                                                    class="mdi mdi-plus-circle me-2"></i> Add Doctor</a>

                                        </div>

                                    </div>

                                    <?php if($msg!=''){ ?>
                                    <div class="alert <?php echo $sql ? 'alert-success' : 'alert-danger'; ?>"
                                        role="alert">
                                        <i class="dripicons-<?php echo $sql ? 'checkmark' : 'cross'; ?> me-2"></i>
                                        <?php echo $msg; ?>
                                    </div>
                                    <?php }?>
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
                                                    <th>Doctor Name</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Role</th>

                                                    <th style="width: 75px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $result=mysqli_query($con,"SELECT * FROM tbldoctor where Role!='admin'");
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
                                                        <?php if($row['Role']=="secretaire"){?>
                                                        <img src="images/sec.png" alt="table-user"
                                                            class="me-2 rounded-circle">
                                                        <?php }else if($row['Role']=="doctor"){?>
                                                        <img src="images/doctor.png" alt="table-user"
                                                            class="me-2 rounded-circle">
                                                        <?php }?>

                                                        <a href="javascript:void(0);"
                                                            class="text-body fw-semibold"><?php echo $row['FullName'] ?></a>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['MobileNumber'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['Email'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['Role'] ?>
                                                    </td>



                                                    <td>
                                                        <a href="edit-user.php?id=<?php echo $row['ID']; ?>"
                                                            class="action-icon"> <i
                                                                class="mdi mdi-square-edit-outline"></i></a>



                                                        <a class="action-icon" data-bs-toggle="modal"
                                                            data-bs-target="#danger-header-modal"> <i
                                                                class="mdi mdi-delete"
                                                                onclick="confirmDelete(<?= $row['ID'] ?>)"></i></a>
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
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <a href="all-patients.php?id=<?php echo $row['patientID']?>&del=delete"
                                        class="btn btn-danger">Delete</a>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

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
    <script>
    function confirmDelete(userId) {
        if (confirm('Are you sure to delete this user?')) {
            // If the user confirms, redirect to the delete action with the user ID
            window.location.href = 'admin-see.php?id=' + userId + '&del=delete';
        }
    }
    </script>
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

</body>
</html>
<?php }?>