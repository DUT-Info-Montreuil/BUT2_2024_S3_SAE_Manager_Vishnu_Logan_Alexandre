<?php

require_once 'ModeleMenuAccueil.php';
require_once 'VueMenuAccueil.php';
require_once 'VueMenuAccueilEtudiant.php';


class ContMenuAccueil {
    private $modele;
    private $vue;
    private $action;

    public function __construct() {
        $this->modele = new ModeleMenuAccueil();
        $this->vue = new VueMenuAccueil();
        $this->action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'mod';

    }
    public function afficherPageAccueil() {

        $this->vue->afficherAccueil();
    }

    public function actionEtudiant() {        
        $vueEtudiant = new VueMenuAccueilEtudiant();
        $vueEtudiant->afficherAccueil();
    }

    public function action() {

        if ($_SESSION['role'] === 'etudiant') {
            $this->actionEtudiant(); 
            return;
        }

        switch ($this->action) {

            case 'connexion':
                echo "connexion";
                break;
            case 'supprimer':
            
                if (isset($_GET['id'])) {
                    $annee_id = intval($_GET['id']);
                    $this->modele->supprimerAnnee($annee_id);
                    header('Location: index.php?module=mod&action=mod');
                }
                break;


            case 'ajouter':
                    $this->vue->afficherFormulaireAjoutAnnee();
                    break;
            case 'enregistrer':
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $annee_debut = intval($_POST['annee_debut']);
                            $annee_fin = intval($_POST['annee_fin']);
                            $this->modele->ajouterAnnee($annee_debut, $annee_fin);
                            header('Location: index.php?module=mod&action=mod');
                        }
                        break;
                    
                
            default:
                $this->vue->afficherAccueil();
                break;
                
        }

    }
}

    


?>
