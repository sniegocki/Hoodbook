<?php
    @session_start();
    if(isset($_SESSION['loggedUser']))
    {
        //przekierowanie zalogowanego usera
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title> 
    <?php include "meta.php"; ?>
</head>
<body>
    <form method="POST" action="PHPMethods/signUp_script">
        <label for="name">Imię</label>
        <input type="text" name="name" id="name" required autocomplete="name">

        <label for="surname">Nazwisko</label>
        <input type="text" name="surname" id="surname" required autocomplete="surname">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required autocomplete="email">

        <label for="pass">Hasło</label>
        <!--Minimum eight and maximum 10 characters, at least one uppercase letter, one lowercase letter, one number and one special character-->
        <input type="password" name="pass" id="pass" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$">

        <label for="passRepeat">Powtórz hasło</label>
        <input type="password" name="passRepeat" id="passRepeat" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$">

        <input type="submit" value="Zarejestruj" name="submit">
        <?php
            if(isset($_SESSION['signUp_error']))
            {
                echo $_SESSION['signUp_error'];
                unset($_SESSION['signUp_error']);
            }
        ?>
    </form>
</body>
</html>