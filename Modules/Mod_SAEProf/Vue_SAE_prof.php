<?php
require_once 'vue_generique.php';
include_once __DIR__ . '/../Mod_accueil/VueAccueil.php';


class VueSAEProf extends VueGenerique {
    private $vue;
    

    public function __construct() {
        parent::__construct();
        $this->vue = new VueAccueil();

    }

    public function afficher_sae($projet) {
        $this->vue->afficherAccueil();
        $description = $projet['description'];
        $id_projet=$projet['id'];

        echo "
        <div class='sae-container'>

            <div class='main-content'>
                <div class='description'>
                <div class='description-header'>
                    <h2>Description</h2>
                    <img src='Modules/Mod_SAEProf/imgSAEProf/modification.png' alt='Modifier' class='icon-modify'>
                </div>
                    <div id='description-view'>
                        <p>$description</p>
                    </div>
                    <form id='edit-description-form' style='display: none;' method='POST' action='index.php?action=updateDescription&id=$id_projet'>
                        <textarea name='description' rows='5' cols='50'>$description</textarea>
                        <button type='submit'>Enregistrer</button>
                        <button type='button' onclick='toggleEditForm()'>Annuler</button>
                    </form>
                </div>
                <div class='resources'>
                    <div class='description-ressource'>

                        <h2>Ressources</h2>
                        <img src='Modules/Mod_SAEProf/imgSAEProf/modification.png' alt='Modifier' class='icon-modify'>
                        <img src='Modules/Mod_SAEProf/imgSAEProf/ajouter.png' alt='ajouter' class='icon-ajouter'>

                        </div>

                    <ul>
                        <li><a href='#'>Resource 1</a></li>
                        <li><a href='#'>Resource 2</a></li>
                    </ul>
                </div>

                <div class='deposits'>
                    <div class='description-depot'>

                        <h2>Dépôts</h2>
                        <img src='Modules/Mod_SAEProf/imgSAEProf/modification.png' alt='Modifier' class='icon-modify'>
                        <img src='Modules/Mod_SAEProf/imgSAEProf/ajouter.png' alt='ajouter' class='icon-ajouter'>

                        </div>

                    <div class='deposit-item'>
                        <p><strong>Dépôt de groupe</strong></p>
                        <p>Date limite : dimanche 20 janvier à 23h59</p>
                    </div>
                </div>

                <button class='evaluation-button'><a href='index.php?module=evaluation&projet_id=$id_projet'>Accéder aux évaluations</a></button>
            </div>
        </div>";
    }
}
?>
