<?php
include("../db.php");

$positions = mysqli_query($conn, "SELECT * FROM positions WHERE posStat='OPEN' AND isDeleted=0");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Election Results</title>
</head>
<body>
    <h2>Election Results</h2>
    <?php while($pos = mysqli_fetch_assoc($positions)): ?>
        <h3><?php echo $pos['posName']; ?></h3>
        <table border="1" cellpadding="5">
            <tr>
                <th>Candidate</th>
                <th>Total Votes</th>
                <th>Voting %</th>
            </tr>
            <?php
            $totalVotesRes = mysqli_query($conn, "SELECT COUNT(*) 
                                                    AS total FROM votes 
                                                    WHERE posID='{$pos['posID']}'");

            $totalVotesRow = mysqli_fetch_assoc($totalVotesRes);
            $totalVotes = $totalVotesRow['total'];

            $candRes = mysqli_query($conn, "
                SELECT c.candFName, c.candLName, COUNT(v.voteID) AS votes
                FROM candidates c
                LEFT JOIN votes v ON c.candID = v.candID AND v.posID='{$pos['posID']}'
                WHERE c.posID='{$pos['posID']}' AND c.isDeleted=0
                GROUP BY c.candID
                ORDER BY votes DESC
            ");

            while($cand = mysqli_fetch_assoc($candRes)):
                $percentage = $totalVotes > 0 ? round(($cand['votes'] / $totalVotes) * 100, 2) : 0;
            ?>
                <tr>
                    <td><?php echo $cand['candFName']." ".$cand['candLName']; ?></td>
                    <td><?php echo $cand['votes']; ?></td>
                    <td><?php echo $percentage; ?>%</td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endwhile; ?>
</body>
</html>
