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
        $projetId = isset($_GET['projetId']) ? htmlspecialchars(strip_tags($_GET['projetId'])) : -1;
        ?>
        <div id="groupe-container" class="groupe-container">
            <?php if ($groupeUtilisateur): ?>
                <h2 class="titre-groupe">Votre Groupe</h2>
                <p><strong>Nom du groupe :</strong> <?= !empty($groupeUtilisateur['nom']) ? $groupeUtilisateur['nom'] : "Groupe " . $groupeUtilisateur['groupe_id'] ?></p>
                <p><strong>Limite du groupe :</strong> <?= count($etudiantsParGroupe[$groupeUtilisateur['groupe_id']])?>/<?= htmlspecialchars($groupeUtilisateur['limiteGroupe']) ?></p>
                    
                <?php if (!empty($groupeUtilisateur['image_titre'])): ?>
                    <img src="<?= htmlspecialchars($groupeUtilisateur['image_titre']) ?>" alt="Image du groupe" class="image-groupe">
                <?php endif; ?>
                    
                <p><strong>Membres :</strong></p>
                <ul class="membres-list">
                    <?php foreach ($etudiantsParGroupe[$groupeUtilisateur['groupe_id']] ?? [] as $membre): ?>
                        <li class="membre"><?= htmlspecialchars($membre['nom'] . ' ' . $membre['prenom']) ?></li>
                    <?php endforeach; ?>
                </ul>
                <div>
                        <?php if ($groupeUtilisateur['groupeValide']): ?>
                            <p class="message-confirmation">Le groupe est validé.</p>
                        <?php else: ?>
                            <?php if (isset($etudiantsParGroupe[$groupeUtilisateur['groupe_id']]) && count($etudiantsParGroupe[$groupeUtilisateur['groupe_id']]) === (int) $groupeUtilisateur['limiteGroupe']): ?>
                                <form method="POST" action="index.php?module=groupe&action=confirmer" class="form-confirm">
                                    <input type="hidden" name="groupe_id" value="<?= htmlspecialchars($groupeUtilisateur['groupe_id']) ?>">
                                    <button type="submit" class="btn confirm-btn">
                                        Confirmer
                                    </button>
                                </form>
                            <?php else: ?>
                                <p class="message-confirmation">Le groupe n'est pas complet.</p>
                                <div class="custom-dropdown">
                                    <button type="button" class="dropdown-btn" onclick="toggleDropdown()">
                                        Sélectionnez les étudiants
                                        <span class="dropdown-icon">▼</span>
                                    </button>
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

                                   

                                    <script>
                                    function toggleDropdown() {
                                        var dropdown = document.querySelector(".custom-dropdown");
                                        dropdown.classList.toggle("active");
                                    }
                                    </script>
                            <?php endif; ?>

                                
                        <?php endif; ?>
                        <button id="btnModifierGroupe" class="btn modifier-btn">
                                    Modifier le groupe
                        </button>
                        <form method="POST" action="index.php?module=groupe&action=quitter" class="form-quitter">
                            <input type="hidden" name="groupe_id" value="<?= $groupeUtilisateur['groupe_id'] ?>">
                            <button type="submit" class="btn quitter-btn">
                                Quitter le groupe
                            </button>
                        </form>
                </div>
            
                
                
                    <div id="modifierGroupeModal" class="modal">
                    <div class="modal-content">
                            <h3 class="modal-titre">Modifier le groupe</h3>
                            <form method="POST" action="index.php?module=groupe&action=modifier" enctype="multipart/form-data" class="form-modifier-groupe">
                                <input type="hidden" name="groupe_id" value="<?= $groupeUtilisateur['groupe_id'] ?>">

                                <?php if ($nomModifiable): ?>
                                    <label for="nom_groupe" class="label-groupe">Nom du groupe :</label><br>
                                    <input type="text" id="nom_groupe" name="nom_groupe" value="<?= !empty($groupeUtilisateur['nom']) ? $groupeUtilisateur['nom'] : "Groupe " . $groupeUtilisateur['groupe_id'] ?>" required class="input-groupe"><br><br>
                                <?php endif; ?>

                                <?php if ($imageModifiable): ?>
                                    <label for="image_groupe" class="label-groupe">Image du groupe (PNG) :</label><br>
                                    <input type="file" name="image_groupe" accept="image/png" class="input-groupe"><br><br>
                                <?php endif; ?>

                                

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
                        <?php
                        $isFull = count($etudiantsParGroupe[$groupe['id']] ?? []) >= $groupe['limiteGroupe'];
                        if ($groupe['groupeValide'] || $isFull) {
                            continue;
                        }
                        ?>
                        <tr class="ligne-groupe">
                            <td class="cell-groupe"><?= !empty($groupe['nom']) ? $groupe['nom'] : "Groupe " . $groupe['id'] ?></td>
                            <td class="cell-action">
                                <?php 
                            
                                ?>
                                
                                <form method="POST" action="index.php?module=groupe&action=rejoindre&projetId=<?$projetId?>" class="form-rejoindre-groupe">
                                    <input type="hidden" name="groupe_id" value="<?= $groupe['id'] ?>">
                                    <button type="submit" class="btn rejoindre-btn"?>
                                        Rejoindre
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
