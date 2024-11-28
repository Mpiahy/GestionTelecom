@extends('base/baseRef')
<head>
    <title>Téléphones - Telecom</title>
</head>


@section('content_ref')

<div class="container-fluid">
    <h3 class="text-dark mb-1">
        <i class="fas fa-phone-alt" style="padding-right: 6px;"></i>Téléphones</h3>
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

            <!-- Toast for Validation Errors -->
            @if ($errors->any())
                <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <strong>Veuillez corriger les erreurs suivantes :</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
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
                                <td>{{ $equipement->modele->marque->marque }}</td>
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
                                    <a class="text-decoration-none"
                                        style="margin-right: 10px;"
                                        data-bs-target="#modal_edt_phone"
                                        data-bs-toggle="modal"
                                        title="Modifier"
                                        href="#"
                                        data-id="{{ $equipement->id_equipement ?? '' }}"
                                        data-type="{{ $equipement->typeEquipement->id_type_equipement ?? '' }}"
                                        data-marque="{{ $equipement->modele->marque->id_marque ?? '' }}"
                                        data-modele="{{ $equipement->modele->id_modele ?? '' }}"
                                        data-imei="{{ $equipement->imei ?? '' }}"
                                        data-sn="{{ $equipement->serial_number ?? '' }}"
                                        data-enroll="{{ $equipement->enrole ? '1' : '2' }}">
                                        <i class="far fa-edit text-info" style="font-size: 25px;"></i>
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
                                        <select id="enr_phone_type" class="form-select @error('enr_phone_type','enr_phone_errors') is-invalid @enderror" name="enr_phone_type" required>
                                            <option value="0" disabled {{ old('enr_phone_type') ? '' : 'selected' }}>Choisir le type</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type->id_type_equipement }}"
                                                    {{ old('enr_phone_type') == $type->id_type_equipement ? 'selected' : '' }}>
                                                    {{ $type->type_equipement }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('enr_phone_type','enr_phone_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="enr_phone_marque"><strong>Marque</strong></label>
                                        <select id="enr_phone_marque" class="form-select @error('enr_phone_marque','enr_phone_errors') is-invalid @enderror" name="enr_phone_marque" required>
                                            <option value="0" disabled {{ old('enr_phone_marque') ? '' : 'selected' }}>Choisir la marque</option>
                                            <option value="new_marque" {{ old('enr_phone_marque') == 'new_marque' ? 'selected' : '' }}>Ajouter une nouvelle marque</option>
                                            @foreach($marques as $marque)
                                                <option value="{{ $marque->id_marque }}"
                                                    {{ old('enr_phone_marque') == $marque->id_marque ? 'selected' : '' }}>
                                                    {{ $marque->marque }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('enr_phone_marque','enr_phone_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <!-- Champ pour nouvelle marque -->
                                        <input id="new_phone_marque" class="form-control mt-2 d-none @error('new_phone_marque','enr_phone_errors') is-invalid @enderror" type="text" placeholder="Nouvelle marque" name="new_phone_marque" value="{{ old('new_phone_marque') }}" />
                                        @error('new_phone_marque','enr_phone_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="enr_phone_modele"><strong>Modèle</strong></label>
                                        <select id="enr_phone_modele" class="form-select @error('enr_phone_modele','enr_phone_errors') is-invalid @enderror" name="enr_phone_modele" required>
                                            <option value="0" disabled {{ old('enr_phone_modele') ? '' : 'selected' }}>Choisir le modèle</option>
                                            <option value="new" {{ old('enr_phone_modele') == 'new' ? 'selected' : '' }}>Ajouter un nouveau modèle</option>
                                            @foreach($modeles as $modele)
                                                <option value="{{ $modele->id_modele }}" {{ old('enr_phone_modele') == $modele->id_modele ? 'selected' : '' }}>
                                                    {{ $modele->nom_modele }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('enr_phone_modele','enr_phone_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <!-- Champ pour ajouter un nouveau modèle -->
                                        <input id="new_phone_modele" class="form-control mt-2 d-none @error('new_phone_modele','enr_phone_errors') is-invalid @enderror"
                                               type="text"
                                               placeholder="Nouveau modèle"
                                               name="new_phone_modele"
                                               value="{{ old('new_phone_modele') }}" />
                                        @error('new_phone_modele','enr_phone_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="enr_phone_imei"><strong>Imei</strong></label>
                                        <input id="enr_phone_imei" class="form-control @error('enr_phone_imei','enr_phone_errors') is-invalid @enderror"
                                            type="text"
                                            placeholder="Entrer l'imei"
                                            name="enr_phone_imei"
                                            value="{{ old('enr_phone_imei') }}"
                                            required />
                                        @error('enr_phone_imei','enr_phone_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="enr_phone_sn"><strong>Numéro de série</strong></label>
                                        <input id="enr_phone_sn" class="form-control @error('enr_phone_sn','enr_phone_errors') is-invalid @enderror"
                                            type="text"
                                            placeholder="Entrer le numéro de série"
                                            name="enr_phone_sn"
                                            value="{{ old('enr_phone_sn') }}"
                                            required />
                                        @error('enr_phone_sn','enr_phone_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="enr_phone_enroll"><strong>Enrôlé</strong></label>
                                        <select id="enr_phone_enroll" class="form-select @error('enr_phone_enroll','enr_phone_errors') is-invalid @enderror" name="enr_phone_enroll" required>
                                            <option value="0" disabled {{ old('enr_phone_enroll') ? '' : 'selected' }}>Oui ou Non</option>
                                            <option value="1" {{ old('enr_phone_enroll') == '1' ? 'selected' : '' }}>Oui</option>
                                            <option value="2" {{ old('enr_phone_enroll') == '2' ? 'selected' : '' }}>Non</option>
                                        </select>
                                        @error('enr_phone_enroll','enr_phone_errors')
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
<div id="modal_edt_phone" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Modifier un téléphone</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-7">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="form_edt_phone" method="get" style="color: #a0c8d8;">
                                    <!-- Champs cachés pour transmettre les valeurs des champs désactivés -->
                                    <input type="hidden" id="edt_phone_id" name="edt_phone_id" value="">
                                    <input type="hidden" id="hidden_phone_type" name="edt_phone_type" value="">
                                    <input type="hidden" id="hidden_phone_marque" name="edt_phone_marque" value="">
                                    <input type="hidden" id="hidden_phone_modele" name="edt_phone_modele" value="">
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_phone_type"><strong>Type</strong></label>
                                        <select disabled id="edt_phone_type" class="form-select @error('edt_phone_type','edt_phone_errors') is-invalid @enderror" name="edt_phone_type" required>
                                            <option value="0" disabled {{ old('edt_phone_type') ? '' : 'selected' }}>Choisir le type</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type->id_type_equipement }}"
                                                    {{ old('edt_phone_type') == $type->id_type_equipement ? 'selected' : '' }}>
                                                    {{ $type->type_equipement }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('edt_phone_type','edt_phone_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="edt_phone_marque"><strong>Marque</strong></label>
                                        <select disabled id="edt_phone_marque" class="form-select @error('edt_phone_marque','edt_phone_errors') is-invalid @enderror" name="edt_phone_marque" required>
                                            <option value="0" disabled {{ old('edt_phone_marque') ? '' : 'selected' }}>Choisir la marque</option>
                                            <option value="new_marque" {{ old('edt_phone_marque') == 'new_marque' ? 'selected' : '' }}>Ajouter une nouvelle marque</option>
                                            @foreach($marques as $marque)
                                                <option value="{{ $marque->id_marque }}"
                                                    {{ old('edt_phone_marque') == $marque->id_marque ? 'selected' : '' }}>
                                                    {{ $marque->marque }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('edt_phone_marque','edt_phone_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <!-- Champ pour nouvelle marque -->
                                        <input id="new_phone_marque_edt" class="form-control mt-2 d-none @error('new_phone_marque_edt','edt_phone_errors') is-invalid @enderror" type="text" placeholder="Nouvelle marque" name="new_phone_marque_edt" value="{{ old('new_phone_marque_edt') }}" />
                                        @error('new_phone_marque_edt','edt_phone_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="edt_phone_modele"><strong>Modèle</strong></label>
                                        <select disabled id="edt_phone_modele" class="form-select @error('edt_phone_modele','edt_phone_errors') is-invalid @enderror" name="edt_phone_modele" required>
                                            <option value="0" disabled {{ old('edt_phone_modele') ? '' : 'selected' }}>Choisir le modèle</option>
                                            <option value="new" {{ old('edt_phone_modele') == 'new' ? 'selected' : '' }}>Ajouter un nouveau modèle</option>
                                            @foreach($modeles as $modele)
                                                <option value="{{ $modele->id_modele }}" {{ old('edt_phone_modele') == $modele->id_modele ? 'selected' : '' }}>
                                                    {{ $modele->nom_modele }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('edt_phone_modele','edt_phone_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <!-- Champ pour ajouter un nouveau modèle -->
                                        <input id="new_phone_modele_edt" class="form-control mt-2 d-none @error('new_phone_modele_edt','edt_phone_errors') is-invalid @enderror"
                                               type="text"
                                               placeholder="Nouveau modèle"
                                               name="new_phone_modele_edt"
                                               value="{{ old('new_phone_modele_edt') }}" />
                                        @error('new_phone_modele_edt','edt_phone_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="edt_phone_imei"><strong>Imei</strong></label>
                                        <input id="edt_phone_imei" class="form-control @error('edt_phone_imei','edt_phone_errors') is-invalid @enderror"
                                            type="text"
                                            placeholder="Entrer l'imei"
                                            name="edt_phone_imei"
                                            value="{{ old('edt_phone_imei') }}"
                                            required />
                                        @error('edt_phone_imei','edt_phone_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="edt_phone_sn"><strong>Numéro de série</strong></label>
                                        <input id="edt_phone_sn" class="form-control @error('edt_phone_sn','edt_phone_errors') is-invalid @enderror"
                                            type="text"
                                            placeholder="Entrer le numéro de série"
                                            name="edt_phone_sn"
                                            value="{{ old('edt_phone_sn') }}"
                                            required />
                                        @error('edt_phone_sn','edt_phone_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="edt_phone_enroll"><strong>Enrôlé</strong></label>
                                        <select id="edt_phone_enroll" class="form-select @error('edt_phone_enroll','edt_phone_errors') is-invalid @enderror" name="edt_phone_enroll" required>
                                            <option value="0" disabled {{ old('edt_phone_enroll') ? '' : 'selected' }}>Oui ou Non</option>
                                            <option value="1" {{ old('edt_phone_enroll') == '1' ? 'selected' : '' }}>Oui</option>
                                            <option value="2" {{ old('edt_phone_enroll') == '2' ? 'selected' : '' }}>Non</option>
                                        </select>
                                        @error('edt_phone_enroll','edt_phone_errors')
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
                <button class="btn btn-info" type="submit" form="form_edt_phone">Modifier</button>
            </div>
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
                                    <div class="mb-3">
                                        <label class="form-label" for="retour_phone"><strong>Téléphone</strong></label>
                                        <input id="retour_phone" class="form-control" type="text" name="retour_phone" value="iPhone 15 Pro Max" readonly />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="retour_sn"><strong>SN</strong></label>
                                        <input id="retour_sn" class="form-control" type="text" name="retour_sn" value="78524 498 6549 8" readonly />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="retour_emp"><strong>Employé</strong></label>
                                        <input id="retour_emp" class="form-control" type="text" name="retour_emp" value="Tantelison Odilon" readonly />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="retour_etat"><strong>Statut</strong></label>
                                        <select id="retour_etat" class="form-select" name="retour_etat" readonly disabled>
                                            <option value="3" selected>Retourné</option>
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
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-danger" type="submit" form="form_retour_phone">Retourner</button></div>
        </div>
    </div>
</div>

@endsection

{{-- ENR --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialisation des éléments du formulaire
        const enrPhoneType = document.getElementById('enr_phone_type');
        const enrPhoneMarque = document.getElementById('enr_phone_marque');
        const newMarqueInput = document.getElementById('new_phone_marque');
        const enrPhoneModele = document.getElementById('enr_phone_modele');
        const newModeleInput = document.getElementById('new_phone_modele');
        const enrPhoneEnroll = document.getElementById('enr_phone_enroll');
        const enrPhoneEnrollDiv = enrPhoneEnroll.closest('.mb-3'); // Conteneur du champ "Enrôlé"

        // Affiche ou masque le champ "Nouvelle Marque"
        function toggleNewMarqueInput() {
            if (enrPhoneMarque.value === 'new_marque') {
                newMarqueInput.classList.remove('d-none');
                populateNewModeleOption(); // Ajoute automatiquement "Ajouter un nouveau modèle"
            } else {
                newMarqueInput.classList.add('d-none');
                newMarqueInput.value = ''; // Réinitialise le champ
            }
        }

        // Affiche ou masque le champ "Nouveau Modèle"
        function toggleNewModeleInput() {
            if (enrPhoneModele.value === 'new') {
                newModeleInput.classList.remove('d-none');
            } else {
                newModeleInput.classList.add('d-none');
                newModeleInput.value = ''; // Réinitialise le champ
            }
        }

        // Affiche ou masque le champ "Enrôlé" en fonction du type d'équipement
        function togglePhoneEnroll() {
            if (enrPhoneType.value === '2') { // Téléphone à touche
                enrPhoneEnrollDiv.classList.add('d-none');
                enrPhoneEnroll.value = '2'; // Définit la valeur par défaut à "Non"
            } else {
                enrPhoneEnrollDiv.classList.remove('d-none');
                enrPhoneEnroll.value = '0'; // Réinitialise la valeur par défaut
            }
        }

        // Réinitialise un champ <select> avec une option par défaut
        function resetSelect(selectElement, defaultOptionText) {
            selectElement.innerHTML = `<option value="0" disabled selected>${defaultOptionText}</option>`;
        }

        // Remplit un champ <select> avec des options dynamiques, en conservant l'option "new" ou "new_marque"
        function populateSelect(selectElement, items, newItemValue, newItemText) {
            if (newItemValue && newItemText) {
                selectElement.insertAdjacentHTML('beforeend', `<option value="${newItemValue}">${newItemText}</option>`);
            }
            items.forEach(item => {
                selectElement.insertAdjacentHTML('beforeend', `<option value="${item.id}">${item.name}</option>`);
            });
        }

        // Ajoute l'option "Ajouter un nouveau modèle" et la sélectionne automatiquement
        function populateNewModeleOption() {
            resetSelect(enrPhoneModele, 'Choisir le modèle');
            enrPhoneModele.insertAdjacentHTML('beforeend', `<option value="new">Ajouter un nouveau modèle</option>`);
            enrPhoneModele.value = 'new';
            toggleNewModeleInput(); // Affiche le champ "Nouveau Modèle"
        }

        // Gère les changements de type d'équipement
        enrPhoneType.addEventListener('change', function () {
            const typeId = this.value;
            resetSelect(enrPhoneMarque, 'Choisir la marque');
            resetSelect(enrPhoneModele, 'Choisir le modèle');
            togglePhoneEnroll();

            if (typeId) {
                fetch(`/get-marques-by-type/${typeId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            populateSelect(enrPhoneMarque, data.marques, 'new_marque', 'Ajouter une nouvelle marque');
                        }
                    })
                    .catch(error => console.error('Erreur lors de la récupération des marques :', error));
            }
        });

        // Gère les changements de marque
        enrPhoneMarque.addEventListener('change', function () {
            const marqueId = this.value;
            resetSelect(enrPhoneModele, 'Choisir le modèle');
            toggleNewMarqueInput();

            if (marqueId && marqueId !== 'new_marque') {
                fetch(`/get-modeles-by-marque/${marqueId}`)
                    .then(response => response.json())
                    .then(data => {
                        populateSelect(enrPhoneModele, data.modeles, 'new', 'Ajouter un nouveau modèle');
                    })
                    .catch(error => console.error('Erreur lors de la récupération des modèles :', error));
            }
        });

        // Gère les changements de modèle
        enrPhoneModele.addEventListener('change', function () {
            toggleNewModeleInput();
        });

        // Gère l'affichage initial (au cas où des champs seraient pré-sélectionnés)
        toggleNewMarqueInput();
        toggleNewModeleInput();
        togglePhoneEnroll();

        // Affiche le modal en cas d'erreurs de validation
        @if ($errors->hasBag('enr_phone_errors'))
            var modalEnrPhone = new bootstrap.Modal(document.getElementById('modal_enr_phone'));
            modalEnrPhone.show();
        @endif
    });
</script>


{{-- EDIT --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        setupEditButtonListeners();
        reopenModalOnValidationError();
    });

    /**
     * Initialise les événements pour les boutons "Éditer".
     */
    function setupEditButtonListeners() {
        const editButtons = document.querySelectorAll('[data-bs-target="#modal_edt_phone"]');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = document.getElementById('form_edt_phone');

                // Injecte les données dynamiques dans le formulaire
                injectDataIntoForm(form, this);

                // Met à jour l'action du formulaire
                const id = this.getAttribute('data-id');
                form.action = `/phones/${id}`;

                // Gère l'affichage du champ "Enrôlé"
                togglePhoneEnroll(this.getAttribute('data-type'), this.getAttribute('data-enroll'));
            });
        });
    }

    /**
     * Injecte les données dynamiques dans le formulaire d'édition.
     * @param {HTMLElement} form - Le formulaire cible.
     * @param {HTMLElement} button - Le bouton contenant les données.
     */
    function injectDataIntoForm(form, button) {
        const fields = [
            { id: 'edt_phone_id', data: 'data-id' },
            { id: 'edt_phone_type', data: 'data-type' },
            { id: 'edt_phone_marque', data: 'data-marque' },
            { id: 'edt_phone_modele', data: 'data-modele' },
            { id: 'edt_phone_imei', data: 'data-imei' },
            { id: 'edt_phone_sn', data: 'data-sn' },
            { id: 'edt_phone_enroll', data: 'data-enroll' },
        ];

        fields.forEach(field => {
            const element = document.getElementById(field.id);
            if (element) {
                element.value = button.getAttribute(field.data);
            }
        });

        syncDisabledFieldsWithHiddenInputs(button);
    }

    /**
     * Synchronise les champs désactivés avec leurs champs cachés correspondants.
     * @param {HTMLElement} button - Bouton contenant les données.
     */
    function syncDisabledFieldsWithHiddenInputs(button) {
        const hiddenFields = [
            { hiddenId: 'hidden_phone_type', data: 'data-type' },
            { hiddenId: 'hidden_phone_marque', data: 'data-marque' },
            { hiddenId: 'hidden_phone_modele', data: 'data-modele' },
        ];

        hiddenFields.forEach(field => {
            const hiddenElement = document.getElementById(field.hiddenId);
            if (hiddenElement) {
                hiddenElement.value = button.getAttribute(field.data);
            }
        });
    }

    /**
     * Gère l'affichage du champ "Enrôlé" selon le type d'équipement.
     * @param {string} typeId - Type d'équipement.
     * @param {string} enrollValue - Valeur "Enrôlé".
     */
    function togglePhoneEnroll(typeId, enrollValue) {
        const edtPhoneEnroll = document.getElementById('edt_phone_enroll');
        const edtPhoneEnrollDiv = edtPhoneEnroll.closest('.mb-3');

        if (typeId === '2') {
            edtPhoneEnrollDiv.classList.add('d-none');
            edtPhoneEnroll.value = '2';
        } else {
            edtPhoneEnrollDiv.classList.remove('d-none');
            edtPhoneEnroll.value = enrollValue || '0';
        }
    }

    /**
     * Rouvre le modal en cas d'erreur de validation.
     */
    function reopenModalOnValidationError() {
        @if ($errors->hasBag('edt_phone_errors'))
            const modalEdtPhone = new bootstrap.Modal(document.getElementById('modal_edt_phone'));
            modalEdtPhone.show();
        @endif
    }
</script>


{{-- HS --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openHSModalButtons = document.querySelectorAll('.open-hs-modal');

        openHSModalButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Empêche l'action par défaut

                // Récupère les données dynamiques
                const phoneId = this.dataset.phoneId;
                const phoneName = this.dataset.phoneName;
                const phoneSN = this.dataset.phoneSn;

                // Injecte les données dans le formulaire
                document.getElementById('hs_phone_id').value = phoneId;
                document.getElementById('hs_phone').value = phoneName;
                document.getElementById('sn_phone').value = phoneSN;

                // Affiche le modal
                const modalHSPhone = new bootstrap.Modal(document.getElementById('modal_hs_phone'));
                modalHSPhone.show();
            });
        });
    });
</script>
