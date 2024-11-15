@extends('base/baseRef')
<head>
    <title>Chantiers - Telecom</title>
</head>

@section('content_ref')

    <div class="container-fluid">
        <h3 class="text-dark"><i class="far fa-building" style="padding-right: 5px;"></i>Chantiers</h3>
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
                            @foreach ($localisations as $localisation)
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
                            @endforeach
                        </tbody>                        
                    </table>
                </div>
            </div>
        </div>
    </div>

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
    

@endsection

@section('modal_ref')

<div id="ajouter_chantier" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Ajouter un chantier</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="add_ue" method="post" action="{{ route('ref.chantier.add') }}" style="color: #a0c8d8;">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="add_ue"><strong>Libellé UE</strong></label>
                                        <select id="add_ue" class="form-select" name="add_ue">
                                            <option value="0" selected>Choisir UE</option>
                                            @foreach ($ue as $ues)
                                                <option value="{{$ues->id_ue}}">{{$ues->libelle_ue}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="add_bu"><strong>Numéro BU</strong></label>
                                        <input id="add_bu" class="form-control" type="text" placeholder="Entrer le numéro BU" name="add_bu" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="add_lib_service"><strong>Libellé Service</strong></label>
                                        <input id="add_lib_service" class="form-control" type="text" placeholder="Entrer le libellé service" name="add_lib_service" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="add_code_imp"><strong>Code Imputation</strong></label>
                                        <input id="add_code_imp" class="form-control" type="text" placeholder="Entrer le code imputation" name="add_code_imp" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-primary" type="submit" form="add_ue">Ajouter</button></div>
        </div>
    </div>
</div>
<div id="supprimer_chantier" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-danger">Voulez vous vraiment supprimer ce chantier?</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-dark" style="margin-bottom: 0px;">Chantier: <strong>2200001AD001-Service Informatique-300800</strong></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button>
                <a href="#" class="btn btn-danger">Supprimer</a>
            </div>
        </div>
    </div>
</div>

<div id="modifier_chantier" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Modifier ce chantier</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-9">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="edt_chantier" action="" method="post" style="color: #a0c8d8;">
                                    @csrf <!-- Protection CSRF -->
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_lib_ue"><strong>Libellé UE</strong></label>
                                        <select id="edt_lib_ue" class="form-select" name="edt_lib_ue">
                                            <option value="0">Choisir UE</option>
                                            @foreach ($ue as $ues)
                                                <option value="{{ $ues->id_ue }}">{{ $ues->libelle_ue }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_bu"><strong>Numéro BU</strong></label>
                                        <input id="edt_bu" class="form-control" type="text" placeholder="Entrer le numéro BU" name="edt_bu" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_lib_service"><strong>Libellé Service</strong></label>
                                        <input id="edt_lib_service" class="form-control" type="text" placeholder="Entrer le libellé service" name="edt_lib_service" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_code_imp"><strong>Code Imputation</strong></label>
                                        <input id="edt_code_imp" class="form-control" type="text" placeholder="Entrer le code imputation" name="edt_code_imp" />
                                    </div>
                                </form>                                
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button>
                <button class="btn btn-info" type="submit" form="edt_chantier">Modifier</button></div>
        </div>
    </div>
</div>

@endsection