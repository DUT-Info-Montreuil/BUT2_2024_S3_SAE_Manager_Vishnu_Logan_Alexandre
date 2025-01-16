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
        $rendus = $this->modele->getRendus($id_projet);


        $ressources = $this->modele->getRessources($id_projet);


        switch ($action) {
            case 'afficher':
                $projet = $this->modele->getProjet($id_projet);
                $ressources = $this->modele->getRessources($id_projet);
                $rendus = $this->modele->getRendus($id_projet);
                $this->vue->afficher_sae($projet, $ressources, $rendus);
                break;
            

            case 'majDescription':
                $newDescription = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
                $this->modele->majDescription($id_projet, $newDescription);
                $projet = $this->modele->getProjet($id_projet);
                $rendus = $this->modele->getRendus($id_projet);
        
        
                $ressources = $this->modele->getRessources($id_projet);
                $this->vue->afficher_sae($projet,$ressources,$rendus);
                break;
            case 'ajouterRessource':
                $titre = isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '';
                $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
                $url = isset($_POST['url']) ? htmlspecialchars($_POST['url']) : '';
                $projet = $this->modele->getProjet($id_projet);
                $rendus = $this->modele->getRendus($id_projet);
        
        
                $ressources = $this->modele->getRessources($id_projet);
                $this->modele->ajouterRessource($id_projet, $titre, $description, $url);
                $this->vue->afficher_sae($projet,$ressources,$rendus);
                break;

                case 'ajouterRendu':
                    $titre = isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '';
                    $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
                    $date_limite = isset($_POST['date_limite']) ? htmlspecialchars($_POST['date_limite']) : '';
                    
                    $projet = $this->modele->getProjet($id_projet);
                    $rendus = $this->modele->getRendus($id_projet);
            
            
                    $ressources = $this->modele->getRessources($id_projet);$type = isset($_POST['type']) ? htmlspecialchars($_POST['type']) : '';
                    $this->modele->ajouterRendu($id_projet, $titre, $description, $date_limite, $type);
                    $this->vue->afficher_sae($projet, $ressources, $rendus);
                    break;
                
                case 'modifierRendu':
                    $id_rendu = isset($_POST['id_rendu']) ? intval($_POST['id_rendu']) : 0;
                    $titre = isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '';
                    $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
                    $date_limite = isset($_POST['date_limite']) ? htmlspecialchars($_POST['date_limite']) : '';
                    $type = isset($_POST['type']) ? htmlspecialchars($_POST['type']) : '';
                    $projet = $this->modele->getProjet($id_projet);
                    $rendus = $this->modele->getRendus($id_projet);
            
            
                    $ressources = $this->modele->getRessources($id_projet);
                    $this->modele->modifierRendu($id_rendu, $titre, $description, $date_limite, $type);
                    $this->vue->afficher_sae($projet, $ressources, $rendus);
                    break;
                
    
            default:
            $projet = $this->modele->getProjet($id_projet);
            $rendus = $this->modele->getRendus($id_projet);
    
    
            $ressources = $this->modele->getRessources($id_projet);
                $this->vue->afficher_sae($projet,$ressources,$rendus);
                break;
        }
    }
}
?>
