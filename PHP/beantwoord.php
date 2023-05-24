<?php 
    include 'Root.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- JS -->
    <script src="../JS/beantwoord.js" defer></script>
</head>

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

        //loop through all questions (if any) and display them
        while($row = mysqli_fetch_assoc($result)){
            echo "<h1>" . $row['vraag'] . "</h1>";
            echo "<p>" . $row['mail'] . "</p>";
            echo '<a class="beantwoordVraag" data-vraagId="'. $row['vraagID'] . '">Beantwoord</a>';
        }
    ?>

    <form class="beantwoord-wrapper"  action="" method="POST">

    </form>

    <?php
        if(isset($_POST['beantwoordButton'])){

            echo "<script>alert('beantwoord btn is pressed');</script>";

            $vraagID = $_POST['vraagID'];
            $antwoord = $_POST['antwoord'];

            echo "<script>alert('$vraagID');</script>";
            echo "<script>alert('$antwoord');</script>";

            $sql = "UPDATE vragen SET status = 'Beantwoord' where vraagID = '$vraagID'";
            $result = mysqli_query($conn, $sql);

            $sql = "UPDATE vragen SET antwoord = '$antwoord' where vraagID = '$vraagID'";
            $result = mysqli_query($conn, $sql);

            $sql = "UPDATE vragen SET beantwoordDoor = '" . $_SESSION['userName'] . "' where vraagID = '$vraagID'";
            $result = mysqli_query($conn, $sql);

            $sql = "UPDATE vragen SET geantwoord = '" . date("Y-m-d") . "' where vraagID = '$vraagID'";
            $result = mysqli_query($conn, $sql);

            if($result){
                echo "Vraag beantwoord";
            }else{
                echo "Er is iets fout gegaan";
            }
        }
    ?>
</body>
</html>