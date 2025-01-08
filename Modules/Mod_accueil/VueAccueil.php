<?php
require_once 'vue_generique.php';


class VueAccueil extends VueGenerique {

    public function __construct() {
        parent::__construct();
    }

    public function afficherAccueil() {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Connexion</title>
            <style>
                
            </style>
        </head>
        <body>
            <div class="login-container">
                <form class="login-form" method="post" action="index.php?action=connexion">
                    <h1>Connexion</h1>
                    <div class="input-group">
                        <input type="text" name="username" placeholder="Nom d’utilisateur" required>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" placeholder="Mot de passe" required>
                    </div>
                    <div class="remember-me">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Se souvenir de moi</label>
                    </div>
                    <button type="submit" class="btn">Se connecter</button>
                    <a href="#" class="forgot-password">Mot de passe oublié ?</a>
                </form>
            </div>
        </body>
        </html>
        <?php
    }
}

?>
