<?php

require_once 'ModeleMenuAccueil.php';
require_once 'VueMenuAccueil.php';
require_once 'VueMenuAccueilEtudiant.php';
require_once 'VueMenuAccueilAdmin.php';


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
    public function actionAdmin(){
        $vueAdmin=new VueMenuAccueilAdmin();
        
        switch ($this->action) {

            case 'supprimer':
                
                if (isset($_GET['id'])) {
                    $annee_id = intval($_GET['id']);
                    $this->modele->supprimerAnnee($annee_id);
                    header('Location: index.php?module=menuAccueil');
                }
                break;

            case 'ajouter':
                    $vueAdmin->afficherFormulaireAjoutAnnee();
                    break;
            case 'enregistrer':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $annee_debut = intval($_POST['annee_debut']);
                        $annee_fin = intval($_POST['annee_fin']);
                        $this->modele->ajouterAnnee($annee_debut, $annee_fin);
                        header('Location: index.php?module=menuAccueil');
                    }
                    break;
                case 'ajouterProjet':
                    if (isset($_GET['semestre_id'])) {
                        $semestre_id = intval($_GET['semestre_id']);
                        $vueAdmin->afficherFormulaireAjoutProjet($semestre_id);
                    }
                    break;                    
                case 'enregistrerProjet':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $titre = htmlspecialchars($_POST['titre']);
                    $description = htmlspecialchars($_POST['description']);
                    $responsable_id = intval($_POST['responsable_id']);
                    $semestre_id = intval($_POST['semestre_id']);
            
                    if ($this->modele) {
                        $this->modele->ajouterProjet($titre, $description, $responsable_id, $semestre_id);
                        header('Location: index.php?module=menuAccueil');
                    } else {
                        
                        die("Erreur : Le modèle n'est pas initialisé.");
                    }
                }
                case 'ajouterSemestre':
                    if (isset($_GET['annee_id'])) {
                        $annee_id = intval($_GET['annee_id']);
                        $vueAdmin->afficherFormulaireAjoutSemestre($annee_id);
                    } else {
                        echo "Erreur : ID de l'année manquant.";
                    }
                    break;
                
                case 'enregistrerSemestre':
        
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $nom = htmlspecialchars($_POST['nom']);
                    $annee_id = intval($_POST['annee_id']);
                
                    if ($this->modele) {
                        $this->modele->ajouterSemestre($nom, $annee_id);
                        header('Location: index.php?module=menuAccueil'); 
                    } else {
                            die("Erreur : Le modèle n'est pas initialisé.");
                        }
                    }
                break;
                case 'supprimerSemestre':
                    if (isset($_GET['semestre_id'])) {
                        $semestre_id = intval($_GET['semestre_id']);
                        $this->modele->supprimerSemestre($semestre_id);
                        header('Location: index.php?module=menuAccueil'); 
                    } else {
                        echo "Erreur : ID du semestre manquant.";
                    }
                    break;
                
                    
                
                
                break;
                case 'supprimerProjet':
                    if (isset($_GET['id'])) {
                        $projet_id = intval($_GET['id']);
                        $this->modele->supprimerProjet($projet_id);
                        header('Location: index.php?module=menuAccueil');
                    } else {
                        echo "Erreur : ID du projet manquant.";
                    }
                    break;
                default:
                    $vueAdmin->afficher();
                    break;
                }
    }

    public function action() {

        if ($_SESSION['role'] === 'etudiant') {
            $this->actionEtudiant(); 
            return;
        }
        elseif($_SESSION['role']==="admin"){
            $this->actionAdmin();
            return;
        }

        switch ($this->action) {

            case 'connexion':
                echo "connexion";
                break;

            default:
                $this->vue->afficherAccueil();
                break;
                
        }

    }
}

    


?>
