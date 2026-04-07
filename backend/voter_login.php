<?php
session_start(); // always at the top
include("../db.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $voterID = mysqli_real_escape_string($conn, $_POST['voterID']);
    $voterPass = mysqli_real_escape_string($conn, $_POST['voterPass']);

    $result = mysqli_query($conn, "SELECT * FROM voters WHERE voterID = '$voterID' AND voterPass = '$voterPass'");
    if($result && mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);

        $voterStat = strtoupper(trim($row['voterStat']));
        $voted = strtoupper(trim($row['voted']));

        $isActive = in_array($voterStat, ['ACTIVE', 'OPEN'], true);
        $hasNotVoted = ($voted === 'NO' || $voted === '' || is_null($row['voted']));

        if($isActive && $hasNotVoted){
            $_SESSION['voterID'] = $row['voterID'];
            header("Location: vote.php");
            exit();
        } else {
            echo "You are either inactive or have already voted.";
        }

    } else {
        echo "Invalid login.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting System</title>
</head>
<body>
    <form method = "POST">
        <label>Voter ID</label>
        <input type = "text" name = "voterID" required><br><br>

        <label>Voter Pass</label>
        <input type = "text" name = "voterPass" required><br><br>

        <button type = "submit">Login</button>
    </form>
    
</body>
</html>