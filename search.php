<?php
session_start();
error_reporting(0);
include('includes/db.php');
if (strlen($_SESSION['damsid']==0)) {
  header('location:logout.php');
  } 
        // Code for Deletion
if(isset($_GET['del']))
{
$sql=mysqli_query($con,"delete from tblappointment where ID = '".$_GET['id']."'");
if($sql){
    $msg="Appointment deleted !";
}

      }

  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CabiNet - Search</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="asset/images/favicon.ico">

    <!-- App css -->
    <link href="asset/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="asset/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="asset/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style">

</head>
<style>
.search {
    display: flex;
    align-items: center;
    justify-content: space-between;
    text-align: center;
}

.search__input {
    font-family: inherit;
    font-size: inherit;
    background-color: #f4f2f2;
    border: none;
    color: #646464;
    padding: 0.7rem 1rem;
    border-radius: 30px;
    width: 30em;
    transition: all ease-in-out .5s;
    margin-right: -2rem;
}

.search__input:hover,
.search__input:focus {
    box-shadow: 0 0 1em #00000013;
}

.search__input:focus {
    outline: none;
    background-color: #f0eeee;
}

.search__input::-webkit-input-placeholder {
    font-weight: 100;
    color: #ccc;
}

.search__input:focus+.search__button {
    background-color: #f0eeee;
}

.search__button {
    border: none;
    background-color: #f4f2f2;
    margin-top: .1em;
}

.search__button:hover {
    cursor: pointer;
}

.search__icon {
    height: 1.3em;
    width: 1.3em;
    fill: #b4b4b4;
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
                                        <li class="breadcrumb-item active">Search</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Patient</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-4">

                            <form method="post">
                                <div class="form-group mb-3">
                                    <label>Search by Pattient Name/CIN</label>

                                    <div class="search mt-3 ">
                                        <input id="searchdata" type="text" name="searchdata" required="true"
                                            class="search__input" placeholder="Type your text">
                                        <button class="search__button" name="search" id="submit" type="submit">
                                            <svg class="search__icon" aria-hidden="true" viewBox="0 0 24 24">
                                                <g>
                                                    <path
                                                        d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z">
                                                    </path>
                                                </g>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div>
                        <?php if($msg!=''){ ?>
                        <div class="alert <?php echo $sql ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                            <i class="dripicons-<?php echo $sql ? 'checkmark' : 'cross'; ?> me-2"></i>
                            <?php echo $msg; ?>
                        </div>
                        <?php }?>
                        <table class="table table-striped table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Phone</th>
                                    <th>CIN</th>
                                    <th>CNSS</th>
                                    <th>Date de Naiss</th>
                                    <th style="width: 75px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(isset($_POST['search'])){
                                $t=true;
                                $sdata=$_POST['searchdata'];
                                ?>
                                <h4 align="center">Result against "<?php echo $sdata;?>" keyword </h4>
                                <?php
                                $sql=mysqli_query($con,"SELECT * from tblpatient where CIN like '$sdata%' || Name like '$sdata%' ");
                                if(mysqli_num_rows($sql)>0){
                                    $cnt=1;
                                while($row=mysqli_fetch_assoc($sql)){
                            ?>
                                <tr>
                                    <td class="table-user">
                                        <img src="asset/images/users/avatar-2.jpg" alt="table-user"
                                            class="me-2 rounded-circle" />
                                        <?php echo $row['Name'] ?>
                                    </td>
                                    <td><?php echo $row['MobileNumber']; ?></td>
                                    <td><?php echo $row['CIN']; ?></td>
                                    <td><?php echo $row['CNSS']; ?></td>
                                    <td><?php echo $row['dob']; ?></td>

                                    <td class="table-action">
                                        <a href="editPatient.php?id=<?php echo $row['patientID']; ?>" class="
                                            action-icon"> <i class="mdi mdi-pencil"></i></a>
                                        <a class="action-icon" onclick="confirmDelete(<?php echo $row['ID']; ?>)"> <i
                                                class="mdi mdi-delete"></i></a>
                                    </td>
                                </tr>
                                <?php }$cnt++;
                            }
                            else if(mysqli_num_rows($sql)==0){?>
                                <td c colspan="6">
                                    <center>Data Not Found !</center>
                                </td>
                                <?php 
                            }
                            }else{?>
                                <tr>
                                    <td c colspan="6">
                                        <center>Data Not Found !</center>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>



                </div>
            </div><!-- .widget-body -->
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

    <script>
    function confirmDelete(userId) {
        if (confirm('Are you sure to delete this user?')) {
            // If the user confirms, redirect to the delete action with the user ID
            window.location.href = 'search.php?id=' + userId + '&del=delete';
        }
    }
    </script>
    <!-- bundle -->
    <script src="asset/js/vendor.min.js"></script>
    <script src="asset/js/app.min.js"></script>

</body>
</html>