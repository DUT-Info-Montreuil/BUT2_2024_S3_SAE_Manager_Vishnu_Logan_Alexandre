<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php

    $module = isset($_GET['module']) ? htmlspecialchars(strip_tags($_GET['module'])) : 'connexion';
    $role = isset($_SESSION['role']) ? htmlspecialchars($_SESSION['role'], ENT_QUOTES, 'UTF-8'): 'etudiant';

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
        case 'menuAccueil':
            echo "<title>Accueil</title>";
            echo '<link rel="stylesheet" href="style_accueil.css">';
            echo '<link rel="stylesheet" href="style_menu_accueil.css">';
            echo '<script src="script.js"></script>';
            break;
        case 'groupe':
            echo "<title>Groupe</title>";
                echo '<link rel="stylesheet" href="style_accueil.css">';
            if($role === 'enseignant'){
                echo '<link rel="stylesheet" href="style_groupe_prof.css">';
                echo '<script src="script_groupe_prof.js"></script>';
            }else{
                echo '<link rel="stylesheet" href="style_groupe.css">';
                echo '<script src="script_groupe.js"></script>';
            }
            break;
        case 'sae':
            echo '<link rel="stylesheet" href="style_accueil.css">';
            if($role === 'enseignant'){
                echo '<link rel="stylesheet" href="style_pageSAE_prof.css">';
                echo '<link rel="stylesheet" href="style_depot.css">';

            }else{
                echo '<link rel="stylesheet" href="style_pageSAE_etudiant.css">';
                
            }
            break;
       
        
    }
    ?>
</head>
