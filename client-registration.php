<?php
include 'dbh.inc';
$username = $_POST["username"];
$name = $_POST["name"];
$last = $_POST["last_name"];
$pass = $_POST["password"];

if($_POST["register"] == "Registruotis")
{
    if ($_POST["username"] == '' && $_POST["name"] == '' && $_POST["last_name"] == '' && $_POST["password"] == '' && $_POST["passwordCheck"] == '') {
        echo "Prašome užpildyti visus laukelius";
    } else {
        if ($_POST["passwordCheck"] === $_POST["password"]) {
            echo $last;
            $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
            $db = "INSERT INTO USERS (username, first_name, last_name, PASSWORD)
            VALUES ('$username', '$name', '$last', '$hashedPassword')";
            if(mysqli_query($sql, $db))
            {
                echo "Sėkminga registracija";
            }
            else
            {
                echo "toks vartotojas su tokiu vartotojo vardu jau egzistuoja";
            }
        }
        else {

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
<?php include 'header.inc'?>

<form method="post" action="">
    <input type="text" name="username"/>
    <input type="text" name="name"/>
    <input type="text" name="last_name"/>
    <input type="password" name="password"/>
    <input type="password" name="passwordCheck"/>
    <input type="submit" name="register" value="Registruotis"/>
</form>

</body>
</html>
