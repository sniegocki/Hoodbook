<?php
    @session_start();

    if(!isset($_SESSION['loggedUser']))
    {
        header("Location: signIn");
        exit(0);
    }

    if(!isset($_GET['estate']))
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
    <title>HoodBook | Osiedle <?php echo $estateName; ?></title> 
    <?php include "meta.php"; ?>
</head>
<body>
    <?php require "sidebar.php"; ?>
    <section class="home-section bg-light">
        <div class="home-content p-3 justify-content-center">

            <div class="col-12 col-lg-10 col-xl-8">
                <div class="d-flex flex-column rounded flex-wrap shadow-sm p-3 bg-white">
                    

                        <?php
                            require "PHPMethods/connect.php";
                            
                            if(!$connect->connect_error)
                            {
                                $sql = "SELECT * FROM Estates WHERE Id=" . $_GET['estate'] . ";";

                                if($result = $connect->query($sql))
                                {
                                    if($result->num_rows == 1)
                                    {
                                        $row = $result->fetch_assoc();

                                        $estateId = $row['Id'];
                                        $estateName = $row['Name'];
                                        $estateStreet = $row['Street'];
                                        $estateZipCode = $row['ZipCode'];
                                        $estateCity = $row['City'];
                                        $estateCountry = $row['Country'];

                                        //User name
                                        echo "<p class='profile-name'>Nazwa: <span class='text-muted'>" . $estateName . "</span></p>";
                                        //User surname
                                        echo "<p class='profile-surname'>Nazwisko: <span class='text-muted'>" . $estateStreet . "</span></p>";
                                        //User email
                                        echo "<p class='profile-email'>Email: <span class='text-muted'>" . $estateCity . "</span></p>";
                                        //User phone
                                        echo "<p class='profile-phone'>Telefon: <span class='text-muted'>" . $estateZipCode . "</span></p>";
                                        //User address
                                        echo "<p class='profile-surname'>Adres: <span class='text-muted'>" . $estateCountry . "</span></p>";
                                    }
                                    else
                                    {
                                        echo "Takie osiedle nie istnieje";
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