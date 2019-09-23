<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "root";
$dbname = "NFQ";

$sql = new mysqli($dbhost, $dbuser, $dbpassword);

$createDB = "
    CREATE DATABASE IF NOT EXISTS NFQ; ";
if(mysqli_query($sql, $createDB))
{
    $selectDb="USE $dbname";
    if(mysqli_query($sql, $selectDb)) {
    }

}


function Login($username, $password, $cnt, $admin, $table, $sql)
{
    if($cnt === 3) {
        if($admin == true) {
            $loginRequest = "SELECT * FROM `$table`
    WHERE admin_user = '$username' ";
        }
        else if($admin == false)
        {
            $loginRequest = "SELECT * FROM `$table`
    WHERE username = '$username' ";
        }
        if ($res = mysqli_query($sql, $loginRequest)) {

            while ($row = mysqli_fetch_row($res)) {
                if((password_verify ($password, $row[5]) && $admin == true) || (password_verify ($password, $row[4]) && $admin == false))
                {
                    $_SESSION['userID'] = $row[0];
                    $_SESSION['username'] = $row[1];
                    $_SESSION['administrator'] = $admin;
                    if($admin == false) {
                        header("Location: ./user.php?prisijunge");
                    }
                    else{
                        header("Location: ./admin.php?prisijunge");
                    }
                    exit;
                }
            }
        }
    }
    else
    {
        echo "Užpildykite visus laukus";
    }
}

function checkTime($sql, $userId)
{
    if (isset($_SESSION['ticketId']) && isset($_SESSION['username']) && isset($_SESSION['administrator']) && isset($_SESSION['userID']) && $_SESSION['administrator'] == false) {
        $ticket = $_SESSION['ticketId'];
        $time = array(
            'data' => "",
            'res' => ""
        );
        $acurateTime = "SELECT visit_time FROM SERVING
WHERE serviced_check = 0 AND _id < '$ticket' ";
        if ($res = mysqli_query($sql, $acurateTime)) {
            if ($res->num_rows > 0) {
                $time['data'] = 0;
                while ($row = mysqli_fetch_row($res)) {
                    $time['data'] += $row[0];
                    $time['res'] = true;
                }
            }else if($res->num_rows == 0)
            {
                $time['res'] = false;
                $time['data'] = "Atėjo jūsu eilė";
            }
        }


        return $time;
    }

}

function AverageTime($sql)
{
    $average = new DateTime();
    $sqlGetTimeStamps = "SELECT time_accepted, time_finished FROM SERVING WHERE serviced_check = 1 ORDER BY time_submitted DESC";
    if ($res2 = mysqli_query($sql, $sqlGetTimeStamps)) {
        if($res2->num_rows > 0){
            while ($row2 = mysqli_fetch_row($res2))
            {
                $visitStart = new DateTime($row2[0]);
                $visitEnd = new DateTime($row2[1]);
                $difference = $visitStart->diff($visitEnd);
                $timeDiff = $difference->format('%H:%I:%S');
                $average = $average + strtotime($timeDiff);
                //echo date("H:i:s",$average) ."\n";
            }
            $average = $average / $res2->num_rows;
        }
    }
    return $average;
}

function LastTime($sql, $userId)
{
    $time = null;
    $sqlGetTimeStamps = "SELECT time_accepted, time_finished FROM SERVING WHERE serviced_check = 1 AND fk_ADMIN_id = '$userId' ORDER BY time_submitted DESC LIMIT 1";
    if ($res2 = mysqli_query($sql, $sqlGetTimeStamps)) {
        if($res2->num_rows > 0){
            while ($row2 = mysqli_fetch_row($res2))
            {
                $visitStart = new DateTime($row2[0]);
                $visitEnd = new DateTime($row2[1]);
                $difference = $visitStart->diff($visitEnd);
                $timeDiff = $difference->format('%H:%I:%S');
                $time = $timeDiff;
            }
        }
    }
    return $time;
}