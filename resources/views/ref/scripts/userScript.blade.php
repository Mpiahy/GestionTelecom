@extends('base/baseRef')

@section('script_ref')

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Sélectionnez tous les boutons de filtre
        const buttons = document.querySelectorAll(".btn-group .btn");

        // Ajoutez un gestionnaire d'événements "click" à chaque bouton
        buttons.forEach(button => {
            button.addEventListener("click", function () {
                // Supprime la classe active de tous les boutons
                buttons.forEach(btn => btn.classList.remove("active"));
                // Ajoute la classe active au bouton cliqué
                this.classList.add("active");

                // Récupérez le texte du bouton cliqué
                const filter = this.textContent.toLowerCase();

                // Sélectionnez toutes les lignes du tableau
                const rows = document.querySelectorAll(".utilisateur-row");

                // Montrez/Cachez les lignes en fonction du filtre
                rows.forEach(row => {
                    if (filter === "tout") {
                        // Affiche toutes les lignes
                        row.style.display = "";
                    } else if (row.classList.contains(filter)) {
                        // Affiche les lignes correspondant au filtre
                        row.style.display = "";
                    } else {
                        // Cache les autres lignes
                        row.style.display = "none";
                    }
                });
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sélectionnez tous les boutons "Modifier"
        const editButtons = document.querySelectorAll('.edit-user-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Récupérez les données de l'utilisateur à partir des attributs data-*
                const userId = this.getAttribute('data-id');
                const userNom = this.getAttribute('data-nom');
                const userPrenom = this.getAttribute('data-prenom');
                const userLogin = this.getAttribute('data-login');
                const userType = this.getAttribute('data-type');
                const userFonction = this.getAttribute('data-fonction');
                const userChantier = this.getAttribute('data-chantier');

                // Remplissez les champs du modal
                document.querySelector('#edt_emp_matricule').value = userId;
                document.querySelector('#edt_emp_nom').value = userNom;
                document.querySelector('#edt_emp_prenom').value = userPrenom;
                document.querySelector('#edt_emp_login').value = userLogin;
                document.querySelector('#edt_emp_type').value = userType;
                document.querySelector('#fonction-select').value = userFonction;
                document.querySelector('#chantier-select').value = userChantier;
            });
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ciblez tous les boutons de suppression
        document.querySelectorAll('.open-delete-modal').forEach(button => {
            button.addEventListener('click', function() {
                // Récupérez les données de l'utilisateur depuis les attributs data-*
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const login = this.getAttribute('data-login');
                const type = this.getAttribute('data-type');
                const fonction = this.getAttribute('data-fonction');
                const chantier = this.getAttribute('data-chantier');
                
                // Mettre à jour le texte dans la modale
                document.querySelector('#supprimer_utilisateur .modal-body #utilisateur_nom').textContent = name;
                document.querySelector('#supprimer_utilisateur .modal-body #utilisateur_id').textContent = id;
                document.querySelector('#supprimer_utilisateur .modal-body #utilisateur_login').textContent = login;
                document.querySelector('#supprimer_utilisateur .modal-body #utilisateur_type').textContent = type;
                document.querySelector('#supprimer_utilisateur .modal-body #utilisateur_fonction').textContent = fonction;
                document.querySelector('#supprimer_utilisateur .modal-body #utilisateur_chantier').textContent = chantier;

                // Configurer le bouton "Supprimer" avec l'URL correspondante
                const deleteButton = document.querySelector('#supprimer_utilisateur .modal-footer #confirm_delete_utilisateur');
                deleteButton.href = `/utilisateur/supprimer/${id}`;
            });
        });
    });
</script>


<script>
    // Ouvrir le modal automatiquement si des erreurs existent
    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->any())
            const modal = new bootstrap.Modal(document.getElementById('modal_add_emp'), { backdrop: 'static' });
            modal.show();
        @endif
    });

    // Afficher le champ "Nouvelle Fonction" si sélectionné
    document.getElementById('fonction-select').addEventListener('change', function () {
        const newFonctionInput = document.getElementById('new-fonction-input');
        if (this.value === 'new') {
            newFonctionInput.style.display = 'block';
        } else {
            newFonctionInput.style.display = 'none';
        }
    });

    // Filtre dynamique pour le champ Fonction
    document.getElementById('search-fonction').addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();
        const options = document.getElementById('fonction-select').options;

        for (let option of options) {
            option.style.display = option.textContent.toLowerCase().includes(searchValue) ? 'block' : 'none';
        }
    });

    // Filtre dynamique pour le champ Chantier
    document.getElementById('search-chantier').addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();
        const options = document.getElementById('chantier-select').options;

        for (let option of options) {
            option.style.display = option.textContent.toLowerCase().includes(searchValue) ? 'block' : 'none';
        }
    });
</script>

@endsection