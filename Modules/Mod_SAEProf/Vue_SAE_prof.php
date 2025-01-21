<?php
require_once 'vue_generique.php';
include_once __DIR__ . '/../Mod_accueil/VueAccueil.php';

class VueSAEProf extends VueGenerique {
    private $vue;

    public function __construct() {
        parent::__construct();
        $this->vue = new VueAccueil();
    }

    public function afficher_sae($projet, $ressource, $rendus) {
        $this->vue->afficherAccueil();
        $description = htmlspecialchars($projet['description']);
        $id_projet = $projet['id'];

        echo "
        <div class='sae-container'>
            <div class='main-content'>

                <div class='description'>
                    <div class='description-header'>
                        <h2>Description</h2>
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
                        <img src='Modules/Mod_SAEProf/imgSAEProf/ajouter.png' alt='Ajouter' class='icon-ajouter' onclick='toggleAddResourceForm()'> 
                    </div>";
                    foreach ($ressource as $ress) {
                        $titre = $ress['titre'];
                        $url = $ress['url'];
                        echo "<p><a href='$url' target='_blank'>$titre</a></p>";
                    }
                    
                    echo "
                    <form id='add-resource-form' style='display: none;' method='POST' action='index.php?module=sae&action=ajouterRessource&id=$id_projet'>
                        <input type='text' name='titre' placeholder='Titre de la ressource' required>
                        <textarea name='description' placeholder='Description' rows='3'></textarea>
                        <input type='text' name='url' placeholder='URL de ressource'>
                        <button type='submit'>Ajouter</button>
                        <button type='button' onclick='toggleAddResourceForm()'>Annuler</button>
                    </form>
                </div>";

        echo "
                <div class='deposits'>
                    <div class='description-depot'>
                        <h2>Dépôts</h2>
                        <img src='Modules/Mod_SAEProf/imgSAEProf/ajouter.png' alt='Ajouter' class='icon-ajouter' onclick='toggleAddRenduForm()'>
                    </div>

                    <!-- Formulaire d'ajout de dépôt -->
                    <form id='add-rendu-form' style='display: none;' method='POST' action='index.php?module=sae&action=ajouterRendu&id=$id_projet'>
                        <input type='text' name='titre' placeholder='Titre du dépôt' required>
                        <textarea name='description' placeholder='Description' rows='3'></textarea>
                        <input type='datetime-local' name='date_limite' required>
                        <select name='type'>
                            <option value='groupe'>Groupe</option>
                            <option value='individuel'>Individuel</option>
                        </select>
                        <button type='submit'>Ajouter</button>
                        <button type='button' onclick='toggleAddRenduForm()'>Annuler</button>
                    </form>";

                    if (!empty($rendus) && is_array($rendus)) {
                        foreach ($rendus as $rendu) {
                            $id_rendu = $rendu['id'];
                            $titre = htmlspecialchars($rendu['titre']);
                            $description = htmlspecialchars($rendu['description']);
                            $date_limite = htmlspecialchars($rendu['date_limite']);
                            $type =$rendu['TYPE'];
                    
                            echo "
                            <div class='deposit-item'>
                                <a href='index.php?module=sae&action=afficherDepot&id_rendu=$id_rendu' class='rendu-link'>
                                    <p><strong>$titre</strong></p>
                                    <p>Description : $description</p>
                                    <p>Date limite : $date_limite</p> 
                                    <p>Type : $type</p>
                                </a>
                                <button onclick='toggleEditRenduForm($id_rendu)'>Modifier</button>
                            </div>
                            <form id='edit-rendu-form-$id_rendu' style='display: none;' method='POST' action='index.php?module=sae&action=modifierRendu&id=$id_rendu'>
                                <input type='hidden' name='projet_id' value='$id_projet'>    
                                <input type='text' name='titre' value='$titre' required>
                                <textarea name='description' rows='3'>$description</textarea>
                                <input type='datetime-local' name='date_limite' value='" . date('Y-m-d\TH:i', strtotime($date_limite)) . "' required>
                                <select name='type'>
                                    <option value='groupe' " . ($type === 'groupe' ? 'selected' : '') . ">Groupe</option>
                                    <option value='individuel' " . ($type === 'individuel' ? 'selected' : '') . ">Individuel</option>
                                </select>
                                <button type='submit'>Enregistrer</button>
                                <button type='button' onclick='toggleEditRenduForm($id_rendu)'>Annuler</button>
                            </form>";
                        }
                    
                    

                    } else {
                        echo "<p>Aucun dépôt trouvé pour ce projet.</p>";
                    }
                    
        echo "
                </div>

                <button class='evaluation-button'>Accéder aux évaluations</button>
            </div>
        </div>

        <script>
            function toggleAddResourceForm() {
                const addForm = document.getElementById('add-resource-form');
                addForm.style.display = addForm.style.display === 'none' ? 'block' : 'none';
            }

            function toggleEditForm() {
                const descriptionView = document.getElementById('description-view');
                const editForm = document.getElementById('edit-description-form');
                if (editForm.style.display === 'none') {
                    editForm.style.display = 'block';
                    descriptionView.style.display = 'none';
                } else {
                    editForm.style.display = 'none';
                    descriptionView.style.display = 'block';
                }
            }

            function toggleAddRenduForm() {
                const addForm = document.getElementById('add-rendu-form');
                addForm.style.display = addForm.style.display === 'none' ? 'block' : 'none';
            }

            function toggleEditRenduForm(id) {
                const form = document.getElementById('edit-rendu-form-' + id);
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            }
        </script>";
    }
    public function afficherDepot($rendu, $groupes) {
        $this->vue->afficherAccueil();
        $titre = htmlspecialchars($rendu['titre']);
        $description = htmlspecialchars($rendu['description']);
        $date_limite = htmlspecialchars($rendu['date_limite']);
        $type = htmlspecialchars($rendu['TYPE']); // Vérifiez le type ici
    
        echo "
        <div class='depot-container'>
            <h1>$titre</h1>
            <div class='depot-header'>
                <p>Type de dépôt : $type</p>
                <p>Date limite : $date_limite</p>
                <p>Description : $description</p>
            </div>
            <table class='depot-table'>
                <thead>
                    <tr>";
    
        if ($type === 'groupe') {
            echo "<th>Nom du groupe</th>";
        } else {
            echo "<th>Nom de l'étudiant</th>";
        }
    
        echo "
                        <th>Fichier déposé</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>";
    
        if (!empty($groupes)) {
            foreach ($groupes as $groupe) {
                if ($type === 'groupe') {
                    // Vérifiez si 'groupe_nom' existe
                    $nom_affichage = isset($groupe['groupe_nom']) ? htmlspecialchars($groupe['groupe_nom']) : 'Nom de groupe non disponible';
                } else {
                    // Vérifiez si 'prenom' et 'nom' existent
                    $prenom = isset($groupe['prenom']) ? htmlspecialchars($groupe['prenom']) : 'Prénom inconnu';
                    $nom = isset($groupe['nom']) ? htmlspecialchars($groupe['nom']) : 'Nom inconnu';
                    $nom_affichage = $prenom . ' ' . $nom;
                }
                
    
                $fichier_url = htmlspecialchars($groupe['fichier_url']);
                $note = isset($groupe['note']) ? htmlspecialchars($groupe['note']) : '--';
                $date_soumission = isset($groupe['date_soumission']) ? htmlspecialchars($groupe['date_soumission']) : '--';
    
                echo "
                <tr>
                    <td>$nom_affichage</td>
                    <td>
                        <a href='$fichier_url' target='_blank'>Télécharger</a> (soumis le $date_soumission)
                    </td>
                    <td>
                        <form method='POST' action='index.php?module=sae&action=ajouterOuModifierNote'>
                            <input type='hidden' name='rendu_id' value='{$rendu['id']}'>
                            <input type='hidden' name='fichier_id' value='{$groupe['fichier_id']}'>
                            <input type='number' name='note' value='$note' min='0' max='20' required>
                            <button type='submit'>Enregistrer</button>
                        </form>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Aucun fichier déposé pour ce rendu.</td></tr>";
        }
    
        echo "
                </tbody>
            </table>
        </div>";
    }
    
    
    
    
}
?>