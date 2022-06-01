<?php

    @session_start();

    if(!isset($_SESSION['loggedUser']) || $_SESSION['permission'] != 2)
    {
        header("Location: app");
        exit(0);
    }

    //prompt success or error status
    if(isset($_SESSION['addEstateSuccess']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-success border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='2000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['addEstateSuccess'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['addEstateSuccess']);
    }

    if(isset($_SESSION['addEstateError']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-error border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='10000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['addEstateError'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['addEstateError']);
    }

    if(isset($_SESSION['editEstateSuccess']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-success border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='2000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['editEstateSuccess'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['editEstateSuccess']);
    }

    if(isset($_SESSION['editEstateError']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-error border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='10000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['editEstateError'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['editEstateError']);
    }
?>

<!DOCTYPE html>
<html lang='pl'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoodBook | Zarządanie osiedlami</title> 
    <?php include "meta.php"; ?>
    
</head>
<body>
<section class="home-section bg-light">
    <div class="home-content p-3 justify-content-center">

        <div class="col-12">
            <div class="d-flex rounded flex-wrap shadow-sm">
                <div class="col-12 col-lg-12 p-3 bg-white">


    <button class='btn btn-success no-sql mb-3' data-bs-toggle='modal' data-bs-target='#addestate'>Dodaj osiedle</button>
    <?php
        require "PHPMethods/connect.php";
        require "sidebar.php";

        if(!$connect->connect_error)
        {
            //Estates table
            $sql = "SELECT Estates.Id, Estates.Name, Estates.Street, Estates.ZipCode, Estates.City, Estates.Country, Estates.CreationDate, count(Estates_Users.IdUser) AS UsersCount FROM Estates JOIN Estates_Users ON Estates.Id=Estates_Users.IdEstate;";

            $result = $connect->query($sql);

            if($result->num_rows > 0)
            {
                echo <<< TABLE
                    <table class='table'>
                        <tr>
                            <th>Id</th>
                            <th>Nazwa</th>
                            <th>Ulica i nr</th>
                            <th>Miasto</th>
                            <th>Kod pocztowy</th>
                            <th>Kraj</th>
                            <th>Liczba użytkowników</th>
                            <th>Data stworzenia</th>
                            <th colspan="1">Akcja</th>
                        </tr>
                TABLE;

                while($row = $result->fetch_assoc())
                {

                    $estateId = $row['Id'];
                    $estateName = $row['Name'];
                    $estateStreet = $row['Street'];
                    $estateZipCode = $row['ZipCode'];
                    $estateCity = $row['City'];
                    $estateCountry = $row['Country'];
                    $estateCreationDate = $row['CreationDate'];
                    $estateUsersCount = $row['UsersCount'];

                    echo "<tr>";

                    echo "<td>" . $estateId . "</td>";
                    echo "<td>" . $estateName . "</td>";
                    echo "<td>" . $estateStreet . "</td>";
                    echo "<td>" . $estateCity . "</td>";
                    echo "<td>" . $estateZipCode . "</td>";
                    echo "<td>" . $estateCountry . "</td>";
                    echo "<td class='no-sql'>" . $estateUsersCount . "</td>";
                    echo "<td class='no-sql'>" . $estateCreationDate . "</td>";
                    echo "<td class='no-sql'><button class='btn btn-secondary no-sql editEstateBtn' data-bs-toggle='modal' data-bs-target='#editestate'>Edytuj informacje</button></td>";
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

    <!-- Add Estate modal -->
    <div class="modal fade" id="addestate" tabindex="-1" aria-labelledby="addestate" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editinfo">Stwórz użytkownika</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <form action="PHPMethods/AdminMethods/addEstate_script" method="POST">

                    <label for="estateName" class="form-label mb-1 mt-3">Nazwa: </label>
                    <input type="text" max="60" name="estateName" id="estateName" class="form-control" value="" autocomplete="off" required>

                    <label for="estateStreet" class="form-label mb-1 mt-3">Ulica i nr: </label>
                    <input type="text" max="60" name="estateStreet" id="estateStreet" class="form-control" value="" autocomplete="off" required>

                    <label for="estateZipCode" class="form-label mb-1 mt-3">Kod pocztowy: </label>
                    <input type="text" max="60" name="estateZipCode" id="estateZipCode" class="form-control" value="" autocomplete="off" required>

                    <label for="estateCity" class="form-label mb-1 mt-3">Miasto: </label>
                    <input type="text" max="60" name="estateCity" id="estateCity" class="form-control" value="" autocomplete="off" required>

                    <label for="estateCountry" class="form-label mb-1 mt-3">Kraj: </label>
                    <input type="text" max="60" name="estateCountry" id="estateCountry" class="form-control" value="" autocomplete="off" required>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" name="addEstateSuccess" class="btn btn-success">Stwórz osiedle</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Estate data modal -->
    <div class="modal fade" id="editestate" tabindex="-1" aria-labelledby="editestate" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editinfo">Edytuj osiedle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <form action="PHPMethods/AdminMethods/editEstate_script" method="POST">

                    <input type="text" max="60" name="estateId" id="estateId" class="form-control" value="" autocomplete="off" required style="display: none;">

                    <label for="estateName" class="form-label mb-1 mt-3">Nazwa: </label>
                    <input type="text" max="60" name="estateName" id="estateName" class="form-control" value="" autocomplete="off" required>

                    <label for="estateStreet" class="form-label mb-1 mt-3">Ulica i nr: </label>
                    <input type="text" max="60" name="estateStreet" id="estateStreet" class="form-control" value="" autocomplete="off" required>

                    <label for="estateCity" class="form-label mb-1 mt-3">Miasto: </label>
                    <input type="text" max="60" name="estateCity" id="estateCity" class="form-control" value="" autocomplete="off" required>

                    <label for="estateZipCode" class="form-label mb-1 mt-3">Kod pocztowy: </label>
                    <input type="text" max="60" name="estateZipCode" id="estateZipCode" class="form-control" value="" autocomplete="off" required>

                    <label for="estateCountry" class="form-label mb-1 mt-3">Kraj: </label>
                    <input type="text" max="60" name="estateCountry" id="estateCountry" class="form-control" value="" autocomplete="off" required>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" name="editEstate" class="btn btn-success">Edytuj osiedle</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener("DOMContentLoaded", () => {
            //Edit estate data model =>
            document.querySelectorAll(".editEstateBtn").forEach(o => {
                o.addEventListener("click", ()=> {
                    let e = o.parentNode.parentNode.querySelectorAll("*:not(.no-sql)");

                    var values = [];
                    e.forEach((ee) => {
                        values.push(ee.outerText);
                    });
                    
                    var modalInputs = document.querySelectorAll("#editestate input");

                    //assign values to inputs            
                    for(let i = 0; i < values.length; i++)
                    {
                        modalInputs[i].value = values[i];
                    }
                });
            });
            //<=Edit estate data modal 

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