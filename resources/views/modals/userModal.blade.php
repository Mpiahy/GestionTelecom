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
                <h4 class="modal-title text-primary">Modifier cet utilisateur</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    <!-- id_utilisateur (caché pour ne pas être modifiable) -->
                                    <input type="hidden" id="edt_emp_id" name="id_edt" />

                                    <!-- Matricule -->
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_emp_matricule"><strong>Matricule</strong></label>
                                        <input id="edt_emp_matricule" class="form-control @error('matricule') is-invalid @enderror" type="text" name="matricule_edt" placeholder="Matricule de l'utilisateur" value="{{ old('matricule') }}" />
                                        @error('nom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <!-- Nom -->
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_emp_nom"><strong>Nom</strong></label>
                                        <input id="edt_emp_nom" class="form-control @error('nom') is-invalid @enderror" type="text" name="nom_edt" placeholder="Nom de l'utilisateur" value="{{ old('nom') }}" />
                                        @error('nom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Prénom -->
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_emp_prenom"><strong>Prénom(s)</strong></label>
                                        <input id="edt_emp_prenom" class="form-control @error('prenom') is-invalid @enderror" type="text" name="prenom_edt" placeholder="Prénom(s) de l'utilisateur" value="{{ old('prenom') }}" />
                                        @error('prenom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Login -->
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_emp_login"><strong>Login</strong></label>
                                        <input id="edt_emp_login" class="form-control @error('login') is-invalid @enderror" type="text" name="login_edt" placeholder="Login de l'utilisateur" value="{{ old('login') }}" />
                                        @error('login')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Type d'utilisateur -->
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_emp_type"><strong>Type</strong></label>
                                        <select id="edt_emp_type" class="form-select @error('id_type_utilisateur') is-invalid @enderror" name="id_type_utilisateur_edt">
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
                                        <label class="form-label" for="fonction-select"><strong>Fonction</strong></label>
                                        <input class="form-control mb-2" type="text" id="search-fonction" placeholder="Rechercher une fonction...">
                                        <select id="fonction-select" class="form-select @error('id_fonction') is-invalid @enderror" name="id_fonction_edt">
                                            <option value="0" disabled selected>Choisir une fonction</option>
                                            @foreach ($fonctions as $fonction)
                                                <option value="{{ $fonction->id_fonction }}" {{ old('id_fonction') == $fonction->id_fonction ? 'selected' : '' }}>
                                                    {{ $fonction->fonction }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="selected_fonction" id="selected_fonction_hidden" value="{{ old('id_fonction_edt') }}">
                                        @error('id_fonction')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Chantier -->
                                    <div class="mb-3">
                                        <label class="form-label" for="chantier-select"><strong>Chantier</strong></label>
                                        <input class="form-control mb-2" type="text" id="search-chantier" placeholder="Rechercher un chantier...">
                                        <select id="chantier-select" class="form-select @error('id_localisation') is-invalid @enderror" name="id_localisation_edt">
                                            <option value="0" disabled selected>Choisir un chantier</option>
                                            @foreach ($chantiers as $chantier)
                                                <option value="{{ $chantier->id_localisation }}" {{ old('id_localisation') == $chantier->id_localisation ? 'selected' : '' }}>
                                                    {{ $chantier->localisation }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="selected_chantier" id="selected_chantier_hidden" value="{{ old('id_localisation_edt') }}">
                                        @error('id_localisation')
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
                <button class="btn btn-warning" type="button" id="close-modal-edit" data-bs-dismiss="modal">Fermer</button>
                <button class="btn btn-primary" type="submit" form="edit_emp">Modifier</button>
            </div>
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
                                <form id="add_emp" action="{{ route('ajouter.utilisateur') }}" method="POST">
                                    @csrf <!-- Token CSRF pour la sécurité -->

                                    <!-- Champ Nom -->
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Nom</strong></label>
                                        <input
                                            class="form-control @error('nom_add') is-invalid @enderror"
                                            type="text"
                                            name="nom_add"
                                            placeholder="Nom de l'utilisateur"
                                            value="{{ old('nom_add') }}"
                                            required
                                        />
                                        @error('nom_add')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Champ Prénom -->
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Prénom(s)</strong></label>
                                        <input
                                            class="form-control @error('prenom_add') is-invalid @enderror"
                                            type="text"
                                            name="prenom_add"
                                            placeholder="Prénom(s) de l'utilisateur"
                                            value="{{ old('prenom_add') }}"
                                            required
                                        />
                                        @error('prenom_add')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Champ Login -->
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Login</strong></label>
                                        <input
                                            class="form-control @error('login_add') is-invalid @enderror"
                                            type="text"
                                            name="login_add"
                                            placeholder="Login de l'utilisateur"
                                            value="{{ old('login_add') }}"
                                            required
                                        />
                                        @error('login_add')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Champ Matricule -->
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Matricule</strong></label>
                                        <input
                                            class="form-control @error('matricule_add') is-invalid @enderror"
                                            type="number"
                                            name="matricule_add"
                                            placeholder="Matricule de l'utilisateur"
                                            value="{{ old('matricule_add') }}"
                                        />
                                        @error('matricule_add')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Type d'utilisateur -->
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Type</strong></label>
                                        <select class="form-select @error('id_type_utilisateur_add') is-invalid @enderror"
                                        name="id_type_utilisateur_add"
                                        required>
                                            <option value="" selected disabled>Type</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id_type_utilisateur }}" {{ old('id_type_utilisateur_add') == $type->id_type_utilisateur ? 'selected' : '' }}>
                                                    {{ $type->type_utilisateur }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_type_utilisateur_add')
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
                                            <option value="new" {{ old('id_fonction') == 'new' ? 'selected' : '' }}>Ajouter une nouvelle fonction</option>
                                            @foreach ($fonctions as $fonction)
                                                <option value="{{ $fonction->id_fonction }}" {{ old('id_fonction') == $fonction->id_fonction ? 'selected' : '' }}>
                                                    {{ $fonction->fonction }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="selected_fonction_add" id="selected_fonction_add_hidden" value="{{ old('id_fonction') }}">
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
                                            id="new_fonction"
                                            placeholder="Entrez une nouvelle fonction"
                                            value="{{ old('new_fonction') }}"
                                            {{ old('id_fonction') === 'new' ? 'required' : '' }}
                                        />
                                        @error('new_fonction')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Chantier -->
                                    <div class="mb-3">
                                        <label class="form-label" for="chantier-select-add"><strong>Chantier</strong></label>
                                        <input class="form-control mb-2" type="text" id="search-chantier-add" placeholder="Rechercher un chantier...">
                                        <select id="chantier-select-add" class="form-select @error('id_localisation_add') is-invalid @enderror" name="id_localisation_add" required>
                                            <option value="" selected disabled>Chantier</option>
                                            @foreach ($chantiers as $chantier)
                                                <option value="{{ $chantier->id_localisation }}" {{ old('id_localisation_add') == $chantier->id_localisation ? 'selected' : '' }}>
                                                    {{ $chantier->localisation }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="selected_chantier_add" id="selected_chantier_add_hidden" value="{{ old('id_localisation_add') }}">
                                        @error('id_localisation_add')
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
                <button class="btn btn-warning" type="button" id="close-modal-add" data-bs-dismiss="modal">Fermer</button>
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
                <p class="text-dark visually-hidden">Id: <strong id="utilisateur_id"></strong></p>
                <p class="text-dark">Utilisateur: <strong id="utilisateur_nom"></strong></p>
                <p class="text-dark">Matricule: <strong id="utilisateur_matricule"></strong></p>
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

{{-- ATTRIBUTION EQUIPEMENT --}}
<div id="modal_attribuer_equipement" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- En-tête du modal -->
            <div class="modal-header">
                <h4 class="modal-title text-primary">Attribuer un Équipement</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form id="form_attr_equipement" action="{{ route('ligne.attrEquipement') }}" method="post">
                    @csrf
                    <input id="id_utilisateur_attr" type="hidden" name="id_utilisateur_attr">
                    <!-- Informations sur l'utilisateur -->
                    <div class="mb-3">
                        <label for="login_attr" class="form-label">Login de l'utilisateur</label>
                        <input type="text" class="form-control" id="login_attr" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nom_prenom_attr" class="form-label">Nom et Prénom de l'utilisateur</label>
                        <input type="text" class="form-control" id="nom_prenom_attr" readonly>
                    </div>

                    <!-- Choix entre Téléphones ou Box -->
                    <div class="mb-3">
                        <label for="type_equipement_attr" class="form-label">Type d'Équipement</label>
                        <select class="form-select" id="type_equipement_attr" required>
                            <option value="" disabled selected>Choisir un type d'équipement</option>
                            <option value="phones">Téléphones</option>
                            <option value="box">Box</option>
                        </select>
                    </div>

                    <!-- Liste des équipements -->
                    <div class="mb-3">
                        <label for="equipement_attr" class="form-label">Équipement</label>
                        <input type="text" class="form-control mb-1" id="search-equipement-attr" placeholder="Rechercher un équipement...">
                        <select class="form-select" id="equipement_attr" required disabled name="id_equipement_attr">
                            <option value="" disabled selected>Choisir un équipement</option>
                        </select>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Annuler</button>
                <button id="btn_attribuer_equipement" class="btn btn-primary" form="form_attr_equipement" disabled>Attribuer</button>
            </div>
        </div>
    </div>
</div>
