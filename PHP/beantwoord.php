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
    ?>  
</body>
</html>