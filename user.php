<?php
include "session.inc";
include 'dbh.inc';
include 'header.inc';
$userId = $_SESSION['userID'];

if(isset($_GET['LogOut']))
{
    $_SESSION['username'] = null;
    $_SESSION['administrator'] = null;
    $_SESSION['userID'] = null;
    $_SESSION['LogedIn'] = false;
    $_SESSION['ticketId'] = null;
    $userId = null;
    header( "Location: ./client-login.php");
}

if(isset($_SESSION['username']) && isset($_SESSION['administrator']) && $_SESSION['administrator'] == false && isset($_SESSION['userID'])) {

    if ($_SESSION['ticketId'] == null) {

        $getTicketNumber = "SELECT _id FROM SERVING WHERE fk_USER_id = '$userId' AND serviced_check = '0' LIMIT 1";
        if ($res = mysqli_query($sql, $getTicketNumber)) {
            if ($res->num_rows > 0) {

                while ($row = mysqli_fetch_row($res)) {
                    $_SESSION['ticketId'] = $row[0];
                }
            }
        }

    }

    if (isset($_GET['submitVisit']) && $_GET['time'] <= 0) {
        echo "vizito laikas turi užtrukti ilgiau negu 0 minučių";
    } else if (isset($_GET['submitVisit']) && $_GET['time'] > 0) {
        $info = $_GET['info'];
        $visitTime = $_GET['time'];
        $checkIfInsert = "SELECT serviced_check, fk_USER_id FROM SERVING
WHERE fk_USER_id = '$userId' AND serviced_check = 0";
        if ($res = mysqli_query($sql, $checkIfInsert)) {
            if ($res->num_rows == 0) {
                $insertVisit = "INSERT INTO SERVING (servicing_info, serviced_check, visit_time, fk_USER_id)
            VALUES ('$info', '0', '$visitTime', '$userId')";
                if (mysqli_query($sql, $insertVisit)) {
                    header("Location: ./user.php?addedVisit");
                }
            } else {
                echo "Jūsų vizitas jau suplanuotas";
            }
        }
    }

    if(isset($_POST['cancelVisit']))
    {
        $removeFromWaiting = "DELETE FROM SERVING WHERE fk_USER_id = '$userId' AND serviced_check = 0";
        if(mysqli_query($sql, $removeFromWaiting))
        {
            $_SESSION['ticketId'] = null;
            echo "visitas panaikintas";
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
    <div>
        <?php if(isset($_SESSION['ticketId'])) { echo "Jūsu laukimo biletas: " . $_SESSION['ticketId']; } ?>
    </div>
    <div>
        <form method="post">
            <input type="submit" name="cancelVisit" value="Atšaukti Vizitą">
        </form>
    </div>
    <div>
            <form >
                <input type="number" name="ticket">
                <input type="submit" name="CheckTime" value="Patrikrinti laiką">
            </form>
    </div>
<?php
if(isset($_GET['ticket']) &&  isset($_GET['CheckTime']) && $_GET['ticket'] > -1 && isset($_SESSION['ticketId'])) { ?>
    <div class="accurateTime">
        <?php
        $returnData = checkTime($sql, $userId);
        if($returnData['res'] == true)
        {
        echo "laukimo laikas: ". $returnData['data'] . "(min)";
        }
        else if($returnData['res'] == false){
            echo "laukimo laikas: ". $returnData['data'];
        } ?>
    </div>
<?php } ?>

<?php
if(isset($_GET['ticket']) &&  isset($_GET['CheckTime']) && $_GET['ticket'] > -1 && isset($_SESSION['ticketId'])) {
    ?> <div class="approximateTime"> <?php
    $time = new DateTime();
    $ticket = $_GET['ticket'];
    $countCheck = "SELECT COUNT(serviced_check) FROM SERVING
WHERE serviced_check = 0 AND _id < '$ticket'
GROUP BY serviced_check";
    if($res = mysqli_query($sql, $countCheck))
    {
        if($res->num_rows > 0)
        {
            while ($row = mysqli_fetch_row($res))
            {
                $time = $row[0] * AverageTime($sql);
                echo "Vidutinis laukimo laikas pagal specialista: ". date("H:i:s",$time) . " (Valandos:Minutes:Sekundes)";
            }
        }
    }
    ?> </div> <?php
}
else if (isset($_GET['ticket']) && $_GET['ticket'] > -1 && isset($_SESSION['ticketId'])){
    echo "<div>Skaičius per mažas</div>";
}

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
<footer>
    <script src="js/UpdateTime.js"></script>
</footer>
</html>


