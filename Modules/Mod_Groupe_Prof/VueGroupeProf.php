<?php
class Vue_Groupe_Prof extends VueGenerique {
    private $vueAccueil;

    public function __construct() {
        parent::__construct();
        $this->vueAccueil = new VueAccueil();
        $this->vueAccueil->afficherAccueil();
    }

    public function afficherFormulaire($groupes) {
        ?>
        <div class="group-container">
            <form id="formGroupe" method='POST' action='index.php?module=groupeProf&action=ajouter'>
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
                        <input type="checkbox" id="modifier_nom" name="modifier_nom" /> Modifier le nom
                    </label>
                    <label for="modifier_image">
                        <input type="checkbox" id="modifier_image" name="modifier_image" /> Modifier l'image
                    </label>
                </div>

                <button type="button" id="ajouterGroupeBtn" class="btn" onclick="afficherApercuGroupes()">Ajouter Groupes</button>

                <div id="aperçuGroupes" class="group-preview">

                </div>


                <button type='submit' id="btnConfirmer" style="display:none;" class="btn">Confirmer la création</button>
            </form>
        </div>


        <div id="groupesList">
            <h2>Groupes existants</h2>
            <ul>
                <?php

                foreach ($groupes as $groupe) {
                    echo '<li id="groupe_' . $groupe['id'] . '">';
                    echo "Groupe " . $groupe['id'] . " | Limite: " . $groupe['limiteGroupe'] . " étudiants";
                    echo ' | <a href="index.php?module=groupeProf&action=modifier&id=' . $groupe['id'] . '">Modifier</a>';
                    echo ' | <a href="index.php?module=groupeProf&action=supprimer&id=' . $groupe['id'] . '">Supprimer</a>';
                    echo '</li>';
                }
                ?>
            </ul>
        </div>

        <script>

            function afficherApercuGroupes() {
                const nombreGroupes = document.getElementById('nombre_groupes').value;
                const limiteGroupe = document.getElementById('limite_groupe').value;
                const modifNom = document.getElementById('modifier_nom').checked;
                const modifImage = document.getElementById('modifier_image').checked;
                const apercuDiv = document.getElementById('aperçuGroupes');
                const btnConfirmer = document.getElementById('btnConfirmer');
                

                apercuDiv.innerHTML = '';
                

                if (nombreGroupes && limiteGroupe) {
                    for (let i = 1; i <= nombreGroupes; i++) {
                        const divGroupe = document.createElement('div');
                        divGroupe.classList.add('groupe-aperçu');
                        divGroupe.innerHTML = `Groupe ${i}: ${limiteGroupe} étudiants. Modifier Nom : ${modifNom ? 'Oui' : 'Non'}, Modifier Image : ${modifImage ? 'Oui' : 'Non'}`;
                        apercuDiv.appendChild(divGroupe);
                    }
                    btnConfirmer.style.display = 'inline-block'; 
                } else {
                    btnConfirmer.style.display = 'none'; 
                }
            }


            


            
        </script>
        <?php
    }
}
?>
