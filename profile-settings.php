<?php 
	include 'config.php';
	session_start();
	if(!isset($_SESSION['role'])) header('location:login.php');

	require './assets/classes/Client.php';
	require './assets/functions/getClientInfo.php';


	if(isset($_POST['sub'])){
		$client = new Client($conn,$_POST['fname'],$_POST['lname'],$_POST['email'],$_SESSION['password']);
		// $_POST['zip_code'] = (empty($_POST['zip_code'])) ? 0 : $_POST['zip_code'];

		$date =  date('Y-m-d',strtotime($_POST['birth_date']));
		$client->updateProfile( $date,
							    $_POST['blood_type'],
								$_POST['phone'],
								$_POST['adresse'],
								$_POST['city'],
								$_POST['state'],
								$_POST['zip_code'],
								$_FILES['profile'],
								$_POST['country'] );
	}
	
	$row = getClientInfo($conn);

?>

<!DOCTYPE html> 
<html lang="en">

<head>
		<meta charset="utf-8">
		<
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		
		<!-- Favicons -->
		<link href="assets/img/favicon.png" rel="icon">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
		
		<!-- Datetimepicker CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">
		
		<!-- Select2 CSS -->
		<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
		
		<!-- Main CSS -->
		<link rel="stylesheet" href="assets/css/style.css">
</head>
	<body>

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			<?php include 'header.php'; ?>
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Profile Settings</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Profile Settings</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					<div class="row">
					
						<?php include 'client-sidebar.php'; ?>
						
						<div class="col-md-7 col-lg-8 col-xl-9">
							<div class="card">
								<div class="card-body">	

									<?php if(isset($_POST['sub'])){
										$client->checkForm();
									}?>
									<!-- Profile Settings Form -->
									<form action="profile-settings.php" method="POST" enctype="multipart/form-data">
										<div class="row form-row">
											<div class="col-12 col-md-12">
												<div class="form-group">
													<div class="change-avatar">
														<div class="profile-img">
															<img src="assets/img/patients/<?= $row['profile_pic'] ?>" alt="User Image">
														</div>
														<div class="upload-img">
															<div class="change-photo-btn">
																<span><i class="fa fa-upload"></i> Upload Photo</span>
																<input type="file" class="upload" name="profile">
															</div>
															<small class="form-text text-muted">Allowed JPG, GIF or PNG. Max size of 2MB</small>
														</div>
													</div>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>First Name</label>
													<input type="text" class="form-control" name="fname" value="<?= $row['first_name'] ?>">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Last Name</label>
													<input type="text" class="form-control" name="lname" value="<?= $row['last_name'] ?>">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Date of Birth</label>
													<input type="date" class="form-control" name="birth_date" value="<?= $row['birth_date'] ?>">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Blood Group</label>
													<select class="form-control select" name="blood_type">
													<?php 
														$blood_types = ['A-','A+','B-','B+','AB-','AB+','O-','O+'];
														for ($i=0; $i < count($blood_types); $i++) { 
															if($row['blood_type'] == $blood_types[$i]){
																echo "<option value='".$row['blood_type']."'>".$row['blood_type']."</option>";	
																break;
															}
														}
														for ($i=0; $i < count($blood_types); $i++) { 
															if($row['blood_type'] != $blood_types[$i]){
																echo "<option value='$blood_types[$i]'>$blood_types[$i]</option>";	
															}
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Email ID</label>
													<input type="email" class="form-control" name="email" value="<?= $row['email'] ?>">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Phone</label>
													<input type="number" value="<?= $row['phone'] ?>" name="phone" class="form-control">
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
												<label>Address</label>
													<input type="text" class="form-control" name="adresse" value="<?= $row['adresse'] ?>">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>City</label>
													<input type="text" class="form-control" name="city" value="<?= $row['city'] ?>">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>State</label>
													<input type="text" class="form-control" name="state" value="<?= $row['state'] ?>">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Zip Code</label>
													<input type="text" class="form-control" name="zip_code" value="<?= $row['zip_code'] ?>">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Country</label>
													<input type="text" class="form-control" name="country" value="<?= $row['country'] ?>">
												</div>
											</div>
										</div>
										<div class="submit-section">
											<button type="submit" class="btn btn-primary submit-btn" name="sub">Save Changes</button>
										</div>
									</form>
									<!-- /Profile Settings Form -->
									
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>		
			<!-- /Page Content -->
   
			<?php include 'footer.php'; ?>
		   
		</div>
		<!-- /Main Wrapper -->
	  
		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Select2 JS -->
		<script src="assets/plugins/select2/js/select2.min.js"></script>
		
		<!-- Datetimepicker JS -->
		<script src="assets/js/moment.min.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
	</body>


</html>