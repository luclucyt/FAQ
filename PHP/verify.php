<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<?php 
    include 'root.php';
?>

<body>
    <?php
        //get the code from the url
        $code = $_GET['code'];

        $sql = "SELECT * FROM verify WHERE code = '$code'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $vraagID = $row['vraagID'];
        }

        //update the status of the question to answered
        $sql = "UPDATE vragen SET status = 'Ingediend' WHERE vraagID = '$vraagID'";
        $result = mysqli_query($conn, $sql);

        $sql = "SELECT * FROM vragen where vraagID = '$vraagID'";
        $result = mysqli_query($conn, $sql);


        while($row = mysqli_fetch_assoc($result)){
            $vraagCode = $row['code'];
            echo "<br>Code: " . $vraagCode;
        }

        header("Location: ../PHP/vraag.php?code=$vraagCode");
    ?>    
</body>
</html>