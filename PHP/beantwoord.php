<?php
    session_start();
    if(!isset($_SESSION['admin']) || !$_SESSION['admin']) {
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beantwoord FAQ || SD-lab</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../CSS/root.css">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/beantwoord.css">
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' />


    <!-- JS -->
    <script src="../JS/beantwoord.js" defer></script>
    
    <!-- Font -->
    <link href="https://fonts.cdnfonts.com/css/nimbus-sans-l" rel="stylesheet">
</head>

<?php 
    include 'root.php';
?>

<body>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'></script>


    <select>
        <option value="">Alles</option>
        <option value="algemeen">Algemeen</option>
        <option value="techonogie">Techonogie</option>
        <option value="rooster">Rooster</option>
        <option value="cijfers">Cijfers</option>
        <option value="activiteiten">Activiteiten</option>
        <option value="overig">Overig</option>
    </select>

    <script>
        let vragen = document.getElementsByClassName('beantwoordVraag');
        let select = document.getElementsByTagName('select')[0];

        select.addEventListener('change', function(){
            for(let i = 0; i < vragen.length; i++){
                if(vragen[i].getAttribute('data-tag') === select.value || select.value === ""){
                    vragen[i].style.display = "block";
                }else{
                    vragen[i].style.display = "none";
                }
            }
        });
    </script>


    <?php
        if (!isset($_SESSION['admin'])) {
            if (!$_SESSION['admin']) {
                echo "Je bent geen docent";
                exit();
            }
            echo "je bent niet ingelogd";
            exit();
        }

        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        else{
            $page = 1;
        }


        $offset = ($page - 1) * 25;


        //check how many questions are not answered
        $sql = "SELECT vraagID FROM vragen WHERE status = 'Ingediend'";
        $result = mysqli_query($conn, $sql);
        $total = mysqli_num_rows($result);

        //get all questions that are not answered in order of oldest to newest
        $sql = "SELECT * FROM vragen WHERE status = 'Ingediend' ORDER BY 'vraagID' LIMIT 25 OFFSET $offset";
        $result = mysqli_query($conn, $sql);

        //if no questions are found
        if(mysqli_num_rows($result) == 0){
            echo "Geen vragen gevonden";
        }

        
        echo "<div class='vragen-wrapper'>";
            //loop through all questions (if any) and display them
            while($row = mysqli_fetch_assoc($result)){
                echo '<a class="beantwoordVraag" data-tag="' . $row['tags'] . '" data-vraagId="'. $row['vraagID'] . '" data-vraag="' . $row['vraag'] . '" data-omschrijving="' . $row['omschrijving'] . '">';
                    echo "<div class='vraag-wrapper'>";
                        echo "<h1>" . $row['vraag'] . "</h1>";
                        echo "<p>" . $row['mail'] . "</p>";
                    echo "</div>";
                echo '</a>';
            }


            // Display next and previous page links if needed
            $totalPages = ceil($total / 25); // Calculate total pages
            if ($totalPages > 1) {
                echo "<div class='pagination'>";
                if ($page > 1) {
                    echo "<a href='?page=" . ($page - 1) . "' class='prev'>Vorige pagina</a>";
                }
                if ($page < $totalPages) {
                    echo "<a href='?page=" . ($page + 1) . "' class='next'>Volgende pagina</a>";
                }
                echo "</div>";
            }

        echo "</div>";
    ?>

    <form class="beantwoord-wrapper" action="" method="POST">
        <input type="hidden" name="vraagID" id="vraagID">
        
        <h2 id="vraagElement">Vraag: </h2>
        <p class="vraag-omschrijving">Omschrijving:</p>

        <input type="text" name="veranderVraag" placeholder="Verander vraag..." class="veranderVraag"><br>
        
        <label for="isPublic">Publiek?</label>
        <input type="checkbox" name="isPublic" value="0" id="isPublic">

        <label for="categorie">Categorie:</label>
        <select name="categorie" id="categorie">
            <option value="Algemeen">Algemeen</option>
            <option value="Techonogie">Techonogie</option>
            <option value="Rooster">Rooster</option>
            <option value="Cijfers">Cijfers</option>
            <option value="Activiteiten">Activiteiten</option>
            <option value="Overig">Overig</option>
        </select>
        
        <textarea name="antwoord" placeholder="Antwoord..." required="required" id="editor"></textarea>
        
        <input type="submit" name="beantwoordButton" value="Beantwoord" class="beantwoordButton">
    </form>
    <?php
        //get the code from the url
        if(isset($_GET['edit']) && $_GET['edit'] == 1){
            $code = $_GET['code'];
            //get the question from the code
            $sql = "SELECT * FROM vragen WHERE code = '$code'";
            $result = mysqli_query($conn, $sql);
            
            while($row = mysqli_fetch_assoc($result)){
                $vraagID = $row['vraagID'];
                $vraag = $row['vraag'];
                $omschrijving = $row['omschrijving'];
                $isPublic = $row['public'];
                $tag = $row['tags'];
                $antwoord = $row['antwoord'];
            }

            echo "<script>";
                echo "document.getElementById('vraagID').value = '$vraagID';";
                echo "document.getElementById('vraagElement').innerHTML = 'Vraag: $vraag';";
                echo "document.getElementsByClassName('vraag-omschrijving')[0].innerHTML = 'Omschrijving: $omschrijving';";
                echo "document.getElementById('isPublic').checked = '$isPublic';";
                echo "document.getElementById('categorie').value = '$tag';";
                echo "document.getElementById('editor').innerHTML = '$antwoord';";
            echo "</script>";
        }
    ?>
    <script>
        //allow img uploads
        let editor = new FroalaEditor('#editor', {
            // allow imgages.
            imageUploadURL: 'test.php',

            imageUploadParams: {
                id: 'my_editor'
            }
        });

    </script>
 
    <?php
        if(isset($_POST['beantwoordButton'])){
            $vraagID = $_POST['vraagID'];
            $antwoord = $_POST['antwoord'];
            if (isset($_POST['isPublic'])) {
                $isPublic = 1;
            } else {
                $isPublic = 0;
            }
            $tag = $_POST['categorie'];
            

            //get the vraag from vraagID
            $sql = "SELECT * FROM vragen WHERE vraagID = '$vraagID'";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $vraag = $row['vraag'];
            }

            if($_POST['veranderVraag'] != ""){
                $vraag = $_POST['veranderVraag'];
            }

            $vraagID = mysqli_real_escape_string($conn, $vraagID);
            $antwoord = mysqli_real_escape_string($conn, $antwoord);

            echo "<script>alert('$antwoord');</script>";
            $antwoord = str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', " ", $antwoord);

            $isPublic = mysqli_real_escape_string($conn, $isPublic);
            $vraag = mysqli_real_escape_string($conn, $vraag);
            $tag = mysqli_real_escape_string($conn, $tag);

            $sql = "UPDATE vragen SET status = 'Beantwoord' where vraagID = '$vraagID'";            
            $result = mysqli_query($conn, $sql);

            $sql = "UPDATE vragen SET antwoord = '$antwoord' where vraagID = '$vraagID'"; 
            $result = mysqli_query($conn, $sql);

            $sql = "UPDATE vragen SET beantwoordDoor = '" . $_SESSION['name'] . "' where vraagID = '$vraagID'";
            $result = mysqli_query($conn, $sql);

            $sql = "UPDATE vragen SET geantwoord = '" . date("Y-m-d") . "' where vraagID = '$vraagID'"; 
            $result = mysqli_query($conn, $sql);

            if (isset($_POST['isPublic'])) {
                $sql = "UPDATE vragen SET public = '1' where vraagID = '$vraagID'";
            }else{
                $sql = "UPDATE vragen SET public = '0' where vraagID = '$vraagID'";
            }
            $result = mysqli_query($conn, $sql);

            $sql = "UPDATE vragen SET tags = '$tag' where vraagID = '$vraagID'";
            $result = mysqli_query($conn, $sql);


            if(isset($vraag)){
                $sql = "UPDATE vragen SET vraag = '$vraag' where vraagID = '$vraagID'"; 
                $result = mysqli_query($conn, $sql);
            }

            if($result){
                echo "Vraag beantwoord";

                //send mail to user
                $sql = "SELECT * FROM vragen WHERE vraagID = '$vraagID'";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)){
                    $code = $row['code'];
                    $vraag = $row['vraag'];
                    $mail = $row['mail'];

                    SendAnwerToMail($mail, $vraag, $antwoord, $code);
                }
            }else{
                echo "Er is iets fout gegaan";
            }
        }
    ?>
</body>
</html>