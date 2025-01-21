<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php

    $module = isset($_GET['module']) ? htmlspecialchars(strip_tags($_GET['module'])) : 'connexion';


    switch ($module) {
        case 'accueil':
            echo "<title>Accueil</title>";
            echo '<link rel="stylesheet" href="style_accueil.css">';
            echo '<script src="script.js"></script>';
            break;
        case 'connexion':
            echo "<title>Connexion</title>";
            echo '<link rel="stylesheet" href="style.css">';
            break;
        case 'mod':
            echo "<title>Accueil</title>";
            echo '<link rel="stylesheet" href="style_menu_accueil.css">';
            echo '<script src="script.js"></script>';
        case 'groupe':
            echo "<title>Groupe</title>";
            echo '<link rel="stylesheet" href="style_accueil.css">';
            echo '<link rel="stylesheet" href="style_groupe.css">';
            echo '<script src="script_groupe.js"></script>';
        case 'sae':
            echo '<link rel="stylesheet" href="style_pageSAEProf.css">';
            echo '<link rel="stylesheet" href="style_accueil.css">';
            echo '<link rel="stylesheet" href="style_depot.css">';


        default:
            echo "<title>Mon Application</title>";
            echo '<link rel="stylesheet" href="styles.css">';
            echo '<link rel="stylesheet" href="style_accueil.css">';
            break;
        
    }
    ?>
</head>
