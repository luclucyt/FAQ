<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ || SD-lab</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../CSS/root.css">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/faq.css">

    <!-- JS -->
    <script src="../JS/root.js" defer></script>
    <script src="../JS/FAQ.js" defer></script>
</head>

<body>
<?php
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    ?> <h2 class='FAQ-loggedIn'>Welkom <?= $_SESSION['name'] ?> </h2> <?php
}
?>
<div class="antwoord-wrapper">
    <div class="FAQ-filter-wrapper">
        <div>
            <h1 class="FAQ-title">FAQ:</h1>

            <input type="text" id="searchInput" placeholder="Zoek een vraag">
            <img src="../img/search.png" alt="Search Icon" class="search-icon">

            <select id="FAQ-filter-select">
                <option value="alles">Alles</option>
                <?php
                foreach ($tagList as $tag) {
                    ?> <option value="<?=$tag?>"> <?=$tag?></option> <?php
                }
                ?>

            </select>

            <a href="create.php" class="FAQ-create-BTN">Stel een vraag</a>
        </div>
    </div>

    <main>
        <?php
        foreach ($tagList as $tag) {
            displayVragen($tag, $conn);
        }
        ?>
    </main>

</div>
</body>
</html>