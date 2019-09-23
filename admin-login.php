<?php
include 'session.inc';
include "dbh.inc";
include 'header.inc';

$cnt = 0;
foreach ($_POST as $key => $value) {
    if (isset($_POST['' . $key . '']) && $_POST['' . $key . ''] != " " && $_POST['' . $key . ''] != "") {
        $cnt = $cnt + 1;
    }
}

if(isset($_POST['Login'])) {
    $password = $_POST["password"];
    $username = $_POST["username"];
    Login($username, $password, $cnt, true, "ADMINS", $sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
</head>
<body>
<?php
    if($_SESSION['username'] == null && $_SESSION['administrator'] == null && $_SESSION['userID'] == null)
    {
?>
<form action="" method="post">
    <input type="text" name="username"/>
    <input type="password" name="password"/>
    <input type="submit" name="Login" value="Login"/>
</form>
<?php }
    else{
        header("Location: ./admin.php");
    }?>
</body>
</html>
