<?php
require_once 'Vue_SAE_prof.php';
require_once 'Modele_sae.php';

class ContSAEProf {
    private $vue;
    private $modele;

    public function __construct() {
        $this->vue = new VueSAEProf();

        $this->modele = new Modele_sae();
    }

  
    

    public function action() {
        $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'afficher';
        $id_projet = isset($_GET['id']) ? intval($_GET['id']) : 0;

    
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
                header('Location: index.php?module=sae&action=afficher&id=' . $id_projet);
                break;
                case 'ajouterOuModifierNote':
                    $fichier_id = isset($_POST['fichier_id']) ? intval($_POST['fichier_id']) : 0;
                    $note = isset($_POST['note']) ? intval($_POST['note']) : null;
                
                    if ($fichier_id > 0 && $note !== null) {
                        $this->modele->ajouterOuModifierNote($fichier_id, $note);
                    }
                
                    $id_rendu = isset($_POST['rendu_id']) ? intval($_POST['rendu_id']) : 0;
                    if ($id_rendu > 0) {
                        $rendu = $this->modele->getRendu($id_rendu);
                        $groupes = $this->modele->getFichiersAvecDetails($id_rendu);
                        $this->vue->afficherDepot($rendu, $groupes);
                    }
                    break;
                
    
            case 'ajouterRessource':
                $titre = isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '';
                $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';

                $cheminFichier = '';
                if (isset($_FILES['fichier_ressource']) && $_FILES['fichier_ressource']['error'] === UPLOAD_ERR_OK) {
                    $dossierCible = 'uploads/ressources/';
                    $tailleMax = 2 * 1024 * 1024; // 2 Mo
                
                    if ($_FILES['fichier_ressource']['size'] > $tailleMax) {
                        die("Erreur : Fichier trop volumineux.");
                    }
                
                    $extension = pathinfo($_FILES['fichier_ressource']['name'], PATHINFO_EXTENSION);
                    $nomFichierUnique = uniqid('ress_') . '.' . $extension;
                
              
       
                    
                
                  
                    $cheminFichier = $dossierCible. $nomFichierUnique;
                
                    if (!copy($_FILES['fichier_ressource']['tmp_name'], $cheminFichier)) {
                        die("Erreur : impossible de copier le fichier.");
                    } else {
                        echo "Copie réussie.";
                    }
                }


                $this->modele->ajouterRessource($id_projet, $titre, $description, $cheminFichier);
                header('Location: index.php?module=sae&action=afficher&id=' . $id_projet);
                break;
    
            case 'ajouterRendu':
                $titre = isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '';
                $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
                $date_limite = isset($_POST['date_limite']) ? htmlspecialchars($_POST['date_limite']) : '';
                $type = isset($_POST['type']) ? htmlspecialchars($_POST['type']) : '';
    
                $this->modele->ajouterRendu($id_projet, $titre, $description, $date_limite, $type);
                header('Location: index.php?module=sae&action=afficher&id=' . $id_projet);
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
                    
                    header('Location: index.php?module=sae&action=afficher&id=' . $id_projet);
                    break;
        
                case 'supprimerRessource':
                    $id_ressource = isset($_GET['id_ressource']) ? intval($_GET['id_ressource']) : 0;
                    $this->modele->supprimerRessource($id_ressource);
                    header('Location: index.php?module=sae&action=afficher&id=' . $id_projet);
                    break;
        
                case 'supprimerRendu':
                    $id_rendu = isset($_GET['id_rendu']) ? intval($_GET['id_rendu']) : 0;
                    $this->modele->supprimerRendu($id_rendu);
                    header('Location: index.php?module=sae&action=afficher&id=' . $id_projet);
                    break;     
                    
                
                
    
            case 'afficherDepot':
                $id_rendu = isset($_GET['id_rendu']) ? intval($_GET['id_rendu']) : 0;
                if ($id_rendu > 0) {
                    $rendu = $this->modele->getRendu($id_rendu);
                    $groupes = $this->modele->getFichiersAvecDetails($id_rendu);
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
            
               
                $ressourceId = uniqid('rendu_'); 
                $dossierRessource = $dossierCible . $ressourceId . '/';

            
                if (!is_dir($dossierRessource)) {
                    mkdir($dossierRessource, 0777, true);
                }
            
                $cheminFichier = $dossierRessource . $nomFichierUnique;
            
                if (!move_uploaded_file($_FILES['fichier']['tmp_name'], $cheminFichier)) {
                    die("Erreur lors du téléchargement du fichier.");
                }
            }

            $this->modele->ajouterFichierRendu($id_rendu, $id_projet, $idEtudiant,$cheminFichier);


        }
    
}
?>