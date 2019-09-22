<?php
include 'dbh.inc';
include 'header.inc';
$userId = $_SESSION['userID'];
if(isset($_GET['LogOut']))
{
    $_SESSION['username'] = null;
    $_SESSION['administrator'] = null;
    $_SESSION['userID'] = null;
    $_SESSION['LogedIn'] = false;
    header( "Location: ./client-login.php");
}
if($_GET['time'] <= 0 && isset($_GET['submitVisit']))
{
    echo "vizito laikas turi užtrukti ilgiau negu 0 minučių";
}
else if($_GET['time'] > 0 && isset($_GET['submitVisit']))
{
    $info = $_GET['info'];
    $visitTime = $_GET['time'];
    $checkIfInsert = "SELECT serviced_check, fk_USER_id FROM SERVING
WHERE fk_USER_id = '$userId' AND serviced_check = 0";
    if($res = mysqli_query($sql, $checkIfInsert)) {
        if($res->num_rows == 0) {
            $insertVisit = "INSERT INTO SERVING (servicing_info, serviced_check, visit_time, fk_USER_id)
            VALUES ('$info', '0', '$visitTime', '$userId')";
            if (mysqli_query($sql, $insertVisit)) {

            }
        }
        else{
            echo "Jūsų vizitas jau suplanuotas";
        }
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
if(isset($_SESSION['username']) && isset($_SESSION['administrator']) && $_SESSION['administrator'] == false && isset($_SESSION['userID'])) {
    ?>
    <form>
        <input type="number" name="time"/>
        <input type="text" name="info">
        <input type="submit" name="submitVisit" value="Registruotis vizitui"/>
    </form>
    <form>
        <input type="number" name="ticket">
        <input type="submit" name="CheckTime" value="Patrikrinti laiką">
    </form>
    <table>
    <?php
    if(isset($_GET['ticket']) &&  isset($_GET['CheckTime']) && $_GET['ticket'] > -1) {
        $ticketId = $_GET['ticket'];
        $getData = "SELECT * 
FROM SERVING
INNER JOIN USERS ON SERVING.fk_USER_id=USERS._id
WHERE SERVING.serviced_check = 0 AND  SERVING.fk_USER_id = '$userId' AND SERVING._id= '$ticketId'
ORDER BY SERVING.time_submitted, SERVING.visit_time
limit 1";
        if ($res = mysqli_query($sql, $getData)) {
            while ($row = mysqli_fetch_row($res)) {
                ?>
                <tr>
                    <th><?php echo $row[0] ?></th>
                    <th><?php echo $row[1] ?></th>
                    <th><?php echo $row[3] ?></th>
                    <th><?php echo $row[11] ?></th>
                    <th><?php echo $row[12] ?></th>
                </tr>
                <?php
            }
        }
    }
    else if (isset($_GET['ticket']) && $_GET['ticket'] > -1){
        echo "<div>Skaičius per mažas</div>";
    }
    ?>
    </table>
    <?php
}
else if($_SESSION['administrator'] == true)
{
    header("Location: ./admin.php");
    exit();
}
else if ($_SESSION['administrator'] == null)
{
    header("Location: ./client-login.php");
    exit();
}
?>
</body>
</html>


