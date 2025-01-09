<?php
require_once 'vue_generique.php';

class VueSAEProf extends VueGenerique {

    public function __construct() {
        parent::__construct();
    }

    public function afficher_sae() {
        echo "
        <div class='sae-container'>
            <header class='header'>
                <div>
                    <p>Vous êtes connecté sous l'identifiant {$_SESSION['login']}</p>
                    <a href='index.php?module=connexion&action=deconnexion'>Déconnexion</a>
                </div>
            </header>

            <div class='main-content'>
                <div class='description'>
                    <h2>Description</h2>
                    <p>
                        Ce projet vise à développer un site web pour aider à la gestion des SAE et à un meilleur suivi, à la fois pour les enseignants et les étudiants, des rendus et des évaluations. Le site web devra donc proposer, pour chaque projet de SAE :
                    </p>
                    <ul>
                        <li>de centraliser les ressources mises en ligne par les enseignants</li>
                        <li>un accès rapide aux différents rendus attendus et envoyés</li>
                        <li>un accès aux évaluations</li>
                    </ul>
                </div>

                <div class='resources'>
                    <h2>Ressources</h2>
                    <ul>
                        <li><a href='#'>Resource 1</a></li>
                        <li><a href='#'>Resource 2</a></li>
                    </ul>
                </div>

                <div class='deposits'>
                    <h2>Dépôts</h2>
                    <div class='deposit-item'>
                        <p><strong>Dépôt de groupe</strong></p>
                        <p>Date limite : dimanche 20 janvier à 23h59</p>
                    </div>
                </div>

                <button class='evaluation-button'>Accéder aux évaluations</button>
            </div>
        </div>";
    }
}
?>
