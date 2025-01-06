@extends('base/baseRef')
<head>
    <title>Chantiers - Telecom</title>
</head>

@section('content_ref')

    <div class="container-fluid">
        <h3 class="text-dark"><i class="far fa-building" style="padding-right: 5px;"></i>Chantiers</h3>

        <!-- Toast container -->
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
            <!-- Toast for Success Message -->
            @if (session('success'))
                <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <!-- Toast for Error Message -->
            @if (session('error'))
                <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            @endif
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toastElList = [].slice.call(document.querySelectorAll('.toast'));
                const toastList = toastElList.map(function (toastEl) {
                    return new bootstrap.Toast(toastEl, { delay: 5000 }); // Durée de 5 secondes
                });

                toastList.forEach(toast => toast.show());
            });
        </script>

        <div class="text-center mb-4"><a class="btn btn-primary btn-icon-split" role="button" data-bs-target="#ajouter_chantier" data-bs-toggle="modal"><span class="icon"><i class="fas fa-plus-circle" style="padding-top: 5px;"></i></span><span class="text">Ajouter un chantier</span></a></div>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="m-0 fw-bold" style="color: #0a4866;">Gestion des chantiers</p>
            </div>
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-5">
                        <div class="col">
                            <form action="{{ route('ref.chantier') }}" method="get">
                                <div class="input-group">
                                    <span class="input-group-text">Imputation</span>
                                    <input class="form-control" type="text" placeholder="Rechercher par Imputation" name="search_chantier_imputation" value="{{ request('search_chantier_imputation') }}" />
                                    <input type="hidden" name="ue" value="{{ request('ue') }}"> <!-- Champ caché pour conserver le filtre de centre -->
                                    <button class="btn btn-primary" type="submit">Rechercher</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-2"></div>
                    <div class="col-5">
                        <form action="{{ route('ref.chantier') }}" method="get">
                            <div class="input-group">
                                <span class="input-group-text">BU</span>
                                <input class="form-control" type="text" placeholder="Rechercher par BU" name="search_chantier_bu" value="{{ request('search_chantier_bu') }}" />
                                <input type="hidden" name="ue" value="{{ request('ue') }}"> <!-- Champ caché pour conserver le filtre de centre -->
                                <button class="btn btn-primary" type="submit">Rechercher</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <form id="filterForm" method="get" action="{{ route('ref.chantier') }}">
                            <div class="btn-group" role="group">
                                <!-- Bouton "Tout" -->
                                <button class="btn btn-outline-primary {{ request('ue') ? '' : 'active' }}" type="submit" name="ue" value="">Tout</button>
                                <!-- Boutons dynamiques pour chaque UE -->
                                @foreach ($ue as $unit)
                                    <button 
                                        class="btn btn-outline-primary {{ request('ue') == $unit->libelle_ue ? 'active' : '' }}" 
                                        type="submit" 
                                        name="ue" 
                                        value="{{ $unit->libelle_ue }}">
                                        {{ $unit->libelle_ue }}
                                    </button>
                                @endforeach
                            </div>
                        </form>
                    </div>                                   
                    <div class="col-5">
                        <form action="{{ route('ref.chantier') }}" method="get">
                            <div class="input-group">
                                <span class="input-group-text">Service</span>
                                <input class="form-control" type="text" placeholder="Rechercher par Service" name="search_chantier_service" value="{{ request('search_chantier_service') }}" />
                                <input type="hidden" name="ue" value="{{ request('ue') }}"> <!-- Champ caché pour conserver le filtre de centre -->
                                <button class="btn btn-primary" type="submit">Rechercher</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="dataTable-1" class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                    <table id="dataTable" class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>Centre (UE)</th>
                                <th>Code BU</th>
                                <th>Service</th>
                                <th>Code Imputation</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($localisations as $localisation)
                                <tr>
                                    <td>{{ $localisation->ue->libelle_ue }}</td> <!-- Centre (UE) -->
                                    <td>{{ $localisation->service->numero_bu }}</td> <!-- Code BU -->
                                    <td>{{ $localisation->service->libelle_service }}</td> <!-- Service -->
                                    <td>{{ $localisation->imputation->code_imputation }}</td> <!-- Code Imputation -->
                                    <td class="text-center">
                                        <a href="#"
                                        data-bs-target="#modifier_chantier" 
                                        data-bs-toggle="modal" 
                                        data-id="{{ $localisation->id_localisation }}" 
                                        data-ue="{{ $localisation->ue->id_ue }}" 
                                        data-bu="{{ $localisation->service->numero_bu }}" 
                                        data-service="{{ $localisation->service->libelle_service }}" 
                                        data-imputation="{{ $localisation->imputation->code_imputation }}"
                                        class="open-edit-modal" 
                                        style="margin-right: 10px; text-decoration: none">
                                            <i class="far fa-edit text-info" style="font-size: 25px;" data-toggle="tooltip" title="Modifier"></i>
                                        </a>
                                        <a href="#" 
                                        data-bs-target="#supprimer_chantier" 
                                        data-bs-toggle="modal" 
                                        data-id="{{ $localisation->id_localisation }}" 
                                        data-name="{{ $localisation->service->numero_bu }}-{{ $localisation->service->libelle_service }}-{{ $localisation->imputation->code_imputation }}"
                                        class="open-delete-modal">
                                            <i class="far fa-trash-alt text-danger" style="font-size: 25px;" data-toggle="tooltip" title="Supprimer"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Aucune localisation trouvée.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Liens de pagination -->
                <div class="mt-4">
                    {{ $localisations->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
                
            </div>
        </div>
    </div>
    
@endsection

@section('modal_ref')

    @include('modals.chantierModal')

@endsection

@section('scripts')

    @include('js.chantierJs')

@endsection