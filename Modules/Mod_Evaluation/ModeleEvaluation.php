<?php

require_once 'connexion.php';

class ModeleEvaluation extends Connexion{

    public function getGroupEvaluations($projet_id) {
        $stmt = self::getBdd()->prepare("SELECT evaluations.id, groupes.nom, evaluations.note 
            FROM evaluations 
            INNER JOIN groupes ON evaluations.groupe_id = groupes.id
            WHERE evaluations.etudiant_id IS NULL 
            AND evaluations.projet_id = :projet_id");
        $stmt->bindParam(':projet_id', $projet_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIndividualEvaluations($projet_id) {
        $stmt = self::getBdd()->prepare("SELECT evaluations.id, utilisateurs.nom, utilisateurs.prenom, evaluations.note 
            FROM evaluations 
            INNER JOIN utilisateurs ON evaluations.etudiant_id = utilisateurs.id 
            WHERE evaluations.groupe_id IS NULL 
            AND utilisateurs.role = 'etudiant' 
            AND evaluations.projet_id = :projet_id");
        $stmt->bindParam(':projet_id', $projet_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function ajouterEvaluationGroupe($evaluateur_id, $groupe_id, $note, $commentaire, $projet_id) {
        $stmt = self::getBdd()->prepare(
            "INSERT INTO evaluations (evaluateur_id, groupe_id, note, commentaire, projet_id) 
             VALUES (:evaluateur_id, :groupe_id, :note, :commentaire, :projet_id)"
        );
        $stmt->execute([
            'evaluateur_id' => $evaluateur_id,
            'groupe_id' => $groupe_id,
            'note' => $note,
            'commentaire' => $commentaire,
            'projet_id' => $projet_id
        ]);
    }
    
    public function ajouterEvaluationIndividuelle($evaluateur_id, $etudiant_id, $note, $commentaire, $projet_id) {
        $stmt = self::getBdd()->prepare(
            "INSERT INTO evaluations (evaluateur_id, etudiant_id, note, commentaire, projet_id) 
             VALUES (:evaluateur_id, :etudiant_id, :note, :commentaire, :projet_id)"
        );
        $stmt->execute([
            'evaluateur_id' => $evaluateur_id,
            'etudiant_id' => $etudiant_id,
            'note' => $note,
            'commentaire' => $commentaire,
            'projet_id' => $projet_id
        ]);
    }
    
    public function getListeGroupes($projet_id) {
        $stmt = self::getBdd()->prepare(
            "SELECT id, nom FROM groupes WHERE projet_id = :projet_id"
        );
        $stmt->execute(['projet_id' => $projet_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getListeEtudiants($projet_id) {
        $stmt = self::getBdd()->prepare(
            "SELECT utilisateurs.id, CONCAT(utilisateurs.prenom, ' ', utilisateurs.nom) AS nom_complet 
             FROM utilisateurs INNER JOIN etudiants USING(id) INNER JOIN projets USING(semestre_id)
             WHERE projets.id = :projet_id"
        );
        $stmt->execute(['projet_id' => $projet_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUtilisateurId($login) {
        $stmt = self::getBdd()->prepare("SELECT id FROM utilisateurs WHERE login = :login");
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();
    
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $utilisateur ? $utilisateur['id'] : null;
    }
    

    public function supprimerEvaluation($id) {
        $stmt = self::getBdd()->prepare('DELETE FROM evaluations WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function modifierEvaluationGroupe($evaluation_id, $note) {
        $stmt = self::getBdd()->prepare(
            "UPDATE evaluations SET note = :note WHERE id = :id AND groupe_id IS NOT NULL"
        );
        $stmt->execute([
            'note' => $note,
            'id' => $evaluation_id
        ]);
    }

    public function modifierEvaluationIndividuelle($evaluation_id, $note) {
        $stmt = self::getBdd()->prepare(
            "UPDATE evaluations SET note = :note WHERE id = :id AND etudiant_id IS NOT NULL"
        );
        $stmt->execute([
            'note' => $note,
            'id' => $evaluation_id
        ]);
    }    
    
}
?>