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
    include 'Root.php'; // Include 'Root.php' for necessary functionality
?>

<header>
    <nav>
        <ul class="menu">
            <li><a href="login.php">Login</a></li>
            <li><a href="beantwoord.php">Docent?</a></li>
        </ul>
    </nav>
</header>

<body>
    <div class="container">
        <h1>Stuur een vraag</h1>
        <form action="" method="POST" id="form-submit-new-wrapper">
            <input type="text" name="vraag" placeholder="Stel je vraag..." class="input-field"><br>
            <input type="email" name="mail" placeholder="School Mail..." value="88875@glr.nl" class="input-field"><br>

            <input type="submit" name="submitVraag" value="Verstuur" class="submit-button">
        </form>
    </div>
</body>
</html>


<?php
    if(isset($_POST['submitVraag'])){
        // Sanitize user input
        $vraag = mysqli_real_escape_string($conn, $_POST['vraag']);
        $mail = mysqli_real_escape_string($conn, $_POST['mail']);

        // Get the current date
        $date = date("Y-m-d");

        // prepare, bind and execute the SQL statement
        $stmt = mysqli_prepare($conn, "INSERT INTO vragen (vraagID, vraag, mail, antwoord, status, tags, beantwoordDoor, aangemaakt, ingediend, geantwoord, bewerkt) VALUES (?, ?, ?, '', 'Aangemaakt', '', '', ?, '', '', '')");
        mysqli_stmt_bind_param($stmt, "isss", $vraagID, $vraag, $mail, $date);
        mysqli_stmt_execute($stmt);

        // Get the last inserted ID
        $vraagID = mysqli_insert_id($conn);

        // Close the statement
        mysqli_stmt_close($stmt);

        if ($vraagID == ""){
            echo "Er is iets fout gegaan";
            exit();
        }

        SendCodeToMail($mail, $vraag, $vraagID); // Assuming the 'SendCodeToMail' function is defined elsewhere
    }

    if(isset($_POST['submitCode'])){
        // The code is submitted
        $code = mysqli_real_escape_string($conn, $_POST['code']);

        // prepare, bind and execute the SQL statement
        $stmt = mysqli_prepare($conn, "SELECT * FROM verify WHERE code = ?");
        mysqli_stmt_bind_param($stmt, "s", $code);
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        // Check if the code exists
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $vraagID = $row['vraagID'];
                $mail = $row['mail'];

                // Update the status to 'Ingediend'
                $stmt = mysqli_prepare($conn, "UPDATE vragen SET status = 'Ingediend' WHERE vraagID = ?");
                mysqli_stmt_bind_param($stmt, "i", $vraagID);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                // Get the current date
                $date = date("Y-m-d");

                // Update the date in ingediend
                $stmt = mysqli_prepare($conn, "UPDATE vragen SET ingediend = ? WHERE vraagID = ?");
                mysqli_stmt_bind_param($stmt, "si", $date, $vraagID);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                // Delete the code from the database
                $stmt = mysqli_prepare($conn, "DELETE FROM verify WHERE vraagID = ?");
                mysqli_stmt_bind_param($stmt, "i", $vraagID);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                echo '<script>alert("Je vraag is ingediend!")</script>';
            }
        }
        else{
            echo '<script>alert("De code is niet correct!")</script>';
        }
    }
?>
