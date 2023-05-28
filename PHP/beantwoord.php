<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beantwoord FAQ || SD-lab</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../CSS/root.css">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/beantwoord.css">

    <!-- JS -->
    <script src="../JS/beantwoord.js" defer></script>
</head>

<?php 
    include 'root.php';
?>

<body>
    <?php
        if($_SESSION['admin'] == false){
            echo "Je bent geen admin";
            exit();
        }

        //get all questions that are not answered in order of oldest to newest
        $sql = "SELECT * FROM vragen WHERE status = 'Ingediend' ORDER BY 'vraagID'";
        $result = mysqli_query($conn, $sql);

        //if no questions are found
        if(mysqli_num_rows($result) == 0){
            echo "Geen vragen gevonden";
            exit();    
        }
        echo "<div class='vragen-wrapper'>";
            //loop through all questions (if any) and display them
            while($row = mysqli_fetch_assoc($result)){
                echo '<a class="beantwoordVraag" data-vraagId="'. $row['vraagID'] . '" data-vraag="' . $row['vraag'] . '">';
                    echo "<div class='vraag-wrapper'>";
                        echo "<h1>" . $row['vraag'] . "</h1>";
                        echo "<p>" . $row['mail'] . "</p>";
                    echo "</div>";
                echo '</a>';
            }
    ?>

    <form class="beantwoord-wrapper" action="" method="POST"></form>

    <?php
        if(isset($_POST['beantwoordButton'])){

            echo "<script>alert('beantwoord btn is pressed');</script>";

            $vraagID = $_POST['vraagID'];
            $antwoord = $_POST['antwoord'];
            if(isset($_POST['isPublic'])){
                $isPublic = $_POST['isPublic'];
            }
            else{
                $isPublic = 0;
            }
            

            //get the vraag from vraagID
            $sql = "SELECT * FROM vragen WHERE vraagID = '$vraagID'";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $vraag = $row['vraag'];
            }

            if($_POST['veranderVraag'] != ""){
                $vraag = $_POST['veranderVraag'];
            }

            $vraagID = mysqli_real_escape_string($conn, $vraagID);
            $antwoord = mysqli_real_escape_string($conn, $antwoord);
            $isPublic = mysqli_real_escape_string($conn, $isPublic);
            $vraag = mysqli_real_escape_string($conn, $vraag);
           

            $sql = "UPDATE vragen SET status = 'Beantwoord' where vraagID = '$vraagID'";            
            $result = mysqli_query($conn, $sql);

            $sql = "UPDATE vragen SET antwoord = '$antwoord' where vraagID = '$vraagID'"; 
            $result = mysqli_query($conn, $sql);

            $sql = "UPDATE vragen SET beantwoordDoor = '" . $_SESSION['userName'] . "' where vraagID = '$vraagID'"; 
            $result = mysqli_query($conn, $sql);

            $sql = "UPDATE vragen SET geantwoord = '" . date("Y-m-d") . "' where vraagID = '$vraagID'"; 
            $result = mysqli_query($conn, $sql);

            if(isset($isPublic)){
                $sql = "UPDATE vragen SET public = '1' where vraagID = '$vraagID'"; 
                $result = mysqli_query($conn, $sql);
            }else{
                $sql = "UPDATE vragen SET public = '0' where vraagID = '$vraagID'"; 
                $result = mysqli_query($conn, $sql);
            }

            if(isset($vraag)){
                $sql = "UPDATE vragen SET vraag = '$vraag' where vraagID = '$vraagID'"; 
                $result = mysqli_query($conn, $sql);
            }

            if($result){
                echo "Vraag beantwoord";

                //send mail to user
                $sql = "SELECT * FROM vragen WHERE vraagID = '$vraagID'";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)){
                    $code = $row['code'];
                    $vraag = $row['vraag'];
                    $mail = $row['mail'];

                    SendAnwerToMail($mail, $vraag, $antwoord, $code);
                }
            }else{
                echo "Er is iets fout gegaan";
            }
        }
    ?>
</body>
</html>

<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>

