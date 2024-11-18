@extends('base/baseRef')
<head>
    <title>Utilisateurs - Telecom</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@section('content_ref')

    <div class="container-fluid">
        <!-- Section des Messages Flash -->
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

        <!-- Contenu principal -->
        <h3 class="text-dark" style="color: #0a4866;">
            <i class="fas fa-users" style="padding-right: 5px;"></i>Utilisateur
        </h3>
        <div class="text-center mb-4">
            <a class="btn btn-primary btn-icon-split" role="button" data-bs-target="#modal_add_emp" data-bs-toggle="modal">
                <span class="icon" style="padding-right: 12px;">
                    <i class="fas fa-plus-circle" style="padding-top: 5px;"></i>
                </span>
                <span class="text">Ajouter un utilisateur</span>
            </a>
        </div>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="m-0 fw-bold" style="color: #0a4866;">Gestion des utilisateurs</p>
            </div>
            <div class="card-body">
                <div class="row mt-2">
                    {{-- Rechercher par Chantier --}}
                    <div class="col">
                        <form action="{{ route('ref.user') }}" method="get">
                            <div class="input-group">
                                <span class="input-group-text">Chantier</span>
                                <input class="form-control" type="text" placeholder="Rechercher par Chantier" name="search_user_chantier" value="{{ request('search_user_chantier') }}" />
                                <input type="hidden" name="type" value="{{ request('type') }}"> <!-- Conserver le filtre actif par type -->
                                <button class="btn btn-primary" type="submit">Rechercher</button>
                            </div>
                        </form>
                    </div>
                    {{-- Rechercher par Login --}}
                    <div class="col">
                        <form action="{{ route('ref.user') }}" method="get">
                            <div class="input-group">
                                <span class="input-group-text">Login</span>
                                <input class="form-control" type="text" placeholder="Rechercher par Login" name="search_user_login" value="{{ request('search_user_login') }}" />
                                <input type="hidden" name="type" value="{{ request('type') }}"> <!-- Conserver le filtre actif par type -->
                                <button class="btn btn-primary" type="submit">Rechercher</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-2">
                    <!-- Filtres par type d'utilisateur -->
                    <div class="col">
                        <form id="filterForm" method="get" action="{{ route('ref.user') }}">
                            <div class="btn-group" role="group">
                                <!-- Bouton "Tous les utilisateurs" -->
                                <button class="btn btn-outline-primary {{ request('type') ? '' : 'active' }}" type="submit" name="type" value="">Tous</button>

                                <!-- Boutons pour les types d'utilisateurs -->
                                @foreach ($types as $type)
                                    <button 
                                        class="btn btn-outline-primary {{ request('type') == $type->type_utilisateur ? 'active' : '' }}" 
                                        type="submit" 
                                        name="type" 
                                        value="{{ $type->type_utilisateur }}">
                                        {{ $type->type_utilisateur }}
                                    </button>
                                @endforeach
                            </div>
                        </form>
                    </div>
                    {{-- Rechercher par nom et prénom --}}
                    <div class="col">
                        <form action="{{ route('ref.user') }}" method="get">
                            <div class="input-group">
                                <span class="input-group-text">Utilisateur</span>
                                <input class="form-control" type="text" placeholder="Rechercher par nom et prénom(s)" name="search_user_name" value="{{ request('search_user_name') }}" />
                                <input type="hidden" name="type" value="{{ request('type') }}"> <!-- Conserver le filtre actif par type -->
                                <button class="btn btn-primary" type="submit">Rechercher</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="dataTable-1" class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                    <table id="dataTable" class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th class="text-center">Matricule</th>
                                <th>Nom et Prénom(s)</th>
                                <th>Login</th>
                                <th>Type</th>
                                <th>Fonction</th>
                                <th>Chantier</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($utilisateurs as $utilisateur)
                                <tr class="utilisateur-row {{ strtolower($utilisateur->typeUtilisateur->type_utilisateur) }}">
                                    <td class="text-center">{{ $utilisateur->matricule }}</td>
                                    <td>{{ $utilisateur->nom }} {{ $utilisateur->prenom }}</td>
                                    <td>{{ $utilisateur->login }}</td>
                                    <td>{{ $utilisateur->typeUtilisateur->type_utilisateur ?? 'N/A' }}</td>
                                    <td>{{ $utilisateur->fonction->fonction ?? 'N/A' }}</td>
                                    <td>{{ $utilisateur->localisation->localisation ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <a href="#" style="margin-right: 10px;" data-bs-target="#modal_voir_emp" data-bs-toggle="modal" data-toggle="tooltip" title="Voir" class="text-decoration-none">
                                            <i class="fas fa-history text-primary" style="font-size: 25px;"></i>
                                        </a>
                                        <a href="#" 
                                            data-toggle="tooltip"
                                            title="Modifier"
                                            style="margin-right: 5px;"
                                            class="text-decoration-none edit-user-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modal_edit_emp"
                                            data-id="{{ $utilisateur->matricule }}"
                                            data-nom="{{ $utilisateur->nom }}"
                                            data-prenom="{{ $utilisateur->prenom }}"
                                            data-login="{{ $utilisateur->login }}"
                                            data-type="{{ $utilisateur->typeUtilisateur->id_type_utilisateur }}"
                                            data-fonction="{{ $utilisateur->fonction->id_fonction }}"
                                            data-chantier="{{ $utilisateur->localisation->id_localisation }}">
                                            <i class="far fa-edit text-warning" style="font-size: 25px;"></i>
                                        </a>
                                        <a href="#" 
                                            data-toggle="tooltip"
                                            title="Départ"
                                            data-bs-target="#supprimer_utilisateur" 
                                            data-bs-toggle="modal" 
                                            data-id="{{ $utilisateur->matricule }}" 
                                            data-name="{{ $utilisateur->nom }} {{ $utilisateur->prenom }}" 
                                            data-login="{{ $utilisateur->login }}"
                                            data-type="{{ $utilisateur->typeUtilisateur->type_utilisateur }}"
                                            data-fonction="{{ $utilisateur->fonction->fonction }}"
                                            data-chantier="{{ $utilisateur->localisation->localisation }}"
                                            class="open-delete-modal">
                                            <i class="fas fa-sign-out-alt text-danger" style="font-size: 25px;"></i>
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

<div id="modal_voir_emp" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Historique des affectations pour cet utilisateur</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-dark">Nom et prénom(s): <strong>Randriamanivo Mpiahisoa</strong></p>
                <div id="dataTable-2" class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                    <table id="dataTable" class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th class="text-center">Equipement</th>
                                <th>Type</th>
                                <th class="text-center">Ligne</th>
                                <th>Statut</th>
                                <th>Chantier</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">Marque + Modèle</td>
                                <td>Smartphone</td>
                                <td class="text-center">+261 34 49 599 53</td>
                                <td>Attribué</td>
                                <td>SGMAD</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button></div>
        </div>
    </div>
</div>
<div id="modal_edit_emp" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Modifier cet utilisateur</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="edit_emp" action="{{ route('modifier.utilisateur') }}" method="POST">
                                    @csrf
                                    <!-- Matricule (caché pour ne pas être modifiable) -->
                                    <input type="hidden" id="edt_emp_matricule" name="matricule" />
                                
                                    <!-- Nom -->
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_emp_nom"><strong>Nom</strong></label>
                                        <input id="edt_emp_nom" class="form-control" type="text" name="nom" placeholder="Nom de l'utilisateur" />
                                    </div>
                                
                                    <!-- Prénom -->
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_emp_prenom"><strong>Prénom(s)</strong></label>
                                        <input id="edt_emp_prenom" class="form-control" type="text" name="prenom" placeholder="Prénom(s) de l'utilisateur" />
                                    </div>
                                
                                    <!-- Login -->
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_emp_login"><strong>Login</strong></label>
                                        <input id="edt_emp_login" class="form-control" type="text" name="login" placeholder="Login de l'utilisateur" />
                                    </div>
                                
                                    <!-- Type d'utilisateur -->
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_emp_type"><strong>Type</strong></label>
                                        <select id="edt_emp_type" class="form-select" name="id_type_utilisateur">
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id_type_utilisateur }}">{{ $type->type_utilisateur }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                
                                    <!-- Fonction -->
                                    <div class="mb-3">
                                        <label class="form-label" for="fonction-select"><strong>Fonction</strong></label>
                                        <input class="form-control mb-2" type="text" id="search-fonction" placeholder="Rechercher une fonction...">
                                        <select id="fonction-select" class="form-select" name="id_fonction">
                                            @foreach ($fonctions as $fonction)
                                                <option value="{{ $fonction->id_fonction }}">{{ $fonction->fonction }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                
                                    <!-- Chantier -->
                                    <div class="mb-3">
                                        <label class="form-label" for="chantier-select"><strong>Chantier</strong></label>
                                        <input class="form-control mb-2" type="text" id="search-chantier" placeholder="Rechercher un chantier...">
                                        <select id="chantier-select" class="form-select" name="id_localisation">
                                            @foreach ($chantiers as $chantier)
                                                <option value="{{ $chantier->id_localisation }}">{{ $chantier->localisation }}</option>
                                            @endforeach
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
                <button class="btn btn-primary" type="submit" form="edit_emp">Modifier</button></div>
        </div>
    </div>
</div>
<div id="modal_add_emp" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Ajouter un nouvel utilisateur</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col"></div>
                    <div class="col-xl-8">
                        <div class="card shadow">
                            <div class="card-body">

                                <!-- Message global pour les erreurs -->
                                <div class="alert alert-danger" id="global-error-message" style="display: {{ $errors->any() ? 'block' : 'none' }}">
                                    Veuillez corriger les erreurs ci-dessous.
                                </div>

                                <form id="add_emp" action="{{ route('ajouter.utilisateur') }}" method="POST">
                                    @csrf <!-- Token CSRF pour la sécurité -->

                                    <!-- Champ Nom -->
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Nom</strong></label>
                                        <input 
                                            class="form-control @error('nom') is-invalid @enderror" 
                                            type="text" 
                                            name="nom" 
                                            placeholder="Nom de l'utilisateur" 
                                            value="{{ old('nom') }}" 
                                            required 
                                        />
                                        @error('nom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Champ Prénom -->
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Prénom(s)</strong></label>
                                        <input 
                                            class="form-control @error('prenom') is-invalid @enderror" 
                                            type="text" 
                                            name="prenom" 
                                            placeholder="Prénom(s) de l'utilisateur" 
                                            value="{{ old('prenom') }}" 
                                            required 
                                        />
                                        @error('prenom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Champ Login -->
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Login</strong></label>
                                        <input 
                                            class="form-control @error('login') is-invalid @enderror" 
                                            type="text" 
                                            name="login" 
                                            placeholder="Login de l'utilisateur" 
                                            value="{{ old('login') }}" 
                                            required 
                                        />
                                        @error('login')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Champ Matricule -->
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Matricule</strong></label>
                                        <input 
                                            class="form-control @error('matricule') is-invalid @enderror" 
                                            type="number" 
                                            name="matricule" 
                                            placeholder="Matricule de l'utilisateur" 
                                            value="{{ old('matricule') }}" 
                                            required 
                                        />
                                        @error('matricule')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Type d'utilisateur -->
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Type</strong></label>
                                        <select class="form-select @error('id_type_utilisateur') is-invalid @enderror" 
                                        name="id_type_utilisateur" 
                                        required>
                                            <option value="" selected disabled>Type</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id_type_utilisateur }}" {{ old('id_type_utilisateur') == $type->id_type_utilisateur ? 'selected' : '' }}>
                                                    {{ $type->type_utilisateur }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_type_utilisateur')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Fonction -->
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Fonction</strong></label>
                                        <input class="form-control mb-2" type="text" id="search-fonction-add" placeholder="Rechercher une fonction...">
                                        <select id="fonction-select-add" class="form-select @error('id_fonction') is-invalid @enderror" 
                                        name="id_fonction" 
                                        required>
                                            <option value="" selected disabled>Fonction</option>
                                            @foreach ($fonctions as $fonction)
                                                <option value="{{ $fonction->id_fonction }}" {{ old('id_fonction') == $fonction->id_fonction ? 'selected' : '' }}>
                                                    {{ $fonction->fonction }}
                                                </option>
                                            @endforeach
                                            <option value="new" {{ old('id_fonction') == 'new' ? 'selected' : '' }}>Ajouter une nouvelle fonction</option>
                                        </select>
                                        @error('id_fonction')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Champ pour nouvelle fonction -->
                                    <div class="mb-3" id="new-fonction-input" style="display: {{ old('id_fonction') === 'new' ? 'block' : 'none' }};">
                                        <label class="form-label"><strong>Nouvelle Fonction</strong></label>
                                        <input 
                                            class="form-control @error('new_fonction') is-invalid @enderror" 
                                            type="text" 
                                            name="new_fonction" 
                                            placeholder="Entrez une nouvelle fonction" 
                                            value="{{ old('new_fonction') }}" 
                                        />
                                        @error('new_fonction')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Chantier -->
                                    <div class="mb-3">
                                        <label class="form-label" for="chantier-select"><strong>Chantier</strong></label>
                                        <input class="form-control mb-2" type="text" id="search-chantier" placeholder="Rechercher un chantier...">
                                        <select id="chantier-select" class="form-select @error('id_localisation') is-invalid @enderror" name="id_localisation" required>
                                            <option value="" selected disabled>Chantier</option>
                                            @foreach ($chantiers as $chantier)
                                                <option value="{{ $chantier->id_localisation }}" {{ old('id_localisation') == $chantier->id_localisation ? 'selected' : '' }}>
                                                    {{ $chantier->localisation }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_localisation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button>
                <button class="btn btn-info" type="submit" form="add_emp">Ajouter</button>
            </div>
        </div>
    </div>
</div>

<div id="supprimer_utilisateur" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-danger">Départ d'un utilisateur ?</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-dark">Utilisateur: <strong id="utilisateur_nom"></strong></p>
                <p class="text-dark">Matricule: <strong id="utilisateur_id"></strong></p>
                <p class="text-dark">Login: <strong id="utilisateur_login"></strong></p>
                <p class="text-dark">Type: <strong id="utilisateur_type"></strong></p>
                <p class="text-dark">Fonction: <strong id="utilisateur_fonction"></strong></p>
                <p class="text-dark">Chantier: <strong id="utilisateur_chantier"></strong></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button>
                <a href="#" id="confirm_delete_utilisateur" class="btn btn-danger">Valider</a>
            </div>
        </div>
    </div>
</div>

{{-- FILTRE --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Gestionnaire unique pour les boutons de filtre (Délégation d'événement)
        const btnGroup = document.querySelector(".btn-group");
        const rows = document.querySelectorAll(".utilisateur-row");

        if (btnGroup) {
            btnGroup.addEventListener("click", function (event) {
                const button = event.target;
                if (button.classList.contains("btn")) {
                    // Supprimer l'état actif de tous les boutons
                    document.querySelectorAll(".btn-group .btn").forEach(btn => btn.classList.remove("active"));

                    // Ajouter l'état actif au bouton cliqué
                    button.classList.add("active");

                    // Récupérer le texte du bouton (filtre)
                    const filter = button.textContent.toLowerCase();

                    // Filtrer les lignes du tableau
                    rows.forEach(row => {
                        row.style.display =
                            (filter === "tout" || row.classList.contains(filter)) ? "" : "none";
                    });
                }
            });
        }
    });
</script>

{{-- MODIFIER --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Gestion des boutons "Modifier"
        const editButtons = document.querySelectorAll(".edit-user-btn");

        editButtons.forEach(button => {
            button.addEventListener("click", function () {
                // Récupérer les données utilisateur
                const userId = this.getAttribute("data-id");
                const userNom = this.getAttribute("data-nom");
                const userPrenom = this.getAttribute("data-prenom");
                const userLogin = this.getAttribute("data-login");
                const userType = this.getAttribute("data-type");
                const userFonction = this.getAttribute("data-fonction");
                const userChantier = this.getAttribute("data-chantier");

                // Vérifier que les champs existent avant de les modifier
                const fields = {
                    matricule: document.querySelector("#edt_emp_matricule"),
                    nom: document.querySelector("#edt_emp_nom"),
                    prenom: document.querySelector("#edt_emp_prenom"),
                    login: document.querySelector("#edt_emp_login"),
                    type: document.querySelector("#edt_emp_type"),
                    fonction: document.querySelector("#fonction-select"),
                    chantier: document.querySelector("#chantier-select"),
                };

                if (fields.matricule) fields.matricule.value = userId;
                if (fields.nom) fields.nom.value = userNom;
                if (fields.prenom) fields.prenom.value = userPrenom;
                if (fields.login) fields.login.value = userLogin;
                if (fields.type) fields.type.value = userType;
                if (fields.fonction) fields.fonction.value = userFonction;
                if (fields.chantier) fields.chantier.value = userChantier;
            });
        });
    });

    // Fonction générique pour le filtre dynamique
    function setupDynamicSearch(inputId, selectId) {
        const input = document.getElementById(inputId);
        const select = document.getElementById(selectId);

        if (input && select) {
            input.addEventListener("input", function () {
                const searchValue = this.value.toLowerCase();
                const options = select.options;

                for (let option of options) {
                    option.style.display = option.textContent.toLowerCase().includes(searchValue) ? "block" : "none";
                }
            });
        }
    }

    // Initialisation des filtres dynamiques
    document.addEventListener("DOMContentLoaded", function () {
        setupDynamicSearch("search-fonction", "fonction-select");
    });
</script>

{{-- SUPPRIMER --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll(".open-delete-modal");

        deleteButtons.forEach(button => {
            button.addEventListener("click", function () {
                // Récupérer les données utilisateur
                const id = this.getAttribute("data-id");
                const name = this.getAttribute("data-name");
                const login = this.getAttribute("data-login");
                const type = this.getAttribute("data-type");
                const fonction = this.getAttribute("data-fonction");
                const chantier = this.getAttribute("data-chantier");

                // Mettre à jour les champs de la modale
                const modal = {
                    nom: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_nom"),
                    id: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_id"),
                    login: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_login"),
                    type: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_type"),
                    fonction: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_fonction"),
                    chantier: document.querySelector("#supprimer_utilisateur .modal-body #utilisateur_chantier"),
                    confirmButton: document.querySelector("#supprimer_utilisateur .modal-footer #confirm_delete_utilisateur"),
                };

                if (modal.nom) modal.nom.textContent = name;
                if (modal.id) modal.id.textContent = id;
                if (modal.login) modal.login.textContent = login;
                if (modal.type) modal.type.textContent = type;
                if (modal.fonction) modal.fonction.textContent = fonction;
                if (modal.chantier) modal.chantier.textContent = chantier;

                // Mettre à jour l'URL du bouton "Supprimer"
                if (modal.confirmButton) modal.confirmButton.href = `/utilisateur/supprimer/${id}`;
            });
        });
    });
</script>

{{-- AJOUTER --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Afficher le modal si des erreurs existent
        @if ($errors->any())
            const modal = new bootstrap.Modal(document.getElementById("modal_add_emp"), { backdrop: "static" });
            modal.show();
        @endif

        // Afficher/masquer le champ "Nouvelle Fonction"
        const fonctionSelectAdd = document.getElementById("fonction-select-add");
        const newFonctionInput = document.getElementById("new-fonction-input");

        if (fonctionSelectAdd && newFonctionInput) {
            fonctionSelectAdd.addEventListener("change", function () {
                newFonctionInput.style.display = this.value === "new" ? "block" : "none";
            });
        }

        // Initialisation des filtres dynamiques pour les champs
        setupDynamicSearch("search-fonction-add", "fonction-select-add");
        setupDynamicSearch("search-chantier", "chantier-select");
    });
</script>

@endsection