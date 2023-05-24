<?php 
    ini_set('session.gc_maxlifetime', (3600 * 24 * 30 )); // 30 days
    session_start();
    //hide all errors
    error_reporting(0);
    include 'include/db.php';
    include 'include/sendMail.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
        if($_SESSION['admin'] == false){
            echo "Je bent geen admin";
            exit();
        }else{
            echo "Je bent een admin";
        }

        //get all questions that are not answered in order of oldest to newest
        $sql = "SELECT * FROM vragen WHERE status = 'Ingediend' ORDER BY 'id'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo "<script>alert('{$row['vraagID']}')</script>";
                echo "<h1>" . $row['vraag'] . "</h1>";
                echo "<p>" . $row['mail'] . "</p>";
                echo "<a href='beantwoord.php?id=" . $row['vraagID'] . "'>Beantwoord</a>";
            }
        }else{
            echo "Geen vragen gevonden";
        }
    ?>  
</body>
</html>