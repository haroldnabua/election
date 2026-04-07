<?php
include("../db.php");


if(isset($_GET['id'])){
    $voterID = intval($_GET['id']);

    $sql = "UPDATE voters
            SET isDeleted = 1
            WHERE voterID = '$voterID'";

            if(mysqli_query($conn, $sql)){
                echo "Voter deleted.";
            }else{
                echo "Error: " . mysqli_error($conn);
            }
}
?>