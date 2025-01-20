<?php
require_once 'vue_generique.php';
include_once __DIR__ . '/../Mod_accueil/VueAccueil.php';

class VueMenuAccueil extends VueGenerique {
    private $vueAccueil;
    private $modeleAccueil;
    public function __construct() {
        parent::__construct();
        $this->vueAccueil = new VueAccueil();
        $this->vueAccueil->afficherAccueil();
        $this->modeleAccueil = new ModeleMenuAccueil();
    }

    public function afficherAccueil() {

        $data = $this->modeleAccueil->getDataAccueil();

        echo "<div class='menu-container'>";
        
        foreach ($data as $annee) {
            $annee_debut = $annee['annee_debut'];
            $annee_fin = $annee['annee_fin'];
            echo "<div class='year'>";
            echo "<button class='toggle-year'>$annee_debut / $annee_fin</button>";

            



            echo "<div class='semesters'>";
            foreach ($annee['semestres'] as $semestre) {
                $semestre_nom = $semestre['nom'];
                echo "<div class='semester'>";
                echo "<button class='toggle-semester'>$semestre_nom</button>";
                
                
                echo "<div class='subjects'>";
                foreach ($semestre['projets'] as $projet) {
                    $projet_titre = $projet['titre'];
                    $projet_id=$projet['id'];
                    echo "<div class='subject'>";
                    echo "<span>$projet_titre</span>";
                    echo "<button class='edit'><a href='index.php?module=sae&action=afficher&id=$projet_id'>Modifier</a></button>";
                    echo "<button class='delete'>Supprimer</button>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>"; 
            }
            
            echo "</div>"; 
            echo "<button class='delete-year'><a href='index.php?module=mod&action=supprimer&id=" . $annee['id'] . "'>Supprimer</a></button>";
            echo "</div>";
            
        }
        echo "<button class='add-year'><a href='index.php?module=mod&action=ajouter'>Ajouter une année</a></button>";

        
        echo "</div>"; 
    }

    public function afficherFormulaireAjoutAnnee() {
        echo "<div class='form-container'>";
        echo "<h2>Ajouter une année universitaire</h2>";
        echo "<form method='POST' action='index.php?module=mod&action=enregistrer'>";
        echo "Année début : <input type='number' name='annee_debut' required><br><br>";
        echo "Année fin : <input type='number' name='annee_fin' required><br><br>";
        echo "<button type='submit'>Ajouter</button>";
        echo "</form>";
        echo "</div>";
    }
    
    
}

?>
