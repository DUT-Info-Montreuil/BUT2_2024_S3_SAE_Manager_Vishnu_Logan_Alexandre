<?php
require_once 'connexion.php';

class Modele_sae extends Connexion{
    public function majDescription($id_projet, $newDescription) {
        if ($id_projet > 0 && !empty($newDescription)) {
            try {

                $stmt = self::getBdd()->prepare("UPDATE projets SET description = :description WHERE id = :id");
                $stmt->bindParam(':description', $newDescription);
                $stmt->bindParam(':id', $id_projet);
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
        $pdo_req->bindParam(":id", $id_Projet);
        $pdo_req->execute();
        $projet = $pdo_req->fetch();
    
        if (!$projet) {
            return false;
        }
    
        return $projet;
    }
    

    public function getRessources($id_Projet){
        $pdo_req = self::getBdd()->prepare("SELECT * FROM ressources WHERE projet_id = :projet_id");
		$pdo_req->bindParam(":projet_id", $id_Projet);
		$pdo_req->execute();
		return $pdo_req->fetchAll();

    }
    

        public function getRendus($id_projet) {
            $pdo_req = self::getBdd()->prepare("SELECT * FROM rendus WHERE projet_id = ?");
            $pdo_req->execute([$id_projet]);
            return $pdo_req->fetchAll();
        }

        public function getRendu($id_rendu) {
            try {
                $pdo_req = self::getBdd()->prepare("SELECT * FROM rendus WHERE id = :id_rendu");
                $pdo_req->bindParam(':id_rendu', $id_rendu);
                $pdo_req->execute();
                return $pdo_req->fetch();
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
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

        public function ajouterOuModifierNote($fichier_id, $note) {
            $pdo_req = self::getBdd()->prepare("
                UPDATE fichiers_rendus 
                SET note = :note
                WHERE id = :fichier_id
            ");
            $pdo_req->bindParam(':note', $note, PDO::PARAM_INT);
            $pdo_req->bindParam(':fichier_id', $fichier_id, PDO::PARAM_INT);
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

        
        public function getGroupesAvecFichiers($id_rendu) {
            $pdo_req = self::getBdd()->prepare("
                SELECT 
                    g.nom AS groupe_nom, 
                    f.fichier_url, 
                    f.date_soumission, 
                    f.id AS fichier_id, 
                    f.note
                FROM groupes g
                INNER JOIN fichiers_rendus f ON f.groupe_id = g.id
                WHERE f.rendu_id = :id_rendu
                ORDER BY g.nom
            ");
            $pdo_req->bindParam(':id_rendu', $id_rendu, PDO::PARAM_INT);
            $pdo_req->execute();
            return $pdo_req->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function getFichiersAvecDetails($id_rendu) {
            $pdo_req = self::getBdd()->prepare("
                SELECT 
                    CASE 
                        WHEN r.TYPE = 'individuel' THEN CONCAT(u.prenom, ' ', u.nom)
                        ELSE g.nom
                    END AS nom_affichage,
                    u.prenom,
                    u.nom,
                    g.nom AS groupe_nom, -- Assurez-vous que g.nom est inclus pour les rendus de type groupe
                    f.fichier_url,
                    f.date_soumission,
                    f.id AS fichier_id,
                    f.note
                FROM fichiers_rendus f
                LEFT JOIN rendus r ON f.rendu_id = r.id
                LEFT JOIN groupes g ON f.groupe_id = g.id
                LEFT JOIN utilisateurs u ON f.etudiant_id = u.id
                WHERE f.rendu_id = :id_rendu
                ORDER BY nom_affichage;
            ");
            $pdo_req->bindParam(':id_rendu', $id_rendu, PDO::PARAM_INT);
            $pdo_req->execute();
            return $pdo_req->fetchAll(PDO::FETCH_ASSOC);
        }
        public function supprimerRessource($id_ressource) {
            try {
                $pdo_req = self::getBdd()->prepare("DELETE FROM ressources WHERE id = :id");
                $pdo_req->bindParam(':id', $id_ressource);
                $pdo_req->execute();
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }
        
        public function supprimerRendu($id_rendu) {
            try {
                $pdo_req = self::getBdd()->prepare("DELETE FROM fichiers_rendus WHERE rendu_id = :id_rendu");
                $pdo_req->bindParam(':id_rendu', $id_rendu);
                $pdo_req->execute();
                $pdo_req = self::getBdd()->prepare("DELETE FROM rendus WHERE id = :id");
                $pdo_req->bindParam(':id', $id_rendu);
                $pdo_req->execute();
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }




        
        
        public function getGroupeEtudiant($id_rendu, $etudiant_id) {
            $pdo_req = self::getBdd()->prepare("
                SELECT g.id 
                FROM groupes g
                JOIN groupe_etudiants ge ON ge.groupe_id = g.id
                WHERE g.projet_id = (SELECT projet_id FROM rendus WHERE id = :id_rendu)
                AND ge.etudiant_id = :etudiant_id
            ");
            $pdo_req->bindParam(':id_rendu', $id_rendu);
            $pdo_req->bindParam(':etudiant_id', $etudiant_id);
            $pdo_req->execute();
            return $pdo_req->fetchColumn();
        }
        
        

        public function ajouterFichierRendu($id_rendu, $groupe_id, $etudiant_id, $fichier_url) {
            $pdo_req = self::getBdd()->prepare("
                INSERT INTO fichiers_rendus (rendu_id, groupe_id, etudiant_id, fichier_url)
                VALUES (:rendu_id, :groupe_id, :etudiant_id, :fichier_url)
            ");
            $pdo_req->bindParam(':rendu_id', $id_rendu);
            $pdo_req->bindParam(':groupe_id', $groupe_id);
            $pdo_req->bindParam(':etudiant_id', $etudiant_id);
            $pdo_req->bindParam(':fichier_url', $fichier_url);
            $pdo_req->execute();
        }
        
        
    }
?>