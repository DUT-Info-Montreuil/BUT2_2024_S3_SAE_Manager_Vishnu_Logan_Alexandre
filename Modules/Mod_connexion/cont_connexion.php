<?php
require_once 'modele_connexion.php';
require_once 'vue_connexion.php';

class ContConnexion {
    private $modele;
    private $vue;

    public function __construct() {
        $this->modele = new ModeleConnexion();
        $this->vue = new VueConnexion();
    }

    public function action() {
  
        $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'connexion';

        switch ($action) {
            case 'connexion':
                $this->connexion();
                break;
            case 'inscription':
                $this->inscription();
                break;
            case 'deconnexion':
                $this->deconnexion();
                break;
            default:
                $this->vue->form_connexion();
        }

    }

    private function connexion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->modele->connexion()) {
                header("Location: index.php?module=menuAccueil&action=menuAccueil");
                exit;
            } else {
                $this->vue->form_connexion();
                echo "<script>alert('Identifiants incorrects.');</script>";
                
            }
        } else {
            $this->vue->form_connexion();
        }
    }

    private function inscription() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->modele->ajoutUtilisateur()) {
                header("Location: index.php?module=menuAccueil&action=menuAccueil");
            }
            else{
                
                $this->vue->form_inscription();
                echo "<p>Erreur lors de l'inscription</p>";
            }
        } else {
            $this->vue->form_inscription();
        }
    }

    private function deconnexion() {
        $this->modele->deconnexion();
        header("Location: index.php?module=connexion&action=connexion");
    }
}
