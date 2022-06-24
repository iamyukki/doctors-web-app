<?php 
    function getDoctorInfo($conn){
        $sql = "SELECT * FROM doctors WHERE idDoctor = ".$_SESSION['id'];
        $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
	     return $row;
    }
?>