<?php

require_once 'connexion.php';

class ModeleConnexion extends Connexion {
    public function connexion() {
        if (isset($_POST['login'], $_POST['mot_de_passe'])) {
            $login = htmlspecialchars(strip_tags($_POST['login']));
            $motDePasse = $_POST['mot_de_passe'];

            $query = self::getBdd()->prepare("SELECT login, motDePasse FROM utilisateurs WHERE login = :login");
            $query->execute([':login' => $login]);

            $user = $query->fetch();

            if ($user && password_verify($motDePasse, $user['motDePasse'])) {
                $_SESSION['login'] = $login;
                return true;
            } 
        }

        return false;
    }

    public function ajoutUtilisateur() {
        if (isset($_POST['login'], $_POST['mot_de_passe'], $_POST['confirm_mot_de_passe'])) {
            $login = htmlspecialchars(strip_tags($_POST['login']));
            $motDePasse = $_POST['mot_de_passe'];
            $confirmMotDePasse = $_POST['confirm_mot_de_passe'];
    
            // Vérifier si les mots de passe correspondent
            if ($motDePasse !== $confirmMotDePasse) {
                echo "<p>Les mots de passe ne correspondent pas.</p>";
                return false;
            }
    
            // Vérifier si le login existe déjà
            $query = self::getBdd()->prepare("SELECT login FROM utilisateurs WHERE login = :login");
            $query->execute([':login' => $login]);
    
            if ($query->fetch()) {
                echo "<p>Login déjà existant.</p>";
                return false;
            }
    
            // Insérer l'utilisateur dans la base de données
            $sth = self::getBdd()->prepare("INSERT INTO utilisateurs (login, motDePasse) VALUES (:login, :motDePasse)");
            $sth->execute([
                ':login' => $login,
                ':motDePasse' => password_hash($motDePasse, PASSWORD_DEFAULT)
            ]);
    
            // Sauvegarder la session utilisateur
            $_SESSION['login'] = $login;
            return true;
        }
    
        return false;
    }

    public function deconnexion() {
        session_unset();
        session_destroy();
    }
}
?>
