<?php 
    //Will return the info os the clinic that relates to the doctor
    function getClinicInfo($conn){
        $sql = "SELECT * FROM clinics WHERE idDoctor = ".$_SESSION['id'];
        $res = mysqli_query($conn,$sql);
        return mysqli_fetch_assoc($res);
    }
?>