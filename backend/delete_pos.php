<?php
include("../db.php");

if(isset($_GET['id'])){
    $posID = intval($_GET['id']);

    $sql = "UPDATE positions
            SET isDeleted = 1
            WHERE posID = '$posID'";

            if(mysqli_query($conn, $sql)){
                echo "Position deleted.";
                header("Location: positions.php");
                exit();
            }else{
                echo "Error: " . mysqli_error($conn);
            }
}
?>  