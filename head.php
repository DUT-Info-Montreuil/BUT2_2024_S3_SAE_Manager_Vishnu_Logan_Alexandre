<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    // Obtenir le module de la requête ou définir un module par défaut
    $module = isset($_GET['module']) ? htmlspecialchars(strip_tags($_GET['module'])) : 'connexion';

    // Gérer dynamiquement le titre et les styles par module
    switch ($module) {
        case 'accueil':
            echo "<title>Accueil</title>";
            echo '<link rel="stylesheet" href="style_accueil.css">';
            break;
        case 'connexion':
            echo "<title>Connexion</title>";
            echo '<link rel="stylesheet" href="style.css">';
            break;
        default:
            echo "<title>Mon Application</title>";
            echo '<link rel="stylesheet" href="styles.css">';
            break;
    }
    ?>
</head>
