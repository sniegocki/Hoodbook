<?php
    //check passed data if exists
    if(!isset($_POST['name']) || !isset($_POST['surname']) || !isset($_POST['email']) || !isset($_POST['pass']) || !isset($_POST['passRepeat']))
    {
        header("Location: ../signUp");
        exit(0);
    }

    @session_start();
    require "connect.php";

    if(!$connect->connect_error)
    {
        //check if email exists in systen
        $sql = "SELECT Email FROM UsersAccount where Email='" . $_POST['email'] . "';";

        $result = $connect->query($sql);

        if($result->num_rows == 0)
        {
            //check password and passwordRepeat compatibility
            if($_POST['pass'] != $_POST['passRepeat'])
            {
                $_SESSION['signUp_error'] = "Hasła muszą być ze sobą zgodne. Spróbuj ponownie.";
                header("Location: ../signUp");
                exit(0);
            }
            
            $passHash = password_hash($_POST['pass'], PASSWORD_BCRYPT);
            //sql for UsersAccount table
            $sql = "INSERT INTO UsersAccount VALUES(default, '" . $_POST['email'] . "', '" . $passHash . "', '" . date('Y-m-d H:i:s', time()) . "', 1);";

            try
            {
                //insert data into UserAccount table
                $connect->query($sql);

                //Get new user id
                $sql = "SELECT Id FROM UsersAccount WHERE Email='" . $_POST['email'] . "';";
                $result = $connect->query($sql);
                $id;

                if($result->num_rows > 0)
                {
                    $row = $result->fetch_assoc();
                    $id = $row['Id'];
                }

                //insert data into Users table
                $sql = "INSERT INTO Users VALUES(" . $id . ", '" . $_POST['name'] . "', '" . $_POST['surname'] . "', '" . $_POST['email'] . "', NULL, NULL, NULL);";
                try
                {
                    $connect->query($sql);
                }
                catch(Exception $e)
                {
                    $_SESSION['signUp_error'] = $e;
                    header("Location: ../signUp");
                    exit(0);
                }

                $_SESSION['signUp_success'] = "Rejestracja się powiodła! Zaloguj się.";
            }
            catch(Exception $e)
            {
                $_SESSION['signUp_error'] = $e;
                 header("Location: ../signUp");
                 exit(0);   
            }

            header("Location: ../signIn");
            exit(0);
        }
        else
        {
            $_SESSION['signUp_error'] = "Użytkownik o podanym adresie email już istnieje.";
            header("Location: ../signUp");
            exit(0);
        }
    }
    else
    {
        die("Connection failed: " . $connect->connect_error);
    }

?>