<?php
require_once 'vue_generique.php';
include_once __DIR__ . '/../Mod_accueil/VueAccueil.php';

class VueMenuAccueilAdmin extends VueGenerique {
    private $vueAccueil;
    private $modeleAccueil;
    public function __construct() {
        parent::__construct();
        $this->vueAccueil = new VueAccueil();
        $this->vueAccueil->afficherAccueil();
        $this->modeleAccueil = new ModeleMenuAccueil();
    }

    public function afficher() {
        $admin_role = $_SESSION['role'];
        if($admin_role==='admin'){
            $data = $this->modeleAccueil->getDataAccueil();

            echo "<div class='menu-container'>";
            
            foreach ($data as $annee) {
                $annee_debut = $annee['annee_debut'];
                $annee_fin = $annee['annee_fin'];
                $annee_id=$annee['id'];
                echo "<div class='year'>";
                echo "<button class='toggle-year'>$annee_debut / $annee_fin  </button>";

                echo "<div class='semesters'>";
                echo "<button class='add-semester' onclick=\"window.location.href='index.php?module=menuAccueil&action=ajouterSemestre&annee_id=$annee_id'\">Ajouter un semestre</button>";

                foreach ($annee['semestres'] as $semestre) {
                    $semestre_nom = $semestre['nom'];
                    echo "<div class='semester'>";
                    echo "<button class='toggle-semester'>$semestre_nom</button>";

                    
                    $semestre_id=$semestre['id'];
                    echo "<div class='subjects'>";
                    foreach ($semestre['projets'] as $projet) {
                        
                        $projet_titre = $projet['titre'];
                        $projet_id=$projet['id'];
                        echo "<div class='subject'>";
                        echo "<span>$projet_titre</span>";
                        echo "<button class='edit'onclick=\"window.location.href='index.php?module=sae&action=afficher&id=$projet_id'\">Modifier</button>";
                        echo "<button class='delete'onclick=\"window.location.href='index.php?module=menuAccueil&action=supprimerProjet&id=$projet_id'\">Supprimer</button>";                    
                        echo "</div>";
                    }
                    echo "<button class='delete-semester'onclick=\"window.location.href='index.php?module=menuAccueil&action=supprimerSemestre&semestre_id=$semestre_id'\">Supprimer le semestre</a></button>";

                    echo "<button class='add-project'onclick=\"window.location.href='index.php?module=menuAccueil&action=ajouterProjet&semestre_id=$semestre_id'\">Ajouter un projet</button>";
                    echo "</div>";
                    echo "</div>"; 
                }
                
                echo "</div>"; 
                echo "<button class='delete-year'onclick=\"window.location.href='index.php?module=menuAccueil&action=supprimer&id=$annee_id'\">Supprimer</button>";
                echo "</div>";
                
            }
            echo "<button class='add-year'onclick=\"window.location.href='index.php?module=menuAccueil&action=ajouter'\">Ajouter une année</button>";

            
            echo "</div>"; 

            echo "<div class='form-ajoutUser'>
                        <button class='inscription-user'onclick=\"window.location.href='index.php?module=admin&action=inscription'\">Ajouter un utilisateur</button>";
        }
        else{
            header("Location:index.php?module=connexion&action=deconnexion");
            exit();
        } 
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
