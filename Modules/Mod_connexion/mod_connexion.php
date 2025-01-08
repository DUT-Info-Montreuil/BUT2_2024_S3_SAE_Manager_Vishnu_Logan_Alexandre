<?php
require_once 'cont_connexion.php';

class ModConnexion {
    private $controleur;

    public function __construct() {
        $this->controleur = new ContConnexion();
        $this->controleur->action();
    }
}
