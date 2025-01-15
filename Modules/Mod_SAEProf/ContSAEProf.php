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

        switch ($action) {
            case 'afficher':
                $projet = $this->modele->getProjet($id_projet);
                $ressources = $this->modele->getRessources($id_projet);
                $this->vue->afficher_sae($projet, $ressources);
                break;

            case 'majDescription':
                $newDescription = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
                $this->modele->majDescription($id_projet, $newDescription);
                $projet = $this->modele->getProjet($id_projet);
                $this->vue->afficher_sae($projet,$ressources);
                break;
            case 'ajouterRessource':
                $titre = isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '';
                $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
                $url = isset($_POST['url']) ? htmlspecialchars($_POST['url']) : '';
                $this->modele->ajouterRessource($id_projet, $titre, $description, $url);
                $projet = $this->modele->getProjet($id_projet);
                $ressources = $this->modele->getRessources($id_projet);
                $this->vue->afficher_sae($projet,$ressources);
                break;
    
            default:
                $projet = $this->modele->getProjet($id_projet);
                $this->vue->afficher_sae($projet,$ressources);
                break;
        }
    }
}
?>
