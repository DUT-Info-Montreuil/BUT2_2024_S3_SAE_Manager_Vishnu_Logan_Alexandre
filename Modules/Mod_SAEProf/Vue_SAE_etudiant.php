<?php
require_once 'vue_generique.php';
include_once __DIR__ . '/../Mod_accueil/VueAccueil.php';


class Vue_SAE_etudiant extends VueGenerique {
    private $vue;

    public function __construct() {
    parent::__construct();

    $this->vue = new VueAccueil();
    }

    public function afficher_sae_etudiant($projet, $ressource, $rendus) {
        $this->vue->afficherAccueil();
    
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
                    foreach ($ressource as $ress) {
                        $titre = htmlspecialchars($ress['titre']);
                        echo "<p>$titre</p>";
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
                    
                            echo "
                            <div class='deposit-item'>
                                <p><strong>$titre</strong></p>
                                <p>Description : $description</p>
                                <p>Date limite : $date_limite</p>
                                <p>Type : $type</p>
                                <!-- Formulaire pour rendre un fichier -->
                                <form method='POST' action='index.php?module=sae&action=rendreFichier&id_rendu=$id_rendu&id_projet=$id_projet' enctype='multipart/form-data'>
                                    <label for='fichier-$id_rendu'>Déposer un fichier :</label>
                                    <input type='file' name='fichier' id='fichier-$id_rendu' required>
                                    <button type='submit'>Rendre</button>
                                </form>
                            </div>";
                        }
                    } else {
                        echo "<p>Aucun dépôt trouvé pour ce projet.</p>";
                    }
        echo "
                    <button class='groupe-button'><a href='index.php?module=groupe&action=formulaire&projetId=$id_projet'>Groupes</button>
                </div>
            </div>
        </div>";
       }
}
?>
