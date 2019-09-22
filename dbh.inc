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
//    fk_USER_id int(11) NOT NULL,
//    fk_ADMIN_id int(11) NOT NULL,
//    KEY `serviced` (`fk_USER_id`),
//    KEY `servicing` (`fk_ADMIN_id`));
//
//    ALTER TABLE `SERVING`
//    ADD CONSTRAINT `serviced` FOREIGN KEY (`fk_USER_id`) REFERENCES `USERS` (`_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
//    ADD CONSTRAINT `servicing` FOREIGN KEY (`fk_ADMIN_id`) REFERENCES `ADMINS` (`_id`) ON DELETE CASCADE ON UPDATE RESTRICT;
//
//    ";

    }
}

