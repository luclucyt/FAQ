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
    <main>
        <div class="vraag-wrapper">
            <?php 
                //extract the code from the url and display the question and answer
                $code = $_GET['code'];
                $code = mysqli_real_escape_string($conn, $code);

                $sql = "SELECT * FROM vragen WHERE code = '$code'";

                echo "<a href='../PHP/faq.php' class='back'><img src='../img/arrow.png'> <span>Ga terug</span></a>";

                $result = mysqli_query($conn, $sql);

                while($row = mysqli_fetch_assoc($result)){
                    echo "<h1>" . $row['vraag'] . "</h1>";
                    echo "<div class='info-wrapper'>";
                        echo "<div>";
                            echo "|<img src='../img/user.png' alt='user' class='user img'>| ";
                            echo $row['beantwoordDoor'];
                        echo "</div>";

                        echo "<div>";
                            echo "|<img src='../img/calendar.png' alt='antwoord' class='antwoord img'>| ";
                            echo $row['aangemaakt'];
                        echo "</div>";

                        echo "<div>";
                            echo "|<img src='../img/pen.png' alt='aangemaakt' class='aangemaakt img'>| ";
                            echo $row['geantwoord'];
                        echo "</div>";
                    echo "</div>";

                    echo "<hr>";
                    

                    echo "<p>" . $row['antwoord'] . "</p>";
                }
            ?>
        </div>
    </main>
</body>
</html>