<?php

require_once 'connexion.php';

class ModeleConnexion extends Connexion {
    public function connexion() {
        if (isset($_POST['login'], $_POST['mot_de_passe'])) {
            $login = htmlspecialchars(strip_tags($_POST['login']));
            $motDePasse = $_POST['mot_de_passe'];

            $query = self::getBdd()->prepare("SELECT * FROM utilisateurs WHERE login = :login");
            $query = self::getBdd()->prepare("SELECT * FROM utilisateurs WHERE login = :login");
            $query->execute([':login' => $login]);

            $user = $query->fetch();

            if ($user && password_verify($motDePasse, $user['mot_de_passe'])) {
                $_SESSION['login'] = $login;
                $_SESSION['role'] = $user['role'];
                $_SESSION['id'] = $user['id'];
                return true;
            } 
        }

        return false;
    }

    

    public function deconnexion() {
        session_unset();
        session_destroy();
    }
}
?>
