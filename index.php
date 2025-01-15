


    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Ensuite, votre inclusion
    include_once 'head.php';
    $module = isset($_GET['module']) ? htmlspecialchars(strip_tags($_GET['module'])) : 'connexion';
    ?>

<body class="<?php echo $module; ?>">
<?php
    // Activer l'affichage des erreurs pour le débogage
    /*ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);*/

    session_start();

    // Inclure les fichiers nécessaires
    include_once 'connexion.php';
    include_once 'Modules/Mod_accueil/ModAccueil.php'; 
    include_once 'Modules/Mod_connexion/mod_connexion.php';
    include_once 'Comp/menu/cont_menu.php';
    include_once 'Modules/New_Mod/mod.php';
    include_once 'Modules/Mod_Groupe/ModGroupe.php';

    // Initialiser la connexion à la base de données
    Connexion::initConnexion();

    // Obtenir le module et l'action de la requête
    $module = isset($_GET['module']) ? htmlspecialchars(strip_tags($_GET['module'])) : 'connexion';
    $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'connexion';

    try {
        $modulesValides = ['accueil', 'connexion','mod','groupe'];
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
                case 'mod':
                    $mod=new Mod();
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




