<?php
// Vue_Groupe.php

class Vue_Groupe extends VueGenerique {
    private $vueAccueil;

    public function __construct() {
        parent::__construct();
        $this->vueAccueil = new VueAccueil();
        $this->vueAccueil->afficherAccueil();
    }

    public function afficherFormulaire($etudiants) {
        ?>
        <div class="group-container">
            <form id="formGroupe" action="index.php?module=groupe&action=creer" method="post">
                
                <div class="input-group">
                    <label for="nom_groupe">Nom du groupe</label>
                    <input type="text" id="nom_groupe" name="nom_groupe" placeholder="Nom du groupe" required>
                </div>
                
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
                
                <button type="button" id="ajouterEleveBtn" class="btn">Ajouter Élève</button>
                <button type="submit" class="btn">Créer le groupe</button>
            </form>

            <div class="prev-group">
                <h3>Prévisualisation des élèves sélectionnés :</h3>
                <div id="listePrevisu" class="liste-eleve">

                </div>
            </div>
        </div>

        <script>
            document.getElementById('ajouterEleveBtn').addEventListener('click', function () {
                const checkboxes = document.querySelectorAll('.etudiant-checkbox:checked');
                const listePrevisu = document.getElementById('listePrevisu');

                listePrevisu.innerHTML = '';

                checkboxes.forEach(function (checkbox) {
                    const nom = checkbox.dataset.nom;
                    const prenom = checkbox.dataset.prenom;
                    const id = checkbox.value;

                    const p = document.createElement('p');
                    p.className = 'eleve';
                    p.textContent = `${nom} ${prenom} (ID: ${id})`;

                    listePrevisu.appendChild(p);

                    let inputHidden = document.createElement('input');
                    inputHidden.type = 'hidden';
                    inputHidden.name = 'etudiants[]';
                    inputHidden.value = id;

                    document.getElementById('formGroupe').appendChild(inputHidden);
                });
            });
        </script>

        <?php
    }
}
