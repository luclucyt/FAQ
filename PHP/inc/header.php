<header>
    <nav>
        <ul class="menu">
            <li><a href="FAQ.php">FAQ</a></li>
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