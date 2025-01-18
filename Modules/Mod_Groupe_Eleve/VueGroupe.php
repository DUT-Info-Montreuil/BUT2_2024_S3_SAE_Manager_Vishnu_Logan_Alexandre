<?php
// Vue_Groupe.php

class Vue_Groupe extends VueGenerique {
    private $vueAccueil;

    public function __construct() {
        parent::__construct();
        $this->vueAccueil = new VueAccueil();
        $this->vueAccueil->afficherAccueil();
    }

    public function afficherFormulaire($etudiants, $groupes, $etudiantsParGroupe, $userId, $groupeUtilisateur) {
        $nomModifiable = !empty($groupeUtilisateur['nom_modifiable']) ? $groupeUtilisateur['nom_modifiable'] : 0;
        $imageModifiable = !empty($groupeUtilisateur['image_modifiable']) ? $groupeUtilisateur['image_modifiable'] : 0;
        ?>
        <div id="groupe-container" class="groupe-container">
            <?php if ($groupeUtilisateur): ?>
                <h2 class="titre-groupe">Votre Groupe</h2>
                <p><strong>Nom du groupe :</strong> <?= !empty($groupe['nom']) ? $groupeUtilisateur['nom'] : "Groupe " . $groupeUtilisateur['groupe_id'] ?></p>
                <p><strong>Limite du groupe :</strong> <?= htmlspecialchars($groupeUtilisateur['limiteGroupe']) ?></p>
                    
                <?php if (!empty($groupeUtilisateur['image_titre'])): ?>
                    <img src="<?= htmlspecialchars($groupeUtilisateur['image_titre']) ?>" alt="Image du groupe" class="image-groupe">
                <?php endif; ?>
                    
                <p><strong>Membres :</strong></p>
                <ul class="membres-list">
                    <?php foreach ($etudiantsParGroupe[$groupeUtilisateur['groupe_id']] ?? [] as $membre): ?>
                        <li class="membre"><?= htmlspecialchars($membre['nom'] . ' ' . $membre['prenom']) ?></li>
                    <?php endforeach; ?>
                </ul>
            
                <form method="POST" action="index.php?module=groupe&action=quitter" class="form-quitter">
                    <input type="hidden" name="groupe_id" value="<?= $groupeUtilisateur['groupe_id'] ?>">
                    <button type="submit" class="btn quitter-btn">
                        Quitter le groupe
                    </button>
                </form>
        
                
                    <button id="btnModifierGroupe" class="btn modifier-btn">
                        Modifier le groupe
                    </button>
                
                    <div id="modifierGroupeModal" class="modal">
                    <div class="modal-content">
                            <h3 class="modal-titre">Modifier le groupe</h3>
                            <form method="POST" action="index.php?module=groupe&action=modifier" class="form-modifier-groupe">
                                <input type="hidden" name="groupe_id" value="<?= $groupeUtilisateur['groupe_id'] ?>">

                                <?php if ($nomModifiable): ?>
                                    <label for="nom_groupe" class="label-groupe">Nom du groupe :</label><br>
                                    <input type="text" id="nom_groupe" name="nom_groupe" value="<?= !empty($groupe['nom']) ? $groupeUtilisateur['nom'] : "Groupe " . $groupeUtilisateur['groupe_id'] ?>" required class="input-groupe"><br><br>
                                <?php endif; ?>

                                <?php if ($imageModifiable): ?>
                                    <label for="image_groupe" class="label-groupe">Image du groupe (PNG) :</label><br>
                                    <input type="file" id="image_groupe" name="image_groupe" accept=".png" class="input-groupe"><br><br>
                                <?php endif; ?>

                                <div class="custom-dropdown">
                                    <button type="button" class="dropdown-btn">Sélectionnez les étudiants</button>
                                    <div class="dropdown-content">
                                        <?php foreach ($etudiants as $etudiant) : ?>
                                            <label>
                                                <input type="checkbox" class="etudiant-checkbox" value="<?php echo $etudiant['id']; ?>" 
                                                    data-nom="<?php echo $etudiant['nom']; ?>" 
                                                    data-prenom="<?php echo $etudiant['prenom']; ?>">
                                                <?php echo $etudiant['nom'] . ' ' . $etudiant['prenom']; ?>
                                            </label><br>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <button type="submit" class="btn enregistrer-btn">
                                    Enregistrer les modifications
                                </button>
                            </form>
                            <button onclick="closeModal()" class="btn fermer-btn">
                                Fermer
                            </button>
                        </div>

                <?php endif; ?>
        
                <script>
                    document.getElementById('btnModifierGroupe').onclick = function() {
                        document.getElementById('modifierGroupeModal').style.display = 'flex';
                    };
    
                    function closeModal() {
                        document.getElementById('modifierGroupeModal').style.display = 'none';
                    }
                </script>
        </div>
        
        <?php if (!$groupeUtilisateur): ?>
            <div id="groupes-container" class="groupes-container">
                <h3 class="titre-groupes">Rejoindre un Groupe</h3>
                <table class="table-groupes">
                    <thead>
                        <tr>
                            <th class="col-groupe">Nom du Groupe</th>
                            <th class="col-action">Rejoindre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($groupes as $groupe): ?>
                            <tr class="ligne-groupe">
                                <td class="cell-groupe"><?= !empty($groupe['nom']) ? $groupe['nom'] : "Groupe " . $groupe['id'] ?></td>
                                <td class="cell-action">
                                    <?php 
                                    $isMember = in_array($userId, array_column($etudiantsParGroupe[$groupe['id']] ?? [], 'user_id')) || $groupeUtilisateur;
                                    ?>
                                    
                                    <form method="POST" action="index.php?module=groupe&action=rejoindre" class="form-rejoindre-groupe">
                                        <input type="hidden" name="groupe_id" value="<?= $groupe['id'] ?>">
                                        <button type="submit" class="btn rejoindre-btn" <?= $isMember ? 'disabled' : '' ?>>
                                            <?= $isMember ? 'Déjà membre' : 'Rejoindre' ?>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        <?php
    }
}
?>
