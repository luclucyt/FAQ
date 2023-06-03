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
    <link rel="stylesheet" href="../CSS/FAQ.css">

    <!-- JS -->
    <script src="../JS/root.js" defer></script>
    <script src="../JS/FAQ.js" defer></script>
</head>

<?php 
    include 'Root.php';
?>

<body>

    <div class="antwoord-wrapper">
        <div class="FAQ-filter-wrapper">
            <div>
                <h1 class="FAQ-title">FAQ:</h1>

                <input type="text" id="searchInput" placeholder="Zoek een vraag">
                <img src="../img/search.png" alt="Search Icon" class="search-icon">

                <select id="FAQ-filter-select">
                    <option value="alles">Alles</option>
                    <option value="algemeen">Algemeen</option>
                    <option value="technologie">Technologie</option>
                    <option value="rooster">Rooster</option>
                    <option value="cijfers">Cijfers</option>
                    <option value="activiteiten">Activiteiten</option>
                    <option value="overig">Overig</option>
                </select>

                <a href="create.php" class="FAQ-create-BTN">Stel een vraag</a>
            </div>
        </div>

<!--        <h1 class="FAQ-header">Vragen:</h1>-->
        <main>
                <?php displayVragen("Algemeen", $conn) ?>
                <?php displayVragen("Technologie", $conn) ?>
                <?php displayVragen("Rooster", $conn) ?>
                <?php displayVragen("Cijfers", $conn) ?>
                <?php displayVragen("Activiteiten", $conn) ?>
                <?php displayVragen("Overig", $conn) ?>
        </main>

        <?php
            function displayVragen($tags, $conn){
                $sql = "SELECT * FROM vragen WHERE status = 'Beantwoord' AND public = '1' AND tags = '$tags' ORDER BY views";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);

                $tags = strtolower($tags);

                while ($row = mysqli_fetch_assoc($result)) {
                    // display the questions with the answer
                    echo "<a href='vraag.php?code=" . $row['code'] . "' class=' FAQ-category-wrapper-BTN FAQ-category-wrapper-{$tags}'>";
                        echo "<div class='FAQ-vraag-main-wrapper '>";

                            $vraag = strip_tags($row['vraag']);
                            $antwoord = strip_tags($row['antwoord']);

                            echo "<h2 class='FAQ-vraag-vraag'>" . $vraag . "</h2>";
                            echo "<p class='FAQ-vraag-antwoord'>" . $antwoord . "</p>";

                        echo "</div>";
                    echo "</a>";
                }
            }
        ?>
    </div>

</body>
</html>