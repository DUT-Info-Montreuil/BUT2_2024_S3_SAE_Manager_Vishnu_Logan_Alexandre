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

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('ajouterEleveBtn').addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('.etudiant-checkbox:checked');
        const listePrevisu = document.getElementById('listePrevisu');
        const formGroupe = document.getElementById('formGroupe');

        if (checkboxes.length === 0) {
            listePrevisu.innerHTML = "<p style='color:red;'>Aucun étudiant sélectionné.</p>";
            return;
        }

        listePrevisu.innerHTML = '';
        document.querySelectorAll('input[name="etudiants[]"]').forEach(input => input.remove());

        checkboxes.forEach(function (checkbox) {
            const nom = checkbox.dataset.nom;
            const prenom = checkbox.dataset.prenom;
            const id = checkbox.value;

            const p = document.createElement('p');
            p.className = 'eleve';
            p.textContent = `${nom} ${prenom} (ID: ${id})`;
            listePrevisu.appendChild(p);

            const inputHidden = document.createElement('input');
            inputHidden.type = 'hidden';
            inputHidden.name = 'etudiants[]';
            inputHidden.value = id;
            formGroupe.appendChild(inputHidden);
        });

    });
});

document.querySelector('.custom-dropdown .dropdown-btn').addEventListener('click', function() {
    const dropdown = this.closest('.custom-dropdown');
    dropdown.classList.toggle('open');
});




