<?php
require_once 'connexion.php';

class Modele_sae extends Connexion{
    public function majDescription($id_projet, $newDescription) {
        if ($id_projet > 0 && !empty($newDescription)) {
            try {

                $stmt = self::getBdd()->prepare("UPDATE projets SET description = :description WHERE id = :id");
                $stmt->bindParam(':description', $newDescription, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id_projet, PDO::PARAM_INT);
                $stmt->execute();
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }
    }

    public function ajouterRessource($id_projet, $titre, $description, $url) {
        if ($id_projet > 0 && !empty($titre)) {
            try {
                $stmt = self::getBdd()->prepare("
                    INSERT INTO ressources (projet_id, titre, description, url)
                    VALUES (:projet_id, :titre, :description, :url)
                ");
                $stmt->bindParam(':projet_id', $id_projet, PDO::PARAM_INT);
                $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
                $stmt->bindParam(':description', $description, PDO::PARAM_STR);
                $stmt->bindParam(':url', $url, PDO::PARAM_STR);
                $stmt->execute();
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }
    }
    

    public function getProjet($id_Projet){
        $pdo_req = self::getBdd()->prepare("SELECT * FROM projets WHERE id = :id");
		$pdo_req->bindParam(":id", $id_Projet, PDO::PARAM_INT);
		$pdo_req->execute();
		return $pdo_req->fetch(PDO::FETCH_ASSOC);
    
    }

    public function getRessources($id_Projet){
        $pdo_req = self::getBdd()->prepare("SELECT * FROM ressources WHERE projet_id = :projet_id");
		$pdo_req->bindParam(":projet_id", $id_Projet);
		$pdo_req->execute();
		return $pdo_req->fetchAll();

    
    }
}
?>
