<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ || SD-lab</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../CSS/FAQ.css">
</head>

<?php 
    include 'Root.php';
?>

<header>
    <nav>
        <ul>
            <li><a href="login.php">Login</a></li>
            <li><a href="beantwoord.php">Docent?</a></li>
        </ul>
    </nav>
</header>

<body>
    <div>
        <h1>Stuur een vraag</h1>
        <form action="" method="POST" id="form-submit-new-wrapper">
            <input type="text" name="vraag" placeholder="Stel je vraag..."><br>
            <input type="email" name="mail" placeholder="School Mail..." value="88875@glr.nl"><br>

            <input type="submit" name="submitVraag" value="Verstuur">
        </form>

        <h1>FAQ:</h1>
        <?php
            //display all the questions that are answered
            $sql = "SELECT * FROM vragen WHERE status = 'Beantwoord' AND public = '1'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            while($row = mysqli_fetch_assoc($result)){
                //display the questions with the answer
                echo "<a href='vraag.php?code=" . $row['code'] . "'>";
                    echo "<div class='vraag-wrapper'>";
                        echo "<h2>" . $row['vraag'] . "</h2>";
                        echo "<p>" . $row['antwoord'] . "</p>";
                    echo "</div>";
                echo "</a>";
            }
        ?>
    </div>
</body>
</html>


<?php
    if(isset($_POST['submitVraag'])){
        //write the vraag to the database
        $vraag = $_POST['vraag'];
        $mail = $_POST['mail'];

        //current date
        $date = date("Y-m-d");

        //generate a code that will be used to display the question (10 digits with letters and numbers)
        $code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);

        //insert into database
        $sql = "INSERT INTO vragen (vraagID, vraag, mail, antwoord, status, tags, beantwoordDoor, aangemaakt, ingediend, geantwoord, bewerkt, code) VALUES ('', '$vraag', '$mail', '', 'Aangemaakt', '', '', '{$date}', '', '', '', '{$code}')";
        $result = mysqli_query($conn, $sql);

        //get the vraagID
        $sql = "SELECT vraagID FROM vragen WHERE vraag = '{$vraag}' AND mail = '{$mail}'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $vraagID = $row['vraagID'];
        }

        if ($vraagID == ""){
            echo "Er is iets fout gegaan";
            exit();
        }

        SendCodeToMail($mail, $vraag, $vraagID, $conn);
    }

    if(isset($_POST['submitCode'])){
        //the code is submitted
        $code = $_POST['code'];

        //check if the code exists in the database
        $sql = "SELECT * FROM verify WHERE code = '{$code}'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        //if the code exists
        if($resultCheck > 0){
            while($row = mysqli_fetch_assoc($result)){
                $vraagID = $row['vraagID'];
                $mail = $row['mail'];

                $sql = "UPDATE vragen SET status = 'Ingediend' WHERE vraagID = '{$vraagID}'";
                $result = mysqli_query($conn, $sql);

                //current date
                $date = date("Y-m-d");

                //update the date in ingdiend
                $sql = "UPDATE vragen SET ingediend = '{$date}' WHERE vraagID = '{$vraagID}'";
                $result = mysqli_query($conn, $sql);

                //delete the code from the database
                $sql = "DELETE FROM verify WHERE vraagID = '{$vraagID}'";
                $result = mysqli_query($conn, $sql);

                echo '<script>alert("Je vraag is ingediend!")</script>';
            }
        }
        else{
            echo '<script>alert("De code is niet correct!")</script>';
        }
    }
?>