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

    // Afficher la vue pour créer un groupe
    public function afficherFormulaire() {
        $etudiants = $this->model->getEtudiants();
        $this->vue->afficherFormulaire($etudiants); // Récupérer les étudiants
         // Inclure la vue pour afficher le formulaire
    } 

    // Créer un groupe et ajouter les étudiants sélectionnés
    public function creerGroupe() {
        if (isset($_POST['nom_groupe'], $_POST['etudiants'], $_POST['projet_id'])) {
            $nomGroupe = htmlspecialchars($_POST['nom_groupe']);
            $etudiants = $_POST['etudiants'];
            $projetId = $_POST['projet_id'];

            // Créer le groupe
            $groupeId = $this->model->createGroupe($projetId, $nomGroupe);

            // Ajouter les étudiants dans le groupe
            $this->model->addEtudiantsToGroupe($groupeId, $etudiants);

            // Rediriger ou afficher un message de succès
            header("Location: index.php?module=groupe&action=liste");
        }
    }
}
?>
