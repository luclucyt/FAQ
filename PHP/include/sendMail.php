<?php   
    include 'mail/PHPMailer.php';
    include 'mail/SMTP.php';
    include 'mail/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    function SendCodeToMail($SendMailTo, $vraag, $vraagID, $conn){
        
        echo "<script>alert('{$vraagID}')</script>";

        $mail = new PHPMailer();


        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;


        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->Username = 'vanbriemenlucas@gmail.com';
        $mail->Password = 'bfyrldyjmdvrzryv'; /* DO NOT CHANGE THIS */

        $mail->Subject = 'Test mail';
        $mail->setFrom('vanbriemenlucas@gmail.com');

        // generate a 6 digit code for the user to enter
        $code = rand(100000, 999999);

        $mail->isHTML(true);

        $mail->Body = "Bedankt voor je vraag: '{$vraag}'' <br> Je code is: '{$code}'";

        $mail->addAddress("{$SendMailTo}");


        //get VraagID from database
        $sql = "SELECT vraagID FROM vragen WHERE vraag = '{$vraag}' AND mail = '{$SendMailTo}'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $vraagID = $row['vraagID'];
        }

        //write to vericy table
        $sql = "INSERT INTO verify (id, vraagID, mail, code) VALUES ('', '{$vraagID}', '{$SendMailTo}', '{$code}')";
        $result = mysqli_query($conn, $sql);

        

        if($mail->send()){
            echo 'Er is een mail verstuurd naar: ' . $SendMailTo . '<br>';
            echo 'Vul de code in die je hebt ontvangen: <br>';
            
            echo '<form action="" method="POST">';
                echo '<input type="text" name="code" placeholder="Code..."><br>';
                echo '<input type="submit" name="submitCode" value="Verstuur">';
            echo '</form>';
        }else{
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }

        $mail->smtpClose();
    }

    function SendLoginMail($SendMailTo){
        $host = "localhost";
        $username = "root";
        $password = "";
        $db = "fqa";
        $conn = mysqli_connect($host, $username, $password, $db);

        $mail = new PHPMailer();        

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;


        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->Username = 'vanbriemenlucas@gmail.com';
        $mail->Password = 'bfyrldyjmdvrzryv'; /* DO NOT CHANGE THIS */

        $mail->Subject = 'Test mail';
        $mail->setFrom('vanbriemenlucas@gmail.com');

        // generate a 6 digit code for the user to enter
        $code = rand(100000, 999999);

        //get the userID from the database
        $sql = "SELECT id FROM users WHERE mail = '{$SendMailTo}'";
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
            $userID = $row['id'];
        }

        //write the code to the database
        $sql = "INSERT INTO userverify (id, userID, code) VALUES ('', '{$userID}', '{$code}')";
        $result = mysqli_query($conn, $sql);

        $mail->isHTML(true);

        $mail->Body = "Maak een account aan met deze code: '{$code}'";

        $mail->addAddress("{$SendMailTo}");

        if($mail->send()){
            echo 'Er is een mail verstuurd naar: ' . $SendMailTo . '<br>';
            echo 'Vul de code in die je hebt ontvangen: <br>';
            
            echo '<form action="" method="POST">';
                echo '<input type="text" name="code" placeholder="Code..."><br>';
                echo '<input type="submit" name="userverify" value="Verstuur">';
            echo '</form>';
        }else{
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }

        $mail->smtpClose();
    }

    function SendAnwerToMail($SendMailTo, $vraag, $antwoord){
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
    }
?>