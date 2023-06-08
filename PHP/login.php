<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login FAQ || SD-lab</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../CSS/root.css">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/login.css">

    <!-- JS -->
    <script src="../JS/root.js" defer></script>
    <script src="../JS/login.js" defer></script>
</head>

<?php 
    include 'root.php';
?>

<body>
    <main>
        <div class="login-wrapper">
            <div>
                <h1>Login:</h1>
                <form action="../login/loginSubmit.php" method="POST">
                    <input type="text" name="mail" placeholder="Gebruikersnaam"><br>
                    <input type="password" name="password" placeholder="Wachtwoord"><br>

                    <input type="submit" name="submitLogin" value="Login">
                </form>
            </div>
        </div>
    </main>
</body>
</html>