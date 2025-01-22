<?php
// Ctrl_Groupe_Prof.php

require_once 'ModeleGroupeProf.php';
require_once 'VueGroupeProf.php';
class Cont_Groupe_Prof {
    private $model;
    private $vue;
    public function __construct() {
        $this->model = new Modele_Groupe_Prof();
        $this->vue = new Vue_Groupe_Prof();
        
    }

    public function action(){
        $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'formulaire';
        $projetId = isset($_GET['id']) ? htmlspecialchars(strip_tags($_GET['id'])) : -1;
        switch ($action) {
            case 'formulaire':
                $this->afficherFormulaire();
                break;
            
            case 'ajouter':
     
                $this->creerGroupe(); 
                header("Location: index.php?module=groupe&action=formulaire&id=$projetId");
                
                break;
            case 'supprimer':
                $this->supprimerGroupe(); 
                header("Location: index.php?module=groupe&action=formulaire&id=$projetId");
                break;
            case 'modifier':
                $this->modifGroupe();
                header("Location: index.php?module=groupe&action=formulaire&id=$projetId");
                break;
        }
    }
    
    public function creerGroupe() {

    

            $projetId=isset($_GET['projetId']) ? htmlspecialchars(strip_tags($_GET['projetId'])) : -1;
            $nombreGroupes = isset($_POST['nombre_groupes']) ? htmlspecialchars(strip_tags($_POST['nombre_groupes'])):0;
            $limiteGroupe = isset($_POST['limite_groupe']) ? htmlspecialchars(strip_tags($_POST['limite_groupe'])):0;
            

            $modifNom = isset($_POST['modifier_nom']) ? 1 : 0;
            $modifImage = isset($_POST['modifier_image']) ? 1 : 0;
            for ($i = 1; $i <= $nombreGroupes; $i++) {
                $this->model->createGroupe($projetId, $limiteGroupe, $modifNom, $modifImage);
            }
        
    }

    public function supprimerGroupe(){
        $groupId=isset($_POST['groupId']) ? htmlspecialchars(strip_tags($_POST['groupId'])) : -1;
        $this->model->deleteGroupe($groupId);
    }
    
    

    public function afficherFormulaire() {
        
        $projetId=isset($_GET['projetId']) ? htmlspecialchars(strip_tags($_GET['projetId'])) : -1;
        $groupes=$this->model->getGroupes($projetId);
        $this->vue->afficherFormulaire($groupes); 

    }

    public function modifGroupe(){
        $groupId=isset($_POST['groupeId']) ? htmlspecialchars(strip_tags($_POST['groupeId'])) : -1;
        $projetId=isset($_GET['projetId']) ? htmlspecialchars(strip_tags($_GET['projetId'])) : -1;
        $nomGroup = isset($_POST['groupeNom']) ? htmlspecialchars(strip_tags($_POST['groupeNom'])) : '';
        $limiteGroupe = isset($_POST['groupeLimite']) ? htmlspecialchars(strip_tags($_POST['groupeLimite'])) : 0;
        $modifNom = isset($_POST['changeNom']) ? 1 : 0;
        $modifImage = isset($_POST['changeImage']) ? 1 : 0;
        $cheminFichier = '';
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
    
            if (!move_uploaded_file($_FILES['image_groupe']['tmp_name'], $cheminFichier)) {
                die("Erreur lors du téléchargement du fichier.");
            }
        }
    

        $this->model->modifGroupe($groupId, $cheminFichier, $projetId, $nomGroup, $limiteGroupe, $modifNom, $modifImage);
    }
    


  
}
?>
