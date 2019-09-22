<?php
include 'header.inc';
include 'dbh.inc';
if(isset($_GET['LogOut']))
{
    $_SESSION['username'] = null;
    $_SESSION['administrator'] = null;
    $_SESSION['userID'] = null;
    header( "Location: ./admin-login.php");
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
                <form>
                    <input type="submit" name="finish" value="Klientas aptarnautas">
                </form>
            </th>
        </tr>
    </table>
</div>

</body>
</html>
