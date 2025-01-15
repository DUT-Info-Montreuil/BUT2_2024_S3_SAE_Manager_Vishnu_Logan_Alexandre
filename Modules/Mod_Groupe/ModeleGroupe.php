<?php
// Mod_Groupe.php

require_once 'connexion.php';

class Modele_Groupe extends Connexion {



    // Récupérer tous les étudiants avec le rôle 'etudiant'
    public function getEtudiants() {
        $stmt = self::getBdd()->prepare("SELECT id, nom, prenom FROM utilisateurs WHERE role = 'etudiant'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Créer un groupe
    public function createGroupe($projetId, $nomGroupe) {
        $stmt = self::getBdd()->prepare("INSERT INTO groupes (projet_id, nom) VALUES (:projet_id, :nom)");
        $stmt->execute([
            ':projet_id' => $projetId,
            ':nom' => $nomGroupe
        ]);
        return self::getBdd()->lastInsertId(); // Retourne l'ID du groupe créé
    }

    // Ajouter des étudiants dans un groupe
    public function addEtudiantsToGroupe($groupeId, $etudiants) {
        foreach ($etudiants as $etudiantId) {
            $stmt = self::getBdd()->prepare("INSERT INTO groupe_etudiants (groupe_id, etudiant_id) VALUES (:groupe_id, :etudiant_id)");
            $stmt->execute([
                ':groupe_id' => $groupeId,
                ':etudiant_id' => $etudiantId
            ]);
        }
    }
}
?>
