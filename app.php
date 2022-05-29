<?php
    @session_start();
    if(!isset($_SESSION['loggedUser']))
    {
        header("Location: signIn");
        exit(0);
    }
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <title>Hoodbook - Strona Główna, aplikacja do zarządzania osiedlem.</title> 
        <?php include "meta.php"; ?>
    </head>

    <body>
        <?php require "sidebar.php"; ?>
        <section class="home-section">
            <div class="home-content p-3 d-flex flex-column">
                Zalogowany user: 
                <?php
                    echo $_SESSION['loggedUser'];
                ?>
            </div>
        </section>
    </body>
</html>