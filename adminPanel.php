<?php

    @session_start();

    if(!isset($_SESSION['loggedUser']) || $_SESSION['permission'] != 2)
    {
        header("Location: app");
        exit(0);
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoodBook | Panel Administratorski</title> 
    <?php include "meta.php"; ?>
    
</head>
<body>
    
    
    <h2>Użytkownicy</h2>
    <?php
        require "PHPMethods/connect.php";

        if(!$connect->connect_error)
        {
            //Users table
            $sql = "SELECT * FROM Users JOIN UsersAccount ON Users.Id=UsersAccount.Id;";

            $result = $connect->query($sql);

            if($result->num_rows > 0)
            {
                echo <<< TABLE
                    <table style='users'>
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
                    echo "<tr>";

                    echo "<td class='no-sql'>" . $row['Id'] . "</td>";
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
                    echo "<td class='no-sql'><button class='btn btn-primary editUserBtn no-sql' data-bs-toggle='modal' data-bs-target='#editinfo'>Edytuj informacje</button></td>"; 
                    
                }
            }
        }
        else
        {
            echo "Błąd w połączeniu z bazą danych";
        }
    ?>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editinfo" tabindex="-1" aria-labelledby="editinfo" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editinfo">Edytuj informacje</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <form action="PHPMethods/profileEdit_script" method="POST">
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

                    <label for="userPermission" class="form-label mb-1 mt-3">Imię: </label>
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

    <script>
        window.addEventListener("DOMContentLoaded", () => {
            let editBtn = document.querySelectorAll(".editUserBtn");

            editBtn.forEach(o => {
                o.addEventListener("click", ()=> {
                    let e = o.parentNode.parentNode.querySelectorAll("*:not(.no-sql)");
                    var values = [];
                    e.forEach((ee) => {
                        values.push(ee.outerText);
                    });
                    
                    var modalInputs = document.querySelectorAll("#editinfo input, option");
                    //modalInputs.push(document.querySelector("#editinfo option"));
                    
                    //assign values to inputs
                    console.log(e);
                    console.log(modalInputs)
                    console.log(values);
                    
                    for(let i = 0; i < values.length; i++)
                    {
                        console.log("Modal: " + modalInputs[i].value + " value: " + values[i]);
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

                        console.log("Modal: " + modalInputs[i].value + " value: " + values[i]);
                    }
                });
            });
        });  
    </script>
</body>
</html>