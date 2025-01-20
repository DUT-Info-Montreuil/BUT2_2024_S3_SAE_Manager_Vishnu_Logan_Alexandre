<?php

require_once 'connexion.php';

class ModeleConnexion extends Connexion {
    public function connexion() {
        if (isset($_POST['login'], $_POST['mot_de_passe'])) {
            $login = htmlspecialchars(strip_tags($_POST['login']));
            $motDePasse = $_POST['mot_de_passe'];

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

    public function ajoutUtilisateur() {
        if (isset($_POST['nom'], $_POST['prenom'], $_POST['login'], $_POST['mot_de_passe'], $_POST['confirm_mot_de_passe'], $_POST['role'])) {
            $nom = htmlspecialchars(strip_tags($_POST['nom']));
            $prenom = htmlspecialchars(strip_tags($_POST['prenom']));
            $login = htmlspecialchars(strip_tags($_POST['login']));
            $motDePasse = $_POST['mot_de_passe'];
            $confirmMotDePasse = $_POST['confirm_mot_de_passe'];
            $role = htmlspecialchars(strip_tags($_POST['role']));
    
            if ($motDePasse !== $confirmMotDePasse) {
                echo "<p>Les mots de passe ne correspondent pas.</p>";
                return false;
            }
    
            $query = self::getBdd()->prepare("SELECT login FROM utilisateurs WHERE login = :login");
            $query->execute([':login' => $login]);
    
            if ($query->fetch()) {
                echo "<p>Login déjà existant.</p>";
                return false;
            }
    
            $sth = self::getBdd()->prepare("INSERT INTO utilisateurs (nom, prenom, login, mot_de_passe, role) 
                                            VALUES (:nom, :prenom, :login, :motDePasse, :role)");
            $sth->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':login' => $login,
                ':motDePasse' => password_hash($motDePasse, PASSWORD_DEFAULT),
                ':role' => $role
            ]);
    
            $_SESSION['login'] = $login;
            $_SESSION['role'] = $role;
            $_SESSION['id'] = self::getBdd()->lastInsertId();
            return true;
        } else {
            echo "<p>Veuillez remplir tous les champs.</p>";
            return false;
        }
    }

    public function deconnexion() {
        session_unset();
        session_destroy();
    }
}
?>
