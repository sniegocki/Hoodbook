<?php
    @session_start();
    if(isset($_SESSION['loggedUser']))
    {
        header("Location: app");
        exit(0);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>HoodBook | Logowanie</title> 
        <?php include "meta.php"; ?>
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center align-items-center" style="height: 100vh;">

                <div class="col-5 d-flex flex-column align-items-center justify-content-center">
                    <img src="img/hoodbook_logo_horizontal.svg" alt="Hoodbook Logo" class="img-fluid w-75 py-3">

                    <form method="POST" action="PHPMethods/signIn_script" class="mt-5 w-100 p-5 rounded-3 shadow-sm bg-light">
                        <h1 class="h4 text-center fs-5 mb-3 d-none">Panel logowania:</h1>
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" id="email" placeholder="Wprowadź swój adres e-mail..." class="form-control" required autocomplete="email">

                        <label for="pass" class="form-label mt-3">Hasło:</label>
                        <!--Minimum eight and maximum 10 characters, at least one uppercase letter, one lowercase letter, one number and one special character-->
                        <input type="password" name="pass" id="pass" placeholder="Wprowadź hasło..." class="form-control" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$">

                        <input type="submit" value="Zaloguj" name="submit" class="btn btn-primary w-100 mt-4">

                        <?php
                            if (isset($_SESSION['signUp_success']))
                            {
                                echo $_SESSION['signUp_success'];

                                echo ('
                                    <div class="alert alert-success mt-3" role="alert" data-aos="fade-down">');
                                        echo $_SESSION['signUp_success'];
                                echo ('
                                    </div>
                                ');

                                unset($_SESSION['signUp_success']);
                            }
                            
                            if (isset($_SESSION['signIn_error']))
                            {
                                echo ('
                                    <div class="alert alert-danger mt-3" role="alert" data-aos="fade-down">');
                                        echo $_SESSION['signIn_error'];
                                echo ('
                                    </div>
                                ');
                                unset($_SESSION['signIn_error']);
                            }
                        ?>
                    </form>
                </div>
                
            </div>
        </div>
        
    </body>
</html>