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

            case 'modifier':
                $this->updateGroupe();
                break;

            case 'quitter':
                $this->quitterGroupe();
                break;

            case 'rejoindre':
                $this->rejoindreGroupe();
                break;
            case 'confirmer':
                $this->confirmerGroupe();
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

        if ($this->model->getGroupeByEtudiantId($userId, $groupeId)) {
            die("Erreur : Vous êtes déjà dans un groupe.");
        }

        // Vérifier la capacité du groupe
        $groupe = $this->model->getGroupeById($groupeId);
        $etudiantsGroupe = $this->model->getEtudiantsByGroupeId($groupeId);

        if (count($etudiantsGroupe) > $groupe['limiteGroupe']) {
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
        var_dump($_POST, $_FILES);  // Debugging (À retirer après test)
    
        $groupeId = isset($_POST['groupe_id']) ? intval($_POST['groupe_id']) : -1;
        $nom = isset($_POST['nom_groupe']) ? htmlspecialchars(strip_tags($_POST['nom_groupe'])) : '';
    
        $this->model->updateNomGroupe($groupeId, $nom);
    
        if (isset($_FILES['image_groupe']) && $_FILES['image_groupe']['error'] === UPLOAD_ERR_OK) {
            $dossierCible = 'uploads/groupe/'; 
    

            $typesAutorises = ['image/jpeg', 'image/png', 'image/gif'];
            $tailleMax = 2 * 1024 * 1024; // 2 Mo
    
            if (!in_array($_FILES['image_groupe']['type'], $typesAutorises)) {
                die("Erreur : Format d'image non autorisé.");
            }
    
            if ($_FILES['image_groupe']['size'] > $tailleMax) {
                die("Erreur : Fichier trop volumineux.");
            }
    
            $extension = pathinfo($_FILES['image_groupe']['name'], PATHINFO_EXTENSION);
            $nomFichierUnique = uniqid('img_') . '.' . $extension;
            $cheminFichier = $dossierCible . $nomFichierUnique;
    
            // Déplacer le fichier uploadé vers le dossier cible
            if (move_uploaded_file($_FILES['image_groupe']['tmp_name'], $cheminFichier)) {
                // Mettre à jour l'image dans la base de données
                $this->model->updateImageGroupe($groupeId, $cheminFichier);
            } else {
                echo "Erreur lors du téléchargement du fichier.";
            }
        }
    
        header("Location: index.php?module=groupe&action=formulaire");
        exit();
    }
    
    

    public function confirmerGroupe() {
        if (!isset($_POST['groupe_id'])) {
            die("Erreur : Données manquantes.");
        }
        $groupeId = intval($_POST['groupe_id']);
        
        $this->model->valideGroupe($groupeId);
        header("Location: index.php?module=groupe&action=formulaire");
        exit();
    }
}
?>
