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
    <title>Document</title> 
    <?php include "meta.php"; ?>
</head>
<body>
    <form method="POST" action="PHPMethods/signIn_script">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required autocomplete="email">

        <label for="pass">Hasło</label>
        <!--Minimum eight and maximum 10 characters, at least one uppercase letter, one lowercase letter, one number and one special character-->
        <input type="password" name="pass" id="pass" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$">

        <input type="submit" value="Zaloguj" name="submit">
        <?php
            if(isset($_SESSION['signUp_success']))
            {
                echo $_SESSION['signUp_success'];
                unset($_SESSION['signUp_success']);
            }
            
            if(isset($_SESSION['signIn_error']))
            {
                echo $_SESSION['signIn_error'];
                unset($_SESSION['signIn_error']);
            }

            if(isset($_SESSION['signOut_success']))
            {
                echo $_SESSION['signOut_success'];
                unset($_SESSION['signOut_success']);
            }
        ?>
    </form>
</body>
</html>