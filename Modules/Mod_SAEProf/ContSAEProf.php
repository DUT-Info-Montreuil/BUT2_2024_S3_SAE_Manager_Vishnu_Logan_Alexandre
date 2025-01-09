<?php
require_once 'VueSAEProf.php';

class ContSAEProf {
    private $vue;

    public function __construct() {
        $this->vue = new VueSAEProf();
    }

    public function action() {
        $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'afficher';

        switch ($action) {
            case 'afficher':
                $this->vue->afficher_sae();
                break;
            default:
                $this->vue->afficher_sae();
                break;
        }
    }
}
?>
