<?php
include 'session.inc';
include 'dbh.inc';
$info = "";
if(isset($_POST["register"]) && $_POST["register"] == "Registruotis")
{
    $username = mysqli_real_escape_string($sql, $_POST["username"]);
    $name = mysqli_real_escape_string($sql, $_POST["name"]);
    $last = mysqli_real_escape_string($sql, $_POST["last_name"]);
    $pass = mysqli_real_escape_string($sql, $_POST["password"]);
    if ($_POST["username"] == '' && $_POST["name"] == '' && $_POST["last_name"] == '' && $_POST["password"] == '' && $_POST["passwordCheck"] == '') {
        echo "Prašome užpildyti visus laukelius";
    } else {
        if ($_POST["passwordCheck"] === $_POST["password"]) {
            $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
            $db = "INSERT INTO USERS (username, first_name, last_name, PASSWORD)
            VALUES ('$username', '$name', '$last', '$hashedPassword')";
            if(mysqli_query($sql, $db))
            {
                $info = "Sėkminga registracija";
            }
            else
            {
                $info = "toks vartotojas su tokiu vartotojo vardu jau egzistuoja";

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
    <input type="text" name="username" placeholder="Username"/>
    <input type="text" name="name" placeholder="First Name"/>
    <input type="text" name="last_name" placeholder="Last Name"/>
    <input type="password" name="password" placeholder="Password"/>
    <input type="password" name="passwordCheck" placeholder="Check Password"/>
    <input type="submit" name="register" value="Registruotis"/>
</form>

<div>
    <?php echo $info; ?>
</div>
</body>
</html>
