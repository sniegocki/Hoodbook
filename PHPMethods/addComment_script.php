<?php

    //Add commment to post script
    //Need logged user, post id, comment text and estateId to get back to previous page
    @session_start();

    if(!isset($_SESSION['loggedUser']) || !isset($_POST['postId']) || !isset($_POST['postComment']) || !isset($_POST['estateId']))
    {
        header("Location: javascript:history.go(-1)");
        exit(0);
    }


    require "connect.php";

    $sql = "INSERT INTO Comments VALUES(default, " . $_POST['postId'] . ", " . $_SESSION['loggedUser'] . ", '" . date('Y-m-d H:i:s', time()) . "', '" . $_POST['postComment'] . "');";

    $href= "Location: ../myEstate?estate=" . $_POST['estateId'];

    try {
        $connect -> query($sql);
        $_SESSION['addCommentPostSuccess'] = "Pomyślnie dodano komentarz.";
        header($href);

    } catch(Exception $e) {
        $_SESSION['addCommentPostError'] = $e;
        header($href);
        exit(0);
    }

    
    


?>