<?php

require_once 'Modele.php';
require_once 'vue.php';

class Cont {
    private $modele;
    private $vue;

    public function __construct() {
        $this->modele = new Modele();
        $this->vue = new Vue();
    }
    public function afficherPageAccueil() {

        $this->vue->afficherAccueil();
    }

    public function action() {

        $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'mod';

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
