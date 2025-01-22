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
        $prof_role = $_SESSION['role'];
        if($prof_role==='enseignant'){
            $data = $this->modeleAccueil->getDataAccueil();

            echo "<div class='menu-container'>";
            
            foreach ($data as $annee) {
                $annee_debut = $annee['annee_debut'];
                $annee_fin = $annee['annee_fin'];
                $annee_id=$annee['id'];
                echo "<div class='year'>";
                echo "<button class='toggle-year'>$annee_debut / $annee_fin  </button>";

                echo "<div class='semesters'>";
            
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
                            
                        echo "</div>";
                    }
                
                    echo "</div>";
                    echo "</div>"; 
                }
                
                echo "</div>"; 
                
                echo "</div>";
                
            }
        
        
            echo "</div>";
        }
        else{
            header("Location:index.php?module=connexion&action=deconnexion");
            exit();
        } 
    }
    
    
    
}

?>
