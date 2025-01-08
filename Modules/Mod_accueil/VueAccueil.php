<?php
require_once 'vue_generique.php';


class VueAccueil extends VueGenerique {

    public function __construct() {
        parent::__construct();
    }

    public function afficherAccueil() {
        ?>
        <?php include_once __DIR__ . '/../../head.php';
                include_once __DIR__ . '/../../header.php';
            ?>
            <nav class="nav">
                <ul id="listeIcones">
                    <li><img src="Modules/Mod_accueil/imgAccueil/utilisateur.png" alt="Profile Icon"></li>
                    <li><img src="Modules/Mod_accueil/imgAccueil/chercher.png" alt="Search Icon"></li>
                    <li><img src="Modules/Mod_accueil/imgAccueil/cloche.png" alt="Settings Icon"></li>
                    <li><img src="Modules/Mod_accueil/imgAccueil/maison.png" alt="Home Icon"></li>
                </ul>
            </nav>
        <?php
    }
}

?>
