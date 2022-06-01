<?php

    @session_start();

    if(!isset($_SESSION['loggedUser']) || $_SESSION['permission'] != 2)
    {
        header("Location: ../../app");
        exit(0);
    }

    //check passed data if exists
    if(!isset($_POST['estateId']) || !isset($_POST['estateName']) || !isset($_POST['estateStreet']) || !isset($_POST['estateCity']) || !isset($_POST['estateZipCode']) || !isset($_POST['estateCountry']))
    {
        $_SESSION['editEstateUser'] = "Nie podano wszystkich danych";
        header("Location: ../../adminPanelEstates");
        exit(0);
    }

    require "../connect.php";

    if(!$connect->connect_error)
    {
        $sql = "UPDATE Estates SET Name='" . $_POST['estateName'] . "', Street='" . $_POST['estateStreet'] . "', ZipCode='" . $_POST['estateZipCode'] . "', City='" . $_POST['estateCity'] . "', Country='" . $_POST['estateCountry'] . "' WHERE Id=" . $_POST['estateId'] . ";";

        try
        {
            $connect->query($sql);
            $_SESSION['editEstateSuccess'] = "Osiedle o ID: " . $_POST['estateId'] . " zostało zmodyfikowane.";
            header("Location: ../../adminPanelEstates");
            exit(0);
        }
        catch(Exception $e)
        {
            $_SESSION['editEstateError'] = $e;
        }
    }
    else
    {
        die("Connection failed: " . $connect->connect_error);
    }

    header("Location: ../../adminPanelEstate");
?>