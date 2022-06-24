<?php 
    function getClientInfo($conn){
        $sql = "SELECT * FROM clients WHERE idClient = ".$_SESSION['id'];
        $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
	     return $row;
    }
?>