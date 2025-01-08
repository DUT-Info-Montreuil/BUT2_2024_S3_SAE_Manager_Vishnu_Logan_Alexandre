<?php

require_once 'ModeleConnexion.php';

class ContAccueil {

    public function afficherPageAccueil() {
        $vue = new VueAccueil();
        $vue->afficherAccueil();
    }

    
}

?>
