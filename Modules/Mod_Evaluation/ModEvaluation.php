<?php
require_once 'ContEvaluation.php';

class ModEvaluation {
    private $controleur;

    public function __construct() {
        $this->controleur = new ContEvaluation();
        $this->controleur->action();
    }
}
