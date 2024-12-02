{{-- ENR --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialisation des éléments du formulaire pour les Box
        const enrBoxMarque = document.getElementById('enr_box_marque');
        const newMarqueInput = document.getElementById('new_box_marque');
        const enrBoxModele = document.getElementById('enr_box_modele');
        const newModeleInput = document.getElementById('new_box_modele');

        // Affiche ou masque le champ "Nouvelle Marque" et sélectionne automatiquement "Ajouter un nouveau modèle"
        function toggleNewMarqueInput() {
            if (enrBoxMarque.value === 'new') { // Vérifie si l'utilisateur a sélectionné "Ajouter une nouvelle marque"
                newMarqueInput.classList.remove('d-none'); // Affiche le champ "Nouvelle Marque"
                populateNewModeleOption(); // Ajoute automatiquement "Ajouter un nouveau modèle"
            } else {
                newMarqueInput.classList.add('d-none');
                newMarqueInput.value = ''; // Réinitialise le champ "Nouvelle Marque"
            }
        }

        // Affiche ou masque le champ "Nouveau Modèle"
        function toggleNewModeleInput() {
            if (enrBoxModele.value === 'new') { // Vérifie si l'utilisateur a sélectionné "Ajouter un nouveau modèle"
                newModeleInput.classList.remove('d-none'); // Affiche le champ "Nouveau Modèle"
            } else {
                newModeleInput.classList.add('d-none');
                newModeleInput.value = ''; // Réinitialise le champ s'il est masqué
            }
        }

        // Réinitialise un champ <select> avec une option par défaut
        function resetSelect(selectElement, defaultOptionText) {
            selectElement.innerHTML = `<option value="0" disabled selected>${defaultOptionText}</option>`;
        }

        // Remplit un champ <select> avec des options dynamiques, tout en gardant l'option "new"
        function populateSelect(selectElement, items, newItemValue, newItemText) {
            if (newItemValue && newItemText) {
                selectElement.insertAdjacentHTML('beforeend', `<option value="${newItemValue}">${newItemText}</option>`);
            }
            items.forEach(item => {
                selectElement.insertAdjacentHTML('beforeend', `<option value="${item.id}">${item.name}</option>`);
            });
        }

        // Ajoute et sélectionne automatiquement l'option "Ajouter un nouveau modèle"
        function populateNewModeleOption() {
            resetSelect(enrBoxModele, 'Choisir le modèle');
            enrBoxModele.insertAdjacentHTML('beforeend', `<option value="new" selected>Ajouter un nouveau modèle</option>`);
            toggleNewModeleInput(); // Affiche le champ "Nouveau Modèle"
        }

        // Gère les changements de marque
        enrBoxMarque.addEventListener('change', function () {
            const marqueId = this.value;
            resetSelect(enrBoxModele, 'Choisir le modèle');
            toggleNewMarqueInput(); // Affiche ou masque le champ "Nouvelle Marque"

            if (marqueId && marqueId !== 'new') { // Si une marque existante est sélectionnée
                fetch(`/get-modeles-by-marque/${marqueId}`)
                    .then(response => response.json())
                    .then(data => {
                        populateSelect(enrBoxModele, data.modeles, 'new', 'Ajouter un nouveau modèle');
                        toggleNewModeleInput(); // Vérifie s'il faut afficher le champ "Nouveau Modèle"
                    })
                    .catch(error => console.error('Erreur lors de la récupération des modèles :', error));
            }
        });

        // Gère les changements de modèle
        enrBoxModele.addEventListener('change', function () {
            toggleNewModeleInput(); // Affiche ou masque le champ "Nouveau Modèle"
        });

        // Gestion initiale lors du chargement de la page
        toggleNewMarqueInput(); // Gère le champ "Nouvelle Marque" au chargement
        toggleNewModeleInput(); // Gère le champ "Nouveau Modèle" au chargement

        // Affiche le modal en cas d'erreurs de validation
        @if ($errors->hasBag('enr_box_errors'))
            const modalEnrBox = new bootstrap.Modal(document.getElementById('modal_enr_box'));
            modalEnrBox.show();
        @endif
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->hasBag('enr_box_errors'))
            setTimeout(function () {
                const modalEnrBox = new bootstrap.Modal(document.getElementById('modal_enr_box'));
                modalEnrBox.show();
            }, 500); // Petit délai pour s'assurer que le DOM est prêt
        @endif
    });
</script>


{{-- EDIT --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        setupEditButtonListeners();
        reopenModalOnValidationError();
    });

    /**
     * Initialise les événements pour les boutons "Éditer".
     */
    function setupEditButtonListeners() {
        const editButtons = document.querySelectorAll('[data-bs-target="#modal_edt_box"]');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = document.getElementById('form_edt_box');

                // Injecte les données dynamiques dans le formulaire
                injectDataIntoForm(form, this);

                // Met à jour l'action du formulaire
                const id_box = this.getAttribute('data-id');
                form.action = `/box/${id_box}`;
            });
        });
    }

    /**
     * Injecte les données dynamiques dans le formulaire d'édition.
     * @param {HTMLElement} form - Le formulaire cible.
     * @param {HTMLElement} button - Le bouton contenant les données.
     */
    function injectDataIntoForm(form, button) {
        const fields = [
            { id: 'edt_box_id', data: 'data-id' },
            { id: 'edt_box_type', data: 'data-type' },
            { id: 'edt_box_marque', data: 'data-marque' },
            { id: 'edt_box_modele', data: 'data-modele' },
            { id: 'edt_box_imei', data: 'data-imei' },
            { id: 'edt_box_sn', data: 'data-sn' },
        ];

        fields.forEach(field => {
            const element = document.getElementById(field.id);
            if (element) {
                element.value = button.getAttribute(field.data);
            }
        });

        syncDisabledFieldsWithHiddenInputs(button);
    }

    /**
     * Synchronise les champs désactivés avec leurs champs cachés correspondants.
     * @param {HTMLElement} button - Bouton contenant les données.
     */
    function syncDisabledFieldsWithHiddenInputs(button) {
        const hiddenFields = [
            { hiddenId: 'hidden_box_type', data: 'data-type' },
            { hiddenId: 'hidden_box_marque', data: 'data-marque' },
            { hiddenId: 'hidden_box_modele', data: 'data-modele' },
        ];

        hiddenFields.forEach(field => {
            const hiddenElement = document.getElementById(field.hiddenId);
            if (hiddenElement) {
                hiddenElement.value = button.getAttribute(field.data);
            }
        });
    }

    /**
     * Rouvre le modal en cas d'erreur de validation.
     */
    function reopenModalOnValidationError() {
        @if ($errors->hasBag('edt_box_errors'))
            const modalEdtbox = new bootstrap.Modal(document.getElementById('modal_edt_box'));
            modalEdtbox.show();
        @endif
    }
</script>


{{-- HS --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openHSModalButtons = document.querySelectorAll('.open-hs-modal');

        openHSModalButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Empêche l'action par défaut

                // Récupère les données dynamiques
                const boxId = this.dataset.boxId;
                const boxName = this.dataset.boxName;
                const boxSN = this.dataset.boxSn;

                // Injecte les données dans le formulaire
                document.getElementById('hs_box_id').value = boxId;
                document.getElementById('hs_box').value = boxName;
                document.getElementById('sn_box').value = boxSN;

                // Affiche le modal
                const modalHSbox = new bootstrap.Modal(document.getElementById('modal_hs_box'));
                modalHSbox.show();
            });
        });
    });
</script>