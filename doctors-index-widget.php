<!-- Doctor Widget -->
<?php
    $dcd = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM doctors_contact_details WHERE idDoctor = ".$idocsRow['idDoctor']));
?>
<div class="profile-widget">
    <div class="doc-img">
        <a href="doctor-profile.html">
            <img class="img-fluid" alt="User Image" src="assets/img/doctors/<?= $idocsRow['profile_pic'] ?>">
        </a>
        <a href="javascript:void(0)" class="fav-btn">
            <i class="far fa-bookmark"></i>
        </a>
    </div>
    <div class="pro-content">
        <h3 class="title">
            <a href="doctor-profile.php?idDoc=<?= $idocsRow['idDoctor'] ?>"><?= $idocsRow['first_name'] .' '. $idocsRow['last_name'] ?></a> 
            <i class="fas fa-check-circle verified"></i>
        </h3>
        <p class="speciality">MDS - Periodontology and Oral Implantology, BDS</p>
        <div class="rating">
            <i class="fas fa-star filled"></i>
            <i class="fas fa-star filled"></i>
            <i class="fas fa-star filled"></i>
            <i class="fas fa-star filled"></i>
            <i class="fas fa-star filled"></i>
            <span class="d-inline-block average-rating">(<?php rand(1,30) ?>)</span>
        </div>
        <ul class="available-info">
            <li>
                <i class="fas fa-map-marker-alt"></i> <?= $dcd['city'] .', '. $dcd['country']?>
            </li>
            <li>
                <i class="far fa-clock"></i> Available on <?= (new DateTime())->format('d M') ?>
            </li>
            <li>
                <i class="far fa-money-bill-alt"></i> <?= $idocsRow['price'] ?>
                <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
            </li>
        </ul>
        <div class="row row-sm">
            <div class="col-6">
                <a href="doctor-profile.php?idDoc=<?= $idocsRow['idDoctor'] ?>" class="btn view-btn">View Profile</a>
            </div>
            <div class="col-6">
                <a href="booking.php?idDoc=<?= $idocsRow['idDoctor'] ?>" class="btn book-btn">Book Now</a>
            </div>
        </div>
    </div>
</div>
<!-- /Doctor Widget -->