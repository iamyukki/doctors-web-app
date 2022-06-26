<?php 
	include 'config.php';
	session_start();
	require './assets/classes/Doctor.php';
	if(!isset($_SESSION['id'])) header('location:login.php');
	if($_SESSION['role'] != "doctor") header('location:index.php');

	include './assets/functions/getDoctorInfo.php';
	include './assets/functions/getClinicInfo.php';
	include './assets/functions/getContactDetails.php';
	include './assets/functions/getServicesAndSpecs.php';
	include './assets/functions/getEducationInfo.php';
	include './assets/functions/getExperienceInfo.php';

	if(isset($_POST['sub'])){
		$doctor = new Doctor($conn,$_POST['fname'],$_POST['lname'],$_POST['email'],$_SESSION['password']);

		$price = ($_POST['rating_option'] == 'price_free') ? 0 : $_POST['custom_rating_count'];
		$doctor->updateData($_FILES['profile'],
							$_POST['username'],
							$_POST['phone'],
							$_POST['gender'],
							$_POST['birth_date'],
							$_POST['about_me'],
							$_POST['clinic_name'],
							$_POST['clinic_adresse'],
							$_FILES['clinic'],
							$_POST['addr1'],
							$_POST['addr2'],
							$_POST['city'],
							$_POST['state'],
							$_POST['country'],
							$_POST['postal_code'],
							$price,
							$_POST['degree'],
							$_POST['college'],
							$_POST['completion_year'],
							$_POST['hospital_name'],
							$_POST['hospital_from'],
							$_POST['hospital_to'],
							$_POST['designation'],
							$_POST['cat'],
							$_POST['start_year']);
	}
	$row = getDoctorInfo($conn);
	$clinicRow = getClinicInfo($conn);
	$cdRow = getContactDetailsInfo($conn);
	$servicesRow = getServicesAnsSpecs($conn);
	$educationRow = getEducationInfo($conn);
	$expRow = getExperienceInfo($conn);
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
		
		<!-- Select2 CSS -->
		<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css">
		
		<link rel="stylesheet" href="assets/plugins/dropzone/dropzone.min.css">
		
		<!-- Main CSS -->
		<link rel="stylesheet" href="assets/css/style.css">
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	
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
						<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
						
						<?php include 'doctor-sidebar.php'; ?>
							
						</div>
						<div class="col-md-7 col-lg-8 col-xl-9">
							<?php if(isset($_POST['sub'])) $doctor->checkForm();?>
						<form action="doctor-profile-settings.php" method="POST" enctype="multipart/form-data">
								<!-- Basic Information -->
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Basic Information</h4>
										<div class="row form-row">
											<div class="col-md-12">
												<div class="form-group">
													<div class="change-avatar">
														<div class="profile-img">
															<img src="assets/img/doctors/<?= $row['profile_pic'] ?>" alt="User Image">
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
											<div class="col-md-6">
												<div class="form-group">
													<label>Username <span class="text-danger">*</span></label>
													<input type="text" class="form-control" name="username" value="<?= $row['username'] ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Email <span class="text-danger">*</span></label>
													<input type="email" class="form-control" name="email" value="<?= $row['email'] ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>First Name <span class="text-danger">*</span></label>
													<input type="text" class="form-control" name="fname" value="<?= $row['first_name'] ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Last Name <span class="text-danger">*</span></label>
													<input type="text" class="form-control" name="lname" value="<?= $row['last_name'] ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Phone Number</label>
													<input type="number" class="form-control" name="phone" value="<?= $row['phone'] ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Gender</label>
													<select class="form-control select" name="gender">
														<option value="">Select</option>
														<option value="Male" <?= ($row['gender'] == "Male") ? " selected" : "" ?> >Male</option>
														<option value="Female" <?= ($row['gender'] == "Female") ? " selected" : "" ?>>Female</option>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Categorie</label>
													<select class="form-control select" name="cat">
														<option value="">Select</option>
														<option value="Dentist" <?= ($row['categorie'] == "Dentist") ? " selected" : "" ?> >Dentist</option>
														<option value="Urology" <?= ($row['categorie'] == "Urology") ? " selected" : "" ?>>Urology</option>
														<option value="Neurology" <?= ($row['categorie'] == "Neurology") ? " selected" : "" ?>>Neurology</option>
														<option value="Orthopedic" <?= ($row['categorie'] == "Orthopedic") ? " selected" : "" ?>>Orthopedic</option>
														<option value="Cardiologist" <?= ($row['categorie'] == "Cardiologist") ? " selected" : "" ?>>Cardiologist</option>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group mb-0">
													<label>Date of Birth</label>
													<input type="date" class="form-control" name="birth_date" value="<?= $row['birth_date'] ?>">
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- /Basic Information -->
								
								<!-- About Me -->
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">About Me</h4>
										<div class="form-group mb-0">
											<label>Biography</label>
											<textarea class="form-control" name="about_me" rows="5"><?= $row['about'] ?></textarea>
										</div>
									</div>
								</div>
								<!-- /About Me -->
								
								<!-- Clinic Info -->
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Clinic Info</h4>
										<div class="row form-row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Clinic Name</label>
													<input type="text" class="form-control" name="clinic_name" value="<?= $clinicRow['clinic_name'] ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Clinic Address</label>
													<input type="text" class="form-control" name="clinic_adresse" value="<?= $clinicRow['clinic_adresse'] ?>">
												</div>
											</div>
											<div class="col-md-12">
												<div class="upload-img">
													<div class="change-photo-btn">
														<span><i class="fa fa-upload"></i> Upload Photo</span>
														<input type="file" class="upload" name="clinic">
													</div>
													<small class="form-text text-muted text-center">Allowed JPG, GIF or PNG. Max size of 2MB</small>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- /Clinic Info -->
							
								<!-- Contact Details -->
								<div class="card contact-card">
									<div class="card-body">
										<h4 class="card-title">Contact Details</h4>
										<div class="row form-row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Address Line 1</label>
													<input type="text" class="form-control" name="addr1" value="<?= $cdRow['adresse_line1'] ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">Address Line 2</label>
													<input type="text" class="form-control" name="addr2" value="<?= $cdRow['adresse_line2'] ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">City</label>
													<input type="text" class="form-control" name="city" value="<?= $cdRow['city'] ?>">
												</div>
											</div>
							
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">State / Province</label>
													<input type="text" class="form-control" name="state" value="<?= $cdRow['state'] ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">Country</label>
													<input type="text" class="form-control" name="country" value="<?= $cdRow['country'] ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">Postal Code</label>
													<input type="text" class="form-control" name="postal_code" value="<?= $cdRow['postal_code'] ?>">
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- /Contact Details -->
								
								<!-- Pricing -->
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Pricing</h4>
										
										<div class="form-group mb-0">
											<div id="pricing_select">
												<div class="custom-control custom-radio custom-control-inline">
													<input type="radio" id="price_free" name="rating_option" class="custom-control-input" value="price_free" <?php if($row['price'] == 0) echo "checked" ?>>
													<label class="custom-control-label" for="price_free">Free</label>
												</div>
												<div class="custom-control custom-radio custom-control-inline">
													<input type="radio" id="price_custom" name="rating_option" value="custom_price" class="custom-control-input" <?php if($row['price'] > 0) echo "checked" ?>>
													<label class="custom-control-label" for="price_custom">Custom Price (per hour)</label>
												</div>
											</div>
							
										</div>
										
										<div class="row custom_price_cont" id="custom_price_cont" style="display: none;">
											<div class="col-md-4">
												<input type="number" class="form-control" id="custom_rating_input" name="custom_rating_count" value="<?= $row['price'] ?>" placeholder="20">
												<small class="form-text text-muted">Custom price you can add</small>
											</div>
										</div>
										
									</div>
								</div>
								<!-- /Pricing -->
								
								<!-- Services and Specialization -->
								<div class="card services-card">
									<div class="card-body">
										<h4 class="card-title">Services and Specialization</h4>
										<div class="form-group" id="servs">
											<label>Services</label>
											<input type="text" data-role="tagsinput" class="input-tags form-control" placeholder="Enter Services" name="services" value="<?= $servicesRow['service_label'] ?>" id="services">
											<small class="form-text text-muted">Note : Type & Press enter to add new services</small>
										</div> 
										<div id="resulthna1"></div>      
										<div class="form-group mb-0" id="specs">
											<label>Specialization </label>
											<input class="input-tags form-control" type="text" data-role="tagsinput" placeholder="Enter Specialization" name="specialist" value="<?= $servicesRow['spec_label'] ?>" id="specialist">
											<small class="form-text text-muted">Note : Type & Press  enter to add new specialization</small>
										</div> 
										<div id="resulthna2"></div>      
									</div>        
								</div>
								<!-- /Services and Specialization -->
							 
								<!-- Education -->
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Education</h4>
										<div class="education-info">
											<div class="row form-row education-cont">
												<div class="col-12 col-md-10 col-lg-11">
													<div class="row form-row">
														<div class="col-12 col-md-6 col-lg-4">
															<div class="form-group">
																<label>Degree</label>
																<input type="text" class="form-control" name="degree" value="<?= $educationRow['degree'] ?>">
															</div> 
														</div>
														<div class="col-12 col-md-6 col-lg-4">
															<div class="form-group">
																<label>College/Institute</label>
																<input type="text" class="form-control" name="college" value="<?= $educationRow['institue'] ?>">
															</div> 
														</div>
														<div class="col-12 col-md-6 col-lg-4">
															<div class="form-group">
																<label>Year of Start</label>
																<input type="number" class="form-control" name="start_year" value="<?= intval($educationRow['year_of_start']) ?>">
															</div> 
														</div>
														<div class="col-12 col-md-6 col-lg-4">
															<div class="form-group">
																<label>Year of Completion</label>
																<input type="number" class="form-control" name="completion_year" value="<?= intval($educationRow['year_of_completion']) ?>">
															</div> 
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- <div class="add-more">
											<a href="javascript:void(0);" class="add-education"><i class="fa fa-plus-circle"></i> Add More</a>
										</div> -->
									</div>
								</div>
								<!-- /Education -->
							
								<!-- Experience -->
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Experience</h4>
										<div class="experience-info">
											<div class="row form-row experience-cont">
												<div class="col-12 col-md-10 col-lg-11">
													<div class="row form-row">
														<div class="col-12 col-md-6 col-lg-4">
															<div class="form-group">
																<label>Hospital Name</label>
																<input type="text" class="form-control" name="hospital_name" value="<?= $expRow['hospital'] ?>">
															</div> 
														</div>
														<div class="col-12 col-md-6 col-lg-4">
															<div class="form-group">
																<label>From</label>
																<input type="date" class="form-control" name="hospital_from" value="<?= $expRow['from_date'] ?>">
															</div> 
														</div>
														<div class="col-12 col-md-6 col-lg-4">
															<div class="form-group">
																<label>To</label>
																<input type="date" class="form-control" name="hospital_to" value="<?= $expRow['to_date'] ?>" >
															</div> 
														</div>
														<div class="col-12 col-md-6 col-lg-4">
															<div class="form-group">
																<label>Designation</label>
																<input type="text" class="form-control" name="designation" value="<?= $expRow['designation'] ?>">
															</div> 
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- <div class="add-more">
											<a href="javascript:void(0);" class="add-experience"><i class="fa fa-plus-circle"></i> Add More</a>
										</div> -->
									</div>
								</div>
								<!-- /Experience -->
							
								<div class="submit-section submit-btn-bottom">
									<button type="submit" class="btn btn-primary submit-btn" name="sub">Save Changes</button>
								</div>
								
						</form>
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
		
		<!-- Sticky Sidebar JS -->
        <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
		
		<!-- Select2 JS -->
		<script src="assets/plugins/select2/js/select2.min.js"></script>
		
		<!-- Dropzone JS -->
		<script src="assets/plugins/dropzone/dropzone.min.js"></script>
		
		<!-- Bootstrap Tagsinput JS -->
		<script src="assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js"></script>
		
		<!-- Profile Settings JS -->
		<script src="assets/js/profile-settings.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
	</body>


</html>