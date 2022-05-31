<?php

    @session_start();

    if(!isset($_SESSION['loggedUser']) || $_SESSION['permission'] != 2)
    {
        header("Location: app");
        exit(0);
    }

    //prompt success or error status
    if(isset($_SESSION['profileUserUpdateSuccess']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-success border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='2000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['profileUserUpdateSuccess'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['profileUserUpdateSuccess']);
    }

    if(isset($_SESSION['profileUserUpdateError']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-error border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='10000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['profileUserUpdateError'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['profileUserUpdateError']);
    }

    if(isset($_SESSION['ProfileUserPassEditSuccess']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-success border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='2000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['ProfileUserPassEditSuccess'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['ProfileUserPassEditSuccess']);
    }

    if(isset($_SESSION['ProfileUserPassEditError']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-error border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='10000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['ProfileUserPassEditError'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['ProfileUserPassEditError']);
    }
?>

<!DOCTYPE html>
<html lang='pl'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoodBook | Panel Administratorski</title> 
    <?php include "meta.php"; ?>
    
</head>
<body>
<section class="home-section bg-light">
    <div class="home-content p-3 justify-content-center">

        <div class="col-12">
            <div class="d-flex rounded flex-wrap shadow-sm">
                <div class="col-12 col-lg-12 p-3 bg-white">


    <button class='btn btn-success no-sql mb-3' data-bs-toggle='modal' data-bs-target='#adduser'>Dodaj użytkownika</button>
    <?php
        require "PHPMethods/connect.php";
        require "sidebar.php";

        if(!$connect->connect_error)
        {
            //Users table
            $sql = "SELECT * FROM Users JOIN UsersAccount ON Users.Id=UsersAccount.Id;";

            $result = $connect->query($sql);

            if($result->num_rows > 0)
            {
                echo <<< TABLE
                    <table class='table'>
                        <tr>
                            <th>Id</th>
                            <th>Email</th>
                            <th>Imię</th>
                            <th>Nazwisko</th>
                            <th>Telefon</th>
                            <th>Adres</th>
                            <th>Data urodzenia</th>
                            <th>Data stworzenia</th>
                            <th>Uprawnienia</th>
                            <th colspan="3">Akcja</th>
                        </tr>
                TABLE;

                while($row = $result->fetch_assoc())
                {

                    $userId = $row['Id'];
                    $userEmail = $row['Email'];
                    $userName = $row['Name'];
                    $userSurname = $row['Surname'];
                    $userPhone = $row['Phone'];
                    $userAddress = $row['Address'];
                    $userBirthday = $row['Birthday'];
                    $userCreationDate = $row['CreationDate'];
                    $user = $row['Permission'];

                    echo "<tr>";

                    echo "<td>" . $row['Id'] . "</td>";
                    echo "<td>" . $row['Email'] . "</td>";
                    echo "<td>" . $row['Name'] . "</td>";
                    echo "<td>" . $row['Surname'] . "</td>";
                    echo "<td>" . $row['Phone'] . "</td>";
                    echo "<td>" . $row['Address'] . "</td>";
                    echo "<td>" . $row['Birthday'] . "</td>";
                    echo "<td class='no-sql'>" . $row['CreationDate'] . "</td>";
                    echo "<td>" ;
                    switch($row['Permission'] )
                    {
                        case 0:
                            echo "Zbanowany";
                            break;
                        case 1:
                            echo "Użytkownik";
                            break;
                        case 2:
                            echo "Administrator";
                            break;
                    }
                    echo "</td>";
                    echo "<td class='no-sql'>
                        <button class='btn btn-secondary no-sql' data-bs-toggle='modal' data-bs-target='#editinfo'>Edytuj informacje</button>
                        <button class='btn btn-secondary no-sql' data-bs-toggle='modal' data-bs-target='#editpass'>Zmień hasło</button>
                        </td>"; 
                }
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

    <!-- Edit User Modal -->
    <div class="modal fade" id="editinfo" tabindex="-1" aria-labelledby="editinfo" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editinfo">Edytuj informacje</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <form action="PHPMethods/AdminMethods/editUserData_script" method="POST">
                    <label for="userId" class="form-label mb-1 mt-3" style="display: none;">Id: </label>
                    <input type="text" max="60" name="userId" id="userId" class="form-control" value="" autocomplete="off" required style="display: none;" required>

                    <label for="userEmail" class="form-label mb-1 mt-3">Email: </label>
                    <input type="text" max="60" name="userEmail" id="userEmail" class="form-control" value="" autocomplete="off" required>

                    <label for="userName" class="form-label mb-1 mt-3">Imię: </label>
                    <input type="text" max="60" name="userName" id="userName" class="form-control" value="" autocomplete="off" required>

                    <label for="userSurname" class="form-label mb-1 mt-3">Nazwisko: </label>
                    <input type="text" max="60" name="userSurname" id="userSurname" class="form-control" value="" autocomplete="off" required>

                    <label for="userPhone" class="form-label mb-1 mt-3">Telefon: </label>
                    <input type="tel" max="15" name="userPhone" id="userPhone" class="form-control" value="" autocomplete="off">

                    <label for="userAddress" class="form-label mb-1 mt-3">Adres: </label>
                    <input type="text" max="60" name="userAddress" id="userAddress" class="form-control" value="" autocomplete="off">

                    <label for="userBirthday" class="form-label mb-1 mt-3">Urodziny: </label>
                    <input type="date" max="60" name="userBirthday" id="userBirthday" class="form-control" value="" autocomplete="off">

                    <label for="userPermission" class="form-label mb-1 mt-3">Uprawnienia: </label>
                    <select type="text" max="60" name="userPermission" id="userPermission" class="form-control" value="" autocomplete="off" required>
                        <option value="0">Zbanowany</option>
                        <option value="1">Użytkownik</option>
                        <option value="2">Administrator</option>
                    </select>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" name="editUser" class="btn btn-success">Zapisz zmiany</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="adduser" tabindex="-1" aria-labelledby="adduser" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editinfo">Stwórz użytkownika</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <form action="PHPMethods/AdminMethods/addUser_script" method="POST">

                    <label for="userEmail" class="form-label mb-1 mt-3">Email: </label>
                    <input type="text" max="60" name="userEmail" id="userEmail" class="form-control" value="" autocomplete="off" required>

                    <label for="userName" class="form-label mb-1 mt-3">Imię: </label>
                    <input type="text" max="60" name="userName" id="userName" class="form-control" value="" autocomplete="off" required>

                    <label for="userSurname" class="form-label mb-1 mt-3">Nazwisko: </label>
                    <input type="text" max="60" name="userSurname" id="userSurname" class="form-control" value="" autocomplete="off" required>

                    <label for="userPhone" class="form-label mb-1 mt-3">Telefon: </label>
                    <input type="tel" max="15" name="userPhone" id="userPhone" class="form-control" value="" autocomplete="off">

                    <label for="userAddress" class="form-label mb-1 mt-3">Adres: </label>
                    <input type="text" max="60" name="userAddress" id="userAddress" class="form-control" value="" autocomplete="off">

                    <label for="userBirthday" class="form-label mb-1 mt-3">Urodziny: </label>
                    <input type="date" max="60" name="userBirthday" id="userBirthday" class="form-control" value="" autocomplete="off">

                    <label for="userPermission" class="form-label mb-1 mt-3">Uprawnienia: </label>
                    <select type="text" max="60" name="userPermission" id="userPermission" class="form-control" value="" autocomplete="off" required>
                        <option value="0">Zbanowany</option>
                        <option value="1">Użytkownik</option>
                        <option value="2">Administrator</option>
                    </select>

                    <label for="pass" class="form-label mt-4">Hasło:</label>
                    <!--Minimum eight and maximum 10 characters, at least one uppercase letter, one lowercase letter, one number and one special character-->
                    <input type="password" name="pass" id="pass" class="form-control" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$">

                    <label for="passRepeat" class="form-label mt-3 mb-2">Powtórz hasło:</label>
                    <input type="password" name="passRepeat" class="form-control" id="passRepeat" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$">
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" name="adduserSubmit" class="btn btn-success">Zapisz zmiany</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Password Modal -->
    <div class="modal fade" id="editpass" tabindex="-1" aria-labelledby="editpass" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editpass">Edytuj hasło</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <form action="PHPMethods/AdminMethods/editUserPass_script" method="POST" id="changepass">
                    
                    <p class="text-muted">Hasło powinno zawierać 8-10 znaków. Minimum 1 duża litera, 1 mała litera, 1 cyfra i 1 znak specjalny</p>
                    <input type="text" value="" name="userId" style="display: none;" id="modalUserId">

                    <label for="pass" class="form-label">Nowe hasło:</label>
                    <input type="password" name="pass" id="pass" class="form-control" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$">

                    <label for="passRepeat" class="form-label mt-3">Powtórz hasło:</label>
                    <input type="password" name="passRepeat" id="passRepeat" class="form-control" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$">

                    <div class="invalid-feedback mt-4" id="errormsg"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" name="editUser" onclick="validate()" class="btn btn-success">Zapisz zmiany</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        window.addEventListener("DOMContentLoaded", () => {
            //Edit user data modal =>
            document.querySelectorAll(".editUserBtn").forEach(o => {
                o.addEventListener("click", ()=> {
                    let e = o.parentNode.parentNode.querySelectorAll("*:not(.no-sql)");
                    var values = [];
                    e.forEach((ee) => {
                        values.push(ee.outerText);
                    });
                    
                    var modalInputs = document.querySelectorAll("#editinfo input, select");
                    
                    //assign values to inputs            
                    for(let i = 0; i < values.length; i++)
                    {
                        if(i == values.length - 1)
                        {
                            switch(values[i])
                            {
                                case "Zbanowany":
                                    modalInputs[i].value = 0;
                                    break;
                                case "Użytkownik":
                                    modalInputs[i].value = 1;
                                    break;
                                case "Administrator":
                                    modalInputs[i].value = 2;
                                    break;
                            }
                        }
                        else
                            modalInputs[i].value = values[i];

                    }
                });
            });
            //<=Edit user data modal 

            //Edit user pass modal =>
            document.querySelectorAll(".editUserPassBtn").forEach((o) => {
                o.addEventListener("click", () => {
                    let e = o.parentNode.parentNode.querySelector("*:first-child");

                    document.querySelector("#editpass #modalUserId").value = e.outerText;
                });
            });
            //<=Edit user pass modal

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