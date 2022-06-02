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
    <title>HoodBook | Użytkownik</title> 
    <?php include "meta.php"; ?>
</head>
<body>

    <?php require "sidebar.php"; ?>

<section class="home-section bg-light">
    <div class="home-content p-3 justify-content-center">

        <div class="col-12 col-lg-10 col-xl-8 bg-white shadow-sm">
            <div class="d-flex rounded justify-content-center flex-wrap">
                
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
                    $userId = $row['Id'];
                    $userName = $row['Name'];
                    $userSurname = $row['Surname'];
                    $userEmail = $row['Email'];
                    $userPhone = $row['Phone'];
                    $userAddress = $row['Address'];
                    $userBirthday = $row['Birthday'];

                    //User avatar
                    $avatarPath = "img/avatars/" . $userId. ".png";

                    if (file_exists($avatarPath))
                    {
                        echo '<div class="col-12 col-lg-4 d-flex justify-content-center p-3 bg-white">';
                        echo "<div class='avatar-place'>
                            <img class='img-fluid' src='" . $avatarPath . "' alt='Zdjęcie profilowe'>
                        </div>";
                        
                    }
                    else
                    {
                        echo '<div class="col-12 col-lg-4 d-flex justify-content-center p-3 bg-white">';
                        echo "<div class='avatar-place'>
                            <img class='profile-avatar' src='" . "img/avatars/avatarPlaceholder.png" . "' alt='Zdjęcie profilowe'>
                        </div>";
                    }

                    echo '</div>';

                    echo '<div class="col-12 col-lg-8 d-flex flex-column justify-content-center fs-5 bg-white px-3">';

                        echo '<h4 class="mb-3">Profil użytkownika:</h4>';

                        //User name
                        echo "<p class='text-muted mb-1 pb-2 border-bottom'>Imię: <span>" . $row['Name'] . "</span></p>";
                        //User surname
                        echo "<p class='text-muted mb-1 pb-2 border-bottom'>Nazwisko: <span>" . $row['Surname'] . "</span></p>";
                        //User email
                        echo "<p class='text-muted mb-1 pb-2 border-bottom'>E-mail: <span>" . $row['Email'] . "</span></p>";
                        //User phone
                        echo "<p class='text-muted mb-1 pb-2 border-bottom'>Telefon: <span>" . $row['Phone'] . "</span></p>";
                        //User address
                        echo "<p class='text-muted mb-1 pb-2 border-bottom'>Adres zamieszkania: <span>" . $row['Address'] . "</span></p>";
                        //User birthday
                        echo "<p class='text-muted mb-1 pb-2'>Data urodzin: <span>" . $row['Birthday'] . "</span></p>"; 

                        echo '</div>';
                    echo '</div>';
                }
                else
                {
                    //Do wystylizowania PK
                    //dodałbym jakis obrazek, że nie ma usera. Coś jak 404.
                    //do tego przycisk "Powrót do aplikacji /app"
                    echo ('
                            <div class="d-flex flex-column py-5">
                                <p class="h3">Taki użytkownik nie istnieje :(</p>
                                <div class="d-flex justify-content-center mt-2">
                                    <a href="app" class="btn btn-secondary">Porzuć wszelką nadzieję.</a>
                                </div>
                            </div>
                        ');
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
                
            </div>
        </div>
    </div>
</section>
</body>
</html>