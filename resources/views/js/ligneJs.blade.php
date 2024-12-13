{{-- ACTIVATION LIGNE --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Gestion des liens mailto statiques dans le HTML
        const mailtoLinks = document.querySelectorAll('.mailto-link');

        mailtoLinks.forEach(link => {
            // Récupération des attributs personnalisés (email et numéro SIM)
            const email = link.dataset.email;
            const numSim = link.dataset.numSim;

            // Définition du sujet et du corps du mail avec encodage URI
            const subject = encodeURIComponent("Demande d'activation d'une ligne");
            const body = encodeURIComponent(
                `Bonjour,

                Merci d'activer une ligne sur la SIM : ${numSim}.

                Merci de bien vouloir traiter cette demande dans les meilleurs délais.

                Cordialement,`
            );

            // Générer et assigner le lien `mailto` dynamique
            link.href = `mailto:${email}?subject=${subject}&body=${body}`;
        });

        // Gestion du formulaire pour générer un lien mailto dynamique
        const form = document.getElementById('form_act_mobile');

        if (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Empêche l'envoi normal du formulaire

                // Récupère les données du formulaire
                const sim = document.getElementById('act_sim').value;

                const operateurSelect = document.getElementById('act_operateur');
                const typeSelect = document.getElementById('act_type');
                const forfaitSelect = document.getElementById('act_forfait');

                // Récupération des valeurs et validation des champs
                const operateur = operateurSelect.options[operateurSelect.selectedIndex]?.text || '';
                const email = operateurSelect.options[operateurSelect.selectedIndex]?.dataset.email || '';
                const type = typeSelect.options[typeSelect.selectedIndex]?.text || '';
                const forfait = forfaitSelect.options[forfaitSelect.selectedIndex]?.text || '';

                // Vérifie si un e-mail est défini pour l'opérateur sélectionné
                if (!email) {
                    alert('Veuillez sélectionner un opérateur avec une adresse e-mail valide.');
                    return;
                }

                // Préparation du lien mailto avec les données encodées
                const subject = encodeURIComponent("Demande d'activation d'une ligne");
                const body = encodeURIComponent(
                    `Bonjour,

                    Merci d'activer une ligne sur la SIM : ${sim}.

                    Forfait : ${forfait}

                    Merci de bien vouloir traiter cette demande dans les meilleurs délais.

                    Cordialement,`
                );

                const mailtoLink = `mailto:${email}?subject=${subject}&body=${body}`;

                // Ouvre le client de messagerie par défaut avec le lien généré
                window.location.href = mailtoLink;

                // Optionnel : soumettre le formulaire après avoir ouvert le client de messagerie
                form.submit();
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const operateurSelect = document.getElementById('act_operateur');
        const typeSelect = document.getElementById('act_type');
        const forfaitSelect = document.getElementById('act_forfait');
        const simInput = document.getElementById('act_sim');
        const demanderButton = document.getElementById('btn_demander');

        // Fonction pour filtrer les forfaits en fonction de l'opérateur et du type sélectionnés
        function filterForfaits() {
            const selectedOperateur = operateurSelect.value;
            const selectedType = typeSelect.value;

            let hasVisibleForfaits = false;

            // Parcourt les options de forfaits et applique un filtrage conditionnel
            Array.from(forfaitSelect.options).forEach(option => {
                const operateurId = option.getAttribute('data-id-operateur');
                const typeForfaitId = option.getAttribute('data-id-type-forfait');
                const isVisible =
                    (operateurId === selectedOperateur || !selectedOperateur) &&
                    (typeForfaitId === selectedType || !selectedType);

                // Affiche ou masque l'option selon le filtre
                option.style.display = isVisible ? '' : 'none';
                if (isVisible) hasVisibleForfaits = true;
            });

            // Active ou désactive le menu déroulant selon les options disponibles
            forfaitSelect.disabled = !hasVisibleForfaits;
            if (!hasVisibleForfaits) forfaitSelect.value = '';
        }

        // Active ou désactive le bouton "Demander" selon la validité du formulaire
        function toggleDemanderButton() {
            const isFormComplete =
                simInput.value.trim() &&
                operateurSelect.value &&
                typeSelect.value &&
                forfaitSelect.value &&
                !forfaitSelect.disabled;

            demanderButton.disabled = !isFormComplete;
        }

        // Gère les changements d'entrée utilisateur pour filtrer et valider les données
        function handleInputChange() {
            filterForfaits();
            toggleDemanderButton();
        }

        // Ajoute les écouteurs sur les sélecteurs et les champs d'entrée
        [operateurSelect, typeSelect].forEach(el =>
            el.addEventListener('change', handleInputChange)
        );
        forfaitSelect.addEventListener('change', toggleDemanderButton);
        simInput.addEventListener('input', toggleDemanderButton);

        // Initialise l'état des forfaits et du bouton au chargement de la page
        filterForfaits();
        toggleDemanderButton();
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Vérifie si des erreurs sont présentes dans `act_ligne_errors` (backend Laravel)
        @if ($errors->hasBag('act_ligne_errors') && $errors->act_ligne_errors->any())
            const modalActLigne = new bootstrap.Modal(document.getElementById('modal_act_ligne'));
            modalActLigne.show(); // Affiche automatiquement le modal pour corriger les erreurs
        @endif
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Sélectionne tous les boutons pour fermer le modal
        const closeModalButtons = document.querySelectorAll('#close_modal_act');

        closeModalButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Sélectionne le formulaire dans le modal
                const form = document.getElementById('form_act_ligne');

                if (form) {
                    // Réinitialise les champs du formulaire
                    form.reset();

                    // Réinitialise manuellement les sélecteurs si nécessaire
                    const selects = form.querySelectorAll('select');
                    selects.forEach(select => {
                        select.value = ''; // Réinitialise le champ
                        select.dispatchEvent(new Event('change')); // Notifie les autres scripts éventuels
                    });

                    // Supprime les classes CSS d'erreur des champs
                    const invalidFields = form.querySelectorAll('.is-invalid');
                    invalidFields.forEach(field => {
                        field.classList.remove('is-invalid');
                    });

                    // Supprime les messages d'erreur affichés
                    const errorMessages = form.querySelectorAll('.invalid-feedback');
                    errorMessages.forEach(error => {
                        error.textContent = '';
                    });
                }
            });
        });
    });
</script>

{{-- ENREGISTREMENT LIGNE --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sélectionne tous les boutons ayant l'id "btn_enr_ligne"
        document.querySelectorAll('#btn_enr_ligne').forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Empêche le comportement par défaut du lien

                // Récupérer les données des attributs data-*
                const simEnr = button.getAttribute('data-sim-enr'); // Numéro SIM
                const forfaitEnr = button.getAttribute('data-forfait-enr'); // Forfait
                const idEnr = button.getAttribute('data-id-enr'); // ID Ligne

                // Injecter les valeurs dans le formulaire du modal
                document.getElementById('enr_sim').value = simEnr || ''; // Numéro SIM
                document.getElementById('enr_forfait').value = forfaitEnr || ''; // Forfait
                document.getElementById('enr_id_ligne').value = idEnr || ''; // ID Ligne
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Vérifie si des erreurs sont présentes dans `enr_ligne_errors` (backend Laravel)
        @if ($errors->hasBag('enr_ligne_errors') && $errors->enr_ligne_errors->any())
            const modalEnrLigne = new bootstrap.Modal(document.getElementById('modal_enr_ligne'));
            modalEnrLigne.show(); // Affiche automatiquement le modal pour corriger les erreurs
        @endif
    });
</script>

{{-- searchUser --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search_enr_user');
        const userSelect = document.getElementById('enr_user');
        const spinner = document.getElementById('loadingSpinner'); // On utilise l'élément déjà existant

        let timeout = null; // Timer pour éviter les requêtes excessives

        searchInput.addEventListener('input', function () {
            clearTimeout(timeout); // Réinitialiser le timer à chaque nouvelle saisie

            const query = searchInput.value.trim();

            if (query.length >= 2) {
                spinner.style.display = 'block'; // Afficher le texte "Recherche en cours..."

                timeout = setTimeout(() => {
                    fetch(`/ligne/searchUser?query=${query}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Erreur lors de la récupération des utilisateurs.');
                            }
                            return response.json();
                        })
                        .then(data => {
                            spinner.style.display = 'none'; // Masquer le spinner après réception des données

                            // Réinitialiser le contenu du select
                            userSelect.innerHTML = '<option value="0" disabled>Choisir un utilisateur</option>';

                            if (data.length > 0) {
                                // Ajouter les options correspondant aux résultats
                                data.forEach(user => {
                                    const option = document.createElement('option');
                                    option.value = user.matricule;
                                    option.textContent = `${user.nom} ${user.prenom}`;
                                    userSelect.appendChild(option);
                                });
                            } else {
                                // Aucun résultat trouvé
                                const noResultOption = document.createElement('option');
                                noResultOption.value = "0";
                                noResultOption.textContent = "Aucun utilisateur trouvé";
                                userSelect.appendChild(noResultOption);
                            }
                        })
                        .catch(error => {
                            spinner.style.display = 'none'; // Masquer le spinner en cas d'erreur
                            console.error('Erreur lors de la recherche des utilisateurs:', error);

                            // Afficher un message d'erreur dans le select
                            userSelect.innerHTML = '<option value="0" disabled>Erreur lors du chargement</option>';
                        });
                }, 300); // Attente de 300ms pour limiter les requêtes fréquentes
            } else {
                // Réinitialiser le contenu du select et masquer le spinner si la saisie est courte
                spinner.style.display = 'none';
                userSelect.innerHTML = '<option value="0" disabled>Choisir un utilisateur</option>';
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Sélectionne tous les boutons pour fermer le modal
        const closeModalButtons = document.querySelectorAll('#close_modal_enr');

        closeModalButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Sélectionne le formulaire dans le modal
                const form = document.getElementById('form_enr_ligne');

                if (form) {
                    // Réinitialise les champs du formulaire
                    form.reset();

                    // Réinitialise manuellement les sélecteurs si nécessaire
                    const selects = form.querySelectorAll('select');
                    selects.forEach(select => {
                        select.value = ''; // Réinitialise le champ
                        select.dispatchEvent(new Event('change')); // Notifie les autres scripts éventuels
                    });

                    // Supprime les classes CSS d'erreur des champs
                    const invalidFields = form.querySelectorAll('.is-invalid');
                    invalidFields.forEach(field => {
                        field.classList.remove('is-invalid');
                    });

                    // Supprime les messages d'erreur affichés
                    const errorMessages = form.querySelectorAll('.invalid-feedback');
                    errorMessages.forEach(error => {
                        error.textContent = '';
                    });
                }
            });
        });
    });
</script>

{{-- VOIR PLUS LIGNE --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sélectionne tous les boutons pour voir les détails
        const voirLigneBtns = document.querySelectorAll('#btn_voir_ligne');

        // Ajoute un gestionnaire d'événements à chaque bouton
        voirLigneBtns.forEach(btn => {
            btn.addEventListener('click', function (event) {
                event.preventDefault(); // Empêche la redirection normale

                // Récupère l'ID de la ligne depuis l'attribut `data-id_voir`
                const idLigne = this.getAttribute('data-id_voir');

                // Vérifie que l'ID est valide
                if (!idLigne) {
                    alert("ID de ligne non valide !");
                    return;
                }

                // Appelle l'API pour récupérer les données
                fetch(`/ligne/detailLigne/${idLigne}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur lors de la récupération des données.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Injecte les données dans le contenu du modal
                        populateModal(data);

                        // Affiche le modal
                        const modal = new bootstrap.Modal(document.getElementById('modal_voir_ligne'));
                        modal.show();
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Une erreur est survenue lors de la récupération des détails de la ligne.');
                    });
            });
        });

        // Fonction pour injecter les données dans le modal
        function populateModal(data) {
            // Remplace les valeurs dans le tableau du modal
            document.querySelector('#modal_voir_ligne .modal-body [data-field="num_ligne"]').textContent = data.num_ligne;
            document.querySelector('#modal_voir_ligne .modal-body [data-field="num_sim"]').textContent = data.num_sim;
            document.querySelector('#modal_voir_ligne .modal-body [data-field="type_ligne"]').textContent = data.type_ligne;
            document.querySelector('#modal_voir_ligne .modal-body [data-field="nom_forfait"]').textContent = data.nom_forfait;
            document.querySelector('#modal_voir_ligne .modal-body [data-field="prix_forfait_ht"]').textContent = data.prix_forfait_ht + " Ar";
            document.querySelector('#modal_voir_ligne .modal-body [data-field="login"]').textContent = data.login;
            document.querySelector('#modal_voir_ligne .modal-body [data-field="localisation"]').textContent = data.localisation;
            document.querySelector('#modal_voir_ligne .modal-body [data-field="debut_affectation"]').textContent = data.debut_affectation;
        }
    });
</script>
