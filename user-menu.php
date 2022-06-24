<?php include_once 'config.php'; ?>

<?php if($_SESSION['role'] == 'client'){
    $sql = "SELECT * FROM clients WHERE email = '".$_SESSION['email']."' AND password = '".$_SESSION['password']."'";
    $res = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($res);
    ?>

        <!-- User Menu -->
        <li class="nav-item dropdown has-arrow logged-item">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" src="assets/img/patients/<?= $row['profile_pic']?>" width="31" alt="<?= $row['first_name'] ?>">
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                        <img src="assets/img/patients/<?= $row['profile_pic']?>" alt="User Image" class="avatar-img rounded-circle">
                    </div>
                    <div class="user-text">
                        <h6><?= $row['first_name'] ?></h6>
                        <p class="text-muted mb-0">Patient</p>
                    </div>
                </div>
                <a class="dropdown-item" href="patient-dashboard.php">Dashboard</a>
                <a class="dropdown-item" href="profile-settings.php">Profile Settings</a>
                <a class="dropdown-item" href="<?= basename($_SERVER['PHP_SELF']);?>?desc">Logout</a>
            </div>
        </li>
        <!-- /User Menu -->

<?php } else if($_SESSION['role'] == 'doctor'){
    $sql = "SELECT * FROM doctors WHERE email = '".$_SESSION['email']."' AND password = '".$_SESSION['password']."'";
    $row = mysqli_fetch_assoc(mysqli_query($conn,$sql));
    ?>
    <!-- User Menu -->
    <li class="nav-item dropdown has-arrow logged-item">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
            <span class="user-img">
                <img class="rounded-circle" src="assets/img/doctors/<?= $row['profile_pic'] ?>" width="31" alt="Darren Elder">
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <div class="user-header">
                <div class="avatar avatar-sm">
                    <img src="assets/img/doctors/<?= $row['profile_pic'] ?>" alt="User Image" class="avatar-img rounded-circle">
                </div>
                <div class="user-text">
                    <h6><?= $row['first_name'] . " " . $row['last_name'] ?></h6>
                    <p class="text-muted mb-0">Doctor</p>
                </div>
            </div>
            <a class="dropdown-item" href="doctor-dashboard.php">Dashboard</a>
            <a class="dropdown-item" href="doctor-profile-settings.php">Profile Settings</a>
            <a class="dropdown-item" href="<?= basename($_SERVER['PHP_SELF']);?>?desc">Logout</a>
        </div>
    </li>
    <!-- /User Menu -->
<?php } ?>