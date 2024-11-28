<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ciblez tous les boutons de modification
        document.querySelectorAll('.open-edit-modal').forEach(button => {
            button.addEventListener('click', function() {
                // Récupérez les valeurs actuelles du chantier depuis les attributs data-*
                const id = this.getAttribute('data-id');
                const ue = this.getAttribute('data-ue');
                const bu = this.getAttribute('data-bu');
                const service = this.getAttribute('data-service');
                const imputation = this.getAttribute('data-imputation');

                // Pré-remplissez les champs du formulaire dans le modal
                document.getElementById('edt_lib_ue').value = ue;
                document.getElementById('edt_bu').value = bu;
                document.getElementById('edt_lib_service').value = service;
                document.getElementById('edt_code_imp').value = imputation;

                // Mettez à jour l'action du formulaire pour inclure l'ID du chantier
                document.getElementById('edt_chantier').action = `/chantier/modifier/${id}`;
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ciblez tous les boutons de suppression
        document.querySelectorAll('.open-delete-modal').forEach(button => {
            button.addEventListener('click', function() {
                // Récupérez l'ID et le nom du chantier depuis les attributs data-*
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                
                // Mettez à jour le texte du modal pour afficher le nom du chantier
                document.querySelector('#supprimer_chantier .modal-body p strong').textContent = name;

                // Mettez à jour le lien de suppression
                const deleteButton = document.querySelector('#supprimer_chantier .modal-footer .btn-danger');
                deleteButton.href = `/chantier/supprimer/${id}`;
            });
        });
    });
</script>