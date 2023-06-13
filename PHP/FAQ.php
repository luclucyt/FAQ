<?php
include 'root.php';
$_SESSION['isFirst'] = true;

$sql = "SELECT DISTINCT tags FROM vragen WHERE status = 'Beantwoord' AND public = '1'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $tagList[] = $row['tags'];
}

function displayVragen($tags, $conn)
{
    $sql = "SELECT * FROM vragen WHERE status = 'Beantwoord' AND public = '1' AND tags = '$tags' ORDER BY views DESC";
    $result = mysqli_query($conn, $sql);


    $tags = strtolower($tags);
    //make the first letter uppercase
    $tags = ucfirst($tags);

    ?>
    <div class='FAQ-category-wrapper active FAQ-category-wrapper-<?=$tags?>'>
        <h1 class='FAQ-category-title'><?=$tags?></h1>

        <?php

        $tags = strtolower($tags);
        while ($row = mysqli_fetch_assoc($result)) {

            $vraag = strip_tags($row['vraag']);
            $antwoord = strip_tags($row['antwoord']);
            $antwoord = str_replace("Powered by Froala Editor", "", $antwoord);

            $views = $row['views'];
            // display the questions with the answer

            ?>
            <a href='vraag.php?code=<?= $row['code'] ?>' class=' FAQ-category-wrapper-BTN FAQ-category-wrapper-<?=$tags?>'>
                <div class='FAQ-vraag-main-wrapper'>
                    <h2 class='FAQ-vraag-vraag'><?=$vraag?></h2>
                    <p class='FAQ-vraag-antwoord'><?=$antwoord?></p>

                    <img src='../img/tag.png' alt='' class='FAQ-vraag-views-icon'> <?=$tags?><br>
                    <img src='../img/eye.png' alt='' class='FAQ-vraag-views-icon'> <?=$views?>
                </div>
            </a>
            <?php
        }
    ?></div><?php
}

include 'FAQ-view.php';
