<?php
    //delete comment script
    //need logged user, comment id, estate id

    @session_start();

    if(!isset($_SESSION['loggedUser']) || !isset($_GET['commentId']) || !isset($_GET['estateId']))
    {
        header("Location: app");
        exit(0);
    }

    require "PHPMethods/connect.php";

    //get post creator(user) id
    $preSql = "SELECT * FROM Comments WHERE Id=" . $_GET['commentId'] . ";";
    $result = $connect->query($preSql);
    $userId;
    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $userId = $row['IdAuthor'];
    }

    //check if bost belongs to user or admin call method
    if($userId != $_SESSION['loggedUser'] && $_SESSION['permission'] != 2)
    {
        header("Location: javascript:history.go(-1)");
        exit(0);
    }

    $sql = "DELETE FROM Comments WHERE Id=" . $_GET['commentId'] . ";";

    try 
    {
        $connect->query($sql);
        $_SESSION['deleteCommentSuccess'] = "Pomyślnie usunięto komentarz.";
    }
    catch(Exception $e)
    {
        $_SESSION['deleteCommentError'] = $e;
    }

    $href = "Location: myEstate?estate=" . $_GET['estateId'];
    header($href);
?>