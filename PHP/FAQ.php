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

<?php
    include 'root.php';
    $_SESSION['isFirst'] = true;
?>

<body>
    <?php
        if(isset($_SESSION['loggedIn'])){
            if($_SESSION['loggedIn']){
                echo "<h2 class='FAQ-loggedIn'>Welkom " . $_SESSION['name'] . "</h2>";
            }
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
                        $sql = "SELECT DISTINCT tags FROM vragen WHERE status = 'Beantwoord' AND public = '1'";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['tags'] . "'>" . $row['tags'] . "</option>";
                        }
                    ?>
                    
                </select>

                <a href="create.php" class="FAQ-create-BTN">Stel een vraag</a>
            </div>
        </div>

        <main>
            <?php
                $sql = "SELECT DISTINCT tags FROM vragen WHERE status = 'Beantwoord' AND public = '1'";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    displayVragen($row['tags'], $conn);
                }
            ?>
        </main>

        <?php
            function displayVragen($tags, $conn){
                $sql = "SELECT * FROM vragen WHERE status = 'Beantwoord' AND public = '1' AND tags = '$tags' ORDER BY views";
                $result = mysqli_query($conn, $sql);


                $tags = strtolower($tags);

                while ($row = mysqli_fetch_assoc($result)) {
                    // display the questions with the answer
                    //if isFirst == true then add the class FAQ-category-wrapper-first
                    if($_SESSION['isFirst']){
                        echo "<a href='vraag.php?code=" . $row['code'] . "' class=' FAQ-category-wrapper-BTN FAQ-category-wrapper-{$tags} FAQ-category-wrapper-first'>";
                        $isFirst = false;
                    } else {
                        echo "<a href='vraag.php?code=" . $row['code'] . "' class=' FAQ-category-wrapper-BTN FAQ-category-wrapper-{$tags}'>";
                    }
                        echo "<div class='FAQ-vraag-main-wrapper '>";

                            $vraag = strip_tags($row['vraag']);
                            $antwoord = strip_tags($row['antwoord']);
                            $antwoord = str_replace("Powered by Froala Editor", "", $antwoord);
                            $tags = $row['tags'];
                            $views = $row['views'];

                            echo "<h2 class='FAQ-vraag-vraag'>" . $vraag . "</h2>";
                            echo "<p class='FAQ-vraag-antwoord'>" . $antwoord . "</p>";
                            echo "<p>Tags: " . $tags . "</p>";
                            echo "<p>Views: " . $views . "</p>";

                        echo "</div>";
                    echo "</a>";

                    $_SESSION['isFirst'] = false;
                }
            }
        ?>
    </div>

</body>
</html>