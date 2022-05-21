<?php

    if(!isset($_POST['email']) || !isset($_POST['pass']))
    {
        $previous = "javascript:history.go(-1)";
        if(isset($_SERVER['HTTP_REFERER'])) {
            $previous = $_SERVER['HTTP_REFERER'];
        }

        header("Location: ../signIn");
        exit(0);
    }

    @session_start();
    require "connect.php";

    if(!$connect->connect_error)
    {
        $sql = "SELECT Id, Email, Password, Permission FROM UsersAccount WHERE Email='" . $_POST['email'] . "';";

        $result = $connect->query($sql);

        if($result->num_rows == 1)
        {
            $row = $result->fetch_assoc();
    
            if(password_verify($_POST['pass'], $row['Password']))
            {
                $_SESSION['loggedUser'] = $row['Id'];
                $_SESSION['permission'] = $row['Permission'];

                header("Location: ../app");
                exit(0);
            }
            else
            {
                $_SESSION['signIn_error'] = "Niepoprawne dane logowania";

                header("Location: ../signIn");
                exit(0);
            }
        }
    }
    else 
    {
        die("Connection failed: " . $connect->connect_error);
    }
?>