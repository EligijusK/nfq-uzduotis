<?php

?>
<head>

    <script src="js/jquery-3.4.1.min.js"></script>

</head>
<form action="index.php">
    <input type="submit" value="Pagrindinis puslapis"/>
</form>
<?php if(isset($_SESSION['username']) && isset($_SESSION['administrator']) && $_SESSION['administrator'] == false && isset($_SESSION['userID']))
    { ?>
        <form action="user.php">
            <input type="submit" value="Naudotojo zona" />
        </form>
        <form action="user.php">
            <input type="submit" name="LogOut" value="Atsijungti"/>
        </form>
    <?php }
    else if(isset($_SESSION['username']) && isset($_SESSION['administrator']) && $_SESSION['administrator'] == true && isset($_SESSION['userID']))
    { ?>
        <form action="admin.php">
            <input type="submit" value="Valdytojo zona" />
        </form>
        <form action="admin.php">
            <input type="submit" name="LogOut" value="Atsijungti"/>
        </form>

    <?php }
    else
        { ?>
<form action="client-login.php">
    <input type="submit" value="Vartotojo Prisijungimas" />
</form>
<form action="admin-login.php">
    <input type="submit" value="Darbuotojo prisijungimas"/>
</form>
<?php  } ?>


