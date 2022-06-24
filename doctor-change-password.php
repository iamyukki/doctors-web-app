<?php 
	include 'config.php';
	session_start();	

	require './assets/classes/Doctor.php';

	if(isset($_POST['sub'])){
		$doctor = new Doctor($conn,$_SESSION['first_name'],$_SESSION['last_name'],$_SESSION['email'],$_SESSION['password']);

		$doctor->updatePassword($_POST['old'],$_POST['new'],$_POST['confirm']);
	}
?>
<!DOCTYPE html> 
<html lang="en">
	
<?php include 'head.php'; ?>
	<body>

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			<?php include 'header.php' ?>
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Change Password</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Change Password</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
						
							<?php include 'doctor-sidebar.php' ?>
							
						</div>
						<div class="col-md-7 col-lg-8 col-xl-9">
							<div class="card">
								<div class="card-body">
									<?php if(isset($_POST['sub'])) $doctor->checkForm(); ?>
									<div class="row">
										<div class="col-md-12 col-lg-6">
											<!-- Change Password Form -->
											<form action="doctor-change-password.php" method="post">
												<div class="form-group">
													<label>Old Password</label>
													<input type="password" class="form-control" name="old">
												</div>
												<div class="form-group">
													<label>New Password</label>
													<input type="password" class="form-control" name="new">
												</div>
												<div class="form-group">
													<label>Confirm Password</label>
													<input type="password" class="form-control" name="confirm">
												</div>
												<div class="submit-section">
													<button type="submit" class="btn btn-primary submit-btn" name="sub">Save Changes</button>
												</div>
											</form>
											<!-- /Change Password Form -->
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>		
			<!-- /Page Content -->
   
			<?php include 'footer.php' ?>
		   
		</div>
		<!-- /Main Wrapper -->
	  
		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
	</body>

<!-- doccure/doctor-change-password.html  30 Nov 2019 04:12:36 GMT -->
</html>