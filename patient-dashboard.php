<?php 
	include 'config.php';
	session_start();
	if(!isset($_SESSION['id'])) header('location:login.php');
	$idCli = $_SESSION['id'];
?>

<!DOCTYPE html> 
<html lang="en">
	
<?php include 'head.php'; ?>
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
									<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Dashboard</h2>
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
								<div class="card-body pt-0">
								
									<!-- Tab Menu -->
									<nav class="user-tabs mb-4">
										<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
											<li class="nav-item">
												<a class="nav-link active" href="#pat_appointments" data-toggle="tab">Appointments</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#pat_billing" data-toggle="tab">Billing</a>
											</li>
										</ul>
									</nav>
									<!-- /Tab Menu -->
									
									<!-- Tab Content -->
									<div class="tab-content pt-0">
										
										<!-- Appointment Tab -->
										<div id="pat_appointments" class="tab-pane fade show active">
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="table-responsive">
														<table class="table table-hover table-center mb-0">
															<thead>
																<tr>
																	<th>Doctor</th>
																	<th>Appt Date</th>
																	<th>Booking Date</th>
																	<th>Amount</th>
																	<th>Status</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>
																<?php 
																	$sql = "SELECT * FROM appointments WHERE idClient = $idCli";
																	$appointsRow = mysqli_fetch_assoc(mysqli_query($conn,$sql));
																
																	$idDoc = $appointsRow['idDoctor'];
																	$sql = "SELECT * FROM doctors d WHERE d.idDoctor = $idDoc";
																	$docsRow = mysqli_fetch_assoc(mysqli_query($conn,$sql));
																
																	$sql = "SELECT total FROM checkouts WHERE idClient = $idCli";
																	$checkout = mysqli_fetch_assoc(mysqli_query($conn,$sql));
																?>
																<tr>
																	<td>
																		<h2 class="table-avatar">
																			<a href="doctor-profile.php?idDoc=$idDoc" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/doctors/<?= $docsRow['profile_pic'] ?>" alt="User Image">
																			</a>
																			<a href="doctor-profile.html">Dr. <?= $docsRow['first_name'] .' '. $docsRow['last_name'] ?> <span><?= $docsRow['categorie'] ?></span></a>
																		</h2>
																	</td>
																	<td><?= (new DateTime($appointsRow['date']))->format('d M Y') ?> <span class="d-block text-info">10.00 AM</span></td>
																	<td><?= (new DateTime($appointsRow['date']))->format('d M Y') ?></td>
																	<td>$<?= $checkout['total'] ?></td>
																	<td>
																		<?php 
																			if($appointsRow['status'] == 'pending'){
																				echo "<span class='badge badge-pill bg-warning-light'>pending</span></td>";
																			}else if($appointsRow['status'] == 'confirm'){
																				echo "<span class='badge badge-pill bg-success-light'>Confirm</span></td>";
																			}else if($appointsRow['status'] == 'cancelled'){
																				echo "<span class='badge badge-pill bg-danger-light'>Cancelled</span></td>";
																			}
																		?>
																		
																	<td class="text-right">
																		<div class="table-action">
																			<a href="invoice-view.php?id=<?= $appointsRow['idAppointment'] .'&print'  ?>" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="invoice-view.php?id=<?= $appointsRow['idAppointment']?>" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<!-- /Appointment Tab -->
										
										<!-- Billing Tab -->
										<div id="pat_billing" class="tab-pane fade">
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="table-responsive">
														<table class="table table-hover table-center mb-0">
															<thead>
																<tr>
																	<th>Invoice No</th>
																	<th>Doctor</th>
																	<th>Amount</th>
																	<th>Paid On</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>
																		<a href="invoice-view.html">#INV-0010</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="doctor-profile.html" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-01.jpg" alt="User Image">
																			</a>
																			<a href="doctor-profile.html">Ruby Perrin <span>Dental</span></a>
																		</h2>
																	</td>
																	<td>$450</td>
																	<td>14 Nov 2019</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="invoice-view.html" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view.html">#INV-0009</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="doctor-profile.html" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image">
																			</a>
																			<a href="doctor-profile.html">Dr. Darren Elder <span>Dental</span></a>
																		</h2>
																	</td>
																	<td>$300</td>
																	<td>13 Nov 2019</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="invoice-view.html" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view.html">#INV-0008</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="doctor-profile.html" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-03.jpg" alt="User Image">
																			</a>
																			<a href="doctor-profile.html">Dr. Deborah Angel <span>Cardiology</span></a>
																		</h2>
																	</td>
																	<td>$150</td>
																	<td>12 Nov 2019</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="invoice-view.html" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view.html">#INV-0007</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="doctor-profile.html" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-04.jpg" alt="User Image">
																			</a>
																			<a href="doctor-profile.html">Dr. Sofia Brient <span>Urology</span></a>
																		</h2>
																	</td>
																	<td>$50</td>
																	<td>11 Nov 2019</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="invoice-view.html" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view.html">#INV-0006</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="doctor-profile.html" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-05.jpg" alt="User Image">
																			</a>
																			<a href="doctor-profile.html">Dr. Marvin Campbell <span>Ophthalmology</span></a>
																		</h2>
																	</td>
																	<td>$600</td>
																	<td>10 Nov 2019</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="invoice-view.html" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view.html">#INV-0005</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="doctor-profile.html" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-06.jpg" alt="User Image">
																			</a>
																			<a href="doctor-profile.html">Dr. Katharine Berthold <span>Orthopaedics</span></a>
																		</h2>
																	</td>
																	<td>$200</td>
																	<td>9 Nov 2019</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="invoice-view.html" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view.html">#INV-0004</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="doctor-profile.html" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-07.jpg" alt="User Image">
																			</a>
																			<a href="doctor-profile.html">Dr. Linda Tobin <span>Neurology</span></a>
																		</h2>
																	</td>
																	<td>$100</td>
																	<td>8 Nov 2019</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="invoice-view.html" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view.html">#INV-0003</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="doctor-profile.html" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-08.jpg" alt="User Image">
																			</a>
																			<a href="doctor-profile.html">Dr. Paul Richard <span>Dermatology</span></a>
																		</h2>
																	</td>
																	<td>$250</td>
																	<td>7 Nov 2019</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="invoice-view.html" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view.html">#INV-0002</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="doctor-profile.html" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-09.jpg" alt="User Image">
																			</a>
																			<a href="doctor-profile.html">Dr. John Gibbs <span>Dental</span></a>
																		</h2>
																	</td>
																	<td>$175</td>
																	<td>6 Nov 2019</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="invoice-view.html" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view.html">#INV-0001</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="doctor-profile.html" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-10.jpg" alt="User Image">
																			</a>
																			<a href="doctor-profile.html">Dr. Olga Barlow <span>#0010</span></a>
																		</h2>
																	</td>
																	<td>$550</td>
																	<td>5 Nov 2019</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="invoice-view.html" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<!-- /Billing Tab -->
										
									</div>
									<!-- Tab Content -->
									
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
		
		<!-- Sticky Sidebar JS -->
        <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
	</body>
</html>