<?php 
    function getServicesAnsSpecs($conn){
        $sql = "SELECT s.service_label ,spec.spec_label FROM services s,specializations spec WHERE s.idDoctor = ".$_SESSION['id'] . " AND spec.idDoctor = ".$_SESSION['id'];

        return mysqli_fetch_assoc(mysqli_query($conn,$sql));
    }
?>