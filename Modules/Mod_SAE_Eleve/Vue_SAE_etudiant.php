<?php
require_once 'vue_generique.php';
include_once __DIR__ . '/../Mod_accueil/VueAccueil.php';


class Vue_SAE_etudiant extends VueGenerique {
    private $vue;
    private $modele;
    public function __construct() {
    parent::__construct();

    $this->vue = new VueAccueil();
    $this->vue->afficherAccueil();
    $this->modele = new Modele_sae_etudiant();
    }
public function afficher_sae_etudiant($projet, $ressources, $rendus) {
       
    
        if (!$projet) {
            echo "<p>Projet introuvable</p>";
            return;
        }
    
        $description = htmlspecialchars($projet['description']);
        $id_projet = $projet['id'];
    
        echo "
        <div class='sae-container'>
            <div class='main-content'>
                <div class='description'>
                    <div class='description-header'>
                        <h2>Description</h2>
                    </div>
                    <div id='description-view'>
                        <p>$description</p>
                    </div>
                </div>
    
                <div class='resources'>
                    <div class='description-ressource'>
                        <h2>Ressources</h2>
                    </div>";
                    foreach ($ressources as $ress) {
                        $titre = htmlspecialchars($ress['titre']);
                        $ressourceURL = htmlspecialchars($ress['url']);
                        echo "<p class='ressource'><a href='$ressourceURL' target='_blank'>$titre</a></p>";
                    }
        echo "
                </div>
                <div class='deposits'>
                    <div class='description-depot'>
                        <h2>Dépôts</h2>
                    </div>";
    
                    if (!empty($rendus) && is_array($rendus)) {
                        foreach ($rendus as $rendu) {
                            $id_rendu = $rendu['id'];
                            $titre = htmlspecialchars($rendu['titre']);
                            $description = htmlspecialchars($rendu['description']);
                            $date_limite = htmlspecialchars($rendu['date_limite']);
                            $type = $rendu['TYPE'];
                            $fichierRendu = $rendu['fichierRendu'];
                
                            if ($fichierRendu) {
                                echo "<div class='deposit-item'>
                                        <div class='deposit-info'>
                                            <p><strong>$titre</strong></p>
                                            <p>Description : $description</p>
                                            <p>Date limite : $date_limite</p>
                                            <p>Type : $type</p>
                                            <p>Fichier rendu : <a href='$fichierRendu'>Télécharger</a></p>
                                            <form method='POST' action='index.php?module=sae&action=supprimerRendu&id_rendu=$id_rendu&id=$id_projet'>
                                                <input type='hidden' name='type' value='$type'>
                                                <button class='supprimer-btn' type='submit'>Supprimer le rendu</button>
                                            </form>
                                        </div>
                                      </div>";
                            } else {
                                $groupe = $this->modele->getGroupeByEtudiantId($_SESSION['id'], $id_projet); 

                                echo "<div class='deposit-item'>
                                        <div class='deposit-info'>
                                            <p><strong>$titre</strong></p>
                                            <p>Description : $description</p>
                                            <p>Date limite : $date_limite</p>
                                            <p>Type : $type</p>";

                                if ($type == "groupe" && !$groupe) {
                                    echo "<p style='color: red;'>Veuillez rejoindre un groupe pour faire le rendu de groupe.</p>";
                                } else {
                                   
                                    echo "<form method='POST' action='index.php?module=sae&action=rendreFichier&id_rendu=$id_rendu&id=$id_projet' enctype='multipart/form-data'>
                                            <label for='fichier-$id_rendu'>Déposer un fichier :</label>
                                            <input type='file' name='fichier' id='fichier-$id_rendu' required>
                                            <input type='hidden' name='type' value='$type'>
                                            <button class='rendre-btn' type='submit'>Rendre</button>
                                        </form>";
                                }

                                echo "  </div>
                                    </div>";
                            }
                        }
                    } else {
                        echo "<p>Aucun dépôt trouvé pour ce projet.</p>";
                    }
        echo "
                    <button class='groupe-button' onclick=\"window.location.href='index.php?module=groupe&action=formulaire&id=$id_projet'\">Groupes</button>
                </div>
            </div>
        </div>";
       }
}
?>
