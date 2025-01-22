<?php
require_once 'vue_generique.php';
include_once __DIR__ . '/../Mod_accueil/VueAccueil.php';

class VueSAEProf extends VueGenerique {
    private $vue;

    public function __construct() {
        parent::__construct();
        $this->vue = new VueAccueil();
        $this->vue->afficherAccueil();
    }

    public function afficher_sae($projet, $ressource, $rendus) {
        $description = htmlspecialchars($projet['description']);
        $id_projet = intval($projet['id']);

        echo "
        <div class='sae-container'>
            <div class='main-content'>

                <!-- Description -->
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

                <!-- Ressources -->
                <div class='resources'>
                    <div class='description-ressource'>
                        <h2>Ressources</h2>
                        <img src='Modules/Mod_SAEProf/imgSAEProf/ajouter.png' alt='Ajouter' class='icon-ajouter' onclick='toggleAddResourceForm()'> 
                    </div>
                    <form id='add-resource-form' style='display: none;' method='POST' action='index.php?module=sae&action=ajouterRessource&id=$id_projet' enctype='multipart/form-data'>
                        <input type='text' name='titre' placeholder='Titre de la ressource' required>
                        <textarea name='description' placeholder='Description' rows='3'></textarea>
                        <input type='file' name='fichier_ressource' class='input-file'>
                        <button type='submit'>Ajouter</button>
                        <button type='button' onclick='toggleAddResourceForm()'>Annuler</button>
                    </form>";
                    foreach ($ressource as $ress) {
                        $titre = htmlspecialchars($ress['titre']);
                        $url = htmlspecialchars($ress['url']);
                        $id_ressource = intval($ress['id']);
                        echo "
                        <div class='ressource-item'>
                            <p class='ressource'><a href='$url' target='_blank'>$titre</a></p>
                            <button class='supprimer-btn' onclick=\"window.location.href='index.php?module=sae&action=supprimerRessource&id=$id_projet&id_ressource=$id_ressource'\">Supprimer</button>
                        </div>";
                    }
                    
                    echo "
                </div>";

        echo "
                <!-- Dépôts -->
                <div class='deposits'>
                    <div class='description-depot'>
                        <h2>Dépôts</h2>
                        <img src='Modules/Mod_SAEProf/imgSAEProf/ajouter.png' alt='Ajouter' class='icon-ajouter' onclick='toggleAddRenduForm()'>
                    </div>
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
                            $id_rendu = intval($rendu['id']);
                            $titre = htmlspecialchars($rendu['titre']);
                            $description = htmlspecialchars($rendu['description']);
                            $date_limite = htmlspecialchars($rendu['date_limite']);
                            $type = htmlspecialchars($rendu['TYPE']);
                    
                            echo "
                            <div class='deposit-item'>
                                <div>
                                    
                                        <p><strong>$titre</strong></p>
                                        <p>Description : $description</p>
                                        <p>Date limite : $date_limite</p> 
                                        <p>Type : $type</p>
                                    
                                    <button class='supprimer-btn' onclick=\"window.location.href='index.php?module=sae&action=supprimerRendu&id=$id_projet&id_rendu=$id_rendu'\">Supprimer</button>
                                    <button onclick='toggleEditRenduForm($id_rendu)'>Modifier</button>
                                <button class='btn-acceder-rendu' onclick=\"window.location.href='index.php?module=sae&action=afficherDepot&id_rendu=$id_rendu'\">Acceder</button>
                                
                                </div>
                                    <form id='edit-rendu-form-$id_rendu' style='display: none;' method='POST' action='index.php?module=sae&action=modifierRendu&id=$id_rendu'>                                <div class='rendu-edit'>
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
                                </div>
                                </form>
                            </div>";
                        }
                    } else {
                        echo "<p>Aucun dépôt trouvé pour ce projet.</p>";
                    }
                    
        echo "
                </div>
                <button class='evaluation-button'onclick=\"window.location.href='index.php?module=evaluation&projet_id=$id_projet'\">Accéder aux évaluations</a></button>
                <button class='groupe-button' onclick=\"window.location.href='index.php?module=groupe&action=formulaire&id=$id_projet'\">Groupes</button>
            </div>
        </div>

        <!-- Scripts -->
        <script>
            function toggleAddResourceForm() {
                const addForm = document.getElementById('add-resource-form');
                addForm.style.display = addForm.style.display === 'none' ? 'block' : 'none';
            }

            function toggleEditForm() {
                const descriptionView = document.getElementById('description-view');
                const editForm = document.getElementById('edit-description-form');
                editForm.style.display = editForm.style.display === 'none' ? 'block' : 'none';
                descriptionView.style.display = editForm.style.display === 'none' ? 'block' : 'none';
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
        $titre = htmlspecialchars($rendu['titre']);
    $description = htmlspecialchars($rendu['description']);
    $date_limite = htmlspecialchars($rendu['date_limite']);
    $type = htmlspecialchars($rendu['TYPE']);
    
    echo "
    <div class='depot-container'>
        <h1>$titre</h1>
        <div class='depot-header'>
            <p>Dépôt de type : $type</p>
            <p>Date limite : $date_limite</p>
            <p>Description : $description</p>
        </div>
        <table class='depot-table'>
            <thead>
                <tr>
                    <th>Nom du groupe</th>
                    <th>Fichiers déposés</th>
                    <th>Date de soumission</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>";
    if (!empty($groupes)) {
        foreach ($groupes as $groupe) {
            if ($type === 'groupe') {
                $nom_affichage = isset($groupe['groupe_nom']) ? htmlspecialchars($groupe['groupe_nom']) : 'Sans groupe';
            } else {
                $prenom = htmlspecialchars($groupe['prenom']);
                $nom = htmlspecialchars($groupe['nom']);
                $nom_affichage = "$prenom $nom";
            }
            $fichier_url = 'rendus/' . htmlspecialchars($groupe['fichier_url']);
            $date_soumission = htmlspecialchars($groupe['date_soumission']);
            $note = isset($groupe['note']) ? htmlspecialchars($groupe['note']) : '';

            echo "
            <tr>
                <td>$nom_affichage</td>
                <td><a href='$fichier_url' target='_blank'>Télécharger</a></td>
                <td>$date_soumission</td>
                <td>
                    <form method='POST' action='index.php?module=sae&action=ajouterOuModifierNote'>
                        <input type='hidden' name='fichier_id' value='" . intval($groupe['fichier_id']) . "'>
                        <input type='hidden' name='rendu_id' value='" . intval($rendu['id']) . "'>
                        <input type='number' name='note' value='$note' min='0' max='20' required>
                        <button type='submit'>Enregistrer</button>
                    </form>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Aucun fichier déposé pour ce rendu.</td></tr>";
    }
    echo "
            </tbody>
        </table>
    </div>";
    }
}
?>
