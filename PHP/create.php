<?php

//start session
ini_set('session.gc_maxlifetime', (3600 * 24 * 30 )); // 30 days
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


include "create-view.php";

if (isset($_POST['submitVraag'])) {

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
    while ($row = mysqli_fetch_assoc($result)) {
        $vraagID = $row['vraagID'];
    }

    if ($vraagID == "") {
        echo "Er is iets fout gegaan";
        exit();
    }
    SendCodeToMail($mail, $vraag, $vraagID, $conn);
}

if (isset($_POST['submitCode'])) {
    //the code is submitted
    $code = $_POST['code'];

    $code = mysqli_real_escape_string($conn, $code);

    //check if the code exists in the database
    $sql = "SELECT * FROM verify WHERE code = '{$code}'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    //if the code exists
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
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
    } else {
        echo '<script>alert("De code is niet correct!")</script>';
    }
}

