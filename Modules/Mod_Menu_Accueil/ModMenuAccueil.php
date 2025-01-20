<?php
require_once 'ContMenuAccueil.php';

class ModMenuAccueil {
    private $controleur;

    public function __construct() {
        $this->controleur = new ContMenuAccueil();
        $this->controleur->action();
    }
}
