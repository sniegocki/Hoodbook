<?php
    //add post
    @session_start();

    if(!isset($_SESSION['loggedUser']))
    {
        header("Location: ../app");
        exit(0);
    }

    $postAuthor = $_SESSION['loggedUser'];
    $postEstate = $_POST['toEstate'];
    // $postTitle = $_POST['postTitle'];
    $postDate = date("Y-m-d H:i:s");
    $postContent = nl2br(strip_tags($_POST['postContent'], "<br>"));
    $postType = "Text";

    require "connect.php";

    //insert data into Users table
    $sql = "INSERT INTO Posts (Id, IdEstate, IdAuthor, Date, TextContent, Type) VALUES (DEFAULT, '".$postEstate."', '".$postAuthor."', '".$postDate."', '".$postContent."', '".$postType."')";

    try {
        $connect -> query($sql);
        $_SESSION['addPostSuccess'] = "Pomyślnie dodano post.";
        header("Location: ../myEstate?estate=".$postEstate."");

    } catch(Exception $e) {
        $_SESSION['addPostError'] = $e;
        header("Location: ../myEstate?estate=".$postEstate."");
        exit(0);
    }

    
    


?>