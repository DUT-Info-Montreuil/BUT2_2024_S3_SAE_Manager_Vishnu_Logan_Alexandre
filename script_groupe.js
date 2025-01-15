document.addEventListener('DOMContentLoaded', () => {
    const dropdownBtn = document.querySelector('.dropdown-btn');
    const dropdownContent = document.querySelector('.dropdown-content');

    dropdownBtn.addEventListener('click', () => {
        dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
    });


    document.addEventListener('click', (event) => {
        if (!dropdownBtn.contains(event.target) && !dropdownContent.contains(event.target)) {
            dropdownContent.style.display = 'none';
        }
    });
});

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