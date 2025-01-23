<?php
require_once 'ContSAE_etudiant.php';

class ModSAEEtudiant {
    private $controleur;

    public function __construct() {
        $this->controleur = new ContSAEtudiant();
        $this->controleur->actionEtudiant();
    }
}
?>
