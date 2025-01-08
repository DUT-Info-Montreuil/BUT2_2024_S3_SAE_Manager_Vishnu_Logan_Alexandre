<?php

class Connexion {

    protected static $bdd; 

    public static function initConnexion() {
        $dsn = 'mysql:host=database-etudiants.iut.univ-paris8.fr; dbname=dutinfopw201651';
        $user = 'dutinfopw201651';
        $password = 'rubajype';

        self::$bdd = new PDO($dsn, $user, $password);

    }

}

?>