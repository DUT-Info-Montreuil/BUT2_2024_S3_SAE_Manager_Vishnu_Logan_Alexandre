<?php

require_once 'Connexion.php';
class ModeleConnexion extends Connexion {

    public function verifierConnexion($login, $mdp) {
        $sqlQuerySelect = 'SELECT mdp FROM Utilisateurs WHERE login = :login';

        $statement = self::$bdd->prepare($sqlQuerySelect);
        $statement->bindValue(':login', $login);

        $statement->execute();

        $resultat = $statement->fetch();
        if (!$resultat) {
            return false;
        }

        $mdpHashe = $resultat['mdp'];

        if ($mdp == $mdpHashe) {
            $_SESSION['login'] = $login;
            $_SESSION['mdp'] = $mdpHashe;
            return true;
        } else {
            return false;
        }

    }
}


?>
