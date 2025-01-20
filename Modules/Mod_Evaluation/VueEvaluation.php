<?php

require_once 'vue_generique.php';

class VueEvaluation extends VueGenerique {

    public function __construct() {
        parent::__construct();
    }

    public function afficherEvaluations($projet_id, $evaluationsGroupe, $evaluationsIndividuelles, $groupes = [], $etudiants = []) {
        ?>
        <?php include_once __DIR__ . '/../../head.php'; ?>
        
        <div class="accueil">
            <!-- Contenu principal -->
            <div class="main-content" style="flex-grow: 1; margin-left: 5%;">
                <!-- En-tête -->
                <div class="header">
                    <h1>Gestion des Évaluations</h1>
                </div>
    
                <!-- Liste des Évaluations de Groupe -->
                <section>
                    <h2>Liste des Évaluations de Groupe</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom du Groupe</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($evaluationsGroupe as $eval) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($eval['nom']) ?></td>
                                    <td><?= htmlspecialchars($eval['note']) ?>/20</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </section>
    
                <!-- Liste des Évaluations Individuelles -->
                <section>
                    <h2>Liste des Évaluations Individuelles</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($evaluationsIndividuelles as $eval) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($eval['nom']) ?></td>
                                    <td><?= htmlspecialchars($eval['prenom']) ?></td>
                                    <td><?= htmlspecialchars($eval['note']) ?>/20</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </section>

                <!-- Formulaire d'ajout d'évaluation de groupe -->
                <section>
                    <h2>Ajouter une Évaluation de Groupe</h2>
                    <form method="POST" action="index.php?module=evaluation&action=ajouterEvaluationGroupe&projet_id=<?= htmlspecialchars($projet_id) ?>">
                        <label for="groupe_id">Sélectionnez un groupe :</label>
                        <select name="groupe_id" id="groupe_id" required>
                            <?php foreach ($groupes as $groupe) { ?>
                                <option value="<?= htmlspecialchars($groupe['id']) ?>">
                                    <?= htmlspecialchars($groupe['nom']) ?>
                                </option>
                            <?php } ?>
                        </select>
        
                        <label for="note">Note :</label>
                        <input type="number" name="note" id="note" step="0.01" min="0" max="20" required>
        
                        <label for="commentaire">Commentaire :</label>
                        <textarea name="commentaire" id="commentaire" required></textarea>
        
                        <button type="submit">Ajouter</button>
                    </form>
                </section>

                <!-- Formulaire d'ajout d'évaluation individuelle -->
                <section>
                    <h2>Ajouter une Évaluation Individuelle</h2>
                    <form method="POST" action="index.php?module=evaluation&action=ajouterEvaluationIndividuelle&projet_id=<?= htmlspecialchars($projet_id) ?>">
                        <label for="etudiant_id">Sélectionnez un étudiant :</label>
                        <select name="etudiant_id" id="etudiant_id" required>
                            <?php foreach ($etudiants as $etudiant) { ?>
                                <option value="<?= htmlspecialchars($etudiant['id']) ?>">
                                    <?= htmlspecialchars($etudiant['nom_complet']) ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label for="note">Note :</label>
                        <input type="number" name="note" id="note" step="0.01" min="0" max="20" required>

                        <label for="commentaire">Commentaire :</label>
                        <textarea name="commentaire" id="commentaire" required></textarea>

                        <button type="submit">Ajouter</button>
                    </form>
                </section>
            </div>
        </div>
        <?php
    }    
    

}
?>
