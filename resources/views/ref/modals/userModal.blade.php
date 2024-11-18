@extends('user')

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
                                        <input class="form-control mb-2" type="text" id="search-fonction" placeholder="Rechercher une fonction...">
                                        <select id="fonction-select" class="form-select @error('id_fonction') is-invalid @enderror" 
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
                <h4 class="modal-title text-danger">Voulez-vous vraiment supprimer cet utilisateur ?</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-dark">Matricule: <strong id="utilisateur_id"></strong></p>
                <p class="text-dark">Utilisateur: <strong id="utilisateur_nom"></strong></p>
                <p class="text-dark">Login: <strong id="utilisateur_login"></strong></p>
                <p class="text-dark">Type: <strong id="utilisateur_type"></strong></p>
                <p class="text-dark">Fonction: <strong id="utilisateur_fonction"></strong></p>
                <p class="text-dark">Chantier: <strong id="utilisateur_chantier"></strong></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button>
                <a href="#" id="confirm_delete_utilisateur" class="btn btn-danger">Supprimer</a>
            </div>
        </div>
    </div>
</div>

@endsection