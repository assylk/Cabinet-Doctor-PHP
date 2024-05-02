<?php
session_start();
error_reporting(0);
include('includes/db.php');
include('includes/dbconnection.php');
if (strlen($_SESSION['damsid']==0)) {
  header('location:logout.php');
  } else{


// Get the first day of the current month
$firstDayOfCurrentMonth = date('Y-m-01');
// Get the current year
$currentYear = date('Y');
// Get the first day of the previous month
$firstDayOfLastMonth = date('Y-m-01', strtotime('-1 month'));
$eid=$_SESSION['damsid'];

$sql=mysqli_query($con,"SELECT * from tbldoctor where ID='$eid'" );
if($sql){
    while($row=mysqli_fetch_assoc($sql)){
        $role=$row['Role']=="doctor"?"Doctor":"Secretaire";
        $email=$row['Email'];   
        $fname=$row['FullName']; 
        $image=$row['image']; 
    }
}





$result=mysqli_query($con,"select tblpatient.patientID as patientID,tblpatient.ID as id,tblpatient.Name as name,tblpatient.CIN as CIN,tblappointment.AppointmentDate as AppointmentDate,tblappointment.AppointmentDate from tblappointment inner join tblpatient on tblappointment.patientID=tblpatient.patientID");
$data = array();


//Get Doctor total Approved Appointments and calculate salary
$docQuery=mysqli_query($con,"select * from tblappointment where Doctor='".$_SESSION['damsfullname']."' and Status='Approved'");
if($docQuery){
    $totapp=mysqli_num_rows($docQuery);
}


// Get the number of appointments for this month
$sqlThisMonth = mysqli_query($con, "SELECT * FROM tblappointment WHERE MONTH(AppointmentDate) = MONTH(NOW()) AND YEAR(AppointmentDate) = YEAR(NOW())");
$countAppThisMonth = mysqli_num_rows($sqlThisMonth);
// Get the number of appointments for last month
$firstDayOfLastMonth = date('Y-m-01', strtotime('first day of last month'));
$lastDayOfLastMonth = date('Y-m-t', strtotime('last day of last month'));
$sqlLastMonth = mysqli_query($con, "SELECT * FROM tblappointment WHERE AppointmentDate BETWEEN '$firstDayOfLastMonth' AND '$lastDayOfLastMonth'");
$countAppLastMonth = mysqli_num_rows($sqlLastMonth);
// Calculate the percentage growth
if ($countAppLastMonth > 0) {
    $percentageGrowth = (($countAppThisMonth - $countAppLastMonth) / $countAppLastMonth) * 100;
} else {
    // Avoid division by zero error if last month had no appointments
    $percentageGrowth = 100; // Set a default value to indicate infinite growth
}




// SQL query to get the number of appointments for this year
$sqlThisYear = mysqli_query($con, "SELECT * FROM tblappointment WHERE YEAR(AppointmentDate) = $currentYear");
$countAppThisYear = mysqli_num_rows($sqlThisYear);
// SQL query to get the number of appointments for last year
$lastYear = $currentYear - 1;
$sqlLastYear = mysqli_query($con, "SELECT * FROM tblappointment WHERE YEAR(AppointmentDate) = $lastYear");
$countAppLastYear = mysqli_num_rows($sqlLastYear);
// Calculate the percentage growth
if ($countAppLastYear > 0) {
    $percentageGrowthYear = (($countAppThisYear - $countAppLastYear) / $countAppLastYear) * 100;
} else {
    // Avoid division by zero error if last year had no appointments
    $percentageGrowthYear = 100; // Set a default value to indicate infinite growth
}




//GET DATA FROM DB
$sql1=mysqli_query($con,"SELECT * from tblappointment");
$countTotalApp=mysqli_num_rows($sql1);

$sql1=mysqli_query($con,"SELECT * from tblappointment where Status='Approved'");
$countApprovedApp=mysqli_num_rows($sql1);

$sql1=mysqli_query($con,"SELECT * from tblappointment where Status='Cancelled'");
$countCancelledApp=mysqli_num_rows($sql1);

$sql1=mysqli_query($con,"SELECT * from tblappointment where Status is Null");
$countNotYetApp=mysqli_num_rows($sql1);






// Calculate number of approved appointments for each month
$approvedAppointmentsPerMonth = array();
for ($month = 1; $month <= 12; $month++) {
    $sql = mysqli_query($con,"SELECT COUNT(*) AS count FROM tblappointment WHERE MONTH(AppointmentDate) = $month AND Status = 'Approved'");
    
    while($row=mysqli_fetch_assoc($sql)){
        $monthName = date("F", mktime(0, 0, 0, $month, 1));
    $approvedAppointmentsPerMonth[$monthName] = $row['count'];
    }
    
}

// Convert data to JSON format
$data_jsonn = json_encode($approvedAppointmentsPerMonth);

if(mysqli_num_rows($result)!=0){
    //Math  for percentage of Approved Appointement
$percentageApproved=((float)$countApprovedApp/(float)$countTotalApp)*100;
//Math  for percentage of Cancelled Appointements
$percentageCancelled=(float)$countCancelledApp/(float)$countTotalApp*100;
//Math  to get the total number of Patients who have not yet made an appointment
$totalPatientWithNoApp=(float)$countNotYetApp/(float)$countTotalApp*100;
// Calculate number of appointments for each month



// Organize data into an associative array
$data = array(
    'Approved' => $percentageApproved,
    'Cancelled' => $percentageCancelled,
    'Not Yet' => $totalPatientWithNoApp
);

// Convert data to JSON format
$data_json = json_encode($data);

}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CabiNet - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="asset/images/favicon.ico">

    <!-- third party css -->
    <link href="asset/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
    <!-- third party css end -->

    <!-- App css -->
    <link href="asset/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="asset/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="asset/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style">

</head>

<body class="loading"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": false}'>
    <!-- Begin page -->
    <div class="wrapper">
        <?php include("includes/sideBar.php"); ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <?php include("includes/topBar.php"); ?>
                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <form class="d-flex">
                                        <div class="input-group">
                                            <input type="text" disabled class="form-control form-control-light"
                                                id="dash-daterange">
                                            <span class="input-group-text bg-primary border-primary text-white">
                                                <i class="mdi mdi-calendar-range font-13"></i>
                                            </span>
                                        </div>

                                        </a>
                                    </form>
                                </div>
                                <h4 class="page-title">Dashboard</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xl-5 col-lg-6">

                            <div class="row">


                                <div class="col-lg-4 col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <span class="float-start m-2 me-4">
                                                <?php if($image!=''){ ?>
                                                <img src="<?php echo $image ?>"
                                                    style="height: 100px;width:100px;object-fit:cover" alt=""
                                                    class="rounded-circle img-thumbnail">

                                                <?php }else if($image=='' && $_SESSION['type']=='Doctor') {?>
                                                <img src="images/doctor.png"
                                                    style="height: 100px;width:100px;object-fit:cover" alt=""
                                                    class="rounded-circle img-thumbnail">
                                                <?php }else if($image=='' && $_SESSION['type']=='Secretaire'){?>
                                                <img src="images/sec.png"
                                                    style="height: 100px;width:100px;object-fit:cover" alt=""
                                                    class="rounded-circle img-thumbnail">
                                                <?php }?>
                                            </span>
                                            <div class="">
                                                <h4 class="mt-1 mb-1"><?php echo $_SESSION['damsfullname']; ?></h4>
                                                <p class="font-13"> Job : <?php echo $_SESSION['type']; ?></p>
                                                <?php if($_SESSION['type']=='Doctor'){ ?>
                                                <ul class="mb-0 list-inline">
                                                    <li class="list-inline-item me-3">
                                                        <h5 class="mb-1"><?php echo $totapp*30 ?> DT</h5>
                                                        <p class="mb-0 font-13">Total Revenue</p>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <h5 class="mb-1"><?php echo $totapp; ?></h5>
                                                        <p class="mb-0 font-13">Number of Orders</p>
                                                    </li>
                                                </ul>
                                                <?php }?>
                                            </div>
                                            <!-- end div-->
                                        </div>
                                        <!-- end card-body-->
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-currency-usd widget-icon"></i>
                                            </div>
                                            <h5 class="text-muted fw-normal mt-0" title="Growth
                                                This Month">Growth
                                                This Month</h5>
                                            <h3 class="mt-3 mb-3"><?php echo $countAppThisMonth; ?></h3>
                                            <p class="mb-0 text-muted">
                                                <span
                                                    class="<?php  echo ($percentageGrowth < 0) ? 'text-danger' : 'text-success'; ?> me-2"><i
                                                        class="mdi <?php echo ($percentageGrowth < 0) ? 'mdi-arrow-down-bold' : 'mdi-arrow-up-bold'; ?>"></i>
                                                    <?php echo $percentageGrowth ?>%</span>
                                                <span class="text-nowrap">Since last month</span>
                                            </p>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->

                                <div class="col-lg-6">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-pulse widget-icon"></i>
                                            </div>
                                            <h5 class="text-muted fw-normal mt-0" title="Growth
                                                This Year">Growth
                                                This Year</h5>
                                            <h3 class="mt-3 mb-3"><?php echo $countAppThisYear ?></h3>
                                            <p class="mb-0 text-muted">
                                                <span
                                                    class="<?php  echo ($percentageGrowthYear < 0) ? 'text-danger' : 'text-success'; ?> me-2"><i
                                                        class="mdi <?php echo ($percentageGrowth < 0) ? 'mdi-arrow-down-bold' : 'mdi-arrow-up-bold'; ?>"></i>
                                                    <?php echo $percentageGrowthYear ?>%</span>
                                                <span class="text-nowrap">Since last year</span>
                                            </p>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->
                            </div> <!-- end row -->

                        </div> <!-- end col -->

                        <div class="col-xl-7 col-lg-6">
                            <div class="card card-h-100">
                                <div class="card-body">

                                    <h4 class="header-title mb-3">Projections Vs Actuals</h4>

                                    <div style="width: 80%;">
                                        <canvas id="myColumnChart"></canvas>
                                    </div>

                                </div> <!-- end card-body-->
                            </div> <!-- end card-->

                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->




                    <div class="row">
                        <div class="col-xl-6 col-lg-12 order-lg-2 order-xl-1">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="header-title mt-2 mb-3">Last Approved Patient</h4>

                                    <div class="table-responsive">
                                        <table class="table table-centered table-nowrap table-hover mb-0">
                                            <tbody>
                                                <?php 
    if(mysqli_num_rows($result) == 0) {
        // Display a paragraph if the courses table is null
        ?>
                                                <tr>
                                                    <td colspan=2>No Data Found</td>
                                                </tr>
                                                <?php
                                            } else {
                                                // Iterate through the results if there are rows in the table
                                                while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                <tr>
                                                    <td>
                                                        <h5 class="font-14 my-1 fw-normal">
                                                            <?php echo $row['name'] ?>
                                                        </h5>
                                                        <span class="text-muted font-13">Patient</span>
                                                    </td>
                                                    <td>
                                                        <h5 class="font-14 my-1 fw-normal">
                                                            <?php echo $row['CIN'] ?>
                                                        </h5>
                                                        <span class="text-muted font-13">CIN</span>
                                                    </td>

                                                    <td>
                                                        <h5 class="font-14 my-1 fw-normal">
                                                            <?php echo $row['AppointmentDate']; ?>
                                                        </h5>
                                                        <span class="text-muted font-13">Date</span>
                                                    </td>
                                                    <td>
                                                        <a href="editPatient.php?id=<?php echo $row['patientID'];?>">
                                                            <button type="button"
                                                                class="btn btn-info btn-rounded my-1 fw-normal">View</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php }}?>


                                            </tbody>
                                        </table>
                                    </div> <!-- end table-responsive-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-xl-3 col-lg-6 order-lg-1">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="header-title">Appointments</h4>

                                    <div class="mb-4">
                                        <canvas id="myPieChart"></canvas>
                                    </div>

                                    <div class="chart-widget-list">
                                        <p>
                                            <i class="mdi mdi-square text-primary"></i> Approved Appointment
                                            <span class="float-end"><?php echo $countApprovedApp ?></span>
                                        </p>
                                        <p>
                                            <i class="mdi mdi-square text-danger"></i> Cancelled Appointment
                                            <span class="float-end"><?php echo $countCancelledApp ?></span>
                                        </p>

                                        <p class="mb-0">
                                            <i class="mdi mdi-square text-warning"></i> Not Yet Approved
                                            <span class="float-end"><?php echo $countNotYetApp ?></span>
                                        </p>
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-xl-3 col-lg-6 order-lg-1">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="header-title mb-2">Recent Activity</h4>

                                    <div data-simplebar="" style="max-height: 419px;">
                                        <div class="timeline-alt pb-0">
                                            <?php $sql=mysqli_query($con,"select * from tblappointment where Name is not NULL order by ApplyDate LIMIT 5");
                                            while($row=mysqli_fetch_assoc($sql)){
                                                 // Calculate time ago
                                                $appointmentTime = strtotime($row['ApplyDate']);
                                                $currentTime = time();
                                                $timeDiff = $currentTime - $appointmentTime;
                                                
                                                // Format time ago based on logic
                                                if ($timeDiff < 60) {
                                                    // Less than a minute ago
                                                    $timeAgo = "Now";
                                                } elseif ($timeDiff < 3600) {
                                                    // Less than an hour ago
                                                    $minutes = round($timeDiff / 60);
                                                    $timeAgo = "$minutes minutes ago";
                                                } else {
                                                    // More than an hour ago
                                                    $hours = round($timeDiff / 3600);
                                                    $timeAgo = "$hours hours ago";
                                                }


                                            ?>
                                            <div class="timeline-item">
                                                <i class="uil-plus  bg-info-lighten text-info timeline-icon"></i>
                                                <div class="timeline-item-info">
                                                    <a href="#" class="text-info fw-bold mb-1 d-block">New
                                                        Appointment</a>
                                                    <small><?php echo $row['Name'] ?> just purchased an
                                                        Appointment!</small>
                                                    <p class="mb-0 pb-2">
                                                        <small class="text-muted"><?php echo $timeAgo ?></small>
                                                    </p>
                                                </div>
                                            </div>
                                            <?php }?>


                                        </div>
                                        <!-- end timeline -->
                                    </div> <!-- end slimscroll -->
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col -->

                    </div>
                    <!-- end row -->

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

    <!-- bundle -->
    <script src="asset/js/vendor.min.js"></script>
    <script src="asset/js/app.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- third party js -->
    <script src="asset/js/vendor/apexcharts.min.js"></script>
    <script src="asset/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="asset/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
    <!-- third party js ends -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <!-- demo app -->
    <script src="asset/js/pages/demo.dashboard.js"></script>
    <!-- end demo js-->
    <script>
    // Parse data from PHP to JavaScript
    var data = <?php echo $data_json; ?>;

    // Get labels and data for the chart
    var labels = Object.keys(data);
    var values = Object.values(data);

    // Create a new pie chart
    var ctx = document.getElementById('myPieChart').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: [
                    'RGB(112, 122, 244)',
                    'RGB(235, 92, 143)',
                    'RGB(254, 188, 0)'
                ],
                borderColor: [
                    'RGB(112, 122, 244)',
                    'RGB(235, 92, 143)',
                    'RGB(254, 188, 0)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
    </script>
    <script>
    // Parse data from PHP to JavaScript
    var data = <?php echo $data_jsonn; ?>;

    // Get labels and data for the chart
    var labels = Object.keys(data);
    var values = Object.values(data);

    // Create a new column chart
    var ctx = document.getElementById('myColumnChart').getContext('2d');
    var myColumnChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Appointments per Month',
                data: values,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
</body>
</html>
<?php }?>