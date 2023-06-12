<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stel || SD-lab</title>

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

            <input type="email" name="mail" placeholder="School Mail"
                <?php
                if(isset($_SESSION['mail'])){
                    echo "value='{$_SESSION['mail']}'";
                }
                ?>
            ><br>

            <input type="submit" name="submitVraag" value="Verstuur">
        </form>
    </div>
</div>
</body>
</html>