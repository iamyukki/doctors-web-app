<?php 
    function getContactDetailsInfo($conn){
        $sql = "SELECT * FROM doctors_contact_details WHERE idDoctor = ".$_SESSION['id'];
        $res = mysqli_query($conn,$sql);
        return mysqli_fetch_assoc($res);
    }
?>