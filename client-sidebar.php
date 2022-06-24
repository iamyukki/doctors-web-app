<!-- Profile Sidebar -->
<?php 
	include_once 'config.php';
	include_once './assets/functions/getClientInfo.php';
	$row = getClientInfo($conn);
	$bd = new DateTime($row['birth_date']);
	$years_old = (new DateTime())->diff($bd)->y;
	if($years_old > 0){
		$years_old = ", " . $years_old . " years";
	}else {$years_old =  "";}
?>
<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
							<div class="profile-sidebar">
								<div class="widget-profile pro-widget-content">
									<div class="profile-info-widget">
										<a href="#" class="booking-doc-img">
											<img src="assets/img/patients/<?= $row['profile_pic'] ?>" alt="User Image">
										</a>
										<div class="profile-det-info">
											<h3><?= $row['first_name'] ." ". $row['last_name'] ?></h3>
											<div class="patient-details">
												<h5><i class="fas fa-birthday-cake"></i> <?= $bd->format("d M Y") . $years_old ?> </h5>
												<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <?= $row['country'] . ", ". $row['state'] ?></h5>
											</div>
										</div>
									</div>
								</div>
								<div class="dashboard-widget">
									<nav class="dashboard-menu">
										<ul>
											<li class="active">
												<a href="patient-dashboard.php">
													<i class="fas fa-columns"></i>
													<span>Dashboard</span>
												</a>
											</li>
											<li>
												<a href="favourites.php">
													<i class="fas fa-bookmark"></i>
													<span>Favourites</span>
												</a>
											</li>
											<li>
												<a href="profile-settings.php">
													<i class="fas fa-user-cog"></i>
													<span>Profile Settings</span>
												</a>
											</li>
											<li>
												<a href="change-password.php">
													<i class="fas fa-lock"></i>
													<span>Change Password</span>
												</a>
											</li>
										</ul>
									</nav>
								</div>

							</div>
						</div>
					<!-- / Profile Sidebar -->