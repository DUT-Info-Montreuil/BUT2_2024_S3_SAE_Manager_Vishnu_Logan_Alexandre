<?php
require_once 'cont.php';

class Mod {
    private $controleur;

    public function __construct() {
        $this->controleur = new Cont();
        $this->controleur->action();
    }
}
