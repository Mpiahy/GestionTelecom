{{-- ENR --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialisation des éléments du formulaire
        const enrBoxType = document.getElementById('enr_box_type');
        const enrBoxMarque = document.getElementById('enr_box_marque');
        const newMarqueInput = document.getElementById('new_box_marque');
        const enrBoxModele = document.getElementById('enr_box_modele');
        const newModeleInput = document.getElementById('new_box_modele');
        const enrBoxEnroll = document.getElementById('enr_box_enroll');
        const enrBoxEnrollDiv = enrBoxEnroll.closest('.mb-3'); // Conteneur du champ "Enrôlé"

        // Affiche ou masque le champ "Nouvelle Marque"
        function toggleNewMarqueInput() {
            if (enrBoxMarque.value === 'new_marque') {
                newMarqueInput.classList.remove('d-none');
                populateNewModeleOption(); // Ajoute automatiquement "Ajouter un nouveau modèle"
            } else {
                newMarqueInput.classList.add('d-none');
                newMarqueInput.value = ''; // Réinitialise le champ
            }
        }

        // Affiche ou masque le champ "Nouveau Modèle"
        function toggleNewModeleInput() {
            if (enrBoxModele.value === 'new') {
                newModeleInput.classList.remove('d-none');
            } else {
                newModeleInput.classList.add('d-none');
                newModeleInput.value = ''; // Réinitialise le champ
            }
        }

        // Affiche ou masque le champ "Enrôlé" en fonction du type d'équipement
        function toggleBoxEnroll() {
            if (enrBoxType.value === '2') { // Télébox à touche
                enrBoxEnrollDiv.classList.add('d-none');
                enrBoxEnroll.value = '2'; // Définit la valeur par défaut à "Non"
            } else {
                enrBoxEnrollDiv.classList.remove('d-none');
                enrBoxEnroll.value = '0'; // Réinitialise la valeur par défaut
            }
        }

        // Réinitialise un champ <select> avec une option par défaut
        function resetSelect(selectElement, defaultOptionText) {
            selectElement.innerHTML = `<option value="0" disabled selected>${defaultOptionText}</option>`;
        }

        // Remplit un champ <select> avec des options dynamiques, en conservant l'option "new" ou "new_marque"
        function populateSelect(selectElement, items, newItemValue, newItemText) {
            if (newItemValue && newItemText) {
                selectElement.insertAdjacentHTML('beforeend', `<option value="${newItemValue}">${newItemText}</option>`);
            }
            items.forEach(item => {
                selectElement.insertAdjacentHTML('beforeend', `<option value="${item.id}">${item.name}</option>`);
            });
        }

        // Ajoute l'option "Ajouter un nouveau modèle" et la sélectionne automatiquement
        function populateNewModeleOption() {
            resetSelect(enrBoxModele, 'Choisir le modèle');
            enrBoxModele.insertAdjacentHTML('beforeend', `<option value="new">Ajouter un nouveau modèle</option>`);
            enrBoxModele.value = 'new';
            toggleNewModeleInput(); // Affiche le champ "Nouveau Modèle"
        }

        // Gère les changements de type d'équipement
        enrBoxType.addEventListener('change', function () {
            const typeId = this.value;
            resetSelect(enrBoxMarque, 'Choisir la marque');
            resetSelect(enrBoxModele, 'Choisir le modèle');
            toggleBoxEnroll();

            if (typeId) {
                fetch(`/get-marques-by-type/${typeId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            populateSelect(enrBoxMarque, data.marques, 'new_marque', 'Ajouter une nouvelle marque');
                        }
                    })
                    .catch(error => console.error('Erreur lors de la récupération des marques :', error));
            }
        });

        // Gère les changements de marque
        enrBoxMarque.addEventListener('change', function () {
            const marqueId = this.value;
            resetSelect(enrBoxModele, 'Choisir le modèle');
            toggleNewMarqueInput();

            if (marqueId && marqueId !== 'new_marque') {
                fetch(`/get-modeles-by-marque/${marqueId}`)
                    .then(response => response.json())
                    .then(data => {
                        populateSelect(enrBoxModele, data.modeles, 'new', 'Ajouter un nouveau modèle');
                    })
                    .catch(error => console.error('Erreur lors de la récupération des modèles :', error));
            }
        });

        // Gère les changements de modèle
        enrBoxModele.addEventListener('change', function () {
            toggleNewModeleInput();
        });

        // Gère l'affichage initial (au cas où des champs seraient pré-sélectionnés)
        toggleNewMarqueInput();
        toggleNewModeleInput();
        toggleBoxEnroll();

        // Affiche le modal en cas d'erreurs de validation
        @if ($errors->hasBag('enr_box_errors'))
            var modalEnrBox = new bootstrap.Modal(document.getElementById('modal_enr_box'));
            modalEnrBox.show();
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
                const id = this.getAttribute('data-id');
                form.action = `/boxs/${id}`;

                // Gère l'affichage du champ "Enrôlé"
                toggleBoxEnroll(this.getAttribute('data-type'), this.getAttribute('data-enroll'));
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
            { id: 'edt_box_enroll', data: 'data-enroll' },
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
     * Gère l'affichage du champ "Enrôlé" selon le type d'équipement.
     * @param {string} typeId - Type d'équipement.
     * @param {string} enrollValue - Valeur "Enrôlé".
     */
    function toggleBoxEnroll(typeId, enrollValue) {
        const edtboxEnroll = document.getElementById('edt_box_enroll');
        const edtboxEnrollDiv = edtboxEnroll.closest('.mb-3');

        if (typeId === '2') {
            edtboxEnrollDiv.classList.add('d-none');
            edtboxEnroll.value = '2';
        } else {
            edtboxEnrollDiv.classList.remove('d-none');
            edtboxEnroll.value = enrollValue || '0';
        }
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