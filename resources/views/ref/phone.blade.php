@extends('base/baseRef')
<head>
    <title>Téléphones - Telecom</title>
</head>


@section('content_ref')

<div class="container-fluid">
    <h3 class="text-dark mb-1">
        <i class="fas fa-phone-alt" style="padding-right: 6px;"></i>Téléphones</h3>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Succès !</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Erreur !</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Veuillez corriger les erreurs suivantes :</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="text-center mb-4">
        <a class="btn btn-primary btn-icon-split" role="button" data-bs-target="#modal_enr_phone" data-bs-toggle="modal">
            <span class="icon">
                <i class="fas fa-plus-circle" style="padding-top: 5px;"></i>
            </span>
            <span class="text">Enregistrer un téléphone</span></a></div>
    <div class="card shadow">
        <div class="card-header py-3">
            <p class="m-0 fw-bold" style="color: #0a4866;">Gestion des téléphones</p>
        </div>
        <div class="card-body">
            <div class="row mt-2">
                <div class="col">
                    <form method="get" action="{{ route('ref.phone') }}">
                        <div class="input-group">
                            <span class="input-group-text">Marque</span>
                            <select name="filter_marque" class="form-select">
                                <option value="" {{ !request('filter_marque') ? 'selected' : '' }}>Toutes les marques</option>
                                @foreach ($marques as $marque)
                                    <option value="{{ $marque->id_marque }}" {{ request('filter_marque') == $marque->id_marque ? 'selected' : '' }}>
                                        {{ $marque->marque }}
                                    </option>
                                @endforeach
                            </select>
                            @foreach (['filter_statut', 'search_imei', 'search_sn'] as $filter)
                                @if (request($filter))
                                    <input type="hidden" name="{{ $filter }}" value="{{ request($filter) }}">
                                @endif
                            @endforeach
                            <button class="btn btn-primary" type="submit">Filtrer</button>
                        </div>
                    </form>
                </div>
                <div class="col">
                    <form action="search_user">
                        <div class="input-group"><span class="input-group-text">Utilisateur</span><input class="form-control" type="text" placeholder="Rechercher par Utilisateur" name="search_user" /><button class="btn btn-primary" type="button">Rechercher</button></div>
                    </form>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <div></div>
                </div>
                <div class="col">
                    <form method="get" action="{{ route('ref.phone') }}">
                        <div class="input-group">
                            <span class="input-group-text">IMEI</span>
                            <input class="form-control" type="text" name="search_imei" placeholder="Rechercher par IMEI" value="{{ request('search_imei') }}">
                            @foreach (['filter_statut', 'filter_marque', 'search_sn'] as $filter)
                                @if (request($filter))
                                    <input type="hidden" name="{{ $filter }}" value="{{ request($filter) }}">
                                @endif
                            @endforeach
                            <button class="btn btn-primary" type="submit">Rechercher</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-xl-6">
                    <form method="get" action="{{ route('ref.phone') }}">
                        <div class="btn-group" role="group">
                            <button class="btn btn-outline-primary {{ !request('filter_statut') ? 'active' : '' }}" type="submit" name="reset_filters" value="1">Tout</button>
                            <button class="btn btn-outline-info {{ request('filter_statut') == 1 ? 'active' : '' }}" type="submit" name="filter_statut" value="1">Nouveau</button>
                            <button class="btn btn-outline-success {{ request('filter_statut') == 2 ? 'active' : '' }}" type="submit" name="filter_statut" value="2">Attribué</button>
                            <button class="btn btn-outline-warning {{ request('filter_statut') == 3 ? 'active' : '' }}" type="submit" name="filter_statut" value="3">Retourné</button>
                            
                            <!-- Champs cachés pour conserver les autres filtres -->
                            <input type="hidden" name="filter_marque" value="{{ request('filter_marque') }}">
                            <input type="hidden" name="search_imei" value="{{ request('search_imei') }}">
                            <input type="hidden" name="search_sn" value="{{ request('search_sn') }}">

                            <button class="btn btn-outline-danger {{ request('filter_statut') == 4 ? 'active' : '' }}" type="submit" name="filter_statut" value="4">HS</button>
                        </div>
                    </form>
                                       
                </div>
                <div class="col-xl-6">
                    <form method="get" action="{{ route('ref.phone') }}">
                        <div class="input-group">
                            <span class="input-group-text">SN</span>
                            <input class="form-control" type="text" name="search_sn" placeholder="Rechercher par Numéro de Série" value="{{ request('search_sn') }}">
                            @foreach (['filter_statut', 'filter_marque', 'search_imei'] as $filter)
                                @if (request($filter))
                                    <input type="hidden" name="{{ $filter }}" value="{{ request($filter) }}">
                                @endif
                            @endforeach
                            <button class="btn btn-primary" type="submit">Rechercher</button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="dataTable-1" class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                <table id="dataTable" class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th>Marque</th>
                            <th>Modèle</th>
                            <th>Type</th>
                            <th>Imei</th>
                            <th>Serial Number</th>
                            <th>Utilisateur</th>
                            <th>Statut</th>
                            <th>Enrôlé</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($equipements as $equipement)
                            <tr>
                                <td><a class="text-decoration-none" href="#">{{ $equipement->modele->marque->marque }}</a></td>
                                <td>{{ $equipement->modele->nom_modele }}</td>
                                <td>{{ $equipement->typeEquipement->type_equipement }}</td>
                                <td>{{ $equipement->imei }}</td>
                                <td>{{ $equipement->serial_number }}</td>
                                <td>
                                    N/A
                                </td>
                                <td>{{ $equipement->statut->statut_equipement }}</td>
                                <td>{{ $equipement->enrole ? 'Oui' : 'Non' }}</td>
                                <td class="text-center">
                                    <!-- Action buttons -->
                                    <a class="text-decoration-none" style="margin-right: 10px;" data-bs-target="#modal_attr_phone" data-bs-toggle="modal" data-toggle="tootlip" title="Attribuer" href="attr_phone">
                                        <i class="fas fa-bars text-success" style="font-size: 25px;"></i>
                                    </a>
                                    <a class="text-decoration-none" data-bs-target="#modal_histo_phone" data-bs-toggle="modal" data-toggle="tooltip" title="Historique" href="#" style="margin-right: 10px;">
                                        <i class="fas fa-history text-primary" style="font-size: 25px;"></i>
                                    </a>
                                    <a class="text-decoration-none open-hs-modal" 
                                        data-bs-toggle="tooltip" 
                                        title="Déclarer HS" 
                                        href="#" 
                                        data-phone-id="{{ $equipement->id_equipement }}" 
                                        data-phone-name="{{ $equipement->modele->marque->marque }} {{ $equipement->modele->nom_modele }}" 
                                        data-phone-sn="{{ $equipement->serial_number }}">
                                        <i class="far fa-times-circle text-danger" style="font-size: 25px;"></i>
                                    </a>
                                    <a class="text-decoration-none" data-bs-target="#modal_retour_phone" data-bs-toggle="modal" data-toggle="tooltip" title="Retourner" href="#" style="margin-left: 10px;">
                                        <i class="fas fa-undo text-warning" style="font-size: 25px;"></i>
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

<div id="modal_enr_phone" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Enregistrer un téléphone</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="form_enr_phone" action="{{ route('phone.enr') }}" method="post" style="color: #a0c8d8;">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="enr_phone_type"><strong>Type</strong></label>
                                        <select id="enr_phone_type" class="form-select @error('enr_phone_type') is-invalid @enderror" name="enr_phone_type" required>
                                            <option value="0" disabled {{ old('enr_phone_type') ? '' : 'selected' }}>Choisir le type</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type->id_type_equipement }}" 
                                                    {{ old('enr_phone_type') == $type->id_type_equipement ? 'selected' : '' }}>
                                                    {{ $type->type_equipement }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('enr_phone_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror                                        
                                    </div>                                    
                                
                                    <div class="mb-3">
                                        <label class="form-label" for="enr_phone_marque"><strong>Marque</strong></label>
                                        <select id="enr_phone_marque" class="form-select @error('enr_phone_marque') is-invalid @enderror" name="enr_phone_marque" required>
                                            <option value="0" disabled {{ old('enr_phone_marque') ? '' : 'selected' }}>Choisir la marque</option>
                                            <option value="new_marque" {{ old('enr_phone_marque') == 'new_marque' ? 'selected' : '' }}>Ajouter une nouvelle marque</option>
                                            @foreach($marques as $marque)
                                                <option value="{{ $marque->id_marque }}" 
                                                    {{ old('enr_phone_marque') == $marque->id_marque ? 'selected' : '' }}>
                                                    {{ $marque->marque }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('enr_phone_marque')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror                                        
                                    
                                        <!-- Champ pour nouvelle marque -->
                                        <input id="new_phone_marque" class="form-control mt-2 d-none @error('new_phone_marque') is-invalid @enderror" type="text" placeholder="Nouvelle marque" name="new_phone_marque" value="{{ old('new_phone_marque') }}" />
                                        @error('new_phone_marque')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>                                    
                                
                                    <div class="mb-3">
                                        <label class="form-label" for="enr_phone_modele"><strong>Modèle</strong></label>
                                        <select id="enr_phone_modele" class="form-select @error('enr_phone_modele') is-invalid @enderror" name="enr_phone_modele" required>
                                            <option value="0" disabled {{ old('enr_phone_modele') ? '' : 'selected' }}>Choisir le modèle</option>
                                            <option value="new" {{ old('enr_phone_modele') == 'new' ? 'selected' : '' }}>Ajouter un nouveau modèle</option>
                                            @foreach($modeles as $modele)
                                                <option value="{{ $modele->id_modele }}" {{ old('enr_phone_modele') == $modele->id_modele ? 'selected' : '' }}>
                                                    {{ $modele->nom_modele }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('enr_phone_modele')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    
                                        <!-- Champ pour ajouter un nouveau modèle -->
                                        <input id="new_phone_modele" class="form-control mt-2 d-none @error('new_phone_modele') is-invalid @enderror" 
                                               type="text" 
                                               placeholder="Nouveau modèle" 
                                               name="new_phone_modele" 
                                               value="{{ old('new_phone_modele') }}" />
                                        @error('new_phone_modele')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>                                    
                                
                                    <div class="mb-3">
                                        <label class="form-label" for="enr_phone_imei"><strong>Imei</strong></label>
                                        <input id="enr_phone_imei" class="form-control @error('enr_phone_imei') is-invalid @enderror" 
                                            type="text" 
                                            placeholder="Entrer l'imei" 
                                            name="enr_phone_imei" 
                                            value="{{ old('enr_phone_imei') }}" 
                                            required />
                                        @error('enr_phone_imei')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror                                    
                                    </div>
                                
                                    <div class="mb-3">
                                        <label class="form-label" for="enr_phone_sn"><strong>Numéro de série</strong></label>
                                        <input id="enr_phone_sn" class="form-control @error('enr_phone_sn') is-invalid @enderror" 
                                            type="text" 
                                            placeholder="Entrer le numéro de série" 
                                            name="enr_phone_sn" 
                                            value="{{ old('enr_phone_sn') }}" 
                                            required />
                                        @error('enr_phone_sn')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror                                    
                                    </div>
                                
                                    <div class="mb-3">
                                        <label class="form-label" for="enr_phone_enroll"><strong>Enrôlé</strong></label>
                                        <select id="enr_phone_enroll" class="form-select @error('enr_phone_enroll') is-invalid @enderror" name="enr_phone_enroll" required>
                                            <option value="0" disabled {{ old('enr_phone_enroll') ? '' : 'selected' }}>Oui ou Non</option>
                                            <option value="1" {{ old('enr_phone_enroll') == '1' ? 'selected' : '' }}>Oui</option>
                                            <option value="2" {{ old('enr_phone_enroll') == '2' ? 'selected' : '' }}>Non</option>
                                        </select>
                                        @error('enr_phone_enroll')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                <button class="btn btn-primary" type="submit" form="form_enr_phone">Enregistrer</button></div>
        </div>
    </div>
</div>
<div id="modal_attr_phone" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Attribuer un téléphone</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-7">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="form_attr_phone" action="attr_phone" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3"><label class="form-label" for="attr_phone"><strong>Téléphone</strong><br /></label><input id="attr_phone" class="form-control" type="text" name="attr_phone" value="iPhone 15 Pro Max" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="attr_phone"><strong>Numéro de série</strong><br /></label><input id="attr_phone-1" class="form-control" type="text" name="attr_phone_sn" value="14646354698" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="attr_phone_emp"><strong>Utilisateur</strong></label><select id="attr_phone_emp" class="form-select" name="attr_phone_emp">
                                            <option value="0" selected>Choisir l&#39;utilsateur</option>
                                            <optgroup label="Dépôt Anosibe">
                                                <option value="1">Randriamanivo Mpiahisoa</option>
                                                <option value="2">Razafindrasoava Mirindra</option>
                                            </optgroup>
                                            <optgroup label="DTAMA">
                                                <option value="3">Tantelison Odilon</option>
                                            </optgroup>
                                        </select></div>
                                    <div class="mb-3"><label class="form-label" for="attr_phone_date"><strong>Date d&#39;affectation</strong></label><input id="attr_phone_date" class="form-control" type="date" name="attr_phone_date" /></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-primary" type="submit" form="form_attr_phone">Attribuer</button></div>
        </div>
    </div>
</div>
<div id="modal_histo_phone" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Historique d&#39;affectation pour ce téléphone</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-dark" style="margin-bottom: 0px;">Téléphone: <strong>iPhone 15 Pro Max</strong></p>
                <p class="text-dark">SN: <strong>321 54982 543</strong></p>
                <div id="dataTable-2" class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                    <table id="dataTable" class="table table-hover my-0">
                        <tbody>
                            <tr>
                                <th class="table-primary">Utilisateur</th>
                                <th class="table-primary text-dark">Date d&#39;affectation</th>
                                <th class="table-primary">Date de retour</th>
                            </tr>
                            <tr>
                                <td class="text-dark">Tantelison Odilon</td>
                                <td class="text-dark">04 Novembre 2024</td>
                                <td class="text-dark">--</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button></div>
        </div>
    </div>
</div>
<div id="modal_hs_phone" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-danger">Voulez-vous vraiment déclarer HS?</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-7">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- Formulaire de déclaration HS -->
                                <form id="form_hs_phone" action="{{ route('phone.hs') }}" method="post">
                                    @csrf
                                    <!-- Champ caché pour l'ID du téléphone (utilisé par le backend) -->
                                    <input type="hidden" name="phone_id" id="hs_phone_id" value="">

                                    <div class="mb-3">
                                        <label class="form-label" for="hs_phone"><strong>Téléphone</strong></label>
                                        <!-- Champ désactivé pour affichage uniquement -->
                                        <input id="hs_phone" class="form-control" type="text" value="" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="sn_phone"><strong>SN</strong></label>
                                        <!-- Champ désactivé pour affichage uniquement -->
                                        <input id="sn_phone" class="form-control" type="text" value="" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="statut_phone"><strong>Etat</strong></label>
                                        <select id="statut_phone" class="form-select" readonly>
                                            <option value="3" selected>HS</option>
                                        </select>
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
                <button class="btn btn-danger" type="submit" form="form_hs_phone">Déclarer HS</button></div>
        </div>
    </div>
</div>
<div id="modal_retour_phone" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-danger">Voulez-vous vraiment retourner ce téléphone?</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-7">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="form_retour_phone" action="retour_phone" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3"><label class="form-label" for="retour_phone"><strong>Téléphone</strong><br /></label><input id="retour_phone" class="form-control" type="text" name="retour_phone" value="iPhone 15 Pro Max" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="retour_sn"><strong>SN</strong></label><input id="retour_sn" class="form-control" type="text" name="retour_sn" value="78524 498 6549 8" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="retour_emp"><strong>Employé</strong><br /></label><input id="retour_emp" class="form-control" type="text" name="retour_emp" value="Tantelison Odilon" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="retour_etat"><strong>Statut</strong></label><select id="retour_etat" class="form-select" name="retour_etat" readonly disabled>
                                            <option value="3" selected>Retourné</option>
                                        </select></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-danger" type="submit" form="form_retour_phone">Retourner</button></div>
        </div>
    </div>
</div>

@endsection

{{-- AJOUTER --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Champ "Nouvelle Marque"
        let enrPhoneMarque = document.getElementById('enr_phone_marque');
        let newMarqueInput = document.getElementById('new_phone_marque');
        if (enrPhoneMarque.value === 'new_marque' || {{ old('enr_phone_marque') == 'new_marque' ? 'true' : 'false' }}) {
            newMarqueInput.classList.remove('d-none');
        }
        enrPhoneMarque.addEventListener('change', function () {
            if (this.value === 'new_marque') {
                newMarqueInput.classList.remove('d-none');
            } else {
                newMarqueInput.classList.add('d-none');
            }
        });

        // Champ "Nouveau Modèle"
        let enrPhoneModele = document.getElementById('enr_phone_modele');
        let newModeleInput = document.getElementById('new_phone_modele');
        if (enrPhoneModele.value === 'new' || {{ old('enr_phone_modele') == 'new' ? 'true' : 'false' }}) {
            newModeleInput.classList.remove('d-none');
        }
        enrPhoneModele.addEventListener('change', function () {
            if (this.value === 'new') {
                newModeleInput.classList.remove('d-none');
            } else {
                newModeleInput.classList.add('d-none');
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->any())
            var modalEnrPhone = new bootstrap.Modal(document.getElementById('modal_enr_phone'));
            modalEnrPhone.show();
        @endif
    });
        // Si d'autres modals ont des erreurs, vous pouvez les gérer ici
    //     @if ($errors->hasBag('default') && $errors->getBag('default')->has('other_modal_errors'))
    //         var modalOther = new bootstrap.Modal(document.getElementById('modal_other'));
    //         modalOther.show();
    //     @endif
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Sélecteurs pour les champs concernés
        const typeSelect = document.getElementById("enr_phone_type");
        const enrollField = document.getElementById("enr_phone_enroll");
        const enrollDiv = enrollField.closest(".mb-3");

        // Fonction pour afficher/masquer le champ "Enrôlé" et définir la valeur par défaut
        function toggleEnrollField() {
            const selectedValue = typeSelect.value; // Récupère l'ID du type sélectionné

            if (selectedValue == 2) { // 2 correspond à "Téléphone à Touche"
                enrollDiv.style.display = "none"; // Masquer
                enrollField.value = "2"; // Définir la valeur sur "Non" (correspondant à l'option)
            } else {
                enrollDiv.style.display = ""; // Afficher
                enrollField.value = "0"; // Réinitialiser si nécessaire
            }
        }

        // Attacher l'écouteur d'événement
        typeSelect.addEventListener("change", toggleEnrollField);

        // Appeler une fois au chargement pour gérer une valeur pré-sélectionnée
        toggleEnrollField();
    });
</script>





{{-- HS --}}

<script>
 document.addEventListener('DOMContentLoaded', function () {
    // Sélectionne tous les liens ayant la classe "open-hs-modal"
    const openHSModalButtons = document.querySelectorAll('.open-hs-modal');
    
    openHSModalButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // Empêche le comportement par défaut du lien
            
            // Récupère les données des attributs "data-*" du lien
            const phoneId = this.dataset.phoneId; // ID du téléphone
            const phoneName = this.dataset.phoneName; // Nom du téléphone
            const phoneSN = this.dataset.phoneSn; // Numéro de série

            // Injecte les données dans les champs du formulaire
            document.getElementById('hs_phone_id').value = phoneId; // Champ caché pour l'ID
            document.getElementById('hs_phone').value = phoneName; // Champ texte pour le nom
            document.getElementById('sn_phone').value = phoneSN; // Champ texte pour le numéro de série

            // Affiche le modal
            const modalHSPhone = new bootstrap.Modal(document.getElementById('modal_hs_phone'));
            modalHSPhone.show();
        });
    });
});
</script>
