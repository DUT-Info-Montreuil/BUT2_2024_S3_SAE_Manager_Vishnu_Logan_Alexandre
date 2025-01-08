<?php
require_once 'vue_generique.php';


class VueConnexion extends VueGenerique {

    public function __construct() {
        parent::__construct();
    }

    public function afficherConnexion() {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Connexion</title>
            <style>
                body {
                    margin: 0;
                    font-family: Arial, sans-serif;
                    background-color: #1b1b41;
                    color: #ffffff;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }

                .login-container {
                    background-color: #252559;
                    padding: 20px 40px;
                    border-radius: 8px;
                    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
                    width: 300px;
                }

                .login-form h1 {
                    font-size: 24px;
                    margin-bottom: 20px;
                    text-align: center;
                }

                .input-group {
                    margin-bottom: 15px;
                }

                .input-group input {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #6666aa;
                    border-radius: 4px;
                    background-color: transparent;
                    color: #ffffff;
                    font-size: 14px;
                }

                .input-group input::placeholder {
                    color: #ccccff;
                }

                .remember-me {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    margin-bottom: 15px;
                    font-size: 14px;
                }

                .btn {
                    width: 100%;
                    padding: 10px;
                    background-color: #d1b7a1;
                    color: #252559;
                    border: none;
                    border-radius: 4px;
                    font-size: 16px;
                    cursor: pointer;
                }

                .btn:hover {
                    background-color: #c5a58e;
                }

                .forgot-password {
                    display: block;
                    text-align: center;
                    margin-top: 10px;
                    font-size: 14px;
                    color: #ccccff;
                    text-decoration: none;
                }

                .forgot-password:hover {
                    text-decoration: underline;
                }
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
