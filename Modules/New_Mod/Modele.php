<?php
class Modele extends Connexion {

// Récupérer les années universitaires, semestres et projets
public function getDataAccueil() {
    // Récupérer les années universitaires
    $query = self::getBdd()->query("SELECT * FROM annees_universitaires ORDER BY annee_debut DESC");
    $annees = $query->fetchAll(PDO::FETCH_ASSOC);

    // Pour chaque année, récupérer les semestres et projets
    foreach ($annees as &$annee) {
        // Récupérer les semestres de l'année
        $querySemestres = self::getBdd()->prepare("SELECT * FROM semestres WHERE annee_id = :annee_id");
        $querySemestres->execute([':annee_id' => $annee['id']]);
        $semestres = $querySemestres->fetchAll(PDO::FETCH_ASSOC);

        // Ajouter les semestres à l'année
        foreach ($semestres as &$semestre) {
            // Récupérer les projets du semestre
            $queryProjets = self::getBdd()->prepare("SELECT * FROM projets WHERE semestre_id = :semestre_id");
            $queryProjets->execute([':semestre_id' => $semestre['id']]);
            $projets = $queryProjets->fetchAll(PDO::FETCH_ASSOC);

            // Ajouter les projets au semestre
            $semestre['projets'] = $projets;
        }
        // Ajouter les semestres à l'année
        $annee['semestres'] = $semestres;
    }

    return $annees;
}
}
?>