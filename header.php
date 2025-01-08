<header class="header">
    <?php
        if (isset($_SESSION['login'])) {
            $login = htmlspecialchars($_SESSION['login'], ENT_QUOTES, 'UTF-8');
            echo "
            <div>
                <p>Vous êtes connecté sous l'identifiant $login</p>
                <a href='index.php?module=connexion&action=deconnexion'>Déconnexion</a>
            </div>";
        }
    ?>
</header>