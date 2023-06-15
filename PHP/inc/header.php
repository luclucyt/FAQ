<?php
//if the session is not started, start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <nav>
        <a href="https://sd-lab.nl/">
            <img src="https://sd-lab.nl/wp-content/uploads/2018/07/Artboard-1-8.png" alt="Logo" class="logo">
        </a>


        <ul class="menu">
            <li><a href="https://sd-lab.nl/">Home</a></li>
            <li><a href="https://sd-lab.nl/category/nieuws/">Aankondigingen</a></li>
            <li><a href="https://sd-lab.nl/mediatechnologie-links/">Links</a> </li>
            <li class="dropdown"><a href="#" class="dropbtn">FAQ</a>
                <div class="dropdown-content">
                    <a href="FAQ.php">FAQ</a>
                    <?php
                    if (isset($_SESSION['admin']) && $_SESSION['admin']) {
                        echo "<a href='beantwoord.php'>Beantwoord</a>";
                    }
                    ?>
                    <a href="create.php">Stel een vraag</a>
                    <a href="login.php">Login</a>
                </div>
            </li>
        </ul>

    </nav>
</header>