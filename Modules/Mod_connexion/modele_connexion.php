<?php

require_once 'connexion.php';

class ModeleConnexion extends Connexion {
    public function connexion() {
        if (isset($_POST['login'], $_POST['mot_de_passe'])) {
            $login = htmlspecialchars(strip_tags($_POST['login']));
            $motDePasse = $_POST['mot_de_passe'];

            $query = self::getBdd()->prepare("SELECT login, mot_de_passe FROM utilisateurs WHERE login = :login");
            $query->execute([':login' => $login]);

            $user = $query->fetch();

            if ($user && password_verify($motDePasse, $user['mot_de_passe'])) {
                $_SESSION['login'] = $login;
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
            $sth = self::getBdd()->prepare("INSERT INTO utilisateurs (nom, prenom, login, mot_de_passe, role) 
                                            VALUES (:nom, :prenom, :login, :motDePasse, :role)");
            $sth->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':login' => $login,
                ':motDePasse' => password_hash($motDePasse, PASSWORD_DEFAULT),
                ':role' => $role
            ]);
    
            // Sauvegarder la session utilisateur
            $_SESSION['login'] = $login;
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
