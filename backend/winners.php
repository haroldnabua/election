<?php
include("../db.php");

$positions = mysqli_query($conn, "SELECT * FROM positions WHERE posStat='OPEN' AND isDeleted=0");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Election Winners</title>
</head>
<body>
    <h2>Election Winners</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Elective Position</th>
            <th>Winner</th>
            <th>Total Votes</th>
        </tr>
        <?php while($pos = mysqli_fetch_assoc($positions)): ?>
            <?php
            $candRes = mysqli_query($conn, "
                SELECT c.candFName, c.candLName, COUNT(v.voteID) AS votes
                FROM candidates c
                LEFT JOIN votes v ON c.candID = v.candID AND v.posID='{$pos['posID']}'
                WHERE c.posID='{$pos['posID']}' AND c.isDeleted=0
                GROUP BY c.candID
                ORDER BY votes DESC
            ");

            $winners = [];
            while($cand = mysqli_fetch_assoc($candRes)){
                $winners[] = $cand;
            }

            $limit = $pos['numOfPositions'];
            $topWinners = array_slice($winners, 0, $limit);

            foreach($topWinners as $winner): ?>
                <tr>
                    <td><?php echo $pos['posName']; ?></td>
                    <td><?php echo $winner['candFName']." ".$winner['candLName']; ?></td>
                    <td><?php echo $winner['votes']; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endwhile; ?>
    </table>
</body>
</html>
