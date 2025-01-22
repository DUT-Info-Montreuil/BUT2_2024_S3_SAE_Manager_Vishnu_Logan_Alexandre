<?php

require_once 'Vue_SAE_etudiant.php';
require_once 'Modele_sae_etudiant.php';

class ContSAEtudiant {

    private $vueEtudiant;
    private $modele;

    public function __construct() {

        $this->vueEtudiant = new Vue_SAE_etudiant();
        $this->modele = new Modele_sae_etudiant();
    }

    public function actionEtudiant() {
        $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'afficher';
        $id_projet = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $etudiant_id = $_SESSION['id'];
        $groupe_id = $this->modele->getGroupeByEtudiantId($etudiant_id,$id_projet);
        $projet = $this->modele->getProjet($id_projet);

        $ressources = $this->modele->getRessources($id_projet);
        $rendus = $this->modele->getRendus($id_projet);
        
        foreach ($rendus as &$rendu) {
            $rendu['fichierRendu'] = $this->modele->verifierRendu($rendu['id'], $etudiant_id, $groupe_id);
        }
        unset($rendu);
        

        switch ($action){
            case 'afficher':
                $this->vueEtudiant->afficher_sae_etudiant($projet, $ressources, $rendus);
                break;
            case 'rendreFichier':
                $this->rendreFichier();
                header('Location: index.php?module=sae&action=afficher&id=' . $id_projet);
                break;
            case 'supprimerRendu':
                $id_rendu = isset($_GET['id_rendu']) ? intval($_GET['id_rendu']) : 0;
                $this->modele->supprimerRendu($id_rendu, $etudiant_id, $groupe_id);
                header('Location: index.php?module=sae&action=afficher&id=' . $id_projet);
                break;
            default:
                $this->vueEtudiant->afficher_sae_etudiant($projet, $ressources, $rendus);
                break;
        }
    }
    
        public function rendreFichier() {
            $id_rendu = isset($_GET['id_rendu']) ? intval($_GET['id_rendu']) : 0;
            $idEtudiant = $_SESSION['id'];
            $cheminFichier = '';
            if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
                $dossierCible = 'uploads/rendu/';
                $tailleMax = 2 * 1024 * 1024; // 2 Mo
            
                if ($_FILES['fichier']['size'] > $tailleMax) {
                    die("Erreur : Fichier trop volumineux.");
                }
            
                $extension = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
                $nomFichierUnique = uniqid('rendu_') . '.' . $extension;
            
            
                $cheminFichier = $dossierCible.$nomFichierUnique;
            
                if (!copy($_FILES['fichier']['tmp_name'], $cheminFichier)) {
                    die("Erreur : impossible de copier le fichier.");
                } else {
                    echo "Copie réussie.";
                }
            }
            if(isset($_POST['type']) && $_POST['type'] == 'groupe'){
                $this->modele->ajouterFichierRenduGroupe($id_rendu, $this->modele->getGroupeEtudiant($id_rendu,$idEtudiant),$cheminFichier);
            }else{
                $this->modele->ajouterFichierRenduEtudiant($id_rendu, $idEtudiant,$cheminFichier);
            }

        }
    
}
?>
