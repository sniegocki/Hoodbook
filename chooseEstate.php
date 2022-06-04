<?php
    @session_start();

    if(!isset($_SESSION['loggedUser']))
    {
        header("Location: app");
        exit(0);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoodBook | Wybierz osiedle</title> 
    <?php include "meta.php"; ?>
</head>
<body>

    <?php 
        require "PHPMethods/connect.php";
        require "sidebar.php";
    ?>

    <section class="home-section bg-light">
        <div class="home-content p-3 justify-content-center">

            <div class="row g-3 w-100">

                <?php
                    if(!$connect->connect_error) {
                        //Estates table
                        $sql = "SELECT Estates.Id, Estates.Name, Estates.Street, Estates.ZipCode, Estates.City, Estates.Country, Estates.CreationDate, count(Estates_Users.IdUser) AS UsersCount FROM Estates JOIN Estates_Users ON Estates.Id=Estates_Users.IdEstate WHERE IdUser = ".$_SESSION['loggedUser']." GROUP BY Estates.Id;";
                        $result = $connect->query($sql);

                        while($row = $result->fetch_assoc()) {

                            $estateId = $row['Id'];
                            $estateName = $row['Name'];
                            $estateStreet = $row['Street'];
                            $estateZipCode = $row['ZipCode'];
                            $estateCity = $row['City'];
                            $estateCountry = $row['Country'];
                            $estateCreationDate = $row['CreationDate'];
                            $estateUsersCount = $row['UsersCount'];

                            echo ('
                                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                                    <div class="d-flex flex-column bg-white rounded shadow align-items-center p-3">
                                        <h3 class="h3 text-center">'.$estateName.'</h3>
                                        ');

                                        //Estate avatar
                                        $avatar_path = "./img/estateAvatars/" . $estateId . ".png";

                                        if (file_exists($avatar_path)) {
                                            echo ('
                                                <div class="avatar-place">
                                                    <img src="img/estateAvatars/'. $estateId.'.png" class="img-fluid w-100" style="max-width: 400px;">
                                                </div>
                                            ');
                                        } else {
                                            echo ('
                                                <div class="avatar-place">
                                                    <img src="img/estate-placeholder.svg" alt="zdjęcie osiedla" class="img-fluid w-100" style="max-width: 400px;">
                                                </div>
                                            ');
                                        }

                                        echo ('
                                        <p class="text-muted mt-2 mb-0">'.$estateStreet.', '.$estateZipCode.', '.$estateCity.' '.$estateCountry.'</p>
                                        <!--<p class="text-muted mt-2">Liczba mieszkańców: '.$estateUsersCount.'</p>-->

                                        <a href="myEstate?estate='.$estateId.'" class="btn btn-primary rounded-0 w-100 mt-3">Przeglądaj osiedle</a>

                                    </div>
                                </div>
                            ');

                        }
                    } 
                ?>

            </div>

        </div>
    </section>

    <script src="js/toast.js"></script>
</body>
</html>