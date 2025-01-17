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
    
        switch ($action) {
            case 'formulaire':
                $this->afficherFormulaire();
                break;
            case 'creer':
                $this->creerGroupe(); 
                break;
            case 'ajouter':
     
                $this->creerGroupe(); 
                header("Location: index.php?module=groupeProf");
                
                break;
        }
    }
    
    public function creerGroupe() {

    

            $projetId=isset($_GET['projetId']) ? htmlspecialchars(strip_tags($_GET['projetId'])) : 5;
            $nombreGroupes = isset($_POST['nombre_groupes']) ? htmlspecialchars(strip_tags($_POST['nombre_groupes'])):0;
            $limiteGroupe = isset($_POST['limite_groupe']) ? htmlspecialchars(strip_tags($_POST['limite_groupe'])):0;
            

            $modifNom = isset($_POST['modifier_nom']) ? 1 : 0;
            $modifImage = isset($_POST['modifier_image']) ? 1 : 0;
        
            // Pour chaque groupe, on appelle la méthode createGroupe
            for ($i = 1; $i <= $nombreGroupes; $i++) {
                $this->model->createGroupe($projetId, $limiteGroupe, $modifNom, $modifImage);
            }
        
    }
    
    

    public function afficherFormulaire() {
        
        $projetId=isset($_GET['projetId']) ? htmlspecialchars(strip_tags($_GET['projetId'])) : 5;
        $groupes=$this->model->getGroupes($projetId);
        $this->vue->afficherFormulaire($groupes); 

    }
    


  
}
?>
