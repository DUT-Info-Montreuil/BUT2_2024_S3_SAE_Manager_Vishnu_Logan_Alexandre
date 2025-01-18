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

        switch ($action) {
            case 'formulaire':
                $this->afficherFormulaire();
                break;

            case 'update':
                $this->updateGroupe();
                break;

            case 'quitter':
                $this->quitterGroupe();
                break;

            case 'rejoindre':
                $this->rejoindreGroupe();
                break;

            default:
                $this->afficherFormulaire();
        }
    }

    public function afficherFormulaire() {
        $projetId = isset($_GET['projetId']) ? intval($_GET['projetId']) : 5;
        $userId = $_SESSION['id'];
        $semestre = $this->model->getEtudiantsById($userId)['semestre_id'];
        // Récupérer les étudiants, groupes et l'utilisateur actuel
        $etudiants = $this->model->getEtudiantsSansGroupeBySemestre($semestre);
        $groupes = $this->model->getGroupes($projetId);
        $etudiantsParGroupe = [];

        foreach ($groupes as $groupe) {
            $etudiantsParGroupe[$groupe['id']] = $this->model->getEtudiantsByGroupeId($groupe['id']);
        }

        $groupeUtilisateur = $this->model->getGroupeByEtudiantId($userId, $projetId);

        // Afficher le formulaire avec les données récupérées
        $this->vue->afficherFormulaire($etudiants, $groupes, $etudiantsParGroupe, $userId, $groupeUtilisateur);
    }

    public function rejoindreGroupe() {
        if (!isset($_POST['groupe_id']) || !isset($_SESSION['id'])) {
            die("Erreur : Données manquantes.");
        }

        $groupeId = intval($_POST['groupe_id']);
        $userId = intval($_SESSION['id']);

        // Vérifier si l'utilisateur est déjà dans un groupe
        if ($this->model->getGroupeByEtudiantId($userId, $groupeId)) {
            die("Erreur : Vous êtes déjà dans un groupe.");
        }

        // Vérifier la capacité du groupe
        $groupe = $this->model->getGroupeById($groupeId);
        $etudiantsGroupe = $this->model->getEtudiantsByGroupeId($groupeId);

        if (count($etudiantsGroupe) >= $groupe['limiteGroupe']) {
            die("Erreur : Ce groupe est complet.");
        }

        // Ajouter l'utilisateur au groupe
        $this->model->addEtudiantToGroupe($groupeId, $userId);

        header("Location: index.php?module=groupe&action=formulaire");
        exit();
    }

    public function quitterGroupe() {
        if (!isset($_POST['groupe_id']) || !isset($_SESSION['id'])) {
            die("Erreur : Données manquantes.");
        }

        $groupeId = intval($_POST['groupe_id']);
        $userId = intval($_SESSION['id']);

        // Supprimer l'utilisateur du groupe
        $this->model->deleteEtudiantFromGroupe($groupeId, $userId);

        header("Location: index.php?module=groupe&action=formulaire");
        exit();
    }

    public function updateGroupe() {
        if (!isset($_POST['groupe_id'])) {
            die("Erreur : Données manquantes.");
        }

        $groupeId = intval($_POST['groupe_id']);
        $nom = htmlspecialchars($_POST['nom']);
        $image = $_FILES['image'];

        // Mettre à jour le nom du groupe
        $this->model->updateNomGroupe($groupeId, $nom);

        // Mettre à jour l'image si elle est fournie
        if ($image['error'] === UPLOAD_ERR_OK) {
            $imagePath = 'uploads/groupes/' . basename($image['name']);
            move_uploaded_file($image['tmp_name'], $imagePath);
            $this->model->updateImageGroupe($groupeId, $imagePath);
        }

        // Ajouter des étudiants
        if (isset($_POST['etudiants'])) {
            $etudiants = array_map('intval', $_POST['etudiants']);
            $this->model->addEtudiantToGroupe($groupeId, $etudiants);
        }

        header("Location: index.php?module=groupe&action=formulaire");
        exit();
    }
}
?>
