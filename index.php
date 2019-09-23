<?php
include 'session.php';
include 'header.inc';
include 'dbh.inc';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
</head>
<body>

<div>
    <table style="width:100%">
        <tr>
            <th>Talono numeris</th>
            <th>Pažymėtas laikas</th>
            <th>Vardas</th>
            <th>Pavardė</th>
        </tr>
<?php
    $getData = "SELECT * 
FROM SERVING
INNER JOIN USERS ON SERVING.fk_USER_id=USERS._id
WHERE SERVING.serviced_check = 0
ORDER BY SERVING.time_submitted, SERVING.visit_time
limit 10";
    if($res = mysqli_query($sql, $getData))
    {
        while ($row = mysqli_fetch_row($res))
        {
            ?>
            <tr>
                <th><?php echo $row[0] ?></th>
                <th><?php echo $row[3] ?></th>
                <th><?php echo $row[11] ?></th>
                <th><?php echo $row[12] ?></th>
            </tr>
            <?php
        }
    }
    ?>
    </table>
</div>
<div class="approximateTime">
<?php
if(isset($_SESSION['username']) && isset($_SESSION['administrator']) && $_SESSION['administrator'] == false && isset($_SESSION['userID'])) {
        $time = new DateTime();
        $ticket = $_SESSION['ticketId'];
        $countCheck = "SELECT COUNT(serviced_check) FROM SERVING
WHERE serviced_check = 0 AND _id < '$ticket'
GROUP BY serviced_check";
        if($res = mysqli_query($sql, $countCheck)) {
            if ($res->num_rows > 0) {
                while ($row = mysqli_fetch_row($res)) {
                    $time = $row[0] * AverageTime($sql);
                    echo "Vidutinis laukimo laikas pagal specialista: " . date("H:i:s", $time) . " (Valandos:Minutes:Sekundes)";
                }
            }
        }

}

?>
</div>

</body>
<footer>
    <script src="js/UpdateTime.js"></script>
</footer>
</html>
