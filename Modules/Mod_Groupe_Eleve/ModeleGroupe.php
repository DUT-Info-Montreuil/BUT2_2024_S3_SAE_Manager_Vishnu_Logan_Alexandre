<?php
// Mod_Groupe.php

require_once 'connexion.php';

class Modele_Groupe extends Connexion {

    public function getEtudiants() {
        $stmt = self::getBdd()->prepare("SELECT id, nom, prenom,semestre_id FROM utilisateurs JOIN etudiants using(id) WHERE role = 'etudiant'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getGroupes($id,$projetId){
        $stmt = self::getBdd()->prepare("SELECT * FROM groupes WHERE id=:id AND projet_id=:projetId");
        $stmt->execute([':id' => $id,':projetId'=>$projetId]);
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
