<?php
include("../db.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $voterID = $_POST['voterID'];
    $voterPass = $_POST['voterPass'];
    $voterFName = $_POST['voterFName'];
    $voterMName = $_POST['voterMName'];
    $voterLName = $_POST['voterLName'];
    $voterStat = $_POST['voterStat'];

    $sql = "INSERT INTO voters (voterID, voterPass, voterFName, voterMName, voterLName, voterStat, voted)
            VALUES ('$voterID', '$voterPass', '$voterFName', '$voterMName', '$voterLName', '$voterStat', 'NO')";

            if(mysqli_query($conn, $sql)){
                echo "Voter added.";
            }else{
                echo "Error: " . mysqli_error($conn);
            }
}

$result = mysqli_query($conn, "SELECT * FROM voters WHERE isDeleted = 0");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting System</title>
</head>
<style>
    form{
        margin: auto;
        border: 3px solid skyblue;
        border-radius: 5px;
        width: 350px;
        padding: 10px;
    }
    table{
        margin: auto;
        width: 1000px;
        text-align: center;
    }
</style>
<body>
    <form method = "POST">
        <label>Voter ID</label>
        <input type = "number" name = "voterID" required><br><br>

        <label>Password</label>
        <input type = "text" name = "voterPass" required><br><br>

        <label>First Name</label>
        <input type = "text" name = "voterFName" required><br><br>

        <label>Middle Name</label>
        <input type = "text" name = "voterMName"><br><br>

        <label>Last Name</label>
        <input type = "text" name = "voterLName" required><br><br>

        <label>Status</label>
        <select name = "voterStat" required>
            <option value = "ACTIVE">ACTIVE</option>
            <option value = "INACTIVE">INACTIVE</option>
        </select><br><br>

        <button type = "submit">Register Voter</button>
    </form><br><br>

    <table border = "1" cellpadding = "10">
        <tr>
            <th>Voter ID</th>
            <th>First Name</th>
            <th>Password</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php
        while($row = mysqli_fetch_assoc($result)){
            echo "
            <tr>
            
            <td>{$row['voterID']}</td>
            <td>{$row['voterPass']}</td>
            <td>{$row['voterFName']}</td>
            <td>{$row['voterMName']}</td>
            <td>{$row['voterLName']}</td>
            <td>{$row['voterStat']}</td>
            <td>
            <a href='voter_delete.php?id={$row['voterID']}'>Delete | </a>
            <a href='voter_update.php?id={$row['voterID']}'>Update</a>
            </td>
            </tr>
            ";
        }
        
        ?>
    </table>
    
</body>
</html>