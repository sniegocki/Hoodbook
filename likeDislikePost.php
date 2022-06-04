<?php
    //like, dislike post
    //need logged user, postid, action type

    @session_start();

    if(!isset($_SESSION['loggedUser']) || !isset($_GET['postId']) || !isset($_GET['estateId']))
    {
        header("Location: app");
        exit(0);
    }

    require "PHPMethods/connect.php";

    //check if like exists
    $preSql = "SELECT * FROM ReactionsPosts WHERE IdAuthor=" . $_SESSION['loggedUser'] . " AND IdPost=" . $_GET['postId'] . ";";
    $result = $connect->query($preSql);
    //dislike
    if($result->num_rows > 0)
    {
        $deleteSql = "DELETE FROM ReactionsPosts WHERE IdAuthor=" . $_SESSION['loggedUser'] . " AND IdPost=" . $_GET['postId'] . ";";

        $connect->query($deleteSql);
    }
    //like
    else
    {
        $addSql = "INSERT INTO ReactionsPosts VALUES(default, " . $_GET['postId'] . ", " . $_SESSION['loggedUser'] . ");";

        $connect->query($addSql);
    }

    $href = "Location: myEstate?estate=" . $_GET['estateId'];
    header($href);
?>