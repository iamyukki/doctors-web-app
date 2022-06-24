<?php 
	include 'config.php';
	session_start();

	$sql = "SELECT * FROM appointments WHERE idDoctor = ".$_SESSION['id'];
	$appoints = mysqli_fetch_assoc(mysqli_query($conn,$sql));

?>

<!DOCTYPE html> 
<html lang="en">
	
<?php include 'head.php' ?>
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
									<li class="breadcrumb-item active" aria-current="page">My Patients</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">My Patients</h2>
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
						
								<?php 
								if($appoints):
									$sql = "SELECT * FROM clients WHERE idClient = ". $appoints['idClient'];
									$client = mysqli_fetch_assoc(mysqli_query($conn,$sql));
								 ?>
							<div class="row row-grid">
								<div class="col-md-6 col-lg-4 col-xl-3">
									<div class="card widget-profile pat-widget-profile">
										<div class="card-body">
											<div class="pro-widget-content">
												<div class="profile-info-widget">
													<a href="patient-profile.html" class="booking-doc-img">
														<img src="assets/img/patients/patient.jpg" alt="User Image">
													</a>
													<div class="profile-det-info">
														<h3><a href="patient-profile.html"><?= $client['first_name'] .' '. $client['last_name'] ?></a></h3>
														
														<div class="patient-details">
															<h5><b>Patient ID :</b> <?= $client['idClient'] ?></h5>
															<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <?= $client['city'] .', '. $client['country']?></h5>
														</div>
													</div>
												</div>
											</div>
											<div class="patient-info">
												<ul>
													<li>Phone <span>0<?= $client['phone'] ?></span></li>

													<li>Age <span><?= (new DateTime())->diff(new DateTime($client['birth_date']))->y . ' Years, Male' ?></span></li>
													<li>Blood Group <span><?= $client['blood_type'] ?></span></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if(!$appoints){
							echo '<div class="alert alert-success alert-dismissible fade show w-100" role="alert">'.
							'No Don\'t have patients yet.'.
							'</div>';
						} ?>
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
</html>