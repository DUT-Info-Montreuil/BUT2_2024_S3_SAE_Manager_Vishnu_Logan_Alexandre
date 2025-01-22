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
            echo "<button class='add-semester'><a href='index.php?module=menuAccueil&action=ajouterSemestre&annee_id=" . $annee['id'] . "'>Ajouter un semestre</a></button>";

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
                    echo "<button class='delete'><a href='index.php?module=menuAccueil&action=supprimerProjet&id=$projet_id'>Supprimer</a></button>";                    echo "</div>";
                }
                echo "<button class='delete-semester'><a href='index.php?module=menuAccueil&action=supprimerSemestre&id=" . $semestre['id'] . "'>Supprimer le semestre</a></button>";

                echo "<button class='add-project'><a href='index.php?module=menuAccueil&action=ajouterProjet&semestre_id=" . $semestre['id'] . "'>Ajouter un projet</a></button>";
                echo "</div>";
                echo "</div>"; 
            }
            
            echo "</div>"; 
            echo "<button class='delete-year'><a href='index.php?module=menuAccueil&action=supprimer&id=" . $annee['id'] . "'>Supprimer</a></button>";
            echo "</div>";
            
        }
        echo "<button class='add-year'><a href='index.php?module=menuAccueil&action=ajouter'>Ajouter une année</a></button>";

        
        echo "</div>"; 
    }
    public function afficherFormulaireAjoutProjet($semestre_id) {
        echo "<div class='form-container'>";
        echo "<h2>Ajouter un projet</h2>";
        echo "<form method='POST' action='index.php?module=menuAccueil&action=enregistrerProjet'>";
        echo "<input type='hidden' name='semestre_id' value='$semestre_id'>";
        echo "Titre du projet : <input type='text' name='titre' required><br><br>";
        echo "Description : <textarea name='description' required></textarea><br><br>";
        echo "Responsable ID : <input type='number' name='responsable_id' required><br><br>";
        echo "<button type='submit'>Ajouter</button>";
        echo "</form>";
        echo "</div>";
    }
    public function afficherFormulaireAjoutSemestre($annee_id) {
        echo "<div class='form-container'>";
        echo "<h2>Ajouter un semestre</h2>";
        echo "<form method='POST' action='index.php?module=menuAccueil&action=enregistrerSemestre'>";
        echo "<input type='hidden' name='annee_id' value='$annee_id'>";
        echo "Nom du semestre : <input type='text' name='nom' required><br><br>";
        echo "<button type='submit'>Ajouter</button>";
        echo "</form>";
        echo "</div>";
    }
    
    

    public function ajouterProjet($titre, $semestre_id) {
        $query = self::getBdd()->prepare("INSERT INTO projets (titre, semestre_id) VALUES (:titre, :semestre_id)");
        $query->execute([
            ':titre' => $titre,
            ':semestre_id' => $semestre_id
        ]);
    }
    
    
    public function afficherFormulaireAjoutAnnee() {
        echo "<div class='form-container'>";
        echo "<h2>Ajouter une année universitaire</h2>";
        echo "<form method='POST' action='index.php?module=menuAccueil&action=enregistrer'>";
        echo "Année début : <input type='number' name='annee_debut' required><br><br>";
        echo "Année fin : <input type='number' name='annee_fin' required><br><br>";
        echo "<button type='submit'>Ajouter</button>";
        echo "</form>";
        echo "</div>";
    }
    
    
}

?>
