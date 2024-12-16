{{-- FILTRE --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Gestionnaire unique pour les boutons de filtre (Délégation d'événement)
        const btnGroup = document.querySelector(".btn-group");
        const rows = document.querySelectorAll(".utilisateur-row");

        if (btnGroup) {
            btnGroup.addEventListener("click", function (event) {
                const button = event.target;
                if (button.classList.contains("btn")) {
                    // Supprimer l'état actif de tous les boutons
                    document.querySelectorAll(".btn-group .btn").forEach(btn => btn.classList.remove("active"));

                    // Ajouter l'état actif au bouton cliqué
                    button.classList.add("active");

                    // Récupérer le texte du bouton (filtre)
                    const filter = button.textContent.toLowerCase();

                    // Filtrer les lignes du tableau
                    rows.forEach(row => {
                        row.style.display =
                            (filter === "tout" || row.classList.contains(filter)) ? "" : "none";
                    });
                }
            });
        }
    });
</script>

{{-- MODIFIER --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Attacher un gestionnaire d'événement au clic sur les liens contenant les attributs data-*
        document.querySelectorAll('a[data-id-edt]').forEach(link => {
            link.addEventListener('click', function (e) {
                // Récupérer les valeurs des attributs data-* du lien cliqué
                const idEdt = this.getAttribute('data-id-edt');
                const matricule = this.getAttribute('data-edt-matricule');
                const nom = this.getAttribute('data-edt-nom');
                const prenom = this.getAttribute('data-edt-prenom');
                const login = this.getAttribute('data-edt-login');
                const type = this.getAttribute('data-edt-type');
                const fonction = this.getAttribute('data-edt-fonction');
                const chantier = this.getAttribute('data-edt-chantier');

                // Remplir les champs du formulaire avec les données récupérées
                document.getElementById('edt_emp_id').value = idEdt;
                document.getElementById('edt_emp_matricule').value = matricule;
                document.getElementById('edt_emp_nom').value = nom;
                document.getElementById('edt_emp_prenom').value = prenom;
                document.getElementById('edt_emp_login').value = login;
                document.getElementById('edt_emp_type').value = type;
                document.getElementById('fonction-select').value = fonction;
                document.getElementById('chantier-select').value = chantier;
            });
        });

        // Afficher le modal d'édition s'il y a des erreurs
        @if (session('modal_with_error') === 'modal_edit_emp')
            const editModal = new bootstrap.Modal(document.getElementById("modal_edit_emp"), { backdrop: "static" });
            editModal.show();
        @endif
    });
</script>

{{-- SUPPRIMER --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll(".open-delete-modal");

        deleteButtons.forEach(button => {
            button.addEventListener("click", function () {
                // Récupérer les données utilisateur
                const id = this.getAttribute("data-id");
                const name = this.getAttribute("data-name");
                const matricule = this.getAttribute("data-matricule");
                const login = this.getAttribute("data-login");
                const type = this.getAttribute("data-type");
                const fonction = this.getAttribute("data-fonction");
                const chantier = this.getAttribute("data-chantier");

                // Mettre à jour les champs de la modale
                const modal = {
                    id: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_id"),
                    nom: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_nom"),
                    matricule: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_matricule"),
                    login: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_login"),
                    type: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_type"),
                    fonction: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_fonction"),
                    chantier: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_chantier"),
                    confirmButton: document.querySelector("#supprimer_utilisateur .modal-footer #confirm_delete_utilisateur"),
                };

                if (modal.id) modal.id.textContent = id;
                if (modal.nom) modal.nom.textContent = name;
                if (modal.matricule) modal.matricule.textContent = matricule;
                if (modal.login) modal.login.textContent = login;
                if (modal.type) modal.type.textContent = type;
                if (modal.fonction) modal.fonction.textContent = fonction;
                if (modal.chantier) modal.chantier.textContent = chantier;

                // Mettre à jour l'URL du bouton "Supprimer"
                if (modal.confirmButton) modal.confirmButton.href = `/utilisateur/supprimer/${id}`;
            });
        });
    });
</script>

{{-- AJOUTER --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Afficher le modal d'ajout s'il y a des erreurs
        @if (session('modal_with_error') === 'modal_add_emp')
            const addModal = new bootstrap.Modal(document.getElementById("modal_add_emp"), { backdrop: "static" });
            addModal.show();
        @endif

        // Afficher/masquer le champ "Nouvelle Fonction"
        const fonctionSelectAdd = document.getElementById("fonction-select-add");
        const newFonctionInput = document.getElementById("new-fonction-input");

        if (fonctionSelectAdd && newFonctionInput) {
            fonctionSelectAdd.addEventListener("change", function () {
                newFonctionInput.style.display = this.value === "new" ? "block" : "none";
            });
        }

        // Initialisation des filtres dynamiques pour les champs
        setupDynamicSearch("search-fonction-add", "fonction-select-add");
        setupDynamicSearch("search-chantier", "chantier-select");

        // Validation avant soumission du formulaire
        const form = document.querySelector("#modal_add_emp form");
        const newFonctionField = document.querySelector("input[name='new_fonction']");

        if (form && fonctionSelectAdd && newFonctionField) {
            form.addEventListener("submit", function (e) {
                if (fonctionSelectAdd.value === "new" && !newFonctionField.value.trim()) {
                    e.preventDefault();
                    alert("Veuillez entrer une nouvelle fonction avant de soumettre le formulaire.");
                    newFonctionField.focus();
                }
            });
        }
    });
</script>

{{-- RESET --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const closeModalAdd = document.getElementById('close-modal-add');
        const form = document.getElementById('add_emp'); // Formulaire à réinitialiser

        closeModalAdd.addEventListener('click', function () {
            // 1. Réinitialiser le formulaire (vide les champs)
            form.reset();

            // 2. Supprimer les classes d'erreur (Bootstrap) et vider les messages d'erreur
            form.querySelectorAll('.is-invalid').forEach(function (element) {
                element.classList.remove('is-invalid'); // Retirer la classe Bootstrap d'erreur
            });

            form.querySelectorAll('.invalid-feedback').forEach(function (element) {
                element.innerHTML = ''; // Vider les messages d'erreur
            });

            // 3. Vider les champs de recherche dynamiques si nécessaire (ex: select2 ou filtres)
            form.querySelectorAll('input[type="text"]').forEach(function (input) {
                input.value = ''; // Réinitialiser les champs texte
            });

            // 4. Réinitialiser les selects à leur option par défaut
            form.querySelectorAll('select').forEach(function (select) {
                select.value = ''; // Réinitialiser les selects
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const closeModalEdit = document.getElementById('close-modal-edit');
        const form = document.getElementById('edit_emp'); // Formulaire à réinitialiser

        closeModalEdit.addEventListener('click', function () {
            // 1. Réinitialiser le formulaire (vide les champs)
            form.reset();

            // 2. Supprimer les classes d'erreur (Bootstrap) et vider les messages d'erreur
            form.querySelectorAll('.is-invalid').forEach(function (element) {
                element.classList.remove('is-invalid'); // Retirer la classe Bootstrap d'erreur
            });

            form.querySelectorAll('.invalid-feedback').forEach(function (element) {
                element.innerHTML = ''; // Vider les messages d'erreur
            });

            // 3. Vider les champs de recherche dynamiques si nécessaire (ex: select2 ou filtres)
            form.querySelectorAll('input[type="text"]').forEach(function (input) {
                input.value = ''; // Réinitialiser les champs texte
            });

            // 4. Réinitialiser les selects à leur option par défaut
            form.querySelectorAll('select').forEach(function (select) {
                select.value = ''; // Réinitialiser les selects
            });
        });
    });
</script>

{{-- RECHERCHE DYNAMIQUE DANS FORMS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Recherche des fonctions
    configureSearchField(
        'search-fonction',       // ID du champ de recherche
        'fonction-select',       // ID du <select> à mettre à jour
        'selected_fonction_hidden', // ID du champ caché
        '/ligne/searchFonction'  // URL pour récupérer les données
    );

    configureSearchField(
        'search-fonction-add',   // Pour le formulaire "AJOUTER"
        'fonction-select-add',
        'selected_fonction_add_hidden',
        '/ligne/searchFonction'
    );

    // Recherche des chantiers
    configureSearchField(
        'search-chantier',
        'chantier-select',
        'selected_chantier_hidden',
        '/ligne/searchChantier'
    );

    configureSearchField(
        'search-chantier-add',
        'chantier-select-add',
        'selected_chantier_add_hidden',
        '/ligne/searchChantier'
    );
});

/**
 * Fonction générique pour gérer un champ de recherche et son <select>.
 */
function configureSearchField(searchInputId, selectId, hiddenInputId, searchUrl) {
    const searchInput = document.getElementById(searchInputId);
    const select = document.getElementById(selectId);
    const hiddenInput = document.getElementById(hiddenInputId);
    const spinner = document.createElement('div');
    spinner.innerHTML = '<small>Recherche en cours...</small>';
    spinner.style.display = 'none';
    searchInput.parentElement.appendChild(spinner);

    let timeout = null;

    searchInput.addEventListener('input', function () {
        clearTimeout(timeout);
        const query = searchInput.value.trim();

        if (query.length >= 2) {
            spinner.style.display = 'block';

            timeout = setTimeout(() => {
                fetch(`${searchUrl}?query=${query}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur lors de la récupération des données.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        spinner.style.display = 'none';
                        select.innerHTML = '<option value="0" disabled>Choisir une option</option>';

                        if (data.length > 0) {
                            data.forEach((item, index) => {
                                const option = document.createElement('option');
                                option.value = item.id;
                                option.textContent = item.label; // "label" représente un nom générique
                                select.appendChild(option);

                                // Sélectionner le premier résultat et mettre à jour le champ caché
                                if (index === 0) {
                                    option.selected = true;
                                    hiddenInput.value = item.id; // Mettre à jour le champ caché
                                }
                            });
                        } else {
                            const noResultOption = document.createElement('option');
                            noResultOption.value = "0";
                            noResultOption.textContent = "Aucun résultat trouvé";
                            select.appendChild(noResultOption);

                            hiddenInput.value = ""; // Réinitialiser le champ caché
                        }
                    })
                    .catch(error => {
                        spinner.style.display = 'none';
                        console.error('Erreur lors de la recherche :', error);
                        select.innerHTML = '<option value="0" disabled>Erreur lors du chargement</option>';
                        hiddenInput.value = ""; // Réinitialiser le champ caché
                    });
            }, 300);
        } else {
            spinner.style.display = 'none';
            select.innerHTML = '<option value="0" disabled>Choisir une option</option>';
            hiddenInput.value = ""; // Réinitialiser le champ caché
        }
    });

    // Synchroniser le champ caché avec le champ <select> lorsqu'une option est sélectionnée
    select.addEventListener('change', function () {
        hiddenInput.value = select.value;
    });
}

</script>