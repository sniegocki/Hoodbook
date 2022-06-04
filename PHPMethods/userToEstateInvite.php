<?php
    //user send request to join estate

    @session_start();

    if(!isset($_SESSION['loggedUser']))
    {
        header("Location: ../app");
        exit(0);
    }

    require "connect.php";

    // begin
    $idTarget = $_POST['idTarget'];
    $idSender = $_POST['idSender'];
    $SendDate = date("Y-m-d H:i:s");
    $Status = "Send";

    if(!$connect->connect_error)
    {
        $sql = "INSERT INTO UserToEstateInvites (Id, IdSender, IdTarget, Status, SendDate) VALUES (DEFAULT, '".$idSender."', '".$idTarget."', 'Send', '".$SendDate."');";
        
        try
        {
            $connect->query($sql);
            $_SESSION['UserToEstateInviteSuccess'] = "Pomyślnie złożono aplikację do osiedla.";
        }
        catch(Exception $e)
        {
            echo $e;
            $_SESSION['UserToEstateInviteError'] = "Nie udało się wysłać aplikacji do osiedla.<br><small>Spróbuj ponownie później.</small>";
        }
    }
    else
    {
        echo "Database connection error";
    }

    header("Location: ../browseEstates");
?>