@extends('base/baseRef')
<head>
    <title>Utilisateurs - Telecom</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@section('content_ref')

<div class="container-fluid">
        <!-- Contenu principal -->
        <h3 class="text-dark" style="color: #0a4866;">
            <i class="fas fa-users" style="padding-right: 5px;"></i>Utilisateur
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
                                    <td class="text-center">{{ $utilisateur->matricule ?? 'N/A' }}</td>
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
                                            data-id="{{ $utilisateur->id_utilisateur }}"
                                            data-matricule="{{ $utilisateur->matricule }}"
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
                                            data-id="{{ $utilisateur->id_utilisateur }}"
                                            data-matricule="{{ $utilisateur->matricule }}"
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

    @include('modals.userModal')

@endsection

@section('scripts')

    @include('js.userJs')

@endsection