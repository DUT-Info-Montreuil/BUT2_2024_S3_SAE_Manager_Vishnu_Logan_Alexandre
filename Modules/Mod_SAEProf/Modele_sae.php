<?php
require_once 'connexion.php';

class Modele_sae {
    public function updateDescription($id_projet, $newDescription) {
        if ($id_projet > 0 && !empty($newDescription)) {
            try {
                $db = new PDO('mysql:host=localhost;dbname=dutinfon201660;charset=utf8', 'username', 'password');
                $stmt = $db->prepare("UPDATE projets SET description = :description WHERE id = :id");
                $stmt->bindParam(':description', $newDescription, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id_projet, PDO::PARAM_INT);
                $stmt->execute();
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }
    }
}
?>
