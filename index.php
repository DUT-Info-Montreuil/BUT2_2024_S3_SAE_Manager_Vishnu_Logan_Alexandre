


    <?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include_once 'head.php';
    $module = isset($_GET['module']) ? htmlspecialchars(strip_tags($_GET['module'])) : 'connexion';
    ?>

<body class="<?php echo $module; ?>">
<?php

    

    include_once 'connexion.php';
    include_once 'Modules/Mod_accueil/ModAccueil.php'; 
    include_once 'Modules/Mod_SAEProf/ModSAEProf.php'; 
    include_once 'Modules/Mod_SAE_Eleve/ModSAE_etudiant.php';
    include_once 'Modules/Mod_connexion/mod_connexion.php';
    include_once 'Comp/menu/cont_menu.php';
    include_once 'Modules/Mod_Menu_Accueil/ModMenuAccueil.php';
    include_once 'Modules/Mod_Groupe_Eleve/ModGroupe.php';
    include_once 'Modules/Mod_Groupe_Prof/ModGroupeProf.php';

    Connexion::initConnexion();

    $module = isset($_GET['module']) ? htmlspecialchars(strip_tags($_GET['module'])) : 'connexion';
    $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'connexion';

    try {
        $modulesValides = ['accueil', 'connexion','menuAccueil','groupe','groupeProf','groupeEtudiant','sae','saeEtudiant','saeProf'];
        if (in_array($module, $modulesValides)) {
            if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
                if ($_SESSION['role'] == 'enseignant') {
                    switch ($module) {
                        case 'accueil':
                            $mod = new ModAccueil();
                            break;
                        case 'menuAccueil':
                            $mod=new ModMenuAccueil();
                            break;
                        case 'connexion':
                            $modConnexion = new ModConnexion();
                            break;
                        case 'sae' : 
                            $sae = new ModSAEProf();
                            break;
                        case 'groupe':
                            $modGroupeProf= new ModGroupeProf();
                            break;
                    
                    }
                    
                } else {
                    switch ($module) {
                        case 'accueil':
                            $mod = new ModAccueil();
                            break;
                        case 'menuAccueil':
                            $mod=new ModMenuAccueil();
                            break;
                        case 'connexion':
                            $modConnexion = new ModConnexion();
                            break;
                        case 'sae' : 
                            $sae = new ModSAEEtudiant();
                            break;
                        case 'groupe':
                            $modGroupe = new ModGroupe();
                            break;
                    
                    }
                }
            }else{
                $modConnexion = new ModConnexion();
                
            } 

        } else {
            die("Module inconnu ou invalide.");
        }
       
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
?>
</body>




