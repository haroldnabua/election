<?php

include("../db.php");
session_start();
if(!isset($_SESSION['voterID'])){   // must be !isset
    header("Location: voter_login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['vote']) || !is_array($_POST['vote'])){
    die("No vote submission found.");
}

$voterID = $_SESSION['voterID'];
$votes = $_POST['vote'];

foreach($votes as $posID => $candIDs){
    $posResult = mysqli_query($conn, "SELECT numOfPositions FROM positions WHERE posID = '$posID'");
    $posRow = mysqli_fetch_assoc($posResult);
    $limit = $posRow['numOfPositions'];

    if(count($candIDs) > $limit){
        die("You selected too many candidates for position $posID.");
    }

    foreach($candIDs as $candID){
        $sql = "INSERT INTO votes (posID, voterID, candID)
                VALUES ('$posID', '$voterID', '$candID')";
        mysqli_query($conn, $sql);
    }
}

// mark voter as voted
mysqli_query($conn, "UPDATE voters SET voted = 'YES' WHERE voterID = '$voterID'");

session_destroy();
echo "Thank you for voting!";
?>
