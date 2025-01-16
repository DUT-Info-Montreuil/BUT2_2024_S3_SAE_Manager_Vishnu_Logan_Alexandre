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
                            $type = isset($rendu['type']) ? htmlspecialchars($rendu['type']) : 'Type non défini';
                            echo "
                            <div class='deposit-item'>
                                <p><strong>$titre</strong></p>
                                <p>Description : $description</p>
                                <p>Date limite : $date_limite</p>
                                <p>Type : $type</p>
                            </div>";
                        }
                    } else {
                        echo "<p>Aucun dépôt trouvé pour ce projet.</p>";
                    }
        echo "
                </div>
            </div>
        </div>";
    }
}
?>
