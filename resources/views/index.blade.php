@extends('base/baseIndex')
<head>
    <title>Tableau de bord - Telecom</title>
</head>

@section('content_index')

<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0"><i class="fas fa-tachometer-alt"></i>Tableau de Bord</h3>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card shadow border-start-warning py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Lignes Actifs</span></div>
                            <div class="text-dark fw-bold h5 mb-0"><span>{{ $ligneActif }}</span></div>
                        </div>
                        <div class="col-auto"><i class="far fa-arrow-alt-circle-up fa-2x text-success"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card shadow border-start-warning py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span>Lignes Résiliés</span></div>
                            <div class="text-dark fw-bold h5 mb-0"><span>{{ $ligneResilie }}</span></div>
                        </div>
                        <div class="col-auto"><i class="far fa-arrow-alt-circle-down fa-2x text-warning"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card shadow border-start-warning py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Lignes en Attente</span></div>
                            <div class="text-dark fw-bold h5 mb-0"><span>{{ $ligneEnAttente }}</span></div>
                        </div>
                        <div class="col-auto"><i class="far fa-arrow-alt-circle-right text-info fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card shadow border-start-warning py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Appareils Actifs</span></div>
                            <div class="text-dark fw-bold h5 mb-0"><span>{{ $equipementActif }}</span></div>
                        </div>
                        <div class="col-auto"><i class="far fa-compass fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card shadow border-start-warning py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span>Appareils Inactifs</span></div>
                            <div class="text-dark fw-bold h5 mb-0"><span>{{ $equipementInactif }}</span></div>
                        </div>
                        <div class="col-auto"><i class="far fa-compass fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card shadow border-start-warning py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-danger fw-bold text-xs mb-1"><span>Appareils HS</span></div>
                            <div class="text-dark fw-bold h5 mb-0"><span>{{ $equipementHS }}</span></div>
                        </div>
                        <div class="col-auto"><i class="far fa-compass fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection