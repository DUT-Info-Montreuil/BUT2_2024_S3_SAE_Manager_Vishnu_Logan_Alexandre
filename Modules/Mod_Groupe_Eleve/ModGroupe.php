<?php
require_once 'ContGroupe.php';

class ModGroupe {
    private $controleur;

    public function __construct() {
        $this->controleur = new Cont_Groupe();
        $this->controleur->action();
    }
}
