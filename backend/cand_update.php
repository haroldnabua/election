<?php

include("../db.php");

if(isset($_GET['id'])){
    $candID = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM candidates WHERE candID = '$candID'");

    if($result && mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
    }
}else{
    echo "No ID provided.";
}


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $candFName = $_POST['candFName'];
    $candMName = $_POST['candMName'];
    $candLName = $_POST['candLName'];
    $posID = $_POST['posID'];
    $candStat = $_POST['candStat'];

    $sql = "UPDATE candidates
            SET candFName = '$candFName',
            candMName = '$candMName',
            candLName = '$candLName',
            posID = '$posID',
            candStat = '$candStat'
            WHERE candID = '$candID' ";

            if(mysqli_query($conn, $sql)){
                echo "Candidate updated.";
                header("Location: cand_add.php");
                exit();
            }else{
                echo "Error: " . mysqli_error($conn);
            }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method = "POST">
        <label>Candidate ID</label>
        <input type = "number" name = "candID" value = "<?php echo $row['candID']?>" readonly><br><br>

        <label>First Name</label>
        <input type = "text" name = "candFName" value = "<?php echo $row['candFName']?>"><br><br>

        <label>Middle Name</label>
        <input type = "text" name = "candMName" value = "<?php echo $row['candMName']?>"><br><br>

        <label>Last Name</label>
        <input type = "text" name = "candLName" value = "<?php echo $row['candLName']?>"><br><br>

        <label>Position</label>
        <select name = "posID" required>
            <?php 
            $positions = mysqli_query($conn, "SELECT posID, posName FROM positions WHERE isDeleted = 0");
            while($pos=mysqli_fetch_assoc($positions)){

            $selected = ($pos['posID'] == $row['posID']) ? "selected" : "";

            echo "<option value='{$pos['posID']}' $selected>{$pos['posName']}</option>";
            }
            ?>
        </select><br><br>

        <label>Status</label>
        <select name = "candStat" required>
            <option value = "OPEN" <?php if($row['candStat'] == 'OPEN') echo 'selected'; ?>>OPEN</option>
            <option value = "CLOSE" <?php if($row['candStat'] == 'CLOSE') echo 'selected'; ?>>CLOSE</option>
 
        </select><br><br>

        <button type = "submit">Update</button>
    </form>
    
</body>
</html>