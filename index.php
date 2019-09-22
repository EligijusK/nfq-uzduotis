<?php
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
<?php
    $getData = "SELECT * 
FROM SERVING
INNER JOIN USERS ON SERVING.fk_USER_id=USERS._id
WHERE SERVING.serviced_check = 0
ORDER BY SERVING.time_submited, SERVING.visit_time
limit 10";
    if($res = mysqli_query($sql, $getData))
    {
        while ($row = mysqli_fetch_row($res))
        {

            ?>
            <tr>
                <th><?php echo $row[0] ?></th>
                <th><?php echo $row[1] ?></th>
                <th><?php echo $row[3] ?></th>
                <th><?php echo $row[9] ?></th>
                <th><?php echo $row[10] ?></th>
            </tr>
            <?php
        }
    }
?>
    </table>
</div>

</body>
</html>
