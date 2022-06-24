<?php 
    include '../../config.php';
    session_start();
    if(empty($_POST['specs'])){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>".
                "<strong>Error!</strong> Specializations must not be empty!.".
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                    '<span aria-hidden="true">&times;</span>'.
                '</button>'.
            '</div>';
    }else{
        $sql = "UPDATE specializations SET spec_label = '". $_POST['specs'] ."' WHERE idDoctor = ".$_SESSION['id'];
        $res = mysqli_query($conn,$sql);
    }
?>