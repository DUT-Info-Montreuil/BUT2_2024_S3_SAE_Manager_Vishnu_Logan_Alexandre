<header class="header">
    <?php
        if (isset($_SESSION['login'])) {
            $login = htmlspecialchars($_SESSION['login'], ENT_QUOTES, 'UTF-8');
            $id = htmlspecialchars($_SESSION['id'], ENT_QUOTES, 'UTF-8');
            $role = htmlspecialchars($_SESSION['role'], ENT_QUOTES, 'UTF-8');
            echo "
            <div>
                <p>Vous êtes connecté sous l'identifiant $login</p>
            </div>";
        }
    ?>
</header>