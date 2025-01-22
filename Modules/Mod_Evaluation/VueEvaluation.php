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
            <div class="main-content">
                <h1>Gestion des Évaluations</h1>
                
                <section class="section-table">
                    <h2>Évaluations de Groupe</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom du Groupe</th>
                                <th>Note</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($evaluationsGroupe as $eval) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($eval['nom']) ?></td>
                                    <td><?= htmlspecialchars($eval['note']) ?>/20</td>
                                    <td>
                                        <button class="btn-supprimer" onclick="if (confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ?')) {
                                                window.location.href = 'index.php?module=evaluation&action=supprimerEvaluation&evaluation_id=<?= htmlspecialchars($eval['id']) ?>&projet_id=<?= htmlspecialchars($projet_id) ?>';}">
                                            Supprimer
                                        </button>

                                        <button class="btn-modifier" onclick="togglePopup('block', '<?= htmlspecialchars($eval['id']) ?>', '<?= htmlspecialchars($eval['note']) ?>', 'groupe')">
                                            Modifier
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </section>
    
                <section class="section-table">
                    <h2>Évaluations Individuelles</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Note</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($evaluationsIndividuelles as $eval) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($eval['nom']) ?></td>
                                    <td><?= htmlspecialchars($eval['prenom']) ?></td>
                                    <td><?= htmlspecialchars($eval['note']) ?>/20</td>
                                    <td>
                                        <button class="btn-supprimer" onclick="if (confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ?')) {
                                                window.location.href = 'index.php?module=evaluation&action=supprimerEvaluation&evaluation_id=<?= htmlspecialchars($eval['id']) ?>&projet_id=<?= htmlspecialchars($projet_id) ?>';}">
                                            Supprimer
                                        </button>
                                        <button class="btn-modifier" onclick="togglePopup('block', '<?= htmlspecialchars($eval['id']) ?>', '<?= htmlspecialchars($eval['note']) ?>', 'individuelle')">
                                            Modifier
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </section>

                <div id="popup-modifier" class="popup">
                    <h2>Modifier l'Évaluation</h2>
                    <form id="form-modifier" method="POST" action="index.php?module=evaluation&action=modifierEvaluation&projet_id=<?= htmlspecialchars($projet_id) ?>">
                        <input type="hidden" name="evaluation_id" id="evaluation-id">
                        <input type="hidden" name="type" id="evaluation-type">
                        <label for="note">Nouvelle note :</label>
                        <input type="number" name="note" id="evaluation-note" step="1.00" min="0" max="20" required>
                        <br><br>
                        <button type="submit" onclick="handleFormSubmit(event)">Confirmer</button>
                        <button type="button" onclick="fermerPopup()">Annuler</button>
                    </form>
                </div>


                <div id="overlay" class="overlay" onclick="fermerPopup()"></div>

                <section class="section-form">
                    <h2>Ajouter une Évaluation de Groupe</h2>
                    <form method="POST" action="index.php?module=evaluation&action=ajouterEvaluationGroupe&projet_id=<?= htmlspecialchars($projet_id) ?>">
                        <label for="groupe_id">Sélectionnez un groupe :</label>
                        <select name="groupe_id" id="groupe_id" required>
                            <?php foreach ($groupes as $groupe) { ?>
                                <option value="<?= htmlspecialchars($groupe['id']) ?>"><?= htmlspecialchars($groupe['nom']) ?></option>
                            <?php } ?>
                        </select>
                        <label for="note">Note :</label>
                        <input type="number" name="note" id="note" step="0.01" min="0" max="20" required>
                        <label for="commentaire">Commentaire :</label>
                        <textarea name="commentaire" id="commentaire" required></textarea>
                        <button type="submit">Ajouter</button>
                    </form>
                </section>

                <section class="section-form">
                    <h2>Ajouter une Évaluation Individuelle</h2>
                    <form method="POST" action="index.php?module=evaluation&action=ajouterEvaluationIndividuelle&projet_id=<?= htmlspecialchars($projet_id) ?>">
                        <label for="etudiant_id">Sélectionnez un étudiant :</label>
                        <select name="etudiant_id" id="etudiant_id" required>
                            <?php foreach ($etudiants as $etudiant) { ?>
                                <option value="<?= htmlspecialchars($etudiant['id']) ?>"><?= htmlspecialchars($etudiant['nom_complet']) ?></option>
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
        <script>

            function togglePopup(display, evaluationId = null, note = null, type = null) {
                console.log("togglePopup called", display);
                const popup = document.getElementById('popup-modifier');
                const overlay = document.getElementById('overlay');

                popup.style.display = display;
                overlay.style.display = display;

                if (display === 'block' && evaluationId) {
                    document.getElementById('evaluation-id').value = evaluationId;
                    document.getElementById('evaluation-note').value = note;
                    document.getElementById('evaluation-type').value = type;
                }
            }

            function fermerPopup() {
                const popup = document.getElementById('popup-modifier');
                const overlay = document.getElementById('overlay');

                popup.style.display = 'none';
                overlay.style.display = 'none';
            }

            function handleFormSubmit(event) {
                event.preventDefault();
                fermerPopup();
                document.getElementById('form-modifier').submit(); 
            }

        </script>
        <?php
    }    
}
?>
