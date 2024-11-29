<div id="modal_enr_box" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Enregistrer un box</h4>
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
                                <form id="form_enr_box" action="{{ route('box.enr') }}" method="post" style="color: #a0c8d8;">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="enr_box_type"><strong>Type</strong></label>
                                        <select id="enr_box_type" class="form-select @error('enr_box_type','enr_box_errors') is-invalid @enderror" name="enr_box_type" required>
                                            <option value="0" disabled {{ old('enr_box_type') ? '' : 'selected' }}>Choisir le type</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type->id_type_equipement }}"
                                                    {{ old('enr_box_type') == $type->id_type_equipement ? 'selected' : '' }}>
                                                    {{ $type->type_equipement }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('enr_box_type','enr_box_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="enr_box_marque"><strong>Marque</strong></label>
                                        <select id="enr_box_marque" class="form-select @error('enr_box_marque','enr_box_errors') is-invalid @enderror" name="enr_box_marque" required>
                                            <option value="0" disabled {{ old('enr_box_marque') ? '' : 'selected' }}>Choisir la marque</option>
                                            <option value="new_marque" {{ old('enr_box_marque') == 'new_marque' ? 'selected' : '' }}>Ajouter une nouvelle marque</option>
                                            @foreach($marques as $marque)
                                                <option value="{{ $marque->id_marque }}"
                                                    {{ old('enr_box_marque') == $marque->id_marque ? 'selected' : '' }}>
                                                    {{ $marque->marque }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('enr_box_marque','enr_box_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <!-- Champ pour nouvelle marque -->
                                        <input id="new_box_marque" class="form-control mt-2 d-none @error('new_box_marque','enr_box_errors') is-invalid @enderror" type="text" placeholder="Nouvelle marque" name="new_box_marque" value="{{ old('new_box_marque') }}" />
                                        @error('new_box_marque','enr_box_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="enr_box_modele"><strong>Modèle</strong></label>
                                        <select id="enr_box_modele" class="form-select @error('enr_box_modele','enr_box_errors') is-invalid @enderror" name="enr_box_modele" required>
                                            <option value="0" disabled {{ old('enr_box_modele') ? '' : 'selected' }}>Choisir le modèle</option>
                                            <option value="new" {{ old('enr_box_modele') == 'new' ? 'selected' : '' }}>Ajouter un nouveau modèle</option>
                                            @foreach($modeles as $modele)
                                                <option value="{{ $modele->id_modele }}" {{ old('enr_box_modele') == $modele->id_modele ? 'selected' : '' }}>
                                                    {{ $modele->nom_modele }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('enr_box_modele','enr_box_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <!-- Champ pour ajouter un nouveau modèle -->
                                        <input id="new_box_modele" class="form-control mt-2 d-none @error('new_box_modele','enr_box_errors') is-invalid @enderror"
                                               type="text"
                                               placeholder="Nouveau modèle"
                                               name="new_box_modele"
                                               value="{{ old('new_box_modele') }}" />
                                        @error('new_box_modele','enr_box_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="enr_box_imei"><strong>Imei</strong></label>
                                        <input id="enr_box_imei" class="form-control @error('enr_box_imei','enr_box_errors') is-invalid @enderror"
                                            type="text"
                                            placeholder="Entrer l'imei"
                                            name="enr_box_imei"
                                            value="{{ old('enr_box_imei') }}"
                                            required />
                                        @error('enr_box_imei','enr_box_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="enr_box_sn"><strong>Numéro de série</strong></label>
                                        <input id="enr_box_sn" class="form-control @error('enr_box_sn','enr_box_errors') is-invalid @enderror"
                                            type="text"
                                            placeholder="Entrer le numéro de série"
                                            name="enr_box_sn"
                                            value="{{ old('enr_box_sn') }}"
                                            required />
                                        @error('enr_box_sn','enr_box_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="enr_box_enroll"><strong>Enrôlé</strong></label>
                                        <select id="enr_box_enroll" class="form-select @error('enr_box_enroll','enr_box_errors') is-invalid @enderror" name="enr_box_enroll" required>
                                            <option value="0" disabled {{ old('enr_box_enroll') ? '' : 'selected' }}>Oui ou Non</option>
                                            <option value="1" {{ old('enr_box_enroll') == '1' ? 'selected' : '' }}>Oui</option>
                                            <option value="2" {{ old('enr_box_enroll') == '2' ? 'selected' : '' }}>Non</option>
                                        </select>
                                        @error('enr_box_enroll','enr_box_errors')
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
                <button class="btn btn-primary" type="submit" form="form_enr_box">Enregistrer</button></div>
        </div>
    </div>
</div>
<div id="modal_edt_box" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Modifier un box</h4>
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
                                <form id="form_edt_box" method="get" style="color: #a0c8d8;">
                                    <!-- Champs cachés pour transmettre les valeurs des champs désactivés -->
                                    <input type="hidden" id="edt_box_id" name="edt_box_id" value="">
                                    <input type="hidden" id="hidden_box_type" name="edt_box_type" value="">
                                    <input type="hidden" id="hidden_box_marque" name="edt_box_marque" value="">
                                    <input type="hidden" id="hidden_box_modele" name="edt_box_modele" value="">
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_box_type"><strong>Type</strong></label>
                                        <select disabled id="edt_box_type" class="form-select @error('edt_box_type','edt_box_errors') is-invalid @enderror" name="edt_box_type" required>
                                            <option value="0" disabled {{ old('edt_box_type') ? '' : 'selected' }}>Choisir le type</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type->id_type_equipement }}"
                                                    {{ old('edt_box_type') == $type->id_type_equipement ? 'selected' : '' }}>
                                                    {{ $type->type_equipement }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('edt_box_type','edt_box_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="edt_box_marque"><strong>Marque</strong></label>
                                        <select disabled id="edt_box_marque" class="form-select @error('edt_box_marque','edt_box_errors') is-invalid @enderror" name="edt_box_marque" required>
                                            <option value="0" disabled {{ old('edt_box_marque') ? '' : 'selected' }}>Choisir la marque</option>
                                            <option value="new_marque" {{ old('edt_box_marque') == 'new_marque' ? 'selected' : '' }}>Ajouter une nouvelle marque</option>
                                            @foreach($marques as $marque)
                                                <option value="{{ $marque->id_marque }}"
                                                    {{ old('edt_box_marque') == $marque->id_marque ? 'selected' : '' }}>
                                                    {{ $marque->marque }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('edt_box_marque','edt_box_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <!-- Champ pour nouvelle marque -->
                                        <input id="new_box_marque_edt" class="form-control mt-2 d-none @error('new_box_marque_edt','edt_box_errors') is-invalid @enderror" type="text" placeholder="Nouvelle marque" name="new_box_marque_edt" value="{{ old('new_box_marque_edt') }}" />
                                        @error('new_box_marque_edt','edt_box_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="edt_box_modele"><strong>Modèle</strong></label>
                                        <select disabled id="edt_box_modele" class="form-select @error('edt_box_modele','edt_box_errors') is-invalid @enderror" name="edt_box_modele" required>
                                            <option value="0" disabled {{ old('edt_box_modele') ? '' : 'selected' }}>Choisir le modèle</option>
                                            <option value="new" {{ old('edt_box_modele') == 'new' ? 'selected' : '' }}>Ajouter un nouveau modèle</option>
                                            @foreach($modeles as $modele)
                                                <option value="{{ $modele->id_modele }}" {{ old('edt_box_modele') == $modele->id_modele ? 'selected' : '' }}>
                                                    {{ $modele->nom_modele }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('edt_box_modele','edt_box_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <!-- Champ pour ajouter un nouveau modèle -->
                                        <input id="new_box_modele_edt" class="form-control mt-2 d-none @error('new_box_modele_edt','edt_box_errors') is-invalid @enderror"
                                               type="text"
                                               placeholder="Nouveau modèle"
                                               name="new_box_modele_edt"
                                               value="{{ old('new_box_modele_edt') }}" />
                                        @error('new_box_modele_edt','edt_box_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="edt_box_imei"><strong>Imei</strong></label>
                                        <input id="edt_box_imei" class="form-control @error('edt_box_imei','edt_box_errors') is-invalid @enderror"
                                            type="text"
                                            placeholder="Entrer l'imei"
                                            name="edt_box_imei"
                                            value="{{ old('edt_box_imei') }}"
                                            required />
                                        @error('edt_box_imei','edt_box_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="edt_box_sn"><strong>Numéro de série</strong></label>
                                        <input id="edt_box_sn" class="form-control @error('edt_box_sn','edt_box_errors') is-invalid @enderror"
                                            type="text"
                                            placeholder="Entrer le numéro de série"
                                            name="edt_box_sn"
                                            value="{{ old('edt_box_sn') }}"
                                            required />
                                        @error('edt_box_sn','edt_box_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="edt_box_enroll"><strong>Enrôlé</strong></label>
                                        <select id="edt_box_enroll" class="form-select @error('edt_box_enroll','edt_box_errors') is-invalid @enderror" name="edt_box_enroll" required>
                                            <option value="0" disabled {{ old('edt_box_enroll') ? '' : 'selected' }}>Oui ou Non</option>
                                            <option value="1" {{ old('edt_box_enroll') == '1' ? 'selected' : '' }}>Oui</option>
                                            <option value="2" {{ old('edt_box_enroll') == '2' ? 'selected' : '' }}>Non</option>
                                        </select>
                                        @error('edt_box_enroll','edt_box_errors')
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
                <button class="btn btn-info" type="submit" form="form_edt_box">Modifier</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_attr_box" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Attribuer un box</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-7">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="form_attr_box" action="attr_box" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3"><label class="form-label" for="attr_box"><strong>box</strong><br /></label><input id="attr_box" class="form-control" type="text" name="attr_box" value="ibox 15 Pro Max" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="attr_box"><strong>Numéro de série</strong><br /></label><input id="attr_box-1" class="form-control" type="text" name="attr_box_sn" value="14646354698" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="attr_box_emp"><strong>Utilisateur</strong></label><select id="attr_box_emp" class="form-select" name="attr_box_emp">
                                            <option value="0" selected>Choisir l&#39;utilsateur</option>
                                            <optgroup label="Dépôt Anosibe">
                                                <option value="1">Randriamanivo Mpiahisoa</option>
                                                <option value="2">Razafindrasoava Mirindra</option>
                                            </optgroup>
                                            <optgroup label="DTAMA">
                                                <option value="3">Tantelison Odilon</option>
                                            </optgroup>
                                        </select></div>
                                    <div class="mb-3"><label class="form-label" for="attr_box_date"><strong>Date d&#39;affectation</strong></label><input id="attr_box_date" class="form-control" type="date" name="attr_box_date" /></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-primary" type="submit" form="form_attr_box">Attribuer</button></div>
        </div>
    </div>
</div>
<div id="modal_histo_box" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Historique d&#39;affectation pour ce box</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-dark" style="margin-bottom: 0px;">box: <strong>ibox 15 Pro Max</strong></p>
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
<div id="modal_hs_box" class="modal" role="dialog" tabindex="-1">
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
                                <form id="form_hs_box" action="{{ route('box.hs') }}" method="post">
                                    @csrf
                                    <!-- Champ caché pour l'ID du box (utilisé par le backend) -->
                                    <input type="hidden" name="box_id" id="hs_box_id" value="">

                                    <div class="mb-3">
                                        <label class="form-label" for="hs_box"><strong>box</strong></label>
                                        <!-- Champ désactivé pour affichage uniquement -->
                                        <input id="hs_box" class="form-control" type="text" value="" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="sn_box"><strong>SN</strong></label>
                                        <!-- Champ désactivé pour affichage uniquement -->
                                        <input id="sn_box" class="form-control" type="text" value="" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="statut_box"><strong>Etat</strong></label>
                                        <select id="statut_box" class="form-select" readonly>
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
                <button class="btn btn-danger" type="submit" form="form_hs_box">Déclarer HS</button></div>
        </div>
    </div>
</div>
<div id="modal_retour_box" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-danger">Voulez-vous vraiment retourner ce box?</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-7">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="form_retour_box" action="retour_box" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3">
                                        <label class="form-label" for="retour_box"><strong>box</strong></label>
                                        <input id="retour_box" class="form-control" type="text" name="retour_box" value="ibox 15 Pro Max" readonly />
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
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-danger" type="submit" form="form_retour_box">Retourner</button></div>
        </div>
    </div>
</div>