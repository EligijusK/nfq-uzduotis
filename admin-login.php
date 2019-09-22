<?php

include "dbh.inc";
include 'header.inc';
$username = $_POST["username"];
$password = $_POST["password"];
$cnt = 0;

foreach ($_POST as $key => $value) {
    if (isset($_POST['' . $key . '']) && $_POST['' . $key . ''] != " " && $_POST['' . $key . ''] != "") {
        $cnt = $cnt + 1;
    }
}

if($cnt === 2) {
    $loginRequest = "SELECT * FROM ADMINS
    WHERE admin_user = '$username' ";
    if ($res = mysqli_query($sql, $loginRequest)) {

        while ($row = mysqli_fetch_row($res)) {
            if(password_verify ($password, $row[5]))
            {
                $_SESSION['username'] = $row[1];
                $_SESSION['administrator'] = true;
                header("Location: ./user.php");
                exit;
            }
        }
    }
}
else
{
    echo "Užpildykite visus laukus";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
</head>
<body>

<form action="" method="post">
    <input type="text" name="username"/>
    <input type="password" name="password"/>
    <input type="submit" value="Login"/>
</form>
</body>
</html>
