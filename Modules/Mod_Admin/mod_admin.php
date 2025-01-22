<?php
require_once 'cont_admin.php';

class ModAdmin {
    private $controleur;

    public function __construct() {
        $this->controleur = new ContAdmin();
        $this->controleur->action();
    }
}
?>
