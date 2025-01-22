<?php
require_once 'ContGroupeProf.php';

class ModGroupeProf {
    private $controleur;

    public function __construct() {
        $this->controleur = new Cont_Groupe_Prof();
        $this->controleur->action();
    }
}
