<?php
session_start();
include("../db.php");

if(!isset($_SESSION['voterID'])){
    header("Location: voter_login.php");
    exit();
}

$voterID = $_SESSION['voterID'];
$positions = mysqli_query($conn, "SELECT * FROM positions WHERE posStat='OPEN' AND isDeleted=0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ballot</title>
</head>
<style>
    form{
        border: 2px solid black;
        width: 350px;
        padding: 10px;
        border-radius: 5px;
        margin: auto;
    }
    button{
        width:350px;
        padding: 10px;
        background-color: wheat;
    }
</style>
<body>
    
    <form method="POST" action="submit_vote.php">
       <h2>Welcome Voter <?php echo $voterID; ?></h2>
        <?php while($pos = mysqli_fetch_assoc($positions)): ?>
            <h3><?php echo $pos['posName']; ?> 
                (Vote up to <?php echo $pos['numOfPositions']; ?>)
            </h3>
            <?php
            $candidates = mysqli_query($conn, "SELECT * FROM candidates WHERE posID='{$pos['posID']}' AND candStat='OPEN' AND isDeleted=0");
            while($cand = mysqli_fetch_assoc($candidates)): ?>
                <label>
                    <input type="checkbox" name="vote[<?php echo $pos['posID']; ?>][]" value="<?php echo $cand['candID']; ?>">
                    <?php echo $cand['candFName'] . " " . $cand['candLName']; ?>
                </label><br>
            <?php endwhile; ?>
        <?php endwhile; ?>
        <br>
        <button type="submit">Submit Ballot</button>
    </form>
</body>
</html>
