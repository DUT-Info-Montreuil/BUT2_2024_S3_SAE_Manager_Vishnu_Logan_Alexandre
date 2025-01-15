<?php
require_once 'vue_generique.php';
include_once __DIR__ . '/../Mod_accueil/VueAccueil.php';

class VueSAEProf extends VueGenerique {
    private $vue;

    public function __construct() {
        parent::__construct();
        $this->vue = new VueAccueil();
    }

    public function afficher_sae($projet, $ressource) {
        $this->vue->afficherAccueil();
        $description = htmlspecialchars($projet['description']);


        $id_projet = $projet['id'];

        echo "
        <div class='sae-container'>
            <div class='main-content'>

                <!-- Section Description -->
                <div class='description'>
                    <div class='description-header'>
                        <h2>Description</h2>
                        <!-- Image pour modifier -->
                        <img src='Modules/Mod_SAEProf/imgSAEProf/modification.png' alt='Modifier' class='icon-modify' onclick='toggleEditForm()'>
                    </div>
                    <div id='description-view'>
                        <p>$description</p>
                    </div>
                    <form id='edit-description-form' style='display: none;' method='POST' action='index.php?module=sae&action=majDescription&id=$id_projet'>
                        <textarea name='description' rows='5' cols='50'>$description</textarea>
                        <button type='submit'>Enregistrer</button>
                        <button type='button' onclick='toggleEditForm()'>Annuler</button>
                    </form>
                </div>

                <div class='resources'>
                    <div class='description-ressource'>
                        <h2>Ressources</h2>
                        <img src='Modules/Mod_SAEProf/imgSAEProf/modification.png' alt='Modifier' class='icon-modify'>
                        <img src='Modules/Mod_SAEProf/imgSAEProf/ajouter.png' alt='Ajouter' class='icon-ajouter' onclick='toggleAddResourceForm()'> 
                    </div>
            ";
                    foreach ($ressource as $ress){
                        $tire = $ress['titre'];
                        echo "<p>$tire</p>";
                    }
                        echo"<form id='add-resource-form' style='display: none;' method='POST' action='index.php?module=sae&action=ajouterRessource&id=$id_projet'>
                        <input type='text' name='titre' placeholder='Titre de la ressource' required>
                        <textarea name='description' placeholder='Description' rows='3'></textarea>
                        <input type='text' name='url' placeholder='url de ressource'>
                        <button type='submit'>Ajouter</button>
                        <button type='button' onclick='toggleAddResourceForm()'>Annuler</button>
                    </form>
                </div>

                <!-- Section Dépôts -->
                <div class='deposits'>
                    <div class='description-depot'>
                        <h2>Dépôts</h2>
                        <img src='Modules/Mod_SAEProf/imgSAEProf/modification.png' alt='Modifier' class='icon-modify'>
                        <img src='Modules/Mod_SAEProf/imgSAEProf/ajouter.png' alt='Ajouter' class='icon-ajouter'>
                    </div>
                    <div class='deposit-item'>
                        <p><strong>Dépôt de groupe</strong></p>
                        <p>Date limite : dimanche 20 janvier à 23h59</p>
                    </div>
                </div>

                <!-- Bouton pour accéder aux évaluations -->
                <button class='evaluation-button'>Accéder aux évaluations</button>
            </div>
        </div>

        <script>
        function toggleAddResourceForm() {
            const addForm = document.getElementById('add-resource-form');
            addForm.style.display = addForm.style.display === 'none' ? 'block' : 'none';
        }
        </script>


        <!-- Script JavaScript -->
        <script>
            function toggleEditForm() {
                const descriptionView = document.getElementById('description-view');
                const editForm = document.getElementById('edit-description-form');
                // Basculer entre les vues
                if (editForm.style.display === 'none') {
                    editForm.style.display = 'block';
                    descriptionView.style.display = 'none';
                } else {
                    editForm.style.display = 'none';
                    descriptionView.style.display = 'block';
                }
            }
        </script>
        ";
    }
}
?>
