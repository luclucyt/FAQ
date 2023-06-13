<header>
    <nav>
        <a href="FAQ.php"><img src="https://sd-lab.nl/wp-content/uploads/2018/07/Artboard-1-8.png" alt="Logo" class="logo"></a>
        <ul class="menu">
            <li><a href="https://sd-lab.nl">FAQ</a></li>
            <?php
                if(isset($_SESSION['admin'])) {
                    if($_SESSION['admin'] == true){
                        echo "<li><a href='beantwoord.php'>Beantwoord</a></li>";
                    }
                }
            ?>
            <li><a href="create.php">Stel een vraag</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>