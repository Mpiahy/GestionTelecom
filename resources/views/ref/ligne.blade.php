@extends('base/baseRef')
<head>
    <title>Lignes - Telecom</title>
</head>

@section('content_ref')

    <div class="container-fluid">
        <h3 class="text-dark mb-1">
            <i class="fas fa-satellite-dish" style="padding-right: 5px;"></i>Lignes
        </h3>
        
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

        <div class="text-center mb-4">
            <a class="btn btn-primary btn-icon-split" role="button" data-bs-target="#modal_act_ligne" data-bs-toggle="modal">
                <span class="icon"><i class="fas fa-plus-circle mt-1"></i></span>
                <span class="text">Demander l&#39;activation d&#39;une ligne</span>
            </a>
        </div>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="m-0 fw-bold" style="color: #0a4866;">Gestion des lignes</p>
            </div>
            <div class="card-body">
                <div class="row mt-2">
                     <!-- Formulaire pour rechercher par numéro de ligne -->
                    <div class="col">
                        <form action="{{ route('ref.ligne') }}" method="get">
                            <div class="input-group">
                                <span class="input-group-text">Ligne</span>
                                <input 
                                    class="form-control" 
                                    type="text" 
                                    placeholder="Rechercher par Ligne" 
                                    name="search_ligne_num" 
                                    value="{{ request('reset_filters') == 'reset' ? '' : request('search_ligne_num') }}" />
                                
                                <!-- Inputs cachés pour conserver les autres filtres/recherches -->
                                <input type="hidden" name="search_ligne_sim" value="{{ request('search_ligne_sim') }}">
                                <input type="hidden" name="statut" value="{{ request('statut') }}">

                                <button class="btn btn-primary" type="submit">Rechercher</button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Formulaire pour rechercher par numéro de SIM -->
                    <div class="col">
                        <form action="{{ route('ref.ligne') }}" method="get">
                            <div class="input-group">
                                <span class="input-group-text">SIM</span>
                                <input 
                                    class="form-control" 
                                    type="text" 
                                    placeholder="Rechercher par SIM" 
                                    name="search_ligne_sim" 
                                    value="{{ request('reset_filters') == 'reset' ? '' : request('search_ligne_sim') }}" />
                                
                                <!-- Inputs cachés pour conserver les autres filtres/recherches -->
                                <input type="hidden" name="search_ligne_num" value="{{ request('search_ligne_num') }}">
                                <input type="hidden" name="statut" value="{{ request('statut') }}">

                                <button class="btn btn-primary" type="submit">Rechercher</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <form action="{{ route('ref.ligne') }}" method="get">
                            <div class="btn-group" role="group">
                                {{-- Bouton "Tout" pour réinitialiser les filtres --}}
                                <button 
                                    class="btn btn-outline-primary {{ is_null(request('statut')) ? 'active' : '' }}" 
                                    type="submit" 
                                    name="reset_filters" 
                                    value="reset">
                                    Tout
                                </button>

                                <!-- Bouton "Tout" pour réinitialiser les filtres -->
                                <input type="hidden" name="search_ligne_num" value="{{ request('search_ligne_num') }}">
                                <input type="hidden" name="search_ligne_sim" value="{{ request('search_ligne_sim') }}">
                        
                                {{-- Boutons dynamiques pour chaque statut --}}
                                @foreach ($statuts as $statut)
                                    @php
                                        $colorClass = App\Models\StatutLigne::getBootstrapClass($statut->id_statut_ligne);
                                    @endphp
                                    <button 
                                        class="btn btn-outline-{{ $colorClass }} {{ request('statut') == $statut->id_statut_ligne ? 'active' : '' }}" 
                                        type="submit" 
                                        name="statut" 
                                        value="{{ $statut->id_statut_ligne }}">
                                        {{ $statut->statut_ligne }}
                                    </button>
                                @endforeach
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <form action="search_ligne_user">
                            <div class="input-group"><span class="input-group-text">Utilisateur</span>
                                <input class="form-control" type="text" placeholder="Rechercher par Utilisateur" name="search_ligne_user" />
                                <button class="btn btn-primary" type="submit">Rechercher</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="dataTable-1" class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                    <table id="dataTable" class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>Opérateur</th>
                                <th>Statut</th>
                                <th>Type</th>
                                <th>Forfait</th>
                                <th>Numéro Ligne</th>
                                <th>Numéro SIM</th>
                                <th>Utilisateur</th>
                                <th>Localisation</th>
                                <th class="text-center" style="padding-right: 30px;padding-left: 30px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lignes as $ligne)
                            <tr>
                                <td>
                                    <a href="#" 
                                        class="mailto-link text-decoration-none"
                                        data-email="{{ $ligne->contact_email }}"
                                        data-num-sim="{{ $ligne->num_sim }}"
                                        title="Relancer">
                                        <i class="far fa-paper-plane"></i>
                                        {{ $ligne->nom_operateur }}
                                    </a>
                                </td>                                
                                <td>{{ $ligne->statut_ligne }}</td>
                                <td>{{ $ligne->type_ligne }}</td>
                                <td>{{ $ligne->nom_forfait }}</td>
                                <td>{{ $ligne->num_ligne ?? 'En attente' }}</td>
                                <td>{{ $ligne->num_sim }}</td>
                                <td>--</td>
                                <td>--</td>
                                <td class="text-center" style="padding-left: 0px;padding-right: 0px;">
                                    <a 
                                        id="btn_enr_ligne" 
                                        class="text-decoration-none" 
                                        href="enr_ligne" 
                                        style="margin-right: 5px;" 
                                        data-bs-target="#modal_enr_ligne" 
                                        data-bs-toggle="modal" 
                                        title="Enregistrer" 
                                        data-toggle="tooltip"
                                        data-sim-enr="{{ $ligne->num_sim }}" 
                                        data-forfait-enr="{{ $ligne->nom_forfait }}" 
                                        data-id-enr="{{ $ligne->id_ligne }}">
                                        <i class="far fa-save text-info" style="font-size: 25px;"></i>
                                    </a>
                                    <a class="text-decoration-none" href="voir_ligne" style="margin-right: 5px;" data-bs-target="#modal_voir_ligne" title="Voir" data-toggle="tooltip" data-bs-toggle="modal">
                                        <i class="fas fa-search-plus text-primary" style="font-size: 25px;"></i>
                                    </a>
                                    <a class="text-decoration-none" href="edit_operateur" data-bs-target="#modal_edit_ligne" data-bs-toggle="modal" title="Modifier" data-toggle="tooltip">
                                        <i class="far fa-edit text-warning" style="font-size: 25px;"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal_ref')

    @include('modals.ligneModal')

@endsection

@section('scripts')

    @include('js.ligneJs')

@endsection