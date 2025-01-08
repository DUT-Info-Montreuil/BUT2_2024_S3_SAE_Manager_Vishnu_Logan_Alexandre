<?php

    class Connexion{
        protected static $bdd;

        public function __construct(){}


        public static function initConnexion(){
            $user = 'dutinfopw201660'; 
            $pass = 'munupeby';
            self::$bdd = new PDO("mysql:host=database-etudiants.iut.univ-paris8.fr;dbname=dutinfopw201660;charset=utf8", $user, $pass);
        }

        protected function getBdd(){
            return self::$bdd;
        }


    }
    





?>