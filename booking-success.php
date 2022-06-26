<?php 
	include 'config.php';
	session_start();

	if(!isset($_SESSION['idDoc']) and !isset($_SESSION['date'])) header('location:index.php');
	$sql = "SELECT * FROM doctors WHERE idDoctor =".$_SESSION['idDoc'] ;
	$docsRow = mysqli_fetch_assoc(mysqli_query($conn,$sql));
	$curAppoint = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM appointments WHERE idClient = ".$_SESSION['id']." ORDER BY idClient DESC"));
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
									<li class="breadcrumb-item active" aria-current="page">Booking</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Booking</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content success-page-cont">
				<div class="container-fluid">
				
					<div class="row justify-content-center">
						<div class="col-lg-6">
						
							<!-- Success Card -->
							<div class="card success-card">
								<div class="card-body">
									<div class="success-cont">
										<i class="fas fa-check"></i>
										<h3>Appointment booked Successfully!</h3>
										<p>Appointment booked with <strong>Dr. <?= $docsRow['first_name'] . ' '. $docsRow['last_name'] ?></strong><br> on <strong><?= $_SESSION['date']->format('d M Y') ?> 10 AM</strong></p>
										<a href="invoice-view.php?id=<?= $curAppoint['idAppointment'] ?>" class="btn btn-primary view-inv-btn">View Invoice</a>
									</div>
								</div>
							</div>
							<!-- /Success Card -->
							
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
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
	</body>
</html>