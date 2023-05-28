<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antwoord FAQ || sd-lab</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../CSS/root.css">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/vraag.css">
</head>

<?php 
    include 'Root.php';
?>

<body>
    <?php 
        //extract the code from the url and display the question and answer
        $code = $_GET['code'];

        $sql = "SELECT * FROM vragen WHERE code = '$code'";
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
            echo "<h1>" . $row['vraag'] . "</h1>";
            echo "<p>Beantwoord door: " . $row['beantwoordDoor'] . "</p>";
            echo "<p>Beantwoord op: " . $row['geantwoord'] . "</p>";
            echo "<p>Aangemaakt op: " . $row['aangemaakt'] . "</p>";

            echo "<p>" . $row['antwoord'] . "</p>";
        }
    ?>
</body>
</html>