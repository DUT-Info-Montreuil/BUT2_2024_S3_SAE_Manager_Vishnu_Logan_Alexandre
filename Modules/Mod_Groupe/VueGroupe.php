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
        <div class="create-group-container">
            <form action="index.php?module=groupe&action=creerGroupe" method="post">
                
                <div class="input-group">
                    <label for="nom_groupe">Nom du groupe</label>
                    <input type="text" name="nom_groupe" placeholder="Nom du groupe" required>
                </div>
                
                <div class="custom-dropdown">
                    <button type="button" class="dropdown-btn">Sélectionnez les étudiants</button>
                    <div class="dropdown-content">
                        <?php foreach ($etudiants as $etudiant) : ?>
                            <label>
                                <input type="checkbox" name="etudiants[]" value="<?php echo $etudiant['id']; ?>">
                                <?php echo $etudiant['nom'] . ' ' . $etudiant['prenom']; ?>
                            </label><br>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <button type="submit" class="btn">Créer le groupe</button>
            </form>
        </div>
        <?php
    }
}
?>
