<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>stel een vraag</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../CSS/root.css">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/create.css">
</head>

<?php
    include 'root.php';
?>

<body>
<div class="new-send-wrapper">
    <div>
        <h1>Stuur een vraag</h1>
        <form action="" method="POST" id="new-form-wrapper">
            <input type="text" name="vraag" placeholder="Stel je vraag"><br>
            <textarea name="vraagOmschrijving" id="vraag" cols="30" rows="10" placeholder="Omscrijf je vraag"></textarea><br>

            <select name="tags" id="new-tags">
                <option value="algemeen">Algemeen</option>
                <option value="Technologie">Technologie</option>
                <option value="rooster">Rooster</option>
                <option value="cijfers">Cijfers</option>
                <option value="activiteiten">Activiteiten</option>
                <option value="overig">Overig</option>
            </select>

            <input type="email" name="mail" placeholder="School Mail" value="88875@glr.nl"><br>

            <input type="submit" name="submitVraag" value="Verstuur">
        </form>
    </div>
</div>
</body>
</html>

<?php
if(isset($_POST['submitVraag'])){
    //write the vraag to the database
    $vraag = $_POST['vraag'];
    $vraagOmschrijving = $_POST['vraagOmschrijving'];
    $tags = $_POST['tags'];
    $mail = $_POST['mail'];

    $vraag = mysqli_real_escape_string($conn, $vraag);
    $vraagOmschrijving = mysqli_real_escape_string($conn, $vraagOmschrijving);
    $tags = mysqli_real_escape_string($conn, $tags);
    $mail = mysqli_real_escape_string($conn, $mail);

    //current date
    $date = date("Y-m-d");

    //generate a code that will be used to display the question (10 digits with letters and numbers)
    $code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);

    //insert into database
    $sql = "INSERT INTO vragen (vraagID, vraag, omschrijving, mail, antwoord, status, tags, beantwoordDoor, aangemaakt, ingediend, geantwoord, bewerkt, code, views) VALUES ('', '$vraag','$vraagOmschrijving' , '$mail', '', 'Aangemaakt', '{$tags}', '', '{$date}', '', '', '', '{$code}', '0')";

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

    $code = mysqli_real_escape_string($conn, $code);

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