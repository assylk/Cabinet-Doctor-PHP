<?php
session_start();
error_reporting(0);
include('includes/db.php');
date_default_timezone_set('Africa/Tunis');

?>


<!-- Topbar Start -->
<div class="navbar-custom">
    <ul class="list-unstyled topbar-menu float-end mb-0">


        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                aria-haspopup="false" aria-expanded="false">
                <i class="dripicons-bell noti-icon"></i>

            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">

                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5 class="m-0">
                        <span class="float-end">
                            <a href="javascript: void(0);" class="text-dark">
                                <!--<small>Clear All</small>-->
                            </a>
                        </span>Notifications
                    </h5>
                </div>

                <div style="max-height: 230px;" data-simplebar="">

                    <?php $sql=mysqli_query($con,"SELECT *
          FROM tblappointment
          WHERE DATE(ApplyDate) >= CURDATE() - INTERVAL 1 DAY
          AND DATE(ApplyDate) <= CURDATE() + INTERVAL 1 DAY AND Name is not Null");
          if(mysqli_num_rows($sql)>0){
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
                    <a href="notseen-app.php" class="dropdown-item notify-item">
                        <div class="notify-icon bg-info">
                            <i class="uil-user-plus"></i>
                        </div>
                        <p class="notify-details">New Appointment Added .
                            <small class="text-muted"><?php echo $timeAgo ?></small>
                        </p>
                    </a>
                    <?php }}else{?>

                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        No New Appointments Today!
                    </a>
                    <?php }?>

                    <!-- item
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-info">
                            <i class="mdi mdi-account-plus"></i>
                        </div>
                        <p class="notify-details">New user registered.
                            <small class="text-muted">5 hours ago</small>
                        </p>
                    </a>-->

                    <!-- item
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon">
                            <img src="asset/images/users/avatar-2.jpg" class="img-fluid rounded-circle" alt="">
                        </div>
                        <p class="notify-details">Cristina Pride</p>
                        <p class="text-muted mb-0 user-msg">
                            <small>Hi, How are you? What about our next meeting</small>
                        </p>
                    </a>-->




                </div>

                <!-- All-->
                <a href="all-app.php" class="dropdown-item text-center text-primary notify-item notify-all">
                    View All
                </a>

            </div>
        </li>



        <li class="notification-list">
            <a class="nav-link end-bar-toggle" href="javascript: void(0);">
                <i class="dripicons-gear noti-icon"></i>

            </a>
        </li>

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#"
                role="button" aria-haspopup="false" aria-expanded="false">
                <span class="account-user-avatar">

                    <img src="<?php echo $_SESSION['image'] ?>" alt=" user-image" class="rounded-circle">


                </span>
                <span>
                    <span class="account-user-name"><?php echo $_SESSION['damsfullname']; ?></span>
                    <span class="account-position"><?php echo $_SESSION['type'] ?></span>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                <!-- item-->
                <div class=" dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome !</h6>
                </div>

                <!-- item-->
                <a href="profile.php" class="dropdown-item notify-item">
                    <i class="mdi mdi-account-circle me-1"></i>
                    <span>My Account</span>
                </a>



                <!-- item-->
                <a href="logout.php" class="dropdown-item notify-item">
                    <i class="mdi mdi-logout me-1"></i>
                    <span>Logout</span>
                </a>
            </div>
        </li>

    </ul>
    <button class="button-menu-mobile open-left">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-menu-2">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M4 6l16 0" />
            <path d="M4 12l16 0" />
            <path d="M4 18l16 0" />
        </svg>
    </button>

</div>
<!-- end Topbar -->