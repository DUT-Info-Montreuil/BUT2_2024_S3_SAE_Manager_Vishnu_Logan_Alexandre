<?php

require_once 'connexion.php';
class ModeleAccueil extends Connexion {
    public function getUtilisateur($id) {
        $pdo_req = self::getBdd()->prepare("SELECT * FROM utilisateurs WHERE id = :id");
        $pdo_req->bindParam(':id', $id, PDO::PARAM_INT);
        $pdo_req->execute();
        return $pdo_req->fetch(PDO::FETCH_ASSOC);
    }

   
}


?>
