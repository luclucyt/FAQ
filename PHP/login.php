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
</head>

<?php 
    include 'Root.php';
?>

<body>
    <h1>Login</h1>
    <form action="" method="POST">
        <input type="text" name="mail" placeholder="School Mail..."><br>
        <input type="password" name="password" placeholder="Wachtwoord"><br>

        <input type="submit" name="submitLogin" value="Login">
    </form>

    <h1>Registreer</h1>
    <form action="" method="POST">
        <input type="text" name="naam" placeholder="Naam"><br>
        <input type="text" name="mail" placeholder="School Mail..."><br>
        <input type="password" name="password" placeholder="Wachtwoord"><br>
        <input type="password" name="password2" placeholder="Herhaal Wachtwoord"><br>

        <input type="submit" name="submitRegistreer" value="Registreer">
    </form>
</body>
</html>

<?php
    //register
    if(isset($_POST['submitRegistreer'])){
        $naam = $_POST['naam'];
        $mail = $_POST['mail'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        //if mail doesnt end with @glr.nl
        if(!strpos($mail, "@glr.nl")){
            echo "Mail moet eindigen met @glr.nl";
            exit();
        }

        //check if mail contains letters or numbers
        $mailSub = explode("@", $mail);
        $mailSub = $mailSub[0];
       
        if(!is_numeric($mailSub)){
            $admin = true; //it contains letters thus it is a teacher
        } else {
            $admin = false; //it contains only numbers thus it is a student
        }

        if($password != $password2){
            echo "Wachtwoorden komen niet overeen";
            exit();
        }

        //check if mail is already in use
        $sql = "SELECT mail FROM users WHERE mail = '{$mail}'";
        $sql = htmlspecialchars($sql);
        $sql = mysqli_real_escape_string($conn, $sql);
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);

        if($count != 0){
            echo "Mail is al in gebruik";
            exit();
        }

        //register
        $sql = "INSERT INTO users (ID, naam, mail, wachtwoord, admin, status) VALUES ('', '{$naam}', '{$mail}', '{$password}', '{$admin}', '0')";
        $sql = htmlspecialchars($sql);
        $sql = mysqli_real_escape_string($conn, $sql);
        $result = mysqli_query($conn, $sql);

        SendLoginMail($mail, $conn);
    }

    if(isset($_POST['userverify'])){
        $code = $_POST['code'];

        $sql = "SELECT * FROM userverify WHERE code = '{$code}'";
        $sql = htmlspecialchars($sql);
        $sql = mysqli_real_escape_string($conn, $sql);
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);

        if($count == 1){
            while($row = mysqli_fetch_assoc($result)){
                $userID = $row['userID'];
            }

            $sql = "UPDATE users SET status = '1' WHERE id = '{$userID}'";
            $sql = htmlspecialchars($sql);
            $sql = mysqli_real_escape_string($conn, $sql);
            $result = mysqli_query($conn, $sql);

            $sql = "DELETE FROM userverify WHERE userID = '{$userID}'";
            $sql = htmlspecialchars($sql);
            $sql = mysqli_real_escape_string($conn, $sql);
            $result = mysqli_query($conn, $sql);

            echo "Account is geverifieerd";
        }else{
            echo "Code is niet geldig";
        }
    }


    //login
    if(isset($_POST['submitLogin'])){
        $mail = $_POST['mail'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE mail = '{$mail}'";
        $sql = htmlspecialchars($sql);
        $sql = mysqli_real_escape_string($conn, $sql);
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);

        if($count == 1){
            while($row = mysqli_fetch_assoc($result)){
                $dbPassword = $row['wachtwoord'];
                $userID = $row['ID'];
                $userName = $row['naam'];
                $status = $row['status'];
                $admin = $row['admin'];
            }

            if($status == 1){
                if($password == $dbPassword){
                    $_SESSION['userID'] = $userID;
                    $_SESSION['userName'] = $userName;
                    echo "Je bent ingelogd";

                    if($admin == 1){
                        $_SESSION['admin'] = true;
                    }else{
                        $_SESSION['admin'] = false;
                    }
                }else{
                    echo "Wachtwoord is niet correct";
                }
            }else{
                echo "Account is nog niet geverifieerd";
            }
        }else{
            echo "Mail is niet gevonden";
        }
    }
?>