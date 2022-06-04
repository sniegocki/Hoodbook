<?php

    //edit user profile as user
    @session_start();

    if(!isset($_SESSION['loggedUser']))
    {
        header("Location: ../app");
        exit(0);
    }

    //check if required data - name and surname was passsed 
    if(!isset($_POST['userName']) || !isset($_POST['userSurname']))
    {
        header("Location: ../profile");
        exit(0);
    }

    require "connect.php";

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
            $sql .= ", Birthday='" . $_POST['userBirthday'] . "'";
        }

        $sql .= " WHERE Id=" . $_SESSION['loggedUser'] . ";";

        try
        {
            $connect->query($sql);
            $_SESSION['profileUserUpdateSuccess'] = "Dane zostały zaktualizowane";
        }
        catch(Exception $e)
        {
            echo $e;
            $_SESSION['profileUserUpdateError'] = "Nie udało się zaktualizować danych";
        }
    }
    else
    {
        echo "Database connection error";
        $_SESSION['profileUserUpdateError'] = "Nie udało się zaktualizować danych";
    }

    header("Location: ../profile");
?>
