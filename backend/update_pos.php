<?php
include("../db.php");


if(isset($_GET['id'])){
    $posID = intval($_GET['id']);
}else{
    die("No ID provided.");
}

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $posName = $_POST['posName'];
    $numOfPositions = $_POST['numOfPositions'];
    $posStat = $_POST['posStat'];

    $sql = "UPDATE positions
            SET posName = '$posName',
                numOfPositions = '$numOfPositions',
                posStat = '$posStat'
            WHERE posID = '$posID'";
        
        if(mysqli_query($conn, $sql)){
            echo "Position updated.";
            header("Location: positions.php");
            exit();
        }else{
            echo "Error: " . mysqli_error($conn);
        }
}

$result = mysqli_query($conn, "SELECT * FROM positions
                                WHERE isDeleted = 0
                                AND posID = '$posID'");
$row = mysqli_fetch_assoc($result);
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
        height: 320px;
        border-radius: 5px;
        padding: 10px;
        margin: auto;
    }
</style>
<body>
    <form method = "POST">
        <h2>Update Position Details</h2>
        <label>Position ID</label>
        <input type = "number" name = "posID" value = "<?php echo $row['posID']?>" readonly><br><br><br>

        <label>Position Name</label>
        <input type = "text" name = "posName" value = "<?php echo $row['posName']?>"><br><br><br>

        <label>Number of Position</label>
        <input type = "number" name = "numOfPositions" value = "<?php echo $row['numOfPositions']?>"><br><br><br>

        <label for = "posStat">Position Status</label>
        <select name = "posStat" id = "posStat" required>
            <option value = "OPEN" <?php if($row['posStat'] == 'OPEN') echo 'selected'; ?>>OPEN</option>
            <option value = "CLOSED" <?php if($row['posStat'] == 'CLOSED') echo 'selected'; ?>>CLOSE</option>
</select>
        <button type = "submit">Update</button>
    </form>
    
</body>
</html>