<?php

require_once 'vue_admin.php';
require_once 'modele_admin.php';

class ContAdmin {

    private $vueAdmin;
    private $modele;

    public function __construct() {

        $this->vueAdmin = new VueAdmin();
        $this->modele = new ModeleAdmin();
    }

    public function action() {
        $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'afficher';
        
        $admin_id = $_SESSION['id'];
        $admin_role=$_SESSION['role'];


        
        if($admin_role==="admin"){
            switch ($action){

                case 'inscription':
                    $this->inscription();
                    break;
                default:

                    break;
            }
        }
        else{
            header("Location:index.php?module=connexion&action=deconnexion");
           
        } 

       
    }

    private function inscription() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->modele->ajoutUtilisateur()) {
                header("Location: index.php?module=menuAccueil&action=menuAccueil");
            }
            else{
                
                $this->vueAdmin->form_inscription();
                echo "<p>Erreur lors de l'inscription</p>";
            }
        } else {
            $this->vueAdmin->form_inscription();
        }
    }
    
       
    
}
?>
