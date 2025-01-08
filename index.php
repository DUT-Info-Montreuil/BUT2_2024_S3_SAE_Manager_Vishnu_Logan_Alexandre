<?php

require_once 'Connexion.php';
require_once 'mod_Connexion/VueConnexion.php';
require_once 'mod_Connexion/ContConnexion.php';

Connexion::initConnexion();

$action = $_GET['action'] ?? '';

$contConnexion = new ContConnexion();

if ($action === 'connexion') {
    $contConnexion->traiterConnexion();
} else {
    $contConnexion->afficherPageConnexion();
}

?>
