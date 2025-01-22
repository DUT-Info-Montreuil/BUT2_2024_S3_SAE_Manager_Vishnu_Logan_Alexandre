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

    public function action() {
        $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'formulaire';
        $projetId = isset($_GET['id']) ? intval($_GET['id']) : null;
        switch ($action) {
            case 'formulaire':
                $this->afficherFormulaire();
                break;

            case 'modifier':
                $this->updateGroupe();
                header("Location: index.php?module=groupe&action=formulaire&id=$projetId");
                break;

            case 'quitter':
                $this->quitterGroupe();
                header("Location: index.php?module=groupe&action=formulaire&id=$projetId");
                break;

            case 'rejoindre':
                $this->rejoindreGroupe();
                header("Location: index.php?module=groupe&action=formulaire&id=$projetId");
                break;
            case 'confirmer':
                $this->confirmerGroupe();
                header("Location: index.php?module=groupe&action=formulaire&id=$projetId");
                break;
            default:
                $this->afficherFormulaire();
                break;
        }
    }

    public function afficherFormulaire() {
        $projetId = isset($_GET['id']) ? intval($_GET['id']) : null;
        $userId = $_SESSION['id'];
        $semestre = $this->model->getEtudiantsById($userId)['semestre_id'];

        $etudiants = $this->model->getEtudiantsSansGroupeBySemestre($semestre);
        $groupes = $this->model->getGroupes($projetId);
        $etudiantsParGroupe = [];

        foreach ($groupes as $groupe) {
            $etudiantsParGroupe[$groupe['id']] = $this->model->getEtudiantsByGroupeId($groupe['id']);
        }

        $groupeUtilisateur = $this->model->getGroupeByEtudiantId($userId, $projetId);

        $this->vue->afficherFormulaire($etudiants, $groupes, $etudiantsParGroupe, $projetId, $groupeUtilisateur);
    }

    public function rejoindreGroupe() {
        if (!isset($_POST['groupe_id']) || !isset($_SESSION['id'])) {
            die("Erreur : Données manquantes.");
        }

        $groupeId = intval($_POST['groupe_id']);
        $userId = intval($_SESSION['id']);
        $projetId = isset($_GET['id']) ? intval($_GET['id']) : null;
        
        if ($this->model->getGroupeByEtudiantId($userId, $projetId)) {
            die("Erreur : Vous êtes déjà dans un groupe.");
        }

        $groupe = $this->model->getGroupeById($groupeId);
        $etudiantsGroupe = $this->model->getEtudiantsByGroupeId($groupeId);

        if (count($etudiantsGroupe) > $groupe['limiteGroupe']) {
            die("Erreur : Ce groupe est complet.");
        }

        $this->model->addEtudiantToGroupe($groupeId, $userId);
 

    }

    public function quitterGroupe() {
        if (!isset($_POST['groupe_id']) || !isset($_SESSION['id'])) {
            die("Erreur : Données manquantes.");
        }

        $groupeId = intval($_POST['groupe_id']);
        $userId = intval($_SESSION['id']);

        $this->model->deleteEtudiantFromGroupe($groupeId, $userId);


    }

    public function updateGroupe() {
    
        $groupeId = isset($_POST['groupe_id']) ? intval($_POST['groupe_id']) : null;
        $nom = isset($_POST['nom_groupe']) ? htmlspecialchars(strip_tags($_POST['nom_groupe'])) : '';
    
        $this->model->updateNomGroupe($groupeId, $nom);
    
        if (isset($_FILES['image_groupe']) && $_FILES['image_groupe']['error'] === UPLOAD_ERR_OK) {
            $dossierCible = 'uploads/groupe/'; 
    

            $typesAutorises = ['image/jpeg', 'image/png', 'image/gif'];
            $tailleMax = 2 * 1024 * 1024; 
    
            if (!in_array($_FILES['image_groupe']['type'], $typesAutorises)) {
                die("Erreur : Format d'image non autorisé.");
            }
    
            if ($_FILES['image_groupe']['size'] > $tailleMax) {
                die("Erreur : Fichier trop volumineux.");
            }
    
            $extension = pathinfo($_FILES['image_groupe']['name'], PATHINFO_EXTENSION);
            $nomFichierUnique = uniqid('img_') . '.' . $extension;
            $cheminFichier = $dossierCible . $nomFichierUnique;
    

            if (move_uploaded_file($_FILES['image_groupe']['tmp_name'], $cheminFichier)) {
                $this->model->updateImageGroupe($groupeId, $cheminFichier);
            } else {
                echo "Erreur lors du téléchargement du fichier.";
            }
        }


    }
    
    

    public function confirmerGroupe() {
        if (!isset($_POST['groupe_id'])) {
            die("Erreur : Données manquantes.");
        }
        $groupeId = intval($_POST['groupe_id']);
        
        $this->model->valideGroupe($groupeId);

    }
}
?>
