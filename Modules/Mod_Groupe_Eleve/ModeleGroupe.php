<?php
// Mod_Groupe.php

require_once 'connexion.php';

class Modele_Groupe extends Connexion {

    public function getEtudiants() {
        $stmt = self::getBdd()->prepare("SELECT id, nom, prenom,semestre_id FROM utilisateurs JOIN etudiants using(id) WHERE role = 'etudiant'");
        $stmt->execute();
        return $stmt->fetchAll();
    }
        public function getEtudiantsSansGroupeBySemestre($semestre) {
        $stmt = self::getBdd()->prepare("
            SELECT u.id, u.nom, u.prenom, u.role, e.semestre_id 
            FROM etudiants e
            JOIN utilisateurs u ON e.id = u.id
            LEFT JOIN groupe_etudiants ge ON e.id = ge.etudiant_id
            WHERE ge.etudiant_id IS NULL AND e.semestre_id = :semestre
        ");
        $stmt->execute([':semestre' => $semestre]);
        return $stmt->fetchAll();
    }
    public function getEtudiantsById($id) {
        $stmt = self::getBdd()->prepare("SELECT id, nom, prenom,semestre_id FROM utilisateurs JOIN etudiants using(id) WHERE role = 'etudiant' AND id=:id");
        $stmt->execute([':id'=>$id]);
        return $stmt->fetch();
    }

    public function getGroupes($projetId){
        $stmt = self::getBdd()->prepare("SELECT * FROM groupes WHERE projet_id=:projetId");
        $stmt->execute([':projetId'=>$projetId]);
        return $stmt->fetchAll();
    }


    public function createGroupe($projetId, $nomGroupe,$limiteGroupe) {
        $stmt = self::getBdd()->prepare("INSERT INTO groupes (projet_id, nom,limiteGroupe) VALUES (:projet_id, :nom,:limiteGroupe)");
        $stmt->execute([
            ':projet_id' => $projetId,
            ':nom' => $nomGroupe,
            ':limiteGroupe' =>$limiteGroupe

        ]);
        return self::getBdd()->lastInsertId(); 
    }

    public function addEtudiantToGroupe($groupeId, $etudiants) {

            $stmt = self::getBdd()->prepare("SELECT COUNT(*) FROM groupe_etudiants WHERE etudiant_id = :etudiant_id");
            $stmt->execute([':etudiant_id' => $etudiants]);
            if ($stmt->fetchColumn() > 0) {
                return;
            }
    
            $stmt = self::getBdd()->prepare("INSERT INTO groupe_etudiants (groupe_id, etudiant_id) VALUES (:groupe_id, :etudiant_id)");
            $stmt->execute([
                ':groupe_id' => $groupeId,
                ':etudiant_id' => $etudiants
            ]);
        }
    
    
    public function getEtudiantsBySemestre($semestre) {
        $stmt = self::getBdd()->prepare("SELECT * FROM etudiants WHERE semestre=:semestre");
        $stmt->execute([':semestre' => $semestre]);
        return $stmt->fetchAll();
    }
    public function getSemestreByEtudiantId($etudiantId) {
        $stmt = self::getBdd()->prepare("SELECT semestre FROM etudiants WHERE id=:etudiantId");
        $stmt->execute([':etudiantId' => $etudiantId]);
        return $stmt->fetchColumn();
    }

    public function getEtudiantsByGroupeId($groupeId) {
        $stmt = self::getBdd()->prepare("
            SELECT u.id, u.nom, u.prenom
            FROM groupe_etudiants ge
            JOIN utilisateurs u ON ge.etudiant_id = u.id
            WHERE ge.groupe_id = :groupe_id
        ");
        $stmt->execute([':groupe_id' => $groupeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function deleteEtudiantFromGroupe($groupeId, $etudiants) {
        
            $stmt = self::getBdd()->prepare("DELETE FROM groupe_etudiants  WHERE (groupe_id=:groupe_id AND etudiant_id=:etudiant_id)");
            $stmt->execute([
                ':groupe_id' => $groupeId,
                ':etudiant_id' => $etudiants
            ]);
        
    }
    public function getGroupeById($groupeId){
        $stmt = self::getBdd()->prepare("SELECT * FROM groupes WHERE id=:groupeId");
        $stmt->execute([':groupeId'=>$groupeId]);
        return $stmt->fetch();
    }

    public function updateNomGroupe($groupeId, $nom) {
        $stmt = self::getBdd()->prepare("UPDATE groupes SET nom = :nom WHERE id = :groupe_id");
        $stmt->execute([
            ':groupe_id' => $groupeId,
            ':nom' => $nom
        ]);
    }

    public function updateImageGroupe($groupeId, $imagePath) {
        $stmt = self::getBdd()->prepare("UPDATE groupes SET image_titre = :image WHERE id = :groupe_id");
        $stmt->execute([
            ':groupe_id' => $groupeId,
            ':image' => $imagePath
        ]);
    }

    public function getGroupeByEtudiantId($userId, $projetId) {
        $stmt = self::getBdd()->prepare("SELECT groupe_id,projet_id,nom,image_titre,nom_modifiable,image_modifiable,limiteGroupe FROM groupe_etudiants JOIN groupes on (groupe_id=groupes.id) WHERE etudiant_id = :etudiant_id AND projet_id = :projet_id");
        $stmt->execute([':etudiant_id' => $userId,
                        ':projet_id' => $projetId]);
        return $stmt->fetch();
    }
}
?>
