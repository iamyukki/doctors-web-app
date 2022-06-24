<?php
    $services = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM services WHERE idDoctor = ".$docsRow['idDoctor']))['service_label'] ;
    $services =explode(',',$services);
    if(empty($services[count($services) -1]) or $services[count($services) -1] == ',') unset($services[count($services) -1]); //Deletes last array item

    $spec = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM specializations WHERE idDoctor = ".$docsRow['idDoctor']))['spec_label'] ;
    $spec = explode(',',$spec)[0];

    $docCmntCountSql = "SELECT count(stars) as cmnts FROM reviews WHERE idDoctor = ";
    if(isset($_GET['idDoc'])){
        $docCmntCountSql .= $idDoc;
    }else{
        $docCmntCountSql .= $docsRow['idDoctor'];
    }
    $cmntsCount = mysqli_fetch_assoc(mysqli_query($conn,$docCmntCountSql));
?>
<!-- Doctor Widget -->
<div class="card">
    <div class="card-body">
        <div class="doctor-widget">
            <div class="doc-info-left">
                <div class="doctor-img">
                    <a href="doctor-profile.html">
                        <img src="assets/img/doctors/<?= $docsRow['profile_pic']?>" class="img-fluid" alt="User Image">
                    </a>
                </div>
                <div class="doc-info-cont">
                    <h4 class="doc-name"><a href=<?=" doctor-profile.php?idDoc=".$docsRow['idDoctor'] ?> >Dr. <?= $docsRow['first_name'] ." ". $docsRow['last_name'] ?></a></h4>
                    <p class="doc-speciality">MDS - <?= $spec ?></p>
                    <h5 class="doc-department"><img src="assets/img/specialities/<?= $docsRow['categorie'] ?>.png" class="img-fluid" alt="Speciality"><?= $docsRow['categorie'] ?></h5>
                    <div class="rating">
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star <?= (rand(0,1)) ? "filled" : "" ?>"></i>
                        <i class="fas fa-star" <?= (rand(0,1)) ? "filled" : "" ?>></i>
                        <span class="d-inline-block average-rating">(<?= $cmntsCount['cmnts'] ?>)</span>
                    </div>
                    <div class="clinic-details">
                        <p class="doc-location"><i class="fas fa-map-marker-alt"></i> <?= $docsRow['city'] .", " . $docsRow['country'] ?> <a href="javascript:void(0);">- Get Directions</a></p>
                        <ul class="clinic-gallery">
                            <li>
                                <a href="assets/img/features/feature-01.jpg" data-fancybox="gallery">
                                    <img src="assets/img/features/feature-01.jpg" alt="Feature">
                                </a>
                            </li>
                            <li>
                                <a href="assets/img/features/feature-02.jpg" data-fancybox="gallery">
                                    <img  src="assets/img/features/feature-02.jpg" alt="Feature">
                                </a>
                            </li>
                            <li>
                                <a href="assets/img/features/feature-03.jpg" data-fancybox="gallery">
                                    <img src="assets/img/features/feature-03.jpg" alt="Feature">
                                </a>
                            </li>
                            <li>
                                <a href="assets/img/features/feature-04.jpg" data-fancybox="gallery">
                                    <img src="assets/img/features/feature-04.jpg" alt="Feature">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="clinic-services">
                        <?php 
                            for ($i=0; $i < count($services); $i++) { 
                                echo "<span>$services[$i]</span>";
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="doc-info-right">
                <div class="clini-infos">
                    <ul>
                        <li><i class="far fa-thumbs-up"></i> <?= rand(40,100).'%' ?></li>
                        <li><i class="far fa-comment"></i> <?= rand(1,30) ?> Feedback</li>
                        <li><i class="fas fa-map-marker-alt"></i><?= $docsRow['city'] .", " . $docsRow['country'] ?></li>
                        <li><i class="far fa-money-bill-alt"></i> $<?= $docsRow['price'] ?> <i class="fas fa-info-circle" data-toggle="tooltip" title="+Booking taxes"></i> </li>
                    </ul>
                </div>
                <div class="clinic-booking">
                    <a class="view-pro-btn" href=<?=" doctor-profile.php?idDoc=".$docsRow['idDoctor'] ?> >View Profile</a>
                    <a class="apt-btn" href= <?= "booking.php?idDoc=".$docsRow['idDoctor'] ?> >Book Appointment</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Doctor Widget -->
