<?php 
	include_once 'config.php';
	if(session_status() == PHP_SESSION_NONE) session_start();	
	if(!isset($_SESSION['role']) and (basename($_SERVER['PHP_SELF']) != ('login.php' or 'client-register.php' or 'doctor-register.php') )){
		header('location:login.php');
	} 

	if(basename($_SERVER['PHP_SELF']) == 'doctor-register.php' and isset($_SESSION['id'])){
		header('location:doctor-dashboard.php');
	}

	if(isset($_GET['desc'])){
		session_destroy();
		header('location:login.php');
	}
?>

<!-- Header -->
<header class="header">
				<nav class="navbar navbar-expand-lg header-nav">
					<div class="navbar-header">
						<a id="mobile_btn" href="javascript:void(0);">
							<span class="bar-icon">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</a>
						<a href="index-2.html" class="navbar-brand logo">
							<img src="assets/img/logo.png" class="img-fluid" alt="Logo">
						</a>
					</div>
					<div class="main-menu-wrapper">
						<div class="menu-header">
							<a href="index.php" class="menu-logo">
								<img src="assets/img/logo.png" class="img-fluid" alt="Logo">
							</a>
							<a id="menu_close" class="menu-close" href="javascript:void(0);">
								<i class="fas fa-times"></i>
							</a>
						</div>
						<ul class="main-nav">
							<?php 
								if(!isset($_SESSION['role']) or $_SESSION['role'] == 'client'){

									echo '<li>
											<a href="index.php">Home</a>
										</li>';
									echo '<li>
											<a href="search.php">Search</a>
										</li>';
									
								}
								if(isset($_SESSION['role'])){
									if($_SESSION['role'] == 'client'){
										echo '<li>
											<a href="patient-dashboard.php">Dashboard</a>
										</li>';
										echo '<li>
											<a href="profile-settings.php">Settings</a>
										</li>';
									}
								}
								if(!isset($_SESSION['role']) or $_SESSION['role'] == 'client'){

									echo '<li>
											<a href="index.php#footer">About</a>
										</li>';
									
								}
							?>
							
							<li class="login-link">
								<a href="login.php">Login / Signup</a>
							</li>
						</ul>	 
					</div>	
					<ul class="nav header-navbar-rht">
						<li class="nav-item contact-item">
							<div class="header-contact-img">
								<i class="far fa-hospital"></i>							
							</div>
							<div class="header-contact-detail">
								<p class="contact-header">Contact</p>
								<p class="contact-info-header">+212657178867</p>
							</div>
						</li>
						<?php if(isset($_SESSION['role'])) {
							include 'user-menu.php';
						}else{	
							echo '<li class="nav-item">
								<a class="nav-link header-login" href="login.php">login / Signup </a>
							</li>';
						} ?>
						
					</ul>
				</nav>
			</header>
			<!-- /Header -->