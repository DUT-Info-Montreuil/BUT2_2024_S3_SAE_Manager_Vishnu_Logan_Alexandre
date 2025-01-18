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
                
            </form>

            <div class="prev-group">
                <h3>Prévisualisation des élèves sélectionnés :</h3>
                <div id="listePrevisu" class="liste-eleve">

                </div>
            </div>
        </div>


        <?php
    }
}
