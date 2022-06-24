<?php 
    function getEducationInfo($conn){
        $sql = "SELECT * FROM educations WHERE idDoctor = ".$_SESSION['id'];
        return mysqli_fetch_assoc(mysqli_query($conn,$sql));
    }
?>