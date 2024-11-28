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
        // Gestion des boutons "Modifier"
        const editButtons = document.querySelectorAll(".edit-user-btn");

        editButtons.forEach(button => {
            button.addEventListener("click", function () {
                // Récupérer les données utilisateur
                const userId = this.getAttribute("data-id");
                const userNom = this.getAttribute("data-nom");
                const userPrenom = this.getAttribute("data-prenom");
                const userLogin = this.getAttribute("data-login");
                const userType = this.getAttribute("data-type");
                const userFonction = this.getAttribute("data-fonction");
                const userChantier = this.getAttribute("data-chantier");

                // Vérifier que les champs existent avant de les modifier
                const fields = {
                    matricule: document.querySelector("#edt_emp_matricule"),
                    nom: document.querySelector("#edt_emp_nom"),
                    prenom: document.querySelector("#edt_emp_prenom"),
                    login: document.querySelector("#edt_emp_login"),
                    type: document.querySelector("#edt_emp_type"),
                    fonction: document.querySelector("#fonction-select"),
                    chantier: document.querySelector("#chantier-select"),
                };

                if (fields.matricule) fields.matricule.value = userId;
                if (fields.nom) fields.nom.value = userNom;
                if (fields.prenom) fields.prenom.value = userPrenom;
                if (fields.login) fields.login.value = userLogin;
                if (fields.type) fields.type.value = userType;
                if (fields.fonction) fields.fonction.value = userFonction;
                if (fields.chantier) fields.chantier.value = userChantier;
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
                const login = this.getAttribute("data-login");
                const type = this.getAttribute("data-type");
                const fonction = this.getAttribute("data-fonction");
                const chantier = this.getAttribute("data-chantier");

                // Mettre à jour les champs de la modale
                const modal = {
                    nom: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_nom"),
                    id: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_id"),
                    login: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_login"),
                    type: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_type"),
                    fonction: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_fonction"),
                    chantier: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_chantier"),
                    confirmButton: document.querySelector("#supprimer_utilisateur .modal-footer #confirm_delete_utilisateur"),
                };

                if (modal.nom) modal.nom.textContent = name;
                if (modal.id) modal.id.textContent = id;
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
