document.addEventListener("DOMContentLoaded", function () {
    const modifierBtns = document.querySelectorAll(".modifier-btn");
    const menuContextuel = document.getElementById("menuContextuel");
    const fermerMenu = document.getElementById("fermerMenu");
    const form = document.getElementById("modifierForm");

    modifierBtns.forEach(btn => {
        btn.addEventListener("click", function (event) {
            event.preventDefault();
            
            document.getElementById("groupeId").value = btn.dataset.id;
            document.getElementById("groupeNom").value = btn.dataset.nom;
            document.getElementById("groupeLimite").value = btn.dataset.limite;
            document.getElementById("changeNom").checked = btn.dataset.changeNom === "1";
            document.getElementById("changeImage").checked = btn.dataset.changeImage === "1";

            menuContextuel.style.display = "block";
        });
    });

    fermerMenu.addEventListener("click", function () {
        menuContextuel.style.display = "none";
    });

    
    
});


function afficherApercuGroupes() {
const nombreGroupes = document.getElementById('nombre_groupes').value;
const limiteGroupe = document.getElementById('limite_groupe').value;
const modifNom = document.getElementById('modifier_nom').checked;
const modifImage = document.getElementById('modifier_image').checked;
const apercuDiv = document.getElementById('aperçuGroupes');


apercuDiv.innerHTML = ''; 


if (nombreGroupes && limiteGroupe) {

    const divResume = document.createElement('div');
    divResume.classList.add('groupe-aperçu');
    divResume.innerHTML = `
        <div class="groupe-header">
            <strong>Résumé des groupes</strong>
        </div>
        <div class="groupe-details">
            <p><strong>Nombre de groupes :</strong> ${nombreGroupes}</p>
            <p><strong>Limite par groupe :</strong> ${limiteGroupe} étudiants</p>
        </div>
        <div class="groupe-actions">
            <button type="submit" id="btnConfirmer" class="btn">Confirmer</button>
            <button type="button" class="btn-annuler" onclick="annulerApercu()">Annuler</button>
        </div>
    `;
    apercuDiv.appendChild(divResume);

    btnConfirmer.style.display = 'inline-block'; 
} else {
    btnConfirmer.style.display = 'none'; 
}
}



        function annulerApercu() {
            const apercuDiv = document.getElementById('aperçuGroupes');
            apercuDiv.innerHTML = ''; 
            const btnConfirmer = document.getElementById('btnConfirmer');
            btnConfirmer.style.display = 'none'; 
        }



        

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".supprimer-btn").forEach(btn => {
                btn.addEventListener("click", function(event) {
                    event.preventDefault(); 
                    
                    let confirmation = confirm("Êtes-vous sûr de vouloir supprimer ce groupe ?");
                    
                    if (confirmation) {
                        window.location.href = this.getAttribute("href"); 
                    }
                });
            });
        });