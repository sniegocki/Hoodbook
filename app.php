<?php
    @session_start();
    if(!isset($_SESSION['loggedUser']))
    {
        header("Location: signIn");
        exit(0);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>App</title> 
        <?php include "meta.php"; ?>
    </head>
    <body>
        Zalogowany user: 
        <?php
            echo $_SESSION['loggedUser'];
        ?>
    </body>
</html>