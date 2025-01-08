<?php
    // Activer l'affichage des erreurs pour le débogage
    /*ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);*/

    session_start();

    // Inclure les fichiers nécessaires
    include_once 'connexion.php';
    include_once 'Modules/Mod_joueurs/mod_joueurs.php'; 
    include_once 'Modules/Mod_connexion/mod_connexion.php';
    include_once 'Comp/menu/cont_menu.php';

    // Initialiser la connexion à la base de données
    Connexion::initConnexion();

    // Obtenir le module et l'action de la requête
    $module = isset($_GET['module']) ? htmlspecialchars(strip_tags($_GET['module'])) : 'connexion';
    $action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'connexion';

    try {
        $modulesValides = ['joueurs', 'connexion'];
        if (in_array($module, $modulesValides)) {
            switch ($module) {
                case 'joueurs':
                    $mod = new ModJoueurs();
                    break;
                case 'connexion':
                    $modConnexion = new ModConnexion();
                    break;
            }
        } else {
            die("Module inconnu ou invalide.");
        }
       
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body class="index">
    <header>
        <?php
        if (isset($_SESSION['login'])) {
            $login = htmlspecialchars($_SESSION['login'], ENT_QUOTES, 'UTF-8');
            echo "<p>Vous êtes connecté sous l'identifiant $login</p>";
            echo '<a href="index.php?module=connexion&action=deconnexion">Déconnexion</a>';
        }
        ?>
    </header>

   
</body>
</html>
