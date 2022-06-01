<?php
    @session_start();

    if(!isset($_SESSION['loggedUser']) || $_SESSION['permission'] != 2)
    {
        header("Location: ../../app");
        exit(0);
    }

    //check passed data if exists
    if(!isset($_POST['userName']) || !isset($_POST['userSurname']) || !isset($_POST['userEmail']) || !isset($_POST['pass']) || !isset($_POST['passRepeat']))
    {
        header("Location: ../../adminPanelUsers");
        exit(0);
    }

    require "../connect.php";

    if(!$connect->connect_error)
    {
        //check if email exists in systen
        $sql = "SELECT Email FROM UsersAccount where Email='" . $_POST['userEmail'] . "';";

        $result = $connect->query($sql);

        if($result->num_rows == 0)
        {
            //check password and passwordRepeat compatibility
            if($_POST['pass'] != $_POST['passRepeat'])
            {
                $_SESSION['addUserError'] = "Hasła muszą być ze sobą zgodne. Spróbuj ponownie.";
                header("Location: ../../adminPanelUsers");
                exit(0);
            }
            
            $passHash = password_hash($_POST['pass'], PASSWORD_BCRYPT);
            //sql for UsersAccount table
            $sql = "INSERT INTO UsersAccount VALUES(default, '" . $_POST['userEmail'] . "', '" . $passHash . "', '" . date('Y-m-d H:i:s', time()) . "'," . $_POST['userPermission'] . ");";

            try
            {
                //insert data into UserAccount table
                $connect->query($sql);

                //Get new user id
                $sql = "SELECT Id FROM UsersAccount WHERE Email='" . $_POST['userEmail'] . "';";
                $result = $connect->query($sql);
                $id;

                if($result->num_rows > 0)
                {
                    $row = $result->fetch_assoc();
                    $id = $row['Id'];
                }

                //insert data into Users table
                $sql = "INSERT INTO Users VALUES(" . $id . ", '" . $_POST['userName'] . "', '" . $_POST['userSurname'] . "', '" . $_POST['userEmail'] . "'";
                if($_POST['userPhone'] != "")
                {
                    $sql .= ",'" . $_POST['userPhone'] . "'";
                }
                else
                {
                    $sql .= ",NULL";
                }
                if($_POST['userAddress'] != "")
                {
                    $sql .= ",'" . $_POST['userAddress'] . "'";
                }
                else
                {
                    $sql .= ",NULL";
                }
                if($_POST['userBirthday'] != "")
                {
                    $sql .= ",'" . $_POST['userBirthday'] . "'";
                }
                else
                {
                    $sql .= ",NULL";
                }
                $sql .= ");";
;
                try
                {
                    $connect->query($sql);
                }
                catch(Exception $e)
                {
                    $_SESSION['addUserError'] = $e;
                    header("Location: ../../adminPanelUsers");
                    exit(0);
                }

                $_SESSION['addUserSuccess'] = "Rejestracja się powiodła! Zaloguj się.";
            }
            catch(Exception $e)
            {
                $_SESSION['addUserError'] = $e;
                 header("Location: ../../adminPanelUsers");
                 exit(0);   
            }

            header("Location: ../../adminPanelUsers");
            exit(0);
        }
        else
        {
            $_SESSION['addUserError'] = "Użytkownik o podanym adresie email już istnieje.";
            header("Location: ../../adminPanelUsers");
            exit(0);
        }
    }
    else
    {
        die("Connection failed: " . $connect->connect_error);
    }

?>