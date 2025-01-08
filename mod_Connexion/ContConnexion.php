<?php

require_once 'ModeleConnexion.php';

class ContConnexion {

    public function afficherPageConnexion() {
        $vue = new VueConnexion();
        $vue->afficherConnexion();
    }

    public function traiterConnexion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $modele = new ModeleConnexion();
            $isLoggedIn = $modele->verifierConnexion($username, $password);

            if ($isLoggedIn) {
                header("futur page");  
                exit;
            } else {
                echo "<script>alert('Identifiants incorrects.');</script>";
            }
        }
    }
}

?>
