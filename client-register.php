<?php 
	include "config.php";
	session_start();
	require "./assets/classes/Client.php";

	if(isset($_POST['submit'])){
		$client = new Client($conn, $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['password']);
		$client->register();
	}
	if(isset($_SESSION['role']) and $_SESSION['role'] == 'doctor'){
		header('location:doctor-profile-settings.php');
	}
?>

<!DOCTYPE html> 
<html lang="en">
	
	<?php include "head.php" ?>

	<body class="account-page">

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			<?php include "header.php"; ?>
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					
					<div class="row">
						<div class="col-md-8 offset-md-2">
								
							<!-- Register Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-7 col-lg-6 login-left">
										<img src="assets/img/login-banner.png" class="img-fluid" alt
									</div>
									<div class="col-md-12 col-lg-6 login-right">
										<div class="login-header">
											<h3>Patient Register <a href="doctor-register.php">Are you a Doctor?</a></h3>
										</div>
										
										<!-- Register Form -->
										<form action="client-register.php" method="post">
											<div class="form-group form-focus">
												<input type="text" class="form-control floating" name="fname">
												<label class="focus-label">First name</label>
											</div>
											<div class="form-group form-focus">
												<input type="text" class="form-control floating" name="lname">
												<label class="focus-label">Last name</label>
											</div>
											<div class="form-group form-focus">
												<input type="email" class="form-control floating" name="email">
												<label class="focus-label">Email</label>
											</div>
											<div class="form-group form-focus">
												<input type="password" class="form-control floating" name="password">
												<label class="focus-label">Create Password</label>
											</div>
											<div class="text-right">
												<a class="forgot-link" href="login.php">Already have an account?</a>
											</div>

											<div id="form_res"></div>
											
											<?php if(isset($_POST['submit'])) $client->checkForm(); ?>

											<button class="btn btn-primary btn-block btn-lg login-btn" type="submit" name="submit">Signup</button>
											<div class="login-or">
												<span class="or-line"></span>
												<span class="span-or">or</span>
											</div>
											<div class="row form-row social-login">
												<div class="col-6">
													<a href="#" class="btn btn-facebook btn-block"><i class="fab fa-facebook-f mr-1"></i> Login</a>
												</div>
												<div class="col-6">
													<a href="#" class="btn btn-google btn-block"><i class="fab fa-google mr-1"></i> Login</a>
												</div>
											</div>
										</form>
										
										<!-- /Register Form -->
										
									</div>
								</div>
							</div>
							<!-- /Register Content -->
								
						</div>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->
   
			<?php include "footer.php"; ?>
		   
		</div>
		<!-- /Main Wrapper -->
	  
		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		<script src="assets/js/formValidate.js"></script>
	</body>


</html>