<?php

require_once 'ModeleEvaluation.php';
require_once 'VueEvaluation.php';

class ContEvaluation {
    private $modele;
    private $vue;
    private $id_projet;

    public function __construct() {
        $this->modele = new ModeleEvaluation();
        $this->vue = new VueEvaluation();
        $this->id_projet = isset($_GET['projet_id']) ? intval($_GET['projet_id']) : null; // Initialisation ici
    }

    public function action() {
        $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'list';

        switch ($action) {
            case 'list':
                $groupes = $this->modele->getListeGroupes($this->id_projet); // Récupération des groupes
                $evaluationsGroupe = $this->modele->getGroupEvaluations($this->id_projet);
                $evaluationsIndividuelles = $this->modele->getIndividualEvaluations($this->id_projet);
                $etudiants = $this->modele->getListeEtudiants($this->id_projet);
                $this->vue->afficherEvaluations($this->id_projet, $evaluationsGroupe, $evaluationsIndividuelles, $groupes, $etudiants);
                break;

            case 'ajouterEvaluationGroupe':
                $this->ajouterEvaluationGroupe();
                break;

            case 'ajouterEvaluationIndividuelle':
                $this->ajouterEvaluationIndividuelle();
                break;
        }
    }

    public function ajouterEvaluationGroupe() {
        // Vérifier si le login est dans la session
        if (!isset($_SESSION['id'])) {
            die("Erreur : Vous devez être connecté pour ajouter une évaluation.");
        }
    
        // Récupérer l'ID de l'utilisateur basé sur le login de la session
        $evaluateur_id = $this->modele->getUtilisateurId($_SESSION['login']);
    
        if (!$evaluateur_id) {
            die("Erreur : Impossible de retrouver l'ID utilisateur.");
        }
    
        // Vérifier si le projet_id est bien passé dans l'URL
        if (!isset($_GET['projet_id'])) {
            die("Erreur : Le projet_id est manquant.");
        }
    
        $this->id_projet = intval($_GET['projet_id']); // Assurer que l'id_projet est récupéré depuis l'URL
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $groupe_id = intval($_POST['groupe_id'] ?? 0);
            $note = floatval($_POST['note'] ?? 0);
            $commentaire = htmlspecialchars(strip_tags($_POST['commentaire'] ?? ''));
    
            // Insérer les données dans la base
            $this->modele->ajouterEvaluationGroupe($evaluateur_id, $groupe_id, $note, $commentaire, $this->id_projet);
    
            // Redirection ou retour à la page des évaluations
            header("Location: index.php?module=evaluation&projet_id=" . $this->id_projet);
            exit;
        }
    
        // Récupérer la liste des groupes pour afficher le formulaire
        $groupes = $this->modele->getListeGroupes($this->id_projet);
    }

    public function ajouterEvaluationIndividuelle() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['id'])) {
            die("Erreur : Vous devez être connecté pour ajouter une évaluation.");
        }
    
        // Récupérer l'ID de l'évaluateur
        $evaluateur_id = $this->modele->getUtilisateurId($_SESSION['login']);
        if (!$evaluateur_id) {
            die("Erreur : Impossible de retrouver l'ID utilisateur.");
        }
    
        // Vérifier la présence de l'id_projet dans l'URL
        if (!isset($_GET['projet_id'])) {
            die("Erreur : Le projet_id est manquant.");
        }
    
        $this->id_projet = intval($_GET['projet_id']);
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $etudiant_id = intval($_POST['etudiant_id'] ?? 0);
            $note = floatval($_POST['note'] ?? 0);
            $commentaire = htmlspecialchars(strip_tags($_POST['commentaire'] ?? ''));
    
            // Insérer les données dans la base
            $this->modele->ajouterEvaluationIndividuelle($evaluateur_id, $etudiant_id, $note, $commentaire, $this->id_projet);
    
            // Redirection ou retour à la page des évaluations
            header("Location: index.php?module=evaluation&projet_id=" . $this->id_projet);
            exit;
        }
    
        // Récupérer la liste des étudiants pour afficher le formulaire
        $etudiants = $this->modele->getListeEtudiants($this->id_projet);
    }
    
}