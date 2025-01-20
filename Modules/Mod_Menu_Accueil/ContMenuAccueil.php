<?php

require_once 'ModeleMenuAccueil.php';
require_once 'VueMenuAccueil.php';

class ContMenuAccueil {
    private $modele;
    private $vue;

    public function __construct() {
        $this->modele = new ModeleMenuAccueil();
        $this->vue = new VueMenuAccueil();
    }
    public function afficherPageAccueil() {

        $this->vue->afficherAccueil();
    }

    public function action() {

        $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'menuAccueil';

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
