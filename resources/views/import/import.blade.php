@extends('base/baseIndex')

<head>
    <title>Imports - Telecom</title>
</head>

@section('content_index')
<div class="container-fluid">

    <!-- Toasts Bootstrap -->
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <!-- Toast de succès -->
            @if (session('success'))
            <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            @endif

            <!-- Toast d'erreur -->
            @if (session('error'))
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Script pour afficher automatiquement les toasts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.map(function (toastEl) {
                const toast = new bootstrap.Toast(toastEl, { delay: 5000 }); // Disparaît après 5s
                toast.show();
            });
        });
    </script>

    <!-- Titre principal -->
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h4 class="text-dark mb-0">
            <i class="fas fa-file-import"></i> Import Lignes inactifs et Utilisateurs avec Localisation
        </h4>
    </div>

    <!-- Formulaire d'importation -->
    <div class="card shadow-sm mb-4" style="max-width: 800px;">
        <div class="card-header bg-primary text-white py-3">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-file-csv"></i> Importer un fichier CSV
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('import.process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="csvFile" class="font-weight-bold">Sélectionnez le fichier CSV</label>
                    <input 
                        type="file" 
                        name="csv_file" 
                        id="csvFile" 
                        class="form-control @error('csv_file') is-invalid @enderror" 
                        accept=".csv" 
                        required
                    >
                    @error('csv_file')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-2">
                        <i class="fas fa-upload"></i> Importer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Section d'instructions -->
    <div class="alert alert-info mt-4 p-4" style="max-width: 800px; border-left: 5px solid #007bff; border-radius: 0.5rem;">
        <h5 class="font-weight-bold">
            <i class="fas fa-info-circle"></i> Instructions pour l'import :
        </h5>
        <p class="mb-2">
            Assurez-vous que le fichier CSV respecte le format suivant. Les colonnes doivent être correctement nommées (respect des <strong>majuscules et minuscules</strong>) :
        </p>
        <ul class="mb-3 pl-4">
            <li><code>Numero2</code> <span class="text-muted">(numéro téléphone)</span></li>
            <li><code>Login</code></li>
            <li><code>Nom et Prénoms</code></li>
            <li><code>Fonction</code></li>
            <li><code>SERVICE</code></li>
            <li><code>Libelle Imputation</code></li>
            <li><code>TYPE FORFAIT</code></li>
        </ul>
        <p class="mb-0">
            <strong>Note :</strong> Veuillez vérifier attentivement le format et les colonnes avant d'importer le fichier.
        </p>
    </div>

</div>
@endsection
