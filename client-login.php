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
if(isset($_POST["Login"])) {
    Login($username, $password, $cnt, false, "USERS", $sql);
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
<a href="client-registration.php">Nesate prisiregistravę? Tai galite padaryti ČIA</a>
<?php }else{
        header("Location: ./user.php");
        exit();
    } ?>
</body>
</html>

