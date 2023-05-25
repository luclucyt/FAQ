<?php   
    include 'mail/PHPMailer.php';
    include 'mail/SMTP.php';
    include 'mail/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    function SetMailUp($SendMailTo){
        //set up the mail
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->Username = 'vanbriemenlucas@gmail.com';
        $mail->Password = 'bfyrldyjmdvrzryv'; /* DO NOT CHANGE THIS */
        $mail->setFrom('vanbriemenlucas@gmail.com');
        $mail->isHTML(true);
        $mail->addAddress("{$SendMailTo}");


        return $mail;
    }

    function SendCodeToMail($SendMailTo, $vraag, $vraagID, $conn){
       
        $mail = SetMailUp($SendMailTo);

        $mail->Subject = 'Test mail';

        // generate a 6 digit code for the user to enter
        $code = rand(100000, 999999);
        $mail->Body = "Bedankt voor je vraag: '{$vraag}'' <br> Je code is: '{$code}'<br>
        of klik op: <a href='http://localhost:3000/PHP/verify.php?code={$code}'>deze link o, hem te verirveren</a>";

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
            echo 'Er is een mail verstuurd naar: ' . $SendMailTo . ' (of klik op de link)<br>';
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

    function SendLoginMail($SendMailTo, $conn){
        $mail = SetMailUp($SendMailTo);

        $mail->Subject = 'Test mail';

        // generate a 6 digit code for the user to enter
        $code = rand(100000, 999999);
        $mail->Body = "Maak een account aan met deze code: '{$code}'";
        
        //get the userID from the database
        $sql = "SELECT id FROM users WHERE mail = '{$SendMailTo}'";
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
            $userID = $row['id'];
        }

        //write the code to the database
        $sql = "INSERT INTO userverify (id, userID, code) VALUES ('', '{$userID}', '{$code}')";
        $result = mysqli_query($conn, $sql);

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

    function SendAnwerToMail($SendMailTo, $vraag, $antwoord, $code){
        $mail = SetMailUp($SendMailTo);

        $mail->Subject = 'Test mail';
        $mail->Body = "Je vraag: '{$vraag}' is beantwoord met: '{$antwoord}'<br> 
        <a href='http://localhost:3000/PHP/vraag.php?code={$code}'>Klik hier om naar de vraag te gaan</a>";

        $mail->send();            
    }
?>