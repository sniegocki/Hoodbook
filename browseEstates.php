<?php
    @session_start();

    if(!isset($_SESSION['loggedUser']))
    {
        header("Location: app");
        exit(0);
    }

    //prompt success or error status
    if(isset($_SESSION['UserToEstateInviteSuccess']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-success border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='2000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['UserToEstateInviteSuccess'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['UserToEstateInviteSuccess']);
    }

    if(isset($_SESSION['UserToEstateInviteError']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-error border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='10000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['UserToEstateInviteError'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['UserToEstateInviteError']);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoodBook | Przeglądaj osiedla</title> 
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
                        $sql = "SELECT Estates.Id, Estates.Name, Estates.Street, Estates.ZipCode, Estates.City, Estates.Country, Estates.CreationDate, count(Estates_Users.IdUser) AS UsersCount FROM Estates LEFT JOIN Estates_Users ON Estates.Id=Estates_Users.IdEstate GROUP BY Estates.Id;";
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
                                        <img src="img/estate-placeholder.svg" alt="zdjęcie osiedla" class="img-fluid">
                                        <p class="text-muted mt-2 mb-0">'.$estateStreet.', '.$estateZipCode.', '.$estateCity.' '.$estateCountry.'</p>
                                        <p class="text-muted mt-2">Liczba mieszkańców: '.$estateUsersCount.'</p>

                                        <form action="PHPMethods/userToEstateInvite" method="POST" class="w-100">

                                            <input type="text" name="idTarget" class="d-none" value="'.$estateId.'">
                                            <input type="text" name="idSender" class="d-none" value="'.$_SESSION['loggedUser'].'">
                                ');

                                $sql2 = "SELECT UserToEstateInvites.IdSender, UserToEstateInvites.IdTarget, UserToEstateInvites.Status FROM UserToEstateInvites WHERE UserToEstateInvites.IdSender = ".$_SESSION['loggedUser']." AND UserToEstateInvites.IdTarget = ".$estateId.";";
                                $result2 = $connect->query($sql2);

                                while($row2 = $result2->fetch_assoc()) {
                                    $stateInviteStatus = $row2['Status'];
                                }

                                if($result2->num_rows == 1) {
                                    if ($stateInviteStatus !== "Accepted") {
                                        echo ('<input type="button" class="btn btn-secondary rounded-0 w-100" value="Oczekiwanie..." disabled>');
                                    } else if ($stateInviteStatus == "Rejected") {
                                        echo ('<input type="button" class="btn btn-danger rounded-0 w-100" value="Odrzucone" disabled>');
                                    } else {
                                        echo ('<input type="button" class="btn btn-success rounded-0 w-100" value="Już należysz" disabled>');
                                    }
                                } else {
                                    echo ('<input type="submit" name="estateApplication" class="btn btn-primary rounded-0 w-100" value="Złóż aplikację">');
                                }

                            echo ('
                                        </form>
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