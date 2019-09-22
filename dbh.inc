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
    if($sql->select_db($dbname) != null)
    {
//        $table = "
//CREATE TABLE IF NOT EXISTS ADMINS (
//    _id INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
//    admin_user VARCHAR(30) NOT NULL UNIQUE,
//    first_name VARCHAR(30) NOT NULL,
//    last_name VARCHAR (30),
//    email VARCHAR(30) NOT NULL UNIQUE,
//    password VARCHAR(256));
//
//    CREATE TABLE IF NOT EXISTS USERS (
//    _id INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
//    username VARCHAR(30) NOT NULL UNIQUE,
//    first_name VARCHAR(30) NOT NULL,
//    last_name VARCHAR (30),
//    password VARCHAR(256));
//

//    CREATE TABLE IF NOT EXISTS SERVING (
//    _id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//    servicing_info VARCHAR(256),
//    serviced_check int(1) NOT NULL,
//    visit_time int(6) NOT NULL,
//    time_submitted TIMESTAMP NOT NULL,
//    time_accepted TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
//    time_finished TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
//    fk_USER_id int(11) NOT NULL,
//    fk_ADMIN_id int(11));
//
//    ALTER TABLE `SERVING`
//    ADD CONSTRAINT `serviced` FOREIGN KEY (`fk_USER_id`) REFERENCES `USERS` (`_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
//    ADD CONSTRAINT `servicing` FOREIGN KEY (`fk_ADMIN_id`) REFERENCES `ADMINS` (`_id`) ON DELETE CASCADE ON UPDATE RESTRICT;
//        ";

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
                        header("Location: ./user.php");
                    }
                    else{
                        header("Location: ./admin.php");
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