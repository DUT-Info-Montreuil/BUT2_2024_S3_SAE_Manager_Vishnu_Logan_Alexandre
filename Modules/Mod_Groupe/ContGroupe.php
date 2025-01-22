<?php
// Ctrl_Groupe.php

require_once 'ModeleGroupe.php';
require_once 'VueGroupe.php';
class Cont_Groupe {
    private $model;
    private $vue;
    public function __construct() {
        $this->model = new Modele_Groupe();
        $this->vue = new Vue_Groupe();
        
    }

    public function action(){
        $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'formulaire';

        switch ($action) {
            case 'formulaire':
                $this->afficherFormulaire();
                break;
            case 'creer':
                $this->creerGroupe();
                break;

                

        }
    }

    public function afficherFormulaire() {
        $etudiants = $this->model->getEtudiants();
        $this->vue->afficherFormulaire($etudiants); 

    } 


    public function creerGroupe() {
        if (isset($_POST['nom_groupe'], $_POST['etudiants'], $_POST['projet_id'])) {
            $nomGroupe = htmlspecialchars($_POST['nom_groupe']);
            $etudiants = $_POST['etudiants'];
            $projetId = $_POST['projet_id'];


            $groupeId = $this->model->createGroupe($projetId, $nomGroupe);


            $this->model->addEtudiantsToGroupe($groupeId, $etudiants);

            header("Location: index.php?module=groupe&action=liste");
        }
    }
}
?>
