<?php
class Vue_Groupe_Prof extends VueGenerique {
    private $vueAccueil;

    public function __construct() {
        parent::__construct();
        $this->vueAccueil = new VueAccueil();
        $this->vueAccueil->afficherAccueil();
    }

    public function afficherFormulaire($groupes) {
        $projetId = isset($_GET['projetId']) ? htmlspecialchars(strip_tags($_GET['projetId'])) : -1;
        ?>
        <div class="groupes">
            <div class="group-container">
                <h2>Ajouter des groupes</h2>
                <form id="formGroupe" method='POST' action='index.php?module=groupeProf&action=ajouter&projetId=<?= $projetId ?>'>
                    <div class="input-group">
                        <label for="nombre_groupes">Nombre de groupes</label>
                        <input type="number" id="nombre_groupes" name="nombre_groupes" placeholder="Nombre de groupes" min="1" required>
                    </div>

                    <div class="input-group">
                        <label for="limite_groupe">Limite d'étudiants</label>
                        <input type="number" id="limite_groupe" name="limite_groupe" placeholder="Limite des groupes" min="1" required>
                    </div>


                    <div class="input-group">
                        <label>Modification possible</label><br>
                        <label for="modifier_nom">
                            <input type="checkbox" id="modifier_nom" name="modifier_nom" /> Nom
                        </label>
                        <label for="modifier_image">
                            <input type="checkbox" id="modifier_image" name="modifier_image" /> Image
                        </label>
                    </div>

                    <button type="button" id="ajouterGroupeBtn" class="btn" onclick="afficherApercuGroupes()">Ajouter Groupes</button>

                    <div id="aperçuGroupes" class="group-preview">

                    </div>


                </form>
            </div>


            <div id="groupesList">
                <h2>Groupes existants</h2>
                <table border="2" class="table-container">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Limite</th>
                            <th>Nom Modifiable</th>
                            <th>Image Modifiable</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($groupes as $groupe): ?>
                            <tr id="groupe_<?= $groupe['id'] ?>">
                                <td><?= !empty($groupe['nom']) ? $groupe['nom'] : "Groupe " . $groupe['id'] ?></td>
                                <td><?= $groupe['limiteGroupe'] ?> </td>
                                <td><?= $groupe['nom_modifiable'] ? 'Oui' : 'Non' ?></td>
                                <td><?= $groupe['image_modifiable'] ? 'Oui' : 'Non' ?></td>
                                <td>
                                <button class="modifier-btn" 
                                        data-id="<?= $groupe['id'] ?>" 
                                        data-nom="<?= $groupe['nom'] ?>" 
                                        data-limite="<?= $groupe['limiteGroupe'] ?>" 
                                        data-change-nom="<?= $groupe['nom_modifiable'] ?>" 
                                        data-change-image="<?= $groupe['image_modifiable'] ?>">
                                    Modifier
                                </button>
                                
                                <button class="supprimer-btn" 
                                        data-idgroupe="<?= $groupe['id'] ?>">
                                    Supprimer
                                </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>


<div id="menuContextuel" class="hidden">
    <h3>Modifier Groupe</h3>
    <form id="modifierForm"method='POST' action='index.php?module=groupeProf&action=modifier&projetId=<?= $projetId ?>' >
        <input type="hidden" id="groupeId" name="groupeId">
        
        <label for="groupeNom">Nom du Groupe :</label>
        <input type="text" id="groupeNom" name="groupeNom" >

        <label for="groupeLimite">Taille Max :</label>
        <input type="number" id="groupeLimite" min="1" name="groupeLimite" >

        <label for="changeNom">Nom Modifiable :</label>
        <input type="checkbox" id="changeNom" name="changeNom">

        <label for="changeImage">Image Modifiable :</label>
        <input type="checkbox" id="changeImage" name="changeImage">

        <button type="submit">Enregistrer</button>
        <button type="button" id="fermerMenu" >Annuler</button>
    </form>
</div>

<div id="menuContextuelSupp">
    <h1>Voulez-vous vraiment supprimer ce groupe ?</h1>
    <form id="supprimerForm" method="POST" action="index.php?module=groupeProf&action=supprimer&projetId=<?= $projetId ?>">
        <input type="hidden" id="groupId" name="groupId">
        <button type="submit">Oui</button>
        <button type="button" id="fermerMenusupp">Annuler</button>
    </form>
</div>  


        <?php
    }
}
?>
