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
        <title>Hoodbook | Rejestracja</title> 
        <?php include "meta.php"; ?>
    </head>

    <body>
        <section id="signup">
            <div class="container">
                <div class="row align-items-center" style="height: 100vh;">

                    <div class="col-12 col-xl-6 d-none d-md-flex align-items-center p-3 flex-column">
                        
                        <div class="text-center bg-light rounded-3 shadow-sm px-5 py-3">

                            <img src="img/hoodbook_logo_vertical.svg" alt="Hoodbook Logo" class="img-fluid w-50 mb-5">

                            <h1 class="h4">Witaj w Hood<span class="fw-bold">Book</span>!</h1>
                            <p class="text-muted">HoodBook to aplikacja internetowa do zarządzania swoim osiedlem. Możesz w niej publikować zbliżające się wydarzenia, lub ważne informacje dotyczące Twojego osiedla. Przekształć swoje osiedle, zintegruj ludzi, powiadom mieszkańców</p>
                            <p class="fs-5 text-muted">Zapewniamy że...</p>
                            <ul class="fs-5" style="list-style: none;">
                                <li><i class='bx bx-check text-success'></i> Rejestracja w HoodBook jest darmowa</li>
                                <li><i class='bx bx-check text-success'></i> Twoje dane nie zostaną wykorzystane poza HoodBook</li>
                            </ul>

                            <p class="text-muted">Zapoznaj się z naszą <a href="#">polityką prywatności</a> i <a href="#">regulaminem</a>.</p>

                        </div>
                    </div>

                    <div class="col-12 col-xl-6">
                        <form method="POST" action="PHPMethods/signUp_script" class="px-5">
                            <p class="fs-5 text-muted">Wypełnij formularz rejestracyjny aby utworzyć swoje konto.</p>
                            <label for="name" class="form-label mt-3">Imię:</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Wprowadź swoje imię..." required autocomplete="name">

                            <label for="surname" class="form-label mt-4">Nazwisko:</label>
                            <input type="text" name="surname" id="surname" class="form-control" placeholder="Wprowadź swoje nazwisko..." required autocomplete="surname">

                            <label for="email" class="form-label mt-4">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" pattern="^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$" placeholder="Wprowadź swój adres e-mail..." required autocomplete="email">

                            <label for="pass" class="form-label mt-4">Hasło:</label>
                            <!--Minimum eight and maximum 10 characters, at least one uppercase letter, one lowercase letter, one number and one special character-->
                            <input type="password" name="pass" id="pass" class="form-control" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$">

                            <label for="passRepeat" class="form-label mt-3 mb-2">Powtórz hasło:</label>
                            <input type="password" name="passRepeat" class="form-control" id="passRepeat" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$">

                            <small class="text-muted d-block"><i class='bx bxs-info-circle' ></i> Hasło powinno zawierać przynajmniej jedną dużą literę, jedną liczbę i jeden znak specjalny. Hasło nie może być krótsze niż 8 znaków i dłuższe niż 20.</small>

                            <input type="submit" value="Zarejestruj" class="w-100 btn btn-primary mt-5" name="submit">

                            

                            <?php
                                if(isset($_SESSION['signUp_error']))
                                {
                                    echo ('
                                    <div class="alert alert-warning mt-3" role="alert" data-aos="fade-down">');
                                        echo $_SESSION['signUp_error'];
                                    echo ('</div>
                                    ');

                                    unset($_SESSION['signUp_error']);
                                }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        
        
    </body>
</html>