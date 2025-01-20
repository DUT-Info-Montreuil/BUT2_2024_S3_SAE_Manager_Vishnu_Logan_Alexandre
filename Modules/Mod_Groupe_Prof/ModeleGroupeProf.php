<?php
// Mod_Groupe_Prof.php

require_once 'connexion.php';

class Modele_Groupe_Prof extends Connexion {

    public function getEtudiants() {
        $stmt = self::getBdd()->prepare("SELECT id, nom, prenom FROM utilisateurs WHERE role = 'etudiant'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getGroupes($id){
        $stmt = self::getBdd()->prepare("SELECT * FROM groupes WHERE projet_id=:projet_id");
        $stmt->execute([':projet_id' => $id]);
        return $stmt->fetchAll();
    }


    public function createGroupe($projetId, $limiteGroupe, $modifNom, $modifImage) {
        $bdd = self::getBdd();
    
 
        $stmt = $bdd->prepare("INSERT INTO groupes (projet_id, nom_modifiable, image_modifiable, limiteGroupe) 
                               VALUES (:projet_id, :modifNom, :modifImage, :limiteGroupe)");
        $stmt->execute([
            ':projet_id' => $projetId,
            ':modifNom' => $modifNom,
            ':modifImage' => $modifImage,
            ':limiteGroupe' => $limiteGroupe
        ]);
    
        $groupeId = $bdd->lastInsertId();

        $stmt = $bdd->prepare("UPDATE groupes SET nom = :nom WHERE id = :id");
        $stmt->execute([
            ':nom' => "groupe " . $groupeId,
            ':id' => $groupeId
        ]);
    
        return $groupeId; 
    }

    public function deleteGroupe($groupeId){
        $stmt = self::getBdd()->prepare("DELETE FROM groupes WHERE id=:groupeId");
        $stmt->execute([':groupeId' => $groupeId]);
    }

    public function modifGroupe($groupeId,$projetId,$nomGroup,$limiteGroupe,$modifNom,$modifImage){
        $stmt = self::getBdd()->prepare("UPDATE groupes 
                                        SET nom=:nom, nom_modifiable=:nom_modifiable, image_modifiable=:image_modifiable, limiteGroupe=:limiteGroupe 
                                        WHERE projet_id=:projetId AND id=:groupeId");

        $stmt->execute([
            ':groupeId' => $groupeId,
            ':projetId' => $projetId,
            ':nom' => $nomGroup, 
            ':nom_modifiable' => $modifNom, 
            ':image_modifiable' => $modifImage, 
            ':limiteGroupe' => $limiteGroupe
        ]);
    }

    public function addEtudiantsToGroupe($groupeId, $etudiants) {
        foreach ($etudiants as $etudiantId) {
            $stmt = self::getBdd()->prepare("INSERT INTO groupe_etudiants (groupe_id, etudiant_id) VALUES (:groupe_id, :etudiant_id)");
            $stmt->execute([
                ':groupe_id' => $groupeId,
                ':etudiant_id' => $etudiantId
            ]);
        }
    }

    public function deleteEtudiantsFromGroupe($groupeId, $etudiants) {
        foreach ($etudiants as $etudiantId) {
            $stmt = self::getBdd()->prepare("DELETE FROM groupe_etudiants  WHERE (groupe_id=:groupe_id AND etudiant_id=:etudiant_id)");
            $stmt->execute([
                ':groupe_id' => $groupeId,
                ':etudiant_id' => $etudiantId
            ]);
        }
    }
}
?>
