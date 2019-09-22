<?php
include 'header.inc';
include 'dbh.inc';

if(isset($_GET['LogOut']))
{
    $_SESSION['username'] = null;
    $_SESSION['administrator'] = null;
    $_SESSION['userID'] = null;
    $_SESSION['timePassed'] = null;
    header( "Location: ./admin-login.php");
}

if(isset($_GET['finish']))
{
    $setAccepted = "UPDATE SERVING
SET serviced_check = 1, time_finished = NOW()
WHERE serviced_check = 0
ORDER BY time_submitted, visit_time
LIMIT 1";
    if(mysqli_query($sql, $setAccepted))
    {

    }
    $sqlGetTimeStamps = "SELECT time_accepted, time_finished FROM SERVING WHERE serviced_check = 1 ORDER BY time_submitted DESC LIMIT 1";
    if ($res2 = mysqli_query($sql, $sqlGetTimeStamps)) {
        if($res2->num_rows > 0){
            while ($row2 = mysqli_fetch_row($res2))
            {
                $visitStart = new DateTime($row2[0]);
                $visitEnd = new DateTime($row2[1]);
                $difference = $visitStart->diff($visitEnd);
                $timeDiff = $difference->format('%H:%I:%S');
                $_SESSION['timePassed'] = $timeDiff;
            }
        }
    }

}

if(isset($_GET['accept']))
{
    $_SESSION['timePassed'] = strtotime("today");
    $id = $_SESSION['userID'];
    $setAccepted = "UPDATE SERVING
SET time_accepted = NOW(), time_finished = NOW(), fk_ADMIN_id = '$id'
WHERE serviced_check = 0
ORDER BY time_submitted, visit_time
LIMIT 1";
    mysqli_query($sql, $setAccepted);
    $_SESSION['timePassed'] = null;

}

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
ORDER BY SERVING.time_submitted, SERVING.visit_time
limit 1";
        if($res = mysqli_query($sql, $getData))
        {

            while ($row = mysqli_fetch_row($res))
            {
                ?>
                <tr>

                    <th><?php echo $row[0] ?></th>
                    <th><?php echo $row[1] ?></th>
                    <th><?php echo $row[3] ?></th>
                    <th><?php echo $row[10] ?></th>
                    <th><?php echo $row[11] ?></th>
                </tr>
                <?php
            }
        }
        ?>
        <tr>
            <th>
            <form>
                <input type="submit" name="accept" value="Priimti klientą">
            </form>
            </th>
            <th>

            </th>
            <th>
                <form>
                    <input type="submit" name="finish" value="Klientas aptarnautas">
                </form>
            </th>
        </tr>
        <tr>
            <th>
                <?php if($_SESSION['timePassed'] != null) { echo $_SESSION['timePassed']; } ?>
            </th>
        </tr>
    </table>
</div>

</body>
</html>
