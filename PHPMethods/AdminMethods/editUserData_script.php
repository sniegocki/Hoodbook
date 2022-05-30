<?php
    @session_start();

    if(!isset($_SESSION['loggedUser']) || $_SESSION['permission'] != 2)
    {
        header("Location: ../app");
        exit(0);
    }

    require "../connect.php";

    //update user data
    if(!$connect->connect_error)
    {
        $sql = "UPDATE Users SET Name='" . $_POST['userName'] . "', Surname='" . $_POST['userSurname'] . "'";
        //multiple check for optional data - Phone, Address, Birthday and add to update query
        if(isset($_POST['userPhone']))
        {
            $sql .= ", Phone='" . $_POST['userPhone'] . "'";
        }
        if(isset($_POST['userAddress']))
        {
            $sql .= ", Address='" . $_POST['userAddress'] . "'";
        }
        if(isset($_POST['userBirthday']))
        {
            if($_POST['userBirthday'] == "")
                $sql .= ", Birthday=null";
            else
                $sql .= ", Birthday='" . $_POST['userBirthday'] . "'";
        }

        $sql .= " WHERE Id=" . $_POST['userId'] . ";";
        $sql2 = "UPDATE UsersAccount SET Permission='" . $_POST['userPermission'] . "' WHERE Id=" . $_POST['userId'];

        try
        {
            $connect->query($sql);
            $connect->query($sql2);
            $_SESSION['profileUserUpdateSuccess'] = "Dane użytkownika o ID: " . $_POST['userId'] . " zostały zaktualizowane";
        }
        catch(Exception $e)
        {
            echo $e;
            $_SESSION['profileUserUpdateError'] = "Nie udało się zaktualizować danych użytkownika o ID: " . $_POST['userId'];
        }
    }
    else
    {
        echo "Database connection error";
        $_SESSION['profileUserUpdateError'] = "Nie udało się zaktualizować danych użytkownika o ID: " . $_POST['userId'];
    }

    header("Location: ../../adminPanel");
?>
