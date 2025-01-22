


    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include_once 'head.php';
    $module = isset($_GET['module']) ? htmlspecialchars(strip_tags($_GET['module'])) : 'connexion';
    ?>

<body class="<?php echo $module; ?>">
<?php

    session_start();

    include_once 'connexion.php';
    include_once 'Modules/Mod_accueil/ModAccueil.php'; 
    include_once 'Modules/Mod_SAEProf/ModSAEProf.php'; 
    include_once 'Modules/Mod_connexion/mod_connexion.php';
    include_once 'Comp/menu/cont_menu.php';
    include_once 'Modules/Mod_Menu_Accueil/ModMenuAccueil.php';
    include_once 'Modules/Mod_Groupe/ModGroupe.php';

    Connexion::initConnexion();

    $module = isset($_GET['module']) ? htmlspecialchars(strip_tags($_GET['module'])) : 'connexion';
    $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'connexion';

    try {
        $modulesValides = ['accueil', 'connexion','mod','groupe','sae'];
        if (in_array($module, $modulesValides)) {
            switch ($module) {
                case 'accueil':
                    if($_SESSION['login']){
                        $mod = new ModAccueil();
                    }
                    else{
                        header("Location: index.php?module=connexion&action=connexion");
                    }
                    
                    break;
                case 'connexion':
                    $modConnexion = new ModConnexion();
                    break;
                case 'sae' : 
                        $sae = new ModSAEProf();
                        break;
                case 'mod':
                    $mod=new ModMenuAccueil();
                    break;
                case 'groupe':
                    $modGroupe = new ModGroupe();
                    break;
            }
        } else {
            die("Module inconnu ou invalide.");
        }
       
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
?>
</body>




