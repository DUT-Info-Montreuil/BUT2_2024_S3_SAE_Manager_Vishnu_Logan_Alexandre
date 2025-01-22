<?php
class ModeleMenuAccueil extends Connexion {


public function getDataAccueil() {

    $query = self::getBdd()->query("SELECT * FROM annees_universitaires ORDER BY annee_debut DESC");
    $annees = $query->fetchAll(PDO::FETCH_ASSOC);


    foreach ($annees as &$annee) {

        $querySemestres = self::getBdd()->prepare("SELECT * FROM semestres WHERE annee_id = :annee_id");
        $querySemestres->execute([':annee_id' => $annee['id']]);
        $semestres = $querySemestres->fetchAll(PDO::FETCH_ASSOC);


        foreach ($semestres as &$semestre) {

            $queryProjets = self::getBdd()->prepare("SELECT * FROM projets WHERE semestre_id = :semestre_id");
            $queryProjets->execute([':semestre_id' => $semestre['id']]);
            $projets = $queryProjets->fetchAll(PDO::FETCH_ASSOC);


            $semestre['projets'] = $projets;
        }

        $annee['semestres'] = $semestres;
    }

    return $annees;
}
public function ajouterAnnee($annee_debut, $annee_fin) {
    if ($annee_debut >= $annee_fin) {
        throw new Exception("L'année de début doit être inférieure à l'année de fin.");
    }
    $query = self::getBdd()->prepare("INSERT INTO annees_universitaires (annee_debut, annee_fin) VALUES (:annee_debut, :annee_fin)");
    $query->execute([
        ':annee_debut' => $annee_debut,
        ':annee_fin' => $annee_fin
    ]);
}
public function supprimerAnnee($annee_id) {
    $query = self::getBdd()->prepare("DELETE FROM annees_universitaires WHERE id = :id");
    $query->execute([':id' => $annee_id]);
}
public function ajouterProjet($titre, $description, $responsable_id, $semestre_id) {
    $query = self::getBdd()->prepare("
        INSERT INTO projets (titre, description, responsable_id, semestre_id, date_creation) 
        VALUES (:titre, :description, :responsable_id, :semestre_id, NOW())
    ");
    $query->execute([
        ':titre' => $titre,
        ':description' => $description,
        ':responsable_id' => $responsable_id,
        ':semestre_id' => $semestre_id
    ]);
}
public function supprimerSemestre($semestre_id) {
    $query = self::getBdd()->prepare("SELECT COUNT(*) FROM semestres WHERE id = :id");
    $query->execute([':id' => $semestre_id]);

    if ($query->fetchColumn() > 0) {
        $queryDeleteProjets = self::getBdd()->prepare("DELETE FROM projets WHERE semestre_id = :id");
        $queryDeleteProjets->execute([':id' => $semestre_id]);
        $queryDeleteSemestre = self::getBdd()->prepare("DELETE FROM semestres WHERE id = :id");
        $queryDeleteSemestre->execute([':id' => $semestre_id]);
    } else {
        throw new Exception("Erreur : Semestre introuvable.");
    }
}


public function supprimerProjet($projet_id) {
    $query = self::getBdd()->prepare("DELETE FROM projets WHERE id = :id");
    $query->execute([':id' => $projet_id]);
}

public function ajouterSemestre($nom, $annee_id) {
    $query = self::getBdd()->prepare("INSERT INTO semestres (nom, annee_id) VALUES (:nom, :annee_id)");
    $query->execute([
        ':nom' => $nom,
        ':annee_id' => $annee_id
    ]);
}


}
?>