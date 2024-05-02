<?php 
session_start();
include("includes/db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CabiNet - Salle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
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
        <?php include("includes/sideBar.php"); ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <?php include("includes/topBar.php");?>

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
                                        <li class="breadcrumb-item active">Salle</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Salle d'Attente</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->


                    <!-- end row -->



                    <!-- end row -->

                    <div class="row">
                        <?php $sql=mysqli_query($con,"select * from tblsalle");
                        while($row=mysqli_fetch_assoc($sql)) { ?>

                        <div class="col-md-6 col-lg-2">
                            <div class="card"
                                style="border:4px solid <?php echo $row['status']=='true'?'green':'red' ?>">
                                <img src="images/sa.png" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Chair is
                                        <?php echo $row['status']=='true'?'Available':'Unavailable' ?></h5>
                                    <?php if($_SESSION['type']=='Secretaire'){ ?>
                                    <a href="edit-salle.php?editid=<?php echo $row['id'];?>&&sta=<?php echo $row['status'];?>"
                                        class="btn btn-primary mt-2 stretched-link">Sit Patient</a>
                                    <?php }?>
                                </div> <!-- end card-body -->
                            </div> <!-- end card -->
                        </div> <!-- end col-->
                        <?php }?>
                    </div>
                    <!-- end row -->



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

</body>
</html>