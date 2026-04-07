<?php
include("../db.php");

if(isset($_GET['id'])){
    $voterID = intval($_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM voters WHERE isDeleted = 0");
    $row = mysqli_fetch_assoc($result);
}


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $voterPass = $_POST['voterPass'];
    $voterFName = $_POST['voterFName'];
    $voterMName = $_POST['voterFName'];
    $voterLName = $_POST['voterLName'];
    $voterStat = $_POST['voterStat'];

    $sql = "UPDATE voters
            SET voterPass = '$voterPass',
                voterFName = '$voterFName',
                voterMName = '$voterMName', 
                voterLName = '$voterLName',
                voterStat = '$voterStat'
            WHERE voterID = '$voterID'";

            if(mysqli_query($conn, $sql)){
                echo "Voter credentials updated.";
                header("Location: voter_add.php");
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
    <title>Voting System</title>
</head>
<body>
    <form method = "POST">
        <label>Voter ID</label>
        <input type = "number" name = "voterID" value = "<?php echo $row['voterID'] ?>" readonly><br><br>

        <label>Password</label>
        <input type = "text" name = "voterPass" value = "<?php echo $row['voterPass']?>"><br><br>

        <label>First Name</label>
        <input type = "text" name = "voterFName" value = "<?php echo $row['voterFName']?>"><br><br>

        <label>Middle Name</label>
        <input type = "text" name = "voterMName" value = "<?php echo $row['voterMName']?>"><br><br>

        <label>Last Name</label>
        <input type = "text" name = "voterLName" value = "<?php echo $row['voterLName']?>"><br><br>

        <label>Status</label>
        <select name = "voterStat" required>
            <option value = "ACTIVE" <?php if($row['voterStat'] == 'ACTIVE') echo 'selected'; ?>>ACTIVE</option>
            <option value = "INACTIVE" <?php if($row['voterStat'] == 'INACTIVE') echo 'selected'; ?>>INACTIVE</option>
        </select><br><br>

        <button type = "submit">Update</button>
    </form>
    
</body>
</html>