<?php
include 'session.inc';
include 'dbh.inc';
include 'header.inc';
$userId = $_SESSION['userID'];
if(isset($_GET['LogOut']))
{
    $_SESSION['username'] = null;
    $_SESSION['administrator'] = null;
    $_SESSION['userID'] = null;
    $_SESSION['timePassed'] = null;
    header( "Location: ./admin-login.php");
}
if(isset($_SESSION['username']) && isset($_SESSION['administrator']) && $_SESSION['administrator'] == true && isset($_SESSION['userID'])) {

    if (isset($_GET['finish'])) {
        $_SESSION['timePassed'] = null;
        $setAccepted = "UPDATE SERVING
SET serviced_check = 1, time_finished = NOW()
WHERE serviced_check = 0 AND fk_ADMIN_id IS NOT NULL 
ORDER BY time_submitted, visit_time
LIMIT 1";
        if (mysqli_query($sql, $setAccepted)) {
        }

    }

    if (isset($_GET['accept'])) {
        $setAccepted = "UPDATE SERVING
SET time_accepted = NOW(), time_finished = NOW(), fk_ADMIN_id = '$userId'
WHERE serviced_check = 0 AND (SERVING.fk_ADMIN_id IS NULL OR SERVING.fk_ADMIN_id = '$userId')
ORDER BY time_submitted, visit_time
LIMIT 1";
        mysqli_query($sql, $setAccepted);

    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
</head>
<body>
<?php
if(isset($_SESSION['username']) && isset($_SESSION['administrator']) && $_SESSION['administrator'] == true && isset($_SESSION['userID'])) {
    ?>
<div>
    <table style="width:100%">
        <?php
        $getData = "SELECT * 
FROM SERVING
INNER JOIN USERS ON SERVING.fk_USER_id=USERS._id
WHERE SERVING.serviced_check = 0 AND (SERVING.fk_ADMIN_id IS NULL OR SERVING.fk_ADMIN_id = '$userId')
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
                <?php echo LastTime($sql, $userId) ?>
            </th>
        </tr>
    </table>
</div>
<?php }
else if($_SESSION['administrator'] == false)
{
    header("Location: ./user.php");
    exit();
}
else if ($_SESSION['administrator'] == null)
{
    header("Location: ./admin-login.php");
    exit();
}
?>
</body>
</html>
