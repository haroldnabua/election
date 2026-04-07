<?php
include("../db.php");

if(isset($_GET['id'])){
    $candID = intval($_GET['id']);

    $sql = "UPDATE candidates 
            SET isDeleted = 1
            WHERE candID = '$candID'";

            if(mysqli_query($conn, $sql)){
                echo "Candidate deleted.";
            }else{
                echo "Error: " . mysqli_error($conn);
            }
}

?>