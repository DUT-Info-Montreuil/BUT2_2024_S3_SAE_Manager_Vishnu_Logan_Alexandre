document.addEventListener("DOMContentLoaded", function () {

    const modifierBtns = document.querySelectorAll(".modifier-btn");
    const menuContextuel = document.getElementById("menuContextuel");
    const fermerMenu = document.getElementById("fermerMenu");


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


    const supprimerBtns = document.querySelectorAll(".supprimer-btn");
    const fermerMenusupp = document.getElementById("fermerMenusupp");
    const menuContextuelSupp= document.getElementById("menuContextuelSupp");
    supprimerBtns.forEach(btn => {
    btn.addEventListener("click", function (event) {
        event.preventDefault(); 

        console.log("ID du groupe : ", btn.dataset.idgroupe); // Vérifie l'ID
        document.getElementById("groupId").value = btn.dataset.idgroupe;

        menuContextuelSupp.style.display = "block";
    });


    fermerMenusupp.addEventListener("click", function () {
        menuContextuelSupp.style.display = "none"; 
    });
    })
});