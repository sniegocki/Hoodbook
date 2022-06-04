<?php

    //signIn script
    if(!isset($_POST['email']) || !isset($_POST['pass']))
    {
        header("Location: javascript:history.go(-1)");
        exit(0);
    }

    @session_start();
    require "connect.php";

    if(!$connect->connect_error)
    {
        $sql = "SELECT Id, Email, Password, Permission FROM UsersAccount WHERE Email='" . $_POST['email'] . "';";

        $result = $connect->query($sql);

        //user exists
        if($result->num_rows == 1)
        {
            $row = $result->fetch_assoc();
            
            //check if password is valid
            if(password_verify($_POST['pass'], $row['Password']))
            {
                //check if user is not banned
                if($row['Permission'] == 0)
                {
                    $_SESSION['signIn_error'] = "Twoje konto jest zablokowane";
                    header("Location: ../signIn");
                    exit(0);
                }
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
        else
        {
            $_SESSION['signIn_error'] = "Niepoprawne dane logowania";

                header("Location: ../signIn");
                exit(0);
        }
    }
    else 
    {
        die("Connection failed: " . $connect->connect_error);
    }
?>