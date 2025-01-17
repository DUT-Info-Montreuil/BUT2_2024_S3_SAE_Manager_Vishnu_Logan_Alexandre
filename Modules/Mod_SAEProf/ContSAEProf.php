<?php
require_once 'Vue_SAE_prof.php';
require_once 'Vue_SAE_etudiant.php';
require_once 'Modele_sae.php';

class ContSAEProf {
    private $vue;
    private $modele;

    public function __construct() {
        $this->vue = new VueSAEProf();
        $this->modele = new Modele_sae();
    }

    public function actionEtudiant() {
        $id_projet = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $projet = $this->modele->getProjet($id_projet);

        $ressources = $this->modele->getRessources($id_projet);
        $rendus = $this->modele->getRendus($id_projet);
        
        $vueEtudiant = new Vue_SAE_etudiant();
        $vueEtudiant->afficher_sae_etudiant($projet, $ressources, $rendus);
    }
    

    public function action() {
        $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'afficher';
        $id_projet = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($_SESSION['role'] === 'etudiant') {
            $this->actionEtudiant(); 
            return;
        }
    
        $projet = $this->modele->getProjet($id_projet);
        $ressources = $this->modele->getRessources($id_projet);
        $rendus = $this->modele->getRendus($id_projet);
    
        switch ($action) {
            case 'afficher':
                $this->vue->afficher_sae($projet, $ressources, $rendus);
                break;
    
            case 'majDescription':
                $newDescription = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
                $this->modele->majDescription($id_projet, $newDescription);
                $projet = $this->modele->getProjet($id_projet);
                $ressources = $this->modele->getRessources($id_projet);
                $rendus = $this->modele->getRendus($id_projet);
                $this->vue->afficher_sae($projet, $ressources, $rendus);
                break;
    
            case 'ajouterRessource':
                $titre = isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '';
                $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
                $url = isset($_POST['url']) ? htmlspecialchars($_POST['url']) : '';
                $this->modele->ajouterRessource($id_projet, $titre, $description, $url);
                $projet = $this->modele->getProjet($id_projet);
                $ressources = $this->modele->getRessources($id_projet);
                $rendus = $this->modele->getRendus($id_projet);
                $this->vue->afficher_sae($projet, $ressources, $rendus);
                break;
    
            case 'ajouterRendu':
                $titre = isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '';
                $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
                $date_limite = isset($_POST['date_limite']) ? htmlspecialchars($_POST['date_limite']) : '';
                $type = isset($_POST['type']) ? htmlspecialchars($_POST['type']) : '';
    
                $this->modele->ajouterRendu($id_projet, $titre, $description, $date_limite, $type);
                $projet = $this->modele->getProjet($id_projet);
                $ressources = $this->modele->getRessources($id_projet);
                $rendus = $this->modele->getRendus($id_projet);
                $this->vue->afficher_sae($projet, $ressources, $rendus);
                break;
    
                case 'modifierRendu':
                    $id_rendu = isset($_GET['id']) ? intval($_GET['id']) : 0;
                    $id_projet = isset($_GET['projet_id']) ? intval($_GET['projet_id']) : (isset($_POST['projet_id']) ? intval($_POST['projet_id']) : 0);
                    
                    $titre = isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '';
                    $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
                    $date_limite = isset($_POST['date_limite']) ? htmlspecialchars($_POST['date_limite']) : '';
                    $type = isset($_POST['type']) ? htmlspecialchars($_POST['type']) : '';
                    
                    if ($id_rendu > 0) {
                        $this->modele->modifierRendu($id_rendu, $titre, $description, $date_limite, $type);
                    }
                    
                    if ($id_projet > 0) {
                        $projet = $this->modele->getProjet($id_projet);
                        $ressources = $this->modele->getRessources($id_projet);
                        $rendus = $this->modele->getRendus($id_projet);
                        $this->vue->afficher_sae($projet, $ressources, $rendus);
                    } else {
                        echo "Erreur";
                    }
                    break;
                
                
                
    
            case 'afficherDepot':
                $id_rendu = isset($_GET['id_rendu']) ? intval($_GET['id_rendu']) : 0;
                if ($id_rendu > 0) {
                    $rendu = $this->modele->getRendu($id_rendu);
                    $groupes = $this->modele->getGroupesAvecFichiers($id_rendu);
                    $this->vue->afficherDepot($rendu, $groupes);
                } else {
                    header('Location: index.php?module=sae&action=afficher&id=' . $id_projet);
                }
                break;
    
            default:
                $this->vue->afficher_sae($projet, $ressources, $rendus);
                break;
        }    
    }

        public function rendreFichier() {
            $id_rendu = isset($_GET['id_rendu']) ? intval($_GET['id_rendu']) : 0;
            $id_projet = isset($_GET['id_projet']) ? intval($_GET['id_projet']) : 0;
    
            if ($id_rendu > 0 && isset($_FILES['fichier']) && $_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
                $fichierTmp = $_FILES['fichier']['tmp_name'];
                $nomFichier = basename($_FILES['fichier']['name']);
                $dossierDestination = 'uploads/rendus/';
                $cheminFichier = $dossierDestination . $nomFichier;
    
                if (!is_dir($dossierDestination)) {
                    mkdir($dossierDestination, 0777, true);
                }
                if (move_uploaded_file($fichierTmp, $cheminFichier)) {

                    $etudiant_id = $_SESSION['user_id']; 
                    $groupe_id = $this->modele->getGroupeEtudiant($id_rendu, $etudiant_id);
                    $this->modele->ajouterFichierRendu($id_rendu, $groupe_id, $etudiant_id, $cheminFichier);
    
                    header("Location: index.php?module=sae&action=afficher&id=$id_projet");
                    exit;
                } else {
                    echo "Erreur lors de l'envoi du fichier.";
                }
            } else {
                echo "Erreur : Informations manquantes ou fichier invalide.";
            }
        }
    
}
?>
