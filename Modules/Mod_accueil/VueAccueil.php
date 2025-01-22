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
                    <li class="Icon"><a href="index.php?module=accueil&action=afficherUtilisateur"><img src="Modules/Mod_accueil/imgAccueil/utilisateur.png" alt="Profile Icon"></li>
                    <li class="Icon"><img src="Modules/Mod_accueil/imgAccueil/chercher.png" alt="Search Icon"></li>
                    <li class="Icon"><img src="Modules/Mod_accueil/imgAccueil/cloche.png" alt="Settings Icon"></li>
                    <li class="Icon"><a href="index.php?module=menuAccueil"><img src="Modules/Mod_accueil/imgAccueil/maison.png" alt="Home Icon"></a></li>
                </ul>
                <div id="decoIcon">
                    <a href='index.php?module=connexion&action=deconnexion'><img src="Modules/Mod_accueil/imgAccueil/se-deconnecter.png" alt="Deconnexion Icon"></a>    
                </div>
            </nav>
        
        <?php
    }
    

    public function afficherUtilisateur($utilisateur) {
        $this->afficherAccueil();
        ?>

        <div class="user-info">
            <h2>Informations de l'utilisateur</h2>
            <ul>
                <li><strong>Nom :</strong> <?= htmlspecialchars($utilisateur['nom']) ?></li>
                <li><strong>Prénom :</strong> <?= htmlspecialchars($utilisateur['prenom']) ?></li>
                <li><strong>Login :</strong> <?= htmlspecialchars($utilisateur['login']) ?></li>
                <li><strong>Date de création :</strong> <?= htmlspecialchars($utilisateur['date_creation']) ?></li>
                <li><strong>Rôle :</strong> <?= htmlspecialchars($utilisateur['role']) ?></li>
            </ul>
            <a href="index.php?module=accueil" class="btn btn-primary">Retour</a>
        </div>
        <?php
    }
    
    
}

?>
