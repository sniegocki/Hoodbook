<?php
    @session_start();

    if(!isset($_SESSION['loggedUser']) || $_SESSION['permission'] != 2)
    {
        header("Location: ../../app");
        exit(0);
    }

    //check passed data if exists
    if(!isset($_POST['estateName']) || !isset($_POST['estateStreet']) || !isset($_POST['estateCity']) || !isset($_POST['estateZipCode']) || !isset($_POST['estateCountry']))
    {
        $_SESSION['addEstateError'] = "Nie podano wszystkich danych";
        header("Location: ../../adminPanelEstates");
        exit(0);
    }

    require "../connect.php";

    if(!$connect->connect_error)
    {
        $sql = "INSERT INTO Estates VALUES (default, '" . $_POST['estateName'] . "', '" . $_POST['estateStreet'] . "', '" . $_POST['estateZipCode'] . "', '" . $_POST['estateCity'] . "', '" . $_POST['estateCountry'] . "', '" . date('Y-m-d H:i:s', time()) . "');";

        try
        {
            $connect->query($sql);
            $_SESSION['addEstateSuccess'] = "Pomyślnie dodano nowe osiedle";
            header("Location: ../../adminPanelEstates");
            exit(0);
        }
        catch(Exception $e)
        {
            $_SESSION['addEstateError'] = $e;
        }
    }
    else
    {
        die("Connection failed: " . $connect->connect_error);
    }

    header("Location: ../../adminPanelEstate");
?>