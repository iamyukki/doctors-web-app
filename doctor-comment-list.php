<?php 
    $cmntsClientInfo = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM clients WHERE idClient = ".$revsRow['idClient']));
?>
<!-- Comment List -->
<li>
    <div class="comment">
        <img class="avatar avatar-sm rounded-circle" alt="User Image" src="assets/img/patients/<?= $cmntsClientInfo['profile_pic'] ?>">
        <div class="comment-body w-100">
            <div class="meta-data">
                <span class="comment-author"><?= $cmntsClientInfo['first_name'] . ' ' . $cmntsClientInfo['last_name'] ?></span>
                <span class="comment-date">Reviewed Recently</span>
                <div class="review-count rating">
                    <?php 
                        $counter = ($revsRow['stars'] == 5) ? 5 : 0;

                        for ($i=0; $i < $revsRow['stars'] ; $i++) { 
                            echo '<i class="fas fa-star filled"></i>';
                            $counter ++;
                        }
                        if($counter < 5){
                            $counter = 5 - $counter ;
                            for ($i=0; $i < $counter ; $i++) { 
                                echo '<i class="fas fa-star"></i>';
                            }
                        }
                    ?>
                </div>
            </div>
            <p class="recommended"><i class="far fa-thumbs-up"></i><?= $revsRow['title'] ?></p>
            <p class="comment-content"><?= $revsRow['review_text'] ?></p>
            <div class="comment-reply">
                <p class="recommend-btn">
                    <span>Recommend?</span>
                    <a href="#" class="like-btn">
                        <i class="far fa-thumbs-up"></i> Yes
                    </a>
                    <a href="#" class="dislike-btn">
                        <i class="far fa-thumbs-down"></i> No
                    </a>
                </p>
            </div>
        </div>
    </div>
</li>
<!-- /Comment List -->