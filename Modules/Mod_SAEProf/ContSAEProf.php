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
                $projet=$this->modele->getProjet($id_projet);
                
                $this->vue->afficher_sae($projet);
                break;
            case 'updateDescription':
                $newDescription = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
                $this->modele->updateDescription($id_projet, $newDescription);
                $this->vue->afficher_sae($id_projet);
                break;
            default:
                $this->vue->afficher_sae($id_projet);
                break;
        }
    }
}
?>
