<?php
    @session_start();

    if(!isset($_SESSION['loggedUser']))
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

    if(isset($_SESSION['profileEditAvatarSuccess']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-success border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='2000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['profileEditAvatarSuccess'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['profileEditAvatarSuccess']);
    }

    if(isset($_SESSION['profileEditAvatarError']))
    {
        echo "
        <div class='position-fixed top-0 end-0 p-3' style='z-index: 11;'>
            <div class='toast align-items-center text-white bg-toast-error border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='10000'>
                <div class='d-flex'>
                    <div class='toast-body'>" .
                        $_SESSION['profileEditAvatarError'] .
                    "</div>
                </div>
            </div>
        </div>";

        unset($_SESSION['profileEditAvatarError']);
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Expires" content="Tue, 01 Jan 1995 12:12:12 GMT">
    <meta http-equiv="Pragma" content="no-cache">
    <title>HoodBook | Mój profil</title> 
    <?php include "meta.php"; ?>
</head>
<body>

    <?php require "sidebar.php"; ?>

<section class="home-section bg-light">
    <div class="home-content p-3 justify-content-center">

        <div class="col-12 col-lg-10 col-xl-8">
            <div class="d-flex rounded flex-wrap shadow-sm">
                <div class="col-12 col-lg-4 d-flex justify-content-center p-3 bg-white">

        <!--User data-->
        <?php
            require "PHPMethods/connect.php";
            

            //get user profile data
            if(!$connect->connect_error)
            {
                $sql = "SELECT * FROM Users WHERE Id=" . $_SESSION['loggedUser'] . ";";

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
                        
                        //User avatar
                        $avatarPath = "img/avatars/" . $_SESSION['loggedUser'] . ".png";

                        if (file_exists($avatarPath))
                        {
                            echo "<div class='avatar-place'>
                                <img class='img-fluid' src='" . $avatarPath . "' alt='Zdjęcie profilowe'>
                            </div>";
                        }
                        else
                        {
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
                    }
                }
                else
                {
                    echo "Database query error has occurred";
                }
            }
        ?>

        </div>
    



        <!--User profile edit-->
        <div class="col-12 p-3 bg-white rounded shadow-sm mt-3">
            <h3 class="fs-5">Zaktualizuj informacje</h3>
            <hr>
            <div class="profile-button-wrapper">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editinfo">Edytuj informacje</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editpass">Zmień hasło</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editavatar">Zmień awatar</button>
                <!--<a href="bug-reports.php"><button class="btn btn-danger">Zgłoś błąd</button></a>-->
            </div>
        </div>

        </div>

        <!--Edit modals-->
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
                        <label for="userName" class="form-label mb-1 mt-3">Imię: </label>
                        <input type="text" max="60" name="userName" id="userName" class="form-control" value="<?php echo $userName; ?>" autocomplete="off" required>

                        <label for="userSurname" class="form-label mb-1 mt-3">Nazwisko: </label>
                        <input type="text" max="60" name="userSurname" id="userSurname" class="form-control" value="<?php echo $userSurname; ?>" autocomplete="off" required>

                        <label for="userPhone" class="form-label mb-1 mt-3">Telefon: </label>
                        <input type="tel" max="15" name="userPhone" id="userPhone" class="form-control" value="<?php echo $userPhone; ?>" autocomplete="off">

                        <label for="userAddress" class="form-label mb-1 mt-3">Adres: </label>
                        <input type="text" max="60" name="userAddress" id="userAddress" class="form-control" value="<?php echo $userAddress; ?>" autocomplete="off">

                        <label for="userBirthday" class="form-label mb-1 mt-3">Urodziny: </label>
                        <input type="date" max="60" name="userBirthday" id="userBirthday" class="form-control" value="<?php echo $userBirthday; ?>" autocomplete="off">
                        
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Anuluj</button>
                        <button type="submit" name="editUser" class="btn btn-success">Zapisz zmiany</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Edit Password Modal -->
    <div class="modal fade" id="editpass" tabindex="-1" aria-labelledby="editpass" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editpass">Edytuj hasło</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <form action="PHPMethods/profileEditPass_script" method="POST" id="changepass">
                    
                    <p class="text-muted">Hasło powinno zawierać 8-10 znaków. Minimum 1 duża litera, 1 mała litera, 1 cyfra i 1 znak specjalny</p>

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

    <!-- Edit Avatar Modal -->
    <div class="modal fade" id="editavatar" tabindex="-1" aria-labelledby="editavatar" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editavatar">Aktualizuj zdjęcie profilowe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body avatar-place">
                    <form action="PHPMethods/profileEditAvatar_script" method="POST" enctype="multipart/form-data">
                    
                    <p class="text-muted">Avatar powinien mieć rozmiary 300x300 pikseli lub proporcje 1:1 (kwadrat). Tylko pliki JPG, JPEG, PNG & GIF nie przekraczające 5MB.</p>

                    <label for="" class="form-label">Twój obecny awatar:</label><br>
                    <?php

                        if(file_exists($avatarPath))
                        {
                            echo "<div class='avatar-place'><img class='img-fluid' src='" . $avatarPath . "' alt='Zdjęcie profilowe'></div>";
                        }
                        else
                        {
                            echo "<div class='avatar-place'><img class='img-fluid' src='" . "img/avatars/avatarPlaceholder.png" . "' alt='Zdjęcie profilowe'></div>";
                        }
                    ?>

                    <br>

                    <div class="mt-3">
                        <label for="formFile" class="form-label">Dodaj nowy awatar:</label>
                        <input class="form-control" name="avatar" type="file" id="avatar">
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" name="addavatar" class="btn btn-success">Zapisz zmiany</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script src="js/toast.js"></script>
</body>
</html>