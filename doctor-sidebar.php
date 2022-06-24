<?php 
    include_once 'config.php';
	include_once './assets/functions/getDoctorInfo.php';
	$row = getDoctorInfo($conn);
?>

<!-- Profile Sidebar -->
<div class="profile-sidebar">
    <div class="widget-profile pro-widget-content">
        <div class="profile-info-widget">
            <a href="#" class="booking-doc-img">
                <img src="assets/img/doctors/<?= $row['profile_pic'] ?>" alt="User Image">
            </a>
            <div class="profile-det-info">
                <h3>Dr. <?= $row['first_name'] ." ". $row['last_name'] ?></h3>
                
                <div class="patient-details">
                    <h5 class="mb-0">BDS, MDS - Oral & Maxillofacial Surgery</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-widget">
        <nav class="dashboard-menu">
            <ul>
                <li <?= (basename($_SERVER['PHP_SELF']) == "doctor-dashboard.php" ) ? 'class="active"' : '' ?> >
                    <a href="doctor-dashboard.php">
                        <i class="fas fa-columns"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li <?= (basename($_SERVER['PHP_SELF']) == "my-patients.html" ) ? 'class="active"' : '' ?> >
                    <a href="my-patients.php">
                        <i class="fas fa-user-injured"></i>
                        <span>My Patients</span>
                    </a>
                </li>
                <li <?= (basename($_SERVER['PHP_SELF']) == "invoices.html" ) ? 'class="active"' : '' ?>>
                    <a href="invoices.php">
                        <i class="fas fa-file-invoice"></i>
                        <span>Invoices</span>
                    </a>
                </li>
                <li <?= (basename($_SERVER['PHP_SELF']) == "reviews.html" ) ? 'class="active"' : '' ?>>
                    <a href="reviews.php">
                        <i class="fas fa-star"></i>
                        <span>Reviews</span>
                    </a>
                </li>
                <li <?= (basename($_SERVER['PHP_SELF']) == "doctor-profile-settings.php" ) ? 'class="active"' : '' ?>>
                    <a href="doctor-profile-settings.php">
                        <i class="fas fa-user-cog"></i>
                        <span>Profile Settings</span>
                    </a>
                </li>
                <li <?= (basename($_SERVER['PHP_SELF']) == "doctor-change-password.php" ) ? 'class="active"' : '' ?>>
                    <a href="doctor-change-password.php">
                        <i class="fas fa-lock"></i>
                        <span>Change Password</span>
                    </a>
                </li>
                <li>
                    <a href="?desc">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /Profile Sidebar -->