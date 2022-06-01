<?php
    @session_start();

    if(!isset($_SESSION['loggedUser']) || $_SESSION['permission'] != 2)
    {
        header("Location: ../app");
        exit(0);
    }

    if($_POST['pass'] != $_POST['passRepeat'])
    {
        $_SESSION['ProfileUserPassEditError'] = "Hasła muszą byż zgodne";
        header("Location: ../../adminPanelUsers");
        exit(0);
    }

    require "../connect.php";

    //update user data
    if(!$connect->connect_error)
    {
        $passHash = password_hash($_POST['pass'], PASSWORD_BCRYPT);
        $sql = "UPDATE UsersAccount SET Password='" . $passHash . "' WHERE Id=" . $_POST['userId'] . ";";
        
        try
        {
            $connect->query($sql);
            $_SESSION['ProfileUserPassEditSuccess'] = "Hasło użytkownika o ID: " . $_POST['userId'] . " zostało zaktualizowane.";
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
        $_SESSION['profileUserUpdateError'] = "Nie udało się zaktualizować danych użytkownika o ID: " . $_POST['userId'];
    }

    header("Location: ../../adminPanelUsers");
?>
