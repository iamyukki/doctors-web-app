<?php 
    include 'config.php';
    session_start();
    $city = "";$gender = '';$cat ='';
	if(isset($_POST['filterSub'])){
		// Check for gender 
		$gender = "";
		if(isset($_POST['gender'])){
			$gender = "gender=". $_POST['gender'];
		}
		//Check for categories
		$cat = "";
		if(isset($_POST['select_specialist'])){
			$cat = "cat=";
			for ($i=0; $i < count($_POST['select_specialist']) ; $i++) { 
				if(isset($_POST['select_specialist'][$i])){
					$cat .= $_POST['select_specialist'][$i] ."+";
				}
			}
			$cat = substr($cat, 0, -1);
		}

		//Check for city
		$city = "";
		if(isset($_POST['city'])){
			$city = "city=";
			for ($i=0; $i < count($_POST['city']); $i++) { 
				if(isset($_POST['city'][$i])){
					$city .= "" . $_POST['city'][$i] . "+";
				}
			}
			$city = substr($city,0,-1);
		}

		$location = "location:search.php?$gender&$cat&$city";
		header($location);
	}
        if(isset($_GET['city']) and isset($_GET['gender']) and isset($_GET['cat'])){
            $city = $_GET['city'];
            $gender = $_GET['gender'];
            $cat = $_GET['cat'];
        }else if(isset($_GET['city'])and isset($_GET['cat'])){
            $city = $_GET['city'];
            $cat = $_GET['cat'];
        }
?>

<!DOCTYPE html> 
<html lang="en">
<head>
		<meta charset="utf-8">
		<title>Doccure</title>
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
		
		<!-- Fancybox CSS -->
		<link rel="stylesheet" href="assets/plugins/fancybox/jquery.fancybox.min.css">
		
		<!-- Main CSS -->
		<link rel="stylesheet" href="assets/css/style.css">
	
</head>
	<body>

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			<?php include 'header.php' ?>
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-8 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Search</li>
								</ol>
							</nav>							
						</div>
						<div class="col-md-4 col-12 d-md-block d-none">
							<div class="sort-by">
								<span class="sort-title">Sort by</span>
								<span class="sortby-fliter">
									<select class="select">
										<option>Select</option>
										<option class="sorting">Rating</option>
										<option class="sorting">Popular</option>
										<option class="sorting">Latest</option>
										<option class="sorting">Free</option>
									</select>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-12 col-lg-4 col-xl-3 theiaStickySidebar">
						
							<!-- Search Filter -->
                            <div class="card search-filter">
                                    <form action="search.php" method="post">
									<div class="card-header">
										<h4 class="card-title mb-0">Search Filter</h4>
									</div>
									<!-- Gender options -->
									<div class="card-body">
										<div class="filter-widget">
											<h4>Gender</h4>
											<div>
												<label class="custom_check">
													<input type="checkbox" name="gender" id="maleCheckBox" value="Male" <?php if (isset($_GET['gender'])){ if($_GET['gender'] == "male") echo "checked";} ?> >
													<span class="checkmark"></span> Male Doctor
												</label>
											</div>
											<div>
												<label class="custom_check">
													<input type="checkbox" name="gender" id="femaleCheckBox" value="Female" <?php if (isset($_GET['gender'])){ if($_GET['gender'] == "female") echo "checked";} ?>>
													<span class="checkmark"></span> Female Doctor
												</label>
											</div>
										</div>
									<!--/Gender options -->

									<!-- categories options -->
									<div class="filter-widget">
										<h4>Select Specialist</h4>
										<div>
											<label class="custom_check">
												<input type="checkbox" name="select_specialist[]" value="Urology" >
												<span class="checkmark"></span> Urology
											</label>
										</div>
										<div>
											<label class="custom_check">
												<input type="checkbox" name="select_specialist[]" value="Neurology">
												<span class="checkmark"></span> Neurology
											</label>
										</div>
										<div>
											<label class="custom_check">
												<input type="checkbox" name="select_specialist[]" value="Dentist">
												<span class="checkmark"></span> Dentist
											</label>
										</div>
										<div>
											<label class="custom_check">
												<input type="checkbox" name="select_specialist[]" value="Orthopedic">
												<span class="checkmark"></span> Orthopedic
											</label>
										</div>
										<div>
											<label class="custom_check">
												<input type="checkbox" name="select_specialist[]" value="Cardiologist">
												<span class="checkmark"></span> Cardiologist
											</label>
										</div>
										
									</div>
									<!--/Categories options -->

									<!-- Cities options -->
									<div class="filter-widget">
										<h4>Select City</h4>
										<div>
											<label class="custom_check">
												<input type="checkbox" name="city[]" id="casa" value="casa" <?php if (isset($_GET['city'])){ if($_GET['city'] == "casa") echo "checked";} ?>>
												<span class="checkmark"></span> Casablanca
											</label>
										</div>
										<div>
											<label class="custom_check">
												<input type="checkbox" name="city[]" id="rbat[]" value="rabat" <?php if (isset($_GET['city'])){ if($_GET['city'] == "rabat") echo "checked";} ?>>
												<span class="checkmark"></span> Rabat
											</label>
										</div>
									</div>
									<!--/Cities options -->
										<div class="btn-search">
											<button type="submit" class="btn btn-block" name="filterSub">Search</button>
										</div>	
									</div>
                                </form>
								</div>
							<!-- /Search Filter -->
							
						</div>
						
						<div class="col-md-12 col-lg-8 col-xl-9">
                            <?php 
                                $sql = "SELECT * FROM doctors d, doctors_contact_details dc WHERE dc.idDoctor = d.idDoctor";
                                if(isset($_GET['city']) and isset($_GET['gender']) and isset($_GET['cat'])){
                                    $sql = "SELECT * FROM doctors d,doctors_contact_details dc WHERE d.categorie = '$cat' AND d.gender = '$gender' AND (dc.idDoctor = d.idDoctor AND city LIKE '$city%') ";
                                }
                                else if(isset($_GET['city']) and isset($_GET['cat'])){
                                    $sql = "SELECT * FROM doctors d,doctors_contact_details dc WHERE d.categorie = '$cat' AND (dc.idDoctor = d.idDoctor AND city LIKE '$city%') ";
                                }
                                $res = mysqli_query($conn,$sql);
                                while($docsRow = mysqli_fetch_assoc($res)){
                                    include 'doctor-search-widget.php';
                                }
                            ?>
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
		
		<!-- Select2 JS -->
		<script src="assets/plugins/select2/js/select2.min.js"></script>
		
		<!-- Datetimepicker JS -->
		<script src="assets/js/moment.min.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
		
		<!-- Fancybox JS -->
		<script src="assets/plugins/fancybox/jquery.fancybox.min.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
	</body>

<!-- doccure/search.html  30 Nov 2019 04:12:16 GMT -->
</html>