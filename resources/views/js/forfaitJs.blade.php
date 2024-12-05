<script>
    document.addEventListener('DOMContentLoaded', function () {
        setupEditElementButtonListeners();
        reopenModalOnValidationError();
    });

    /**
     * Initialise les événements pour les boutons "Modifier" des éléments du forfait.
     */
    function setupEditElementButtonListeners() {
        const editButtons = document.querySelectorAll('[data-bs-target="#modifier_element"]');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = document.getElementById('edt_element_form');

                // Injecter les données dans le formulaire
                injectElementDataIntoForm(form, this);

                // Mettre à jour l'action du formulaire
                const idElement = this.getAttribute('data-id_element');
                const idForfait = this.getAttribute('data-id_forfait');
                form.action = `/forfaits/update-element/${idForfait}/${idElement}`;
            });
        });
    }

    /**
     * Injecte les données dynamiques dans le formulaire d'édition d'élément.
     * @param {HTMLElement} form - Le formulaire cible.
     * @param {HTMLElement} button - Le bouton contenant les données.
     */
    function injectElementDataIntoForm(form, button) {
        const fields = [
            { id: 'edt_element', data: 'data-libelle' },
            { id: 'edt_unite', data: 'data-unite' },
            { id: 'edt_qu', data: 'data-quantite' },
            { id: 'edt_id_forfait', data: 'data-id_forfait' },
            { id: 'edt_id_element', data: 'data-id_element' }
        ];

        fields.forEach(field => {
            const element = document.getElementById(field.id);
            if (element) {
                element.value = button.getAttribute(field.data);
            }
        });

        // Nettoyer et formater le prix unitaire avant de l'injecter
        const prixUnitaire = button.getAttribute('data-prix_unitaire')
            .replace(/\s/g, '') // Supprimer les espaces
            .replace(',', '.'); // Remplacer la virgule par un point

        document.getElementById('edt_pu').value = parseFloat(prixUnitaire) || 0;
    }

    /**
     * Rouvre le modal en cas d'erreur de validation.
     */
    function reopenModalOnValidationError() {
        @if ($errors->hasBag('edt_element_errors'))
            const modalEdtElement = new bootstrap.Modal(document.getElementById('modifier_element'));
            modalEdtElement.show();
        @endif
    }
</script>
