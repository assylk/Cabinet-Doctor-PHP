<?php  

session_start();
error_reporting(0);
include('dbconnection.php');

?>

<div class="leftside-menu">

    <!-- LOGO -->
    <a href="dashboard.php" class="logo text-center logo-light mt-2">
        <span class="logo-lg">
            <img src="images/logo.png" width="260" alt="">
        </span>
        <span class="logo-sm">
            <img src="images/logo.png" width="260" alt="">

        </span>
    </a>

    <!-- LOGO -->
    <a href="dashboard.php" class="logo text-center logo-dark mt-2">
        <span class="logo-lg">
            <img src="images/logo.png" width="260" alt="">
        </span>
        <span class="logo-sm">
            <img src="images/logo.png" width="260" alt="">
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar="">

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title side-nav-item">Navigation</li>
            <li class="side-nav-item">
                <a href="dashboard.php" class="side-nav-link">
                    <i class="uil-home-alt"></i>


                    <span> Dashboards </span>
                </a>
            </li>

            <?php if($_SESSION["type"]!="Admin"){ ?>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarDashboards" aria-expanded="false"
                    aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class="uil-medkit"></i>

                    <span class="badge bg-success float-end">5</span>
                    <span> Appointments </span>
                </a>
                <div class="collapse" id="sidebarDashboards">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="search-app.php">Search</a>
                        </li>
                        <li>
                            <a href="today-app.php">Today's</a>
                        </li>
                        <li>
                            <a href="approved-app.php">Approved</a>
                        </li>

                        <li>
                            <a href="cancelled-app.php">Cancelled</a>
                        </li>
                        <li>
                            <a href="notseen-app.php">Not Seen</a>
                        </li>
                        <li>
                            <a href="all-app.php">All</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPatients" aria-expanded="false"
                    aria-controls="sidebarPatients" class="side-nav-link">
                    <i class="uil-ambulance"></i>

                    <span class="badge bg-success float-end">3</span>
                    <span> Patients </span>
                </a>
                <div class="collapse" id="sidebarPatients">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="add-patient.php">Add</a>
                        </li>
                        <li>
                            <a href="search.php">Search</a>
                        </li>
                        <li>
                            <a href="all-patients.php">See</a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a href="salle.php" class="side-nav-link">
                    <i class="uil-wheelchair"></i>

                    <span> Salle d'Attente </span>
                </a>
            </li>
            <?php }else if($_SESSION["type"]=="Admin"){?>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPatients" aria-expanded="false"
                    aria-controls="sidebarPatients" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span class="badge bg-success float-end">2</span>
                    <span> Manage Users </span>
                </a>
                <div class="collapse" id="sidebarPatients">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="add-patient.php">Add</a>
                        </li>

                        <li>
                            <a href="admin-see.php">See</a>
                        </li>

                    </ul>
                </div>
            </li>

            <?php  }if($_SESSION['type'] =='Doctor'){?>
            <li class="side-nav-title side-nav-item">Apps</li>


            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPatientsREC" aria-expanded="false"
                    aria-controls="sidebarPatientsREC" class="side-nav-link">
                    <i class="uil-parcel"></i>

                    <span class="badge bg-success float-end">2</span>
                    <span> Patient Record </span>
                </a>
                <div class="collapse" id="sidebarPatientsREC">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="add-record.php">Add Record</a>
                        </li>
                        <li>
                            <a href="pat-rec.php">See Records</a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPatientsMed" aria-expanded="false"
                    aria-controls="sidebarPatientsMed" class="side-nav-link">
                    <i class="uil-prescription-bottle"></i>

                    <span class="badge bg-success float-end">2</span>
                    <span> Medical Prescription </span>
                </a>
                <div class="collapse" id="sidebarPatientsMed">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="add-ordonnance.php">Add Prescription</a>
                        </li>
                        <li>
                            <a href="all-ordonnance.php">See Prescription</a>
                        </li>

                    </ul>
                </div>
            </li>
            <?php }?>





        </ul>


        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->