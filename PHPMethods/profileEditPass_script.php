<?php

    @session_start();

    if(!isset($_SESSION['loggedUser']))
    {
        header("Location: ../app");
        exit(0);
    }

    if(!isset($_POST['pass']) || !isset($_POST['passRepeat']))
    {
        header("Location: ../profile");
        exit(0);
    }

    if($_POST['pass'] != $_POST['passRepeat'])
    {
        $_SESSION['profileEditPassError'] = "Hasła muszą byż zgodne";
        header("Location: ../profile");
        exit(0);
    }

    require "connect.php";

    if(!$connect->connect_error)
    {
        $passHash = password_hash($_POST['pass'], PASSWORD_BCRYPT);
        $sql = "UPDATE UsersAccount SET Password='" . $passHash . "' WHERE Id=" . $_SESSION['loggedUser'] . ";";
        
        try
        {
            $connect->query($sql);
            $_SESSION['ProfileuserPassEditSuccess'] = "Hasło zostało zaktualizowane";
        }
        catch(Exception $e)
        {
            echo $e;
            $_SESSION['ProfileUserPassEditError'] = "Nie udało się zaktualizować hasła";
        }
    }
    else
    {
        echo "Database connection error";
    }

    header("Location: ../profile");
?>