


    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include_once 'head.php';
    ?>
<?php

    session_start();

    include_once 'connexion.php';
    include_once 'Modules/Mod_accueil/ModAccueil.php'; 
    include_once 'Modules/Mod_SAEProf/ModSAEProf.php'; 
    include_once 'Modules/Mod_connexion/mod_connexion.php';
    include_once 'Comp/menu/cont_menu.php';

    Connexion::initConnexion();

    $module = isset($_GET['module']) ? htmlspecialchars(strip_tags($_GET['module'])) : 'connexion';
    $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'connexion';

    try {
        $modulesValides = ['accueil', 'connexion','sae'];
        if (in_array($module, $modulesValides)) {
            switch ($module) {
                case 'accueil':
                    $mod = new ModAccueil();
                    break;
                case 'connexion':
                    $modConnexion = new ModConnexion();
                    break;
                case 'sae' : 
                        $sae = new ModSAEProf();
                        break;
            }
        } else {
            die("Module inconnu ou invalide.");
        }
       
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
?>
<body class="<?php echo $module; ?>">
    
</body>




