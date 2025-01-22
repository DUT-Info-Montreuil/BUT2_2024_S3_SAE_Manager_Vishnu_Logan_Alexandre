


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
    include_once 'Modules/Mod_Evaluation/ModEvaluation.php';
    include_once 'Modules/Mod_Admin/mod_admin.php';


    Connexion::initConnexion();

    $module = isset($_GET['module']) ? htmlspecialchars(strip_tags($_GET['module'])) : 'connexion';
$action = isset($_GET['action']) ? htmlspecialchars(strip_tags($_GET['action'])) : 'connexion';

try {
    // Modules accessibles à tous
    $modulesCommuns = ['accueil', 'connexion', 'menuAccueil'];
    
    // Modules spécifiques par rôle
    $modulesSpecifiques = [
        'enseignant' => ['sae', 'groupe', 'evaluation'],
        'admin' => ['admin', 'sae', 'groupe'],
        'etudiant' => ['sae', 'groupe']
    ];

    // Vérification si le module est valide
    $modulesValides = array_merge($modulesCommuns, ...array_values($modulesSpecifiques));
    if (!in_array($module, $modulesValides)) {
        die("Module inconnu ou invalide.");
    }

    // Gestion des rôles
    if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
        $role = $_SESSION['role'];

        // Vérification d'accès aux modules spécifiques
        if (!in_array($module, $modulesCommuns) && (!isset($modulesSpecifiques[$role]) || !in_array($module, $modulesSpecifiques[$role]))) {
            session_destroy(); // Déconnexion forcée
            header("Location: index.php?module=connexion");
            exit();
        }

        // Chargement du bon module
        switch ($module) {
            case 'accueil':
                $mod = new ModAccueil();
                break;
            case 'menuAccueil':
                $mod = new ModMenuAccueil();
                break;
            case 'connexion':
                $modConnexion = new ModConnexion();
                break;
            case 'sae':
                $modSae = ($role === 'enseignant') ? new ModSAEProf() : new ModSAEEtudiant();
                break;
            case 'groupe':
                $modGroupe = ($role === 'enseignant') ? new ModGroupeProf() : new ModGroupe();
                break;
            case 'evaluation':
                if ($role === 'enseignant') {
                    $modEvaluation = new ModEvaluation();
                }
                break;
            case 'admin':
                if ($role === 'admin') {
                    $modAdmin = new ModAdmin();
                }
                break;
        }
    } else {
        // Par défaut, si l'utilisateur n'est pas connecté
        $modConnexion = new ModConnexion();
    }

} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}
?>
</body>




