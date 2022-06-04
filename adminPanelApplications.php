<?php

    @session_start();

    if(!isset($_SESSION['loggedUser']) || $_SESSION['permission'] != 2)
    {
        header("Location: app");
        exit(0);
    }

    //prompt success or error status
    if(isset($_SESSION['changeAppSuccess']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-success border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='2000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['changeAppSuccess'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['changeAppSuccess']);
    }

    if(isset($_SESSION['changeAppError']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-error border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='10000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['changeAppError'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['changeAppError']);
    }
?>

<!DOCTYPE html>
<html lang='pl'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoodBook | Zarządanie zgłoszeniami</title> 
    <?php include "meta.php"; ?>
    
</head>
<body>
<section class="home-section bg-light">
    <div class="home-content p-3 justify-content-center">

        <div class="col-12">
            <div class="d-flex rounded flex-wrap shadow-sm">
                <div class="col-12 col-lg-12 p-3 bg-white">

    <?php
        require "PHPMethods/connect.php";
        require "sidebar.php";

        if(!$connect->connect_error)
        {
            //Estates table
            $sql = "SELECT UserToEstateInvites.Id, UserToEstateInvites.IdSender, UserToEstateInvites.IdTarget, UserToEstateInvites.Status, UserToEstateInvites.SendDate, Users.Name AS 'UserName', Users.Surname, Estates.Name AS 'EstateName' FROM UserToEstateInvites JOIN Users ON UserToEstateInvites.IdSender=Users.Id JOIN Estates ON UserToEstateInvites.IdTarget=Estates.Id ORDER BY UserToEstateInvites.SendDate DESC";

            $result = $connect->query($sql);

            if($result->num_rows > 0)
            {
                echo <<< TABLE
                    <table class='table'>
                        <tr>
                            <th>Id</th>
                            <th>Użytkownik</th>
                            <th>Osiedle</th>
                            <th>Status</th>
                            <th>Data złożenia</th>
                            <th colspan="2">Akcja</th>
                        </tr>
                TABLE;

                while($row = $result->fetch_assoc())
                {

                    $appId = $row['Id'];
                    $userId = $row['IdSender'];
                    $estateId = $row['IdTarget'];
                    $appStatus = $row['Status'];
                    $appSendDate = $row['SendDate'];
                    $userName = $row['UserName'];
                    $userSurname = $row['Surname'];
                    $estateName = $row['EstateName'];

                    echo "<tr>";

                    echo "<td>" . $appId . "</td>";
                    echo "<td><a target='_blank' href='checkprofile?user=$userId'>" . $userName . " " . $userSurname . "</a></td>";
                    echo "<td><a target='_blank' href='checkEstate?estate=$estateId'>" . $estateName . "</a></td>";
                    echo "<td>" . $appStatus . "</td>";
                    echo "<td>" . $appSendDate . "</td>";
                    echo "
                        <td class='no-sql'>
                            <a class='btn btn-success' href='PHPMethods/AdminMethods/changeApplicationStatus?idapp=$appId&iduser=$userId&idestate=$estateId&type=2'>Akceptuj</a>
                            <a class='btn btn-danger' href='PHPMethods/AdminMethods/changeApplicationStatus?idapp=$appId&iduser=$userId&idestate=$estateId&type=1'>Odrzuć</a>
                        </td>";
                    echo "</tr>";
                }

                echo "</table>";
            }
        }
        else
        {
            echo "Błąd w połączeniu z bazą danych";
        }
    ?>
                </div>
            </div>
        </div>
    </div>
</section>

    <script>
        window.addEventListener("DOMContentLoaded", () => {
            //Toast=>
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
            var toastList = toastElList.map(function (toastEl) {
                // Creates an array of toasts (it only initializes them)
                return new bootstrap.Toast(toastEl) // No need for options; use the default options
            });
            toastList.forEach(toast => toast.show()); // This show them
            });  
            //<=Toast
    </script>
</body>
</html>