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
}
?>