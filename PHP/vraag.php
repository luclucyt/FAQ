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

    
    <!-- Font -->
    <link href="https://fonts.cdnfonts.com/css/nimbus-sans-l" rel="stylesheet">
</head>

<?php 
    include 'root.php';
?>

<body>
    <main>
        <div class="vraag-wrapper">
            <?php
                if(!isset($_GET['code'])){
                    header("Location: FAQ.php");
                    exit();
                }

                //extract the code from the url and display the question and answer
                $code = $_GET['code'];

                $code = mysqli_real_escape_string($conn, $code);

                $sql = "SELECT * FROM vragen WHERE code = '$code'";

                echo "<a href='FAQ.php' class='back'><img src='../img/arrow.png' alt=''><span>Ga terug</span></a>";

                if(isset($_SESSION['admin'])) {
                    if($_SESSION['admin'] == true){

                        $sql = "SELECT * FROM vragen WHERE code = '$code'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);

                        $code = $row['code'];
                        
                        echo "<a href='../PHP/beantwoord.php?code={$code}&edit=1' class='edit'><img src='../img/pen.png'></a>";                    
                    }
                }

                $result = mysqli_query($conn, $sql);

                while($row = mysqli_fetch_assoc($result)){
                    echo "<h1 class='vraag'>" . $row['vraag'] . "</h1>";
                    echo "<div class='info-wrapper'>";
                        echo "<div>";
                            echo "|<img src='../img/user.png' alt='user' class='user img'>| ";
                            if($row['beantwoordDoor'] == ""){
                                echo "Nog niet beantwoord";
                            }
                            else{
                                echo $row['beantwoordDoor'];
                            }
                        echo "</div>";

                        echo "<div>";
                            echo "|<img src='../img/calendar.png' alt='antwoord' class='antwoord img'>| ";
                            echo $row['aangemaakt'];
                        echo "</div>";

                        echo "<div>";
                            echo "|<img src='../img/pen.png' alt='aangemaakt' class='aangemaakt img'>| ";
                            if($row['geantwoord'] == "0000-00-00"){
                                echo "Nog niet beantwoord";
                            }
                            else{
                                echo $row['geantwoord'];
                            }
                        echo "</div>";

                        echo "<div>";
                            echo "|<img src='../img/eye.png' alt='views' class='views img'>| ";
                            echo ($row['views'] + 1) . " keer bekeken";
                        echo "</div>";


                    echo "</div>";

                    echo "<hr>";
                    

                    echo "<div class='antwoordText'>";

                    $antwoord = $row['antwoord'];
                    $antwoord = str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', "", $antwoord);

                        echo "<p>" . $antwoord . "</p>";
                    echo "</div>";
                }
            ?>

            <?php 
                //get the code from the url and update the views count
                $code = $_GET['code'];
                $code = mysqli_real_escape_string($conn, $code);

                $sql = "SELECT * FROM vragen WHERE code = '$code'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                $views = $row['views'];
                $views++;

                $sql = "UPDATE vragen SET views = '$views' WHERE code = '$code'";
                mysqli_query($conn, $sql);
            ?>
        </div>
    </main>
</body>
</html>