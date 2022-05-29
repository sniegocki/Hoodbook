<?php
    @session_start();

    if(!isset($_SESSION['loggedUser']))
    {
        header("Location: signIn");
        exit(0);
    }

    if(!isset($_GET['user']))
    {
        header("Location: javascript:history.go(-1)");
    }
    
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoodBook | <?php echo $userName . " " . $userSurname; ?></title> 
    <?php include "meta.php"; ?>
</head>
<body>
    <?php

        require "PHPMethods/connect.php";

        if(!$connect->connect_error)
        {
            $sql = "SELECT * FROM Users WHERE Id=" . $_GET['user'] . ";";

            if($result = $connect->query($sql))
            {
                if($result->num_rows == 1)
                {
                    $row = $result->fetch_assoc();
                    $userName = $row['Name'];
                    $userSurname = $row['Surname'];
                    $userEmail = $row['Email'];
                    $userPhone = $row['Phone'];
                    $userAddress = $row['Address'];
                    $userBirthday = $row['Birthday'];
                    //User name
                    echo "<p class='profile-name'>Imię: <span>" . $userName . "</span></p>";
                    //User surname
                    echo "<p class='profile-surname'>Nazwisko: <span>" . $userSurname . "</span></p>";
                    //User email
                    echo "<p class='profile-email'>Email: <span>" . $userEmail . "</span></p>";
                    //User phone
                    echo "<p class='profile-phone'>Telefon: <span>" . $userPhone . "</span></p>";
                    //User address
                    echo "<p class='profile-surname'>Adres: <span>" . $userAddress . "</span></p>";
                    //User birthday
                    echo "<p class='profile-birthday'>Urodziny: <span>" . $userBirthday . "</span></p>"; 
                    //User avatar
                    $avatarPath = "img/avatars/" . $_SESSION['loggedUser'] . ".png";

                    if(file_exists($avatarPath))
                    {
                        echo "<div class='avater-place'><img class='profile-avatar' src='" . $avatarPath . "' alt='Zdjęcie profilowe'></div>";
                    }
                    else
                    {
                        echo "<div class='avater-place'><img class='profile-avatar' src='" . "img/avatars/avatarPlaceholder.png" . "' alt='Zdjęcie profilowe'></div>";
                    }
                }
                else
                {
                    //Do wystylizowania PK
                    //dodałbym jakis obrazek, że nie ma usera. Coś jak 404.
                    //do tego przycisk "Powrót do aplikacji /app"
                    echo "Taki użytkownik nie istnieje";
                }
            }
            else
            {
                echo "Database query error has occurred";
            }
        }
        else
        {
            echo "Bład w połączeniu z bazą";
        }

    ?>
</body>
</html>