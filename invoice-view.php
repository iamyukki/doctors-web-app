<?php 
	include 'config.php';
	session_start();
	if(!isset($_GET['id'])) header('location:index.php');
	$sql = "SELECT * FROM appointments WHERE idAppointment = ".$_GET['id'];
	
	$appRow = mysqli_fetch_assoc(mysqli_query($conn,$sql));
	$idDoc = $appRow['idDoctor'];
	$sql = "SELECT * 
			FROM doctors d, doctors_contact_details dc 
			WHERE d.idDoctor = $idDoc
			AND dc.idDoctor = d.idDoctor";
	$docsRow = mysqli_fetch_assoc(mysqli_query($conn,$sql));

	include './assets/functions/getClientInfo.php';
	$client = getClientInfo($conn);
	$idCli = ($_SESSION['role'] == 'client') ? $_SESSION['id'] : $_GET['idCli'];
	$checkout = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM checkouts WHERE idClient = ".$idCli));
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
									<li class="breadcrumb-item active" aria-current="page">Invoice View</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Invoice View</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">

					<div class="row">
						<div class="col-lg-8 offset-lg-2">
							<div class="invoice-content">
								<div class="invoice-item">
									<div class="row">
										<div class="col-md-6">
											<div class="invoice-logo">
												<img src="assets/img/logo.png" alt="logo">
											</div>
										</div>
										<div class="col-md-6">
											<p class="invoice-details">
												<strong>Order:</strong> #<?= $appRow['idAppointment'] ?> <br>
												<strong>Issued:</strong> <?= $appRow['date'] ?>
											</p>
										</div>
									</div>
								</div>
								
								<!-- Invoice Item -->
								<div class="invoice-item">
									<div class="row">
										<div class="col-md-6">
											<div class="invoice-info">
												<strong class="customer-text">Invoice From</strong>
												<p class="invoice-details invoice-details-two">
													Dr. <?= $docsRow['first_name'] .' '. $docsRow['last_name'] ?> <br>
													<?= $docsRow['adresse_line1'] . '/'. $docsRow['adresse_line1'] ?>,<br>
													<?= $docsRow['city'] . ', ' . $docsRow['country'] ?> <br>
												</p>
											</div>
										</div>
										<div class="col-md-6">
											<div class="invoice-info invoice-info2">
												<strong class="customer-text">Invoice To</strong>
												<p class="invoice-details">
													<?= $_SESSION['first_name'] .' '. $_SESSION['last_name'] ?> <br>
													<?= $client['adresse'] ?>, <br>
													<?= $client['city'] .', '. $client['zip_code']  .', '. $client['country'] ?> <br>
												</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /Invoice Item -->
								
								<!-- Invoice Item -->
								<div class="invoice-item">
									<div class="row">
										<div class="col-md-12">
											<div class="invoice-info">
												<strong class="customer-text">Payment Method</strong>
												<?php 
													if($checkout['payment_type'] == 'cc'){
														echo "<p class='invoice-details invoice-details-two'>
																Debit Card <br>
																".$checkout['cardNumber']." <br>
																CIH Bank<br>
															</p>";
													}else if($checkout['payment_type'] == 'cash'){
														echo "<p class='invoice-details invoice-details-two'>
																Cash <br>
																Dirhams <br>
															</p>";
													}
												?>
												
											</div>
										</div>
									</div>
								</div>
								<!-- /Invoice Item -->
								
								<!-- Invoice Item -->
								<div class="invoice-item invoice-table-wrap">
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<table class="invoice-table table table-bordered">
													<thead>
														<tr>
															<th>Description</th>
															<th class="text-center">Quantity</th>
															<th class="text-right">Total</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>General Consultation</td>
															<td class="text-center">1</td>
															<td class="text-right">$<?= $docsRow['price'] ?></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-md-6 col-xl-4 ml-auto">
											<div class="table-responsive">
												<table class="invoice-table-two table">
													<tbody>
													<tr>
														<th>Website Fee:</th>
														<td><span>$10</span></td>
													</tr>
													<tr>
														<th>Total Amount:</th>
														<td><span>$<?= $docsRow['price']+10 ?></span></td>
													</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<!-- /Invoice Item -->
								
								<!-- Invoice Information -->
								<div class="other-info">
									<h4>Other information</h4>
									<p class="text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed dictum ligula, cursus blandit risus. Maecenas eget metus non tellus dignissim aliquam ut a ex. Maecenas sed vehicula dui, ac suscipit lacus. Sed finibus leo vitae lorem interdum, eu scelerisque tellus fermentum. Curabitur sit amet lacinia lorem. Nullam finibus pellentesque libero.</p>
								</div>
								<!-- /Invoice Information -->
								
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
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
	</body>
	<?php 
		if(isset($_GET['print'])){
			echo "<script>window.print()</script>";
		}
		?>
</html>