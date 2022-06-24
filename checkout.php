<?php 
	include 'config.php';
	session_start();
	if(!isset($_SESSION['id']))	header('location:login.php');
	if($_SESSION['role'] == 'doctor') header('location:doctor-profile-settings.php');
	if(!isset($_GET['idDoc'])) header('location:index.php');

	$idDoc = $_GET['idDoc'];

	include './assets/functions/getClientInfo.php';
	$clientInfo = getClientInfo($conn);

	$sql = "SELECT d.*, dc.city, dc.country, count(r.idReview) as cmnts
			FROM doctors d, doctors_contact_details dc, reviews r
			WHERE d.idDoctor = $idDoc
			AND dc.idDoctor = d.idDoctor
			AND r.idDoctor = d.idDoctor";

	$docsRow = mysqli_fetch_assoc(mysqli_query($conn,$sql));
	$total = $docsRow['price'] + 10;

	if(isset($_POST['sub'])){
		require './assets/classes/Client.php';
		$client = new Client($conn,$_POST['fname'],$_POST['lname'],$_POST['email'],$_SESSION['password']);
		if($_POST['payment_type'] == 'cc'){
			$client->checkoutCC($_POST['fname'],
								$_POST['lname'],
								$_POST['email'],
								$_POST['phone'],
								$_POST['cc_name'],
								$_POST['cc_number'],
								$_POST['cc_month'],
								$_POST['cc_year'],
								$_POST['cvv'],
								$total,
								$idDoc);
		}
		else{
			$client->checkoutCash($_POST['fname'],$_POST['lname'],$_POST['email'],$_POST['phone'],$total,$idDoc);
		}
	}
?>

<!DOCTYPE html> 
<html lang="en">
	
<?php include 'head.php' ?>
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
									<li class="breadcrumb-item active" aria-current="page">Checkout</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Checkout</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<div class="row">
						<div class="col-md-7 col-lg-8">
							<div class="card">
								<div class="card-body">
									<?php if(isset($_POST['sub'])) $client->checkForm(); ?>
									<!-- Checkout Form -->
									<form action="checkout.php?idDoc=<?= $_GET['idDoc'] ?>" method="post">
									
										<!-- Personal Information -->
										<div class="info-widget">
											<h4 class="card-title">Personal Information</h4>
											<div class="row">
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>First Name</label>
														<input class="form-control" type="text" name="fname" value="<?= $clientInfo['first_name'] ?>">
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Last Name</label>
														<input class="form-control" type="text" name="lname" value="<?= $clientInfo['last_name'] ?>">
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Email</label>
														<input class="form-control" type="email" name="email" value="<?= $clientInfo['email'] ?>">
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Phone</label>
														<input class="form-control" type="text"  name="phone" value="<?= $clientInfo['phone'] ?>">
													</div>
												</div>
											</div>
										</div>
										<!-- /Personal Information -->
										
										<div class="payment-widget">
											<h4 class="card-title">Payment Method</h4>
											
											<!-- Credit Card Payment -->
											<div class="payment-list">
												<label class="payment-radio credit-card-option">
													<input type="radio" name="payment_type" value="cc">
													<span class="checkmark"></span>
													Credit card
												</label>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group card-label">
															<label for="card_name">Name on Card</label>
															<input class="form-control" id="card_name" type="text" name="cc_name">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group card-label">
															<label for="card_number">Card Number</label>
															<input class="form-control" id="card_number" name="cc_number" placeholder="1234  5678  9876  5432" type="text">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group card-label">
															<label for="expiry_month">Expiry Month</label>
															<input class="form-control" id="expiry_month" name="cc_month" placeholder="MM" type="text">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group card-label">
															<label for="expiry_year">Expiry Year</label>
															<input class="form-control" id="expiry_year" name="cc_year" placeholder="YY" type="text">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group card-label">
															<label for="cvv">CVV</label>
															<input class="form-control" id="cvv" name="cvv" type="number">
														</div>
													</div>
												</div>
											</div>
											<!-- /Credit Card Payment -->
											
											<!-- Paypal Payment -->
											<div class="payment-list">
												<label class="payment-radio paypal-option">
													<input type="radio" name="payment_type" value="cash">
													<span class="checkmark"></span>
													Cash
												</label>
											</div>
											<!-- /Paypal Payment -->
											
											<!-- Terms Accept -->
											<div class="terms-accept">
												<div class="custom-checkbox">
												   <input type="checkbox" id="terms_accept">
												   <label for="terms_accept">I have read and accept <a href="#">Terms &amp; Conditions</a></label>
												</div>
											</div>
											<!-- /Terms Accept -->
											
											<!-- Submit Section -->
											<div class="submit-section mt-4">
												<button type="submit" class="btn btn-primary submit-btn" name="sub">Confirm and Pay</button>
											</div>
											<!-- /Submit Section -->
										</div>
									</form>
									<!-- /Checkout Form -->
									
								</div>
							</div>
							
						</div>
						
						<div class="col-md-5 col-lg-4 theiaStickySidebar">
						
							<!-- Booking Summary -->
							<div class="card booking-card">
								<div class="card-header">
									<h4 class="card-title">Booking Summary</h4>
								</div>
								<div class="card-body">
								
									<!-- Booking Doctor Info -->
									<div class="booking-doc-info">
										<a href="doctor-profile.html" class="booking-doc-img">
											<img src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image">
										</a>
										<div class="booking-info">
											<h4><a href="doctor-profile.html">Dr. <?= $docsRow['first_name'] . ' ' . $docsRow['last_name'] ?></a></h4>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(<?= $docsRow['cmnts'] ?>)</span>
											</div>
											<div class="clinic-details">
												<p class="doc-location"><i class="fas fa-map-marker-alt"></i> <?= $docsRow['city'] .', '. $docsRow['country'] ?></p>
											</div>
										</div>
									</div>
									<!-- Booking Doctor Info -->
									
									<div class="booking-summary">
										<div class="booking-item-wrap">
											<ul class="booking-date">
												<li>Date <span><?= (new DateTime())->format('d M Y') ?></span></li>
												<li>Time <span>10:00 AM</span></li>
											</ul>
											<ul class="booking-fee">
												<li>Consulting Fee <span>$<?= $docsRow['price'] ?></span></li>
												<li>Booking Fee <span>$10</span></li>
											</ul>
											<div class="booking-total">
												<ul class="booking-total-list">
													<li>
														<span>Total</span>
														<span class="total-cost">$<?= $total ?></span>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /Booking Summary -->
							
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

<!-- doccure/checkout.html  30 Nov 2019 04:12:16 GMT -->
</html>