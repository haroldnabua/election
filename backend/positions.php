<?php
include("../db.php");

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $posID = $_POST['posID'];
    $posName = $_POST['posName'];
    $numOfPositions = $_POST['numOfPositions'];

    $sql = "INSERT INTO positions (posID, posName, numOfPositions, posStat)
            VALUES ('$posID', '$posName', '$numOfPositions', 'OPEN')";

    if(mysqli_query($conn, $sql)){
        echo "Position added.";

        $sqlUpdate = "UPDATE positions SET posStat = 'OPEN' WHERE posID = '$posID'";
        if(mysqli_query($conn, $sqlUpdate)){
            echo "";
        }else{
            echo "Update failed: " . mysqli_error($conn);
        }
    }else{
        echo "Query failed: " . mysqli_error($conn);
    }
}

$result = mysqli_query($conn, "SELECT * FROM positions WHERE isDeleted = 0");
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Philippine National Election System</title>
</head>
<style>
    form{
        border: 2px solid black;
        width: 350px;
        margin: auto;
        border-radius: 5px;
        padding: 20px;
    }
    button{
        width: 350px;
        background-color: green;
        padding: 5px;
        font-size: 25px;
        color: white;
        border-radius: 30px;
    }
    table{
        margin: auto;
        text-align: center;
    }
    td{
        font-size: 17px;
    }
</style>
<body>
    <form method = "POST">
        <h2>Add Position</h2>
        <label>Position ID</label>
        <input type = "number" name = "posID" required><br><br>

        <label>Position Name</label>
        <input type = "text" name = "posName" required><br><br>

        <label>Number of Positions</label>
        <input type = "number" name = "numOfPositions" required><br><br>

        <button type = "submit">Add Position</button>
    </form><br>

    <table border = "2" cellpadding = "10">
        <tr>
            <th>Position ID</th>
            <th>Position Name</th>
            <th>Number of Positions</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php
        while($row = mysqli_fetch_assoc($result)){
            echo "
            <tr>
            <td>{$row['posID']}</td>
            <td>{$row['posName']}</td>
            <td>{$row['numOfPositions']}</td>
            <td>{$row['posStat']}</td>
            <td><a href='delete_pos.php?id={$row['posID']}'>Delete | </a>
            <a href='update_pos.php?id={$row['posID']}'>Update</a></td>
            </tr>
            ";
        }




?>
    </table>
    
</body>
</html>