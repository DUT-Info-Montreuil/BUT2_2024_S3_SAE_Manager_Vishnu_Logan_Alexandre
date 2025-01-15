<?php

require_once 'ModeleAccueil.php';
require_once 'VueAccueil.php';

class ContAccueil {
    private $modele;
    private $vue;

    public function __construct() {
        $this->modele = new ModeleAccueil();
        $this->vue = new VueAccueil();
    }
    public function afficherPageAccueil() {

        $this->vue->afficherAccueil();
    }

    public function action() {

        $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'accueil';

        switch ($action) {
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
