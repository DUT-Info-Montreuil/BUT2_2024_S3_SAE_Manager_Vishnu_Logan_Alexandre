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
        $this->id_projet = isset($_GET['projet_id']) ? intval($_GET['projet_id']) : null; 
    }

    public function action() {
        $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'list';

        switch ($action) {
            case 'list':
                $groupes = $this->modele->getListeGroupes($this->id_projet); 
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

            case 'supprimerEvaluation':
                $this->supprimerEvaluation();
                break;
            
            case 'modifierEvaluation':
                $this->modifierEvaluation();
                break;
                
        }
    }

    public function ajouterEvaluationGroupe() {
        if (!isset($_SESSION['id'])) {
            die("Erreur : Vous devez être connecté pour ajouter une évaluation.");
        }
    
        $evaluateur_id = $this->modele->getUtilisateurId($_SESSION['login']);
    
        if (!$evaluateur_id) {
            die("Erreur : Impossible de retrouver l'ID utilisateur.");
        }
    
        if (!isset($_GET['projet_id'])) {
            die("Erreur : Le projet_id est manquant.");
        }
    
        $this->id_projet = intval($_GET['projet_id']); 
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $groupe_id = intval($_POST['groupe_id'] ?? 0);
            $note = floatval($_POST['note'] ?? 0);
            $commentaire = htmlspecialchars(strip_tags($_POST['commentaire'] ?? ''));
    
            $this->modele->ajouterEvaluationGroupe($evaluateur_id, $groupe_id, $note, $commentaire, $this->id_projet);
    
            header("Location: index.php?module=evaluation&projet_id=" . $this->id_projet);
            exit;
        }
    
        $groupes = $this->modele->getListeGroupes($this->id_projet);
    }

    public function ajouterEvaluationIndividuelle() {
        if (!isset($_SESSION['id'])) {
            die("Erreur : Vous devez être connecté pour ajouter une évaluation.");
        }
    
        $evaluateur_id = $this->modele->getUtilisateurId($_SESSION['login']);
        if (!$evaluateur_id) {
            die("Erreur : Impossible de retrouver l'ID utilisateur.");
        }
    
        if (!isset($_GET['projet_id'])) {
            die("Erreur : Le projet_id est manquant.");
        }
    
        $this->id_projet = intval($_GET['projet_id']);
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $etudiant_id = intval($_POST['etudiant_id'] ?? 0);
            $note = floatval($_POST['note'] ?? 0);
            $commentaire = htmlspecialchars(strip_tags($_POST['commentaire'] ?? ''));
    
            $this->modele->ajouterEvaluationIndividuelle($evaluateur_id, $etudiant_id, $note, $commentaire, $this->id_projet);
    
            header("Location: index.php?module=evaluation&projet_id=" . $this->id_projet);
            exit;
        }
    
        $etudiants = $this->modele->getListeEtudiants($this->id_projet);
    }

    public function supprimerEvaluation() {
        if (!isset($_SESSION['id'])) {
            die("Erreur : Vous devez être connecté pour supprimer une évaluation.");
        }
    
        if (!isset($_GET['evaluation_id'])) {
            die("Erreur : L'identifiant de l'évaluation est manquant.");
        }
    
        $evaluation_id = intval($_GET['evaluation_id']);
        $this->modele->supprimerEvaluation($evaluation_id);
    
        header("Location: index.php?module=evaluation&projet_id=" . $this->id_projet);
        exit;
    }

    public function modifierEvaluation() {
        if (!isset($_SESSION['id'])) {
            die("Erreur : Vous devez être connecté pour modifier une évaluation.");
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $evaluation_id = intval($_POST['evaluation_id']);
            $note = floatval($_POST['note']);
            $type = $_POST['type'];
    
            if ($type == 'groupe') {
                $this->modele->modifierEvaluationGroupe($evaluation_id, $note);
            } else if ($type == 'individuelle') {
                $this->modele->modifierEvaluationIndividuelle($evaluation_id, $note);
            }
            
            header("Location: index.php?module=evaluation&projet_id=" . $this->id_projet);
            exit;
        }
    }    
    
    
}