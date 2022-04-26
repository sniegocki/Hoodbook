<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title> 
    <?php include "meta.php"; ?>
</head>
<body>
    <form method="POST" action="/PHPMethods/signUp_script.php">
        <label for="name">Imię</label>
        <input type="text" name="name" id="name" required>

        <label for="surname">Nazwisko</label>
        <input type="text" name="surname" id="surname" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="pass">Hasło</label>
        <!--Minimum eight and maximum 10 characters, at least one uppercase letter, one lowercase letter, one number and one special character-->
        <input type="password" name="pass" id="pass" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$">

        <label for="passRepeat">Powtórz hasło</label>
        <input type="password" name="passRepeat" id="passRepeat" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$">

        <input type="submit" value="Zarejestruj" name="submit">
    </form>
</body>
</html>