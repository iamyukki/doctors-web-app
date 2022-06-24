<?php 
    function getExperienceInfo($conn){
        $sql = "SELECT * FROM experience WHERE idDoctor = ".$_SESSION['id'];
        return mysqli_fetch_assoc(mysqli_query($conn,$sql));
    }
?>