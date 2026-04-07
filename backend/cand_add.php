<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../db.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $candID = $_POST['candID'];
    $candFName = $_POST['candFName'];
    $candMName = $_POST['candMName'];
    $candLName = $_POST['candLName'];
    $posID = $_POST['posID'];
    $candStat = $_POST['candStat'];

    $sql = "INSERT INTO candidates (candID, candFName, candMName, candLName, posID, candStat)
            VALUES ('$candID', '$candFName', '$candMName', '$candLName', '$posID','$candStat')";

            if(mysqli_query($conn, $sql)){
                echo "Candidate added.";

            }else{
                echo "Error: " . mysqli_error($conn);
            }
        }


$result = mysqli_query($conn, "SELECT c.*, p.posName
                                FROM candidates c
                                JOIN positions p ON c.posID = p.posID
                                WHERE c.isDeleted = 0");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Philippine Election Management System</title>
</head>
<style>
    form{
        margin: auto;
        border: 3px solid skyblue;
        width: 350px;
        border-radius: 5px;
        padding: 10px;
    }
    table{
        margin-left: auto;
        margin-right: auto;
        width: 1000;
        text-align: center;
    }
</style>
<body>
    <form method = "POST">
        <h2>Add Candidate</h2>
        <label>Candidate ID</label>
        <input type = "number" name = "candID" required><br><br>

        <label>Candidate First Name</label>
        <input type = "text" name = "candFName" required><br><br>

        <label>Candidate Middle Name</label>
        <input type = "text" name = "candMName"><br><br>

        <label>Candidate Last Name</label>
        <input type = "text" name = "candLName" required><br><br>

        <label>Position</label>
        <select name = "posID" required>
            <?php
            $positions = mysqli_query($conn, "SELECT posID, posName FROM positions WHERE isDeleted = 0");
            while($pos = mysqli_fetch_assoc($positions)){
                echo "<option value = '{$pos['posID']}'>{$pos['posName']}</option>";
            }

?>
        </select><br><br>

        <label for = "candStat">Candidate Status</label>
        <select name = "candStat" id = "candStat" required>
            <option value = "OPEN">OPEN</option>
            <option value = "CLOSE">CLOSE</option>

        </select>

        <button type = "submit">Add Candidate</button>
    </form><br>

    <table border = "1" cellpadding = "10">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Position</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php 
        while($row = mysqli_fetch_assoc($result)){
            echo "
            <tr>

            <td>{$row['candID']}</td>
            <td>{$row['candFName']}</td>
            <td>{$row['candMName']}</td>
            <td>{$row['candLName']}</td>
            <td>{$row['posName']}</td>
            <td>{$row['candStat']}</td>
            <td>
            <a href ='cand_delete.php?id={$row['candID']}'>Delete |</a>
            <a href ='cand_update.php?id={$row['candID']}'>Update</a>
            </td>
            </tr>

            ";
        }
        
        
        
    
        ?>





    </table>
    
</body>
</html>