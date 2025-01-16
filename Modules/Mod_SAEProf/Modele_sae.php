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
    

        public function getRendus($id_projet) {
            $pdo_req = self::getBdd()->prepare("SELECT * FROM rendus WHERE projet_id = :projet_id");
            $pdo_req->bindParam(':projet_id', $id_projet);
            $pdo_req->execute();
            return $pdo_req->fetchAll();
        }
        
        public function ajouterRendu($id_projet, $titre, $description, $date_limite, $type) {
            $pdo_req = self::getBdd()->prepare("
                INSERT INTO rendus (projet_id, titre, description, date_limite, type)
                VALUES (:projet_id, :titre, :description, :date_limite, :type)
            ");
            $pdo_req->bindParam(':projet_id', $id_projet);
            $pdo_req->bindParam(':titre', $titre);
            $pdo_req->bindParam(':description', $description);
            $pdo_req->bindParam(':date_limite', $date_limite);
            $pdo_req->bindParam(':type', $type);
            $pdo_req->execute();
        }
        
        public function modifierRendu($id_rendu, $titre, $description, $date_limite, $type) {
            $pdo_req = self::getBdd()->prepare("
                UPDATE rendus
                SET titre = :titre, description = :description, date_limite = :date_limite, type = :type
                WHERE id = :id
            ");
            $pdo_req->bindParam(':titre', $titre);
            $pdo_req->bindParam(':description', $description);
            $pdo_req->bindParam(':date_limite', $date_limite);
            $pdo_req->bindParam(':type', $type);
            $pdo_req->bindParam(':id', $id_rendu);
            $pdo_req->execute();
        }
        
    }
?>
