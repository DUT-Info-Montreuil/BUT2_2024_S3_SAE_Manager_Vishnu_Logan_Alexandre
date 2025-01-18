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
                    <li class="Icon"><img src="Modules/Mod_accueil/imgAccueil/utilisateur.png" alt="Profile Icon"></li>
                    <li class="Icon"><img src="Modules/Mod_accueil/imgAccueil/chercher.png" alt="Search Icon"></li>
                    <li class="Icon"><img src="Modules/Mod_accueil/imgAccueil/cloche.png" alt="Settings Icon"></li>
                    <li class="Icon"><a href="index.php?module=accueil"><img src="Modules/Mod_accueil/imgAccueil/maison.png" alt="Home Icon"></a></li>
                </ul>
                <div id="decoIcon">
                    <a href='index.php?module=connexion&action=deconnexion'><img src="Modules/Mod_accueil/imgAccueil/se-deconnecter.png" alt="Deconnexion Icon"></a>    
                </div>
            </nav>
        
            <a id = "test" href='index.php?module=menuAccueil&action=menuAccueil'>Afficher Menu</a>
            <a id = "test2" href='index.php?module=groupe&action=formulaire'>test2</a>
            
        <?php
    }
    
}

?>
