<?php

    @session_start();

    if(!isset($_SESSION['loggedUser']) || $_SESSION['permission'] != 2)
    {
        header("Location: app");
        exit(0);
    }

    if(!isset($_GET['idapp']) || !isset($_GET['iduser']) || !isset($_GET['idestate']) || !isset($_GET['type']))
    {
        $_SESSION['changeAppError'] = "Nie podano wszystkich danych w GET";
        header("Location: ../../adminPanelApplications");
        exit(0);
    }

    https://localhost/HoodBook/PHPMethods/AdminMethods/changeApplicationStatus?idapp=1&iduser=13&idestate=1&type=2

    require "../connect.php";

    if(!$connect->connect_error)
    {
        if($_GET['type'] == 1)
        {
            $action = "Rejected";
        }
        else
        {
            $action = "Accepted";
        }

        $sql = "UPDATE UserToEstateInvites SET Status='$action' WHERE Id=" . $_GET['idapp'] . ";";

        try
        {
            $connect->query($sql);

            $sql2 = "SELECT * FROM Estates_Users WHERE IdUser=" . $_GET['iduser'] . " AND IdEstate=" . $_GET['idestate'] . ";";
            $result = $connect->query($sql2);
            $sql3 = null;
            if($result->num_rows==1)
            {
                if($_GET['type'] == 1)
                {
                    $sql3 = "DELETE FROM Estates_Users WHERE IdUser=" . $_GET['iduser'] . " AND IdEstate=" . $_GET['idestate'] . ";";
                }
            }
            else
            {
                $sql3 = "INSERT INTO Estates_Users VALUES(" . $_GET['iduser'] . ", " . $_GET['idestate'] . ", 1);";
            }

            if($sql3 != null)
            {
                $connect->query($sql3);
            }

            $_SESSION['changeAppSuccess'] = "Zgłoszenie o ID: " . $_GET['idapp'] . " zostało zaktualizowane";
            header("Location: ../../adminPanelApplications");
            exit(0);
        }
        catch(Exception $e)
        {
            $_SESSION['changeAppError'] = $e;
        }
    }
    else
    {
        die("Connection failed: " . $connect->connect_error);
    }

    header("Location: ../../adminPanelApplications");

?>