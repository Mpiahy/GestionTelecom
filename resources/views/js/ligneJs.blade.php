<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Gestion des liens mailto statiques dans le HTML
        const mailtoLinks = document.querySelectorAll('.mailto-link');

        mailtoLinks.forEach(link => {
            const email = link.dataset.email;
            const numSim = link.dataset.numSim;

            const subject = encodeURIComponent("Demande d'activation d'une ligne");
            const body = encodeURIComponent(
                `Bonjour,

                Merci d'activer une ligne sur la SIM : ${numSim}.

                Merci de bien vouloir traiter cette demande dans les meilleurs délais.

                Cordialement,`
            );

            // Générer le lien `mailto`
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

                const operateur = operateurSelect.options[operateurSelect.selectedIndex]?.text || '';
                const email = operateurSelect.options[operateurSelect.selectedIndex]?.dataset.email || '';
                const type = typeSelect.options[typeSelect.selectedIndex]?.text || '';
                const forfait = forfaitSelect.options[forfaitSelect.selectedIndex]?.text || '';

                // Vérifie si un e-mail est défini
                if (!email) {
                    alert('Veuillez sélectionner un opérateur avec une adresse e-mail valide.');
                    return;
                }

                // Sujet et contenu de l'e-mail
                const subject = encodeURIComponent("Demande d'activation d'une ligne");
                const body = encodeURIComponent(
                    `Bonjour,

                    Merci d'activer une ligne sur la SIM : ${sim}.

                    Forfait : ${forfait}

                    Merci de bien vouloir traiter cette demande dans les meilleurs délais.

                    Cordialement,`
                );

                // Génère le lien mailto
                const mailtoLink = `mailto:${email}?subject=${subject}&body=${body}`;

                // Ouvre le client de messagerie avec le lien mailto
                window.location.href = mailtoLink;

                // Optionnel : soumettre le formulaire après avoir ouvert le client de messagerie
                form.submit();
            });
        }
    });

</script>