@extends('base/baseIndex')

<head>
    <title>Tableau de bord - Telecom</title>
</head>

@section('content_index')
<div class="container-fluid">
    <!-- Titre principal -->
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0"><i class="fas fa-tachometer-alt"></i> Tableau de Bord</h3>
    </div>

    <!-- Formulaire de filtrage -->
    <form method="POST" action="{{ route('index.filter') }}" class="mb-4">
        @csrf
        <div class="row g-3 align-items-end">
            <!-- Sélection du mois -->
            <div class="col-md-3">
                <label for="mois" class="form-label">Mois :</label>
                <select name="mois" id="mois" class="form-select">
                    <option value="">-- Tous les mois --</option>
                    @php
                        $moisFrancais = [
                            1 => 'Janvier',
                            2 => 'Février',
                            3 => 'Mars',
                            4 => 'Avril',
                            5 => 'Mai',
                            6 => 'Juin',
                            7 => 'Juillet',
                            8 => 'Août',
                            9 => 'Septembre',
                            10 => 'Octobre',
                            11 => 'Novembre',
                            12 => 'Décembre',
                        ];
                    @endphp
                    @foreach($moisFrancais as $i => $mois)
                        <option value="{{ $i }}" @if(request('mois') == $i) selected @endif>
                            {{ $mois }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sélection de l'année -->
            <div class="col-md-3">
                <label for="annee" class="form-label">Année :</label>
                <input 
                    type="number" 
                    name="annee" 
                    id="annee" 
                    class="form-control" 
                    placeholder="Ex : 2024" 
                    value="{{ request('annee', date('Y')) }}" 
                    min="2000" 
                    max="{{ date('Y') }}" 
                    required>
            </div>

            <!-- Bouton de validation -->
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Afficher les chiffres</button>
            </div>
        </div>
    </form>

    <!-- Affichage des graphiques et des données -->
    <div class="row mb-5">
        <div class="col-md-12">
            @if($monthlyData)
                <!-- Graphique pour les données mensuelles -->
                <h4 class="text-dark text-center mb-4">Tableau de bord Telecom {{ $selectedYear }}</h4>
                <div class="d-flex justify-content-center">
                    <canvas id="monthlyChart" class="w-100" style="max-width: 100%; height: 500px;"></canvas>
                </div>

                <!-- Boutons d'exportation -->
                <div class="d-flex justify-content-center mt-4 gap-2">
                    <a href="{{ route('export.pdf', ['annee' => request('annee')]) }}" class="btn btn-outline-danger">
                        <i class="fas fa-file-pdf me-2"></i> Export TBD PDF
                    </a>
                    <a href="{{ route('export.xlsx', ['annee' => request('annee')]) }}" class="btn btn-outline-success">
                        <i class="fas fa-file-excel me-2"></i> Export TBD XLSX
                    </a>
                    <a href="{{ route('export.suivi.xlsx', ['annee' => request('annee')]) }}" class="btn btn-outline-info">
                        <i class="fas fa-file-excel me-2"></i> Export SUIVI FLOTTE XLSX
                    </a>                    
                </div>
            @elseif($totalPrixForfaitHT)
                <!-- Affichage du total pour un mois donné -->
                <div class="card shadow border-0">
                    <div class="card-body text-center">
                        <h4 class="text-dark mb-4 fw-bold">
                            Total pour {{ $moisFrancais[$selectedMonth] }} {{ $selectedYear }}
                        </h4>
                        <div class="alert alert-success text-center p-4" role="alert">
                            <span class="fw-bold h4">
                                {{ number_format($totalPrixForfaitHT, 2, ',', ' ') }} MGA
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <!-- Message si aucune donnée n'est disponible -->
                <div class="card shadow-sm border-warning">
                    <div class="card-body text-center">
                        <div class="alert alert-warning text-center p-4" role="alert">
                            <h5 class="text-dark fw-bold mb-3">Aucune donnée disponible</h5>
                            <p class="mb-0">
                                Aucun résultat pour la période sélectionnée. Veuillez essayer une autre période ou vérifier les paramètres.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Section des graphiques (Lignes et Équipements) -->
    <div class="row mt-5">
        <div class="col-md-6 chart-container">
            <canvas id="ligneChart"></canvas>
        </div>
        <div class="col-md-6 chart-container">
            <canvas id="equipementChart"></canvas>
            <!-- Bouton d'exportation pour Équipements -->
            <div class="d-flex justify-content-center mt-4">
                <a href="{{ route('export.equipement.xlsx') }}" class="btn btn-outline-success">
                    <i class="fas fa-file-excel me-2"></i> Export XLSX
                </a>
            </div>
        </div>
    </div>

</div>

<!-- Scripts pour les graphiques -->
<script src="{{ asset('assets/js/chart.js') }}"></script>
<script>
    // Graphique des chiffres mensuels
    const moisFrancais = [
        'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 
        'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
    ];

    @if($monthlyData)
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: moisFrancais,
                datasets: [{
                    label: 'Total Prix Forfait HT (MGA)',
                    data: @json(array_column($monthlyData, 'total_prix_forfait_ht')),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });
    @endif

    // Graphique des lignes
    const ligneCtx = document.getElementById('ligneChart').getContext('2d');
    new Chart(ligneCtx, {
        type: 'doughnut',
        data: {
            labels: ['Lignes Actifs', 'Lignes Inactifs', 'Lignes Résiliés', 'Lignes en Attente'],
            datasets: [{
                data: [{{ $ligneActif ?? 0 }}, {{ $ligneInactif ?? 0 }}, {{ $ligneResilie ?? 0 }}, {{ $ligneEnAttente ?? 0 }}],
                backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(255, 159, 64, 0.6)', 'rgba(255, 0, 0, 0.6)', 'rgba(54, 162, 235, 0.6)']
            }]
        },
        options: { responsive: true }
    });

    // Graphique des équipements
    const equipementCtx = document.getElementById('equipementChart').getContext('2d');
    new Chart(equipementCtx, {
        type: 'doughnut',
        data: {
            labels: ['Équipements Actifs', 'Équipements Inactifs', 'Équipements HS'],
            datasets: [{
                data: [{{ $equipementActif ?? 0 }}, {{ $equipementInactif ?? 0 }}, {{ $equipementHS ?? 0 }}],
                backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(255, 159, 64, 0.6)', 'rgba(255, 0, 0, 0.6)']
            }]
        },
        options: { responsive: true }
    });
</script>

<!-- Styles CSS -->
<style>
    .chart-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 20px auto;
        width: 100%; 
        max-width: 400px; /* Taille maximale du graphique */
        height: 400px;
    }

    canvas {
        max-width: 100%;
        max-height: 100%;
    }
</style>
@endsection
