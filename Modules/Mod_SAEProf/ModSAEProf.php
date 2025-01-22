<?php
require_once 'ContSAEProf.php';

class ModSAEProf {
    private $controleur;

    public function __construct() {
        $this->controleur = new ContSAEProf();
        $this->controleur->action();
    }
}
?>
