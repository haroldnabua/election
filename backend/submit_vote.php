<?php
session_start();
include("../db.php");

if(!isset($_SESSION['voterID'])){
    header("Location: voter_login.php");
    exit();
}

$voterID = $_SESSION['voterID'];
$votes = $_POST['vote'];

foreach($votes as $posID => $candIDs){
    $posResult = mysqli_query($conn, "SELECT numOfPositions FROM positions WHERE posID='$posID'");
    $posRow = mysqli_fetch_assoc($posResult);
    $limit = $posRow['numOfPositions'];

    if(count($candIDs) > $limit){
        die("You selected too many candidates for position $posID.");
    }

    foreach($candIDs as $candID){
        mysqli_query($conn, "INSERT INTO votes (posID, voterID, candID)
                             VALUES ('$posID', '$voterID', '$candID')");
    }
}

mysqli_query($conn, "UPDATE voters SET voted='YES' WHERE voterID='$voterID'");

session_destroy();
echo "✅ Thank you for voting!";
?>
