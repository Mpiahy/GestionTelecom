<div id="modal_voir_ligne" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Plus d&#39;information pour cette ligne</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="dataTable-2" class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                    <table id="dataTable" class="table table-hover my-0">
                        <tbody>
                            <tr>
                                <th class="table-primary">Numéro d&#39;Appel</th>
                                <td class="text-dark">+261 49 599 53</td>
                            </tr>
                            <tr>
                                <th class="table-primary">Numéro SIM</th>
                                <td class="text-dark">1234567890123456789</td>
                            </tr>
                            <tr>
                                <th class="table-primary">Adresse IP</th>
                                <td class="text-dark">--</td>
                            </tr>
                            <tr>
                                <th class="table-primary">Type</th>
                                <td class="text-dark">Voix Mobile</td>
                            </tr>
                            <tr>
                                <th class="table-primary">Forfait</th>
                                <td class="text-dark">Forfait 0</td>
                            </tr>
                            <tr>
                                <th class="table-primary">Prix HT</th>
                                <td class="text-dark">19 764 Ar</td>
                            </tr>
                            <tr>
                                <th class="table-primary">Responsable</th>
                                <td class="text-dark">Randriamanivo Andriamahaleo Mpiahisoa</td>
                            </tr>
                            <tr>
                                <th class="table-primary">Localisation</th>
                                <td class="text-dark">Dépôt Anosibe</td>
                            </tr>
                            <tr>
                                <th class="table-primary">Date d&#39;affectation</th>
                                <td class="text-dark">25-10-2024</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button></div>
        </div>
    </div>
</div>
<div id="modal_edit_ligne" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Modifier cette ligne</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="form_edt_mobile" action="edit_mobile" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_ligne">
                                            <strong>Numéro d&#39;appel</strong></label>
                                            <input id="edt_ligne" class="form-control" type="text" name="edt_ligne" value="+261 34 49 599 53" readonly />
                                        </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_sim">
                                            <strong>Numéro SIM</strong>
                                        </label>
                                        <input id="edt_sim" class="form-control" type="text" name="edt_sim" value="64587932145698" readonly />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_operateur">
                                            <strong>Opérateur</strong>
                                        </label>
                                        <input id="edt_operateur" class="form-control" type="text" name="edt_operateur" value="TELMA" readonly />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_forfait">
                                            <strong>Forfait</strong>
                                        </label>
                                        <select id="edt_forfait" class="form-select" name="edt_forfait">
                                            <option value="0">Choisir le forfait</option>
                                            <option value="1" selected>Forfait 0</option>
                                            <option value="2">Forfait 1</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_resp">
                                            <strong>Responsable</strong>
                                        </label>
                                        <select id="edt_resp" class="form-select" name="edt_resp">
                                            <option value="0">Choisir le responsable</option>
                                            <option value="1" selected>Randriamanivo Andriamahaleo Mpiahisoa</option>
                                            <option value="2">Odilon</option>
                                            <option value="3">Mirindra</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_date">
                                            <strong>Date d&#39;affectation</strong>
                                        </label>
                                        <input id="edt_date" class="form-control" type="date" name="edt_date" />
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
                <button class="btn btn-primary" type="submit" form="form_edt_mobile">Modifier</button>
            </div>
        </div>
    </div>
</div>
<div id="modal_act_ligne" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Demande d'activation d'une ligne</h4>
                <button id="close_modal" class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="form_act_mobile" action="{{ route('ligne.save') }}" method="POST" style="color: #a0c8d8;">
                                    @csrf <!-- Protection CSRF -->
                                    <input type="hidden" id="enr_mailto" value="{{ session('enr_mailto') ? 'true' : 'false' }}">

                                    <!-- Numéro SIM -->
                                    <div class="mb-3">
                                        <label class="form-label" for="act_sim"><strong>Numéro SIM</strong></label>
                                        <input id="act_sim" class="form-control @error('act_sim', 'act_ligne_errors') is-invalid @enderror" 
                                            type="text" name="act_sim" placeholder="Numéro SIM" 
                                            value="{{ old('act_sim') }}" required />
                                        @error('act_sim', 'act_ligne_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Opérateur -->
                                    <div class="mb-3">
                                        <label class="form-label" for="act_operateur"><strong>Opérateur</strong></label>
                                        <select id="act_operateur" class="form-select @error('act_operateur', 'act_ligne_errors') is-invalid @enderror" 
                                                name="act_operateur" required>
                                            <option value="" disabled {{ old('act_operateur') ? '' : 'selected' }}>Choisir l'opérateur</option>
                                            @foreach ($contactsOperateurs as $contact)
                                                <option value="{{ $contact->id_operateur }}" data-email="{{ $contact->email }}"
                                                    {{ old('act_operateur') == $contact->id_operateur ? 'selected' : '' }}>
                                                    {{ $contact->operateur->nom_operateur }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('act_operateur', 'act_ligne_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Type -->
                                    <div class="mb-3">
                                        <label class="form-label" for="act_type"><strong>Type</strong></label>
                                        <select id="act_type" class="form-select @error('act_type', 'act_ligne_errors') is-invalid @enderror" 
                                                name="act_type" required>
                                            <option value="" disabled {{ old('act_type') ? '' : 'selected' }}>Choisir le type</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id_type_ligne }}"
                                                    {{ old('act_type') == $type->id_type_ligne ? 'selected' : '' }}>
                                                    {{ $type->type_ligne }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('act_type', 'act_ligne_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Forfait -->
                                    <div class="mb-3">
                                        <label class="form-label" for="act_forfait"><strong>Forfait</strong></label>
                                        <select id="act_forfait" class="form-select @error('act_forfait', 'act_ligne_errors') is-invalid @enderror" 
                                                name="act_forfait" {{ old('act_forfait') ? '' : 'disabled' }}>
                                            <option value="" disabled {{ old('act_forfait') ? '' : 'selected' }}>Choisir le forfait</option>
                                            @foreach ($forfaits as $forfait)
                                                <option value="{{ $forfait->id_forfait }}" 
                                                        data-id-operateur="{{ $forfait->id_operateur }}" 
                                                        data-id-type-forfait="{{ $forfait->id_type_forfait }}"
                                                    {{ old('act_forfait') == $forfait->id_forfait ? 'selected' : '' }}>
                                                    {{ $forfait->nom_forfait }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('act_forfait', 'act_ligne_errors')
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
                <button id="close_modal" class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button>
                <button id="btn_demander" class="btn btn-primary" type="submit" form="form_act_mobile" disabled>Demander</button>
            </div>
        </div>
    </div>
</div>
<div id="modal_enr_ligne" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Enregistrer une ligne</h4>
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
                                <form id="form_enr_ligne" action="{{ route('ligne.enr') }}" method="post" style="color: #a0c8d8;">
                                    @csrf
                                    <div class="mb-3">
                                        <input id="enr_id_ligne" class="form-control" type="hidden" name="enr_id_ligne" value="{{ old('enr_id_ligne') }}"/>
                                    </div>                                    
                                    <div class="mb-3">
                                        <label class="form-label" for="enr_sim">
                                            <strong>Numéro SIM</strong>
                                        </label>
                                        <input id="enr_sim" class="form-control" type="text" name="enr_sim" readonly value="{{ old('enr_sim') }}"/>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="enr_forfait">
                                            <strong>Forfait</strong>
                                        </label>
                                        <input id="enr_forfait" class="form-control" type="text" name="enr_forfait" readonly value="{{ old('enr_forfait') }}"/>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="enr_ligne">
                                            <strong>Numéro Ligne</strong>
                                        </label>
                                        <input id="enr_ligne" class="form-control @error('enr_ligne', 'enr_ligne_errors') is-invalid @enderror" 
                                               type="text" name="enr_ligne" placeholder="Entrer le numéro ligne" value="{{ old('enr_ligne') }}" />
                                        @error('enr_ligne', 'enr_ligne_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="enr_user">
                                            <strong>Utilisateur</strong>
                                        </label>
                                        <input id="search_enr_user" class="form-control mb-1" type="text" name="search_enr_user" placeholder="Rechercher un utilisateur" value="{{ old('search_enr_user') }}" />
                                        <div id="loadingSpinner" style="display: none;"><small>Recherche en cours...</small></div>
                                        <select id="enr_user" class="form-select @error('enr_user', 'enr_ligne_errors') is-invalid @enderror" name="enr_user">
                                            <option value="0" disabled {{ old('enr_user') ? '' : 'selected' }}>Choisir un utilisateur</option>
                                            @foreach ($utilisateurs as $utilisateur)
                                            <option value="{{ $utilisateur->matricule }}" {{ old('enr_user') == $utilisateur->matricule ? 'selected' : '' }}>
                                                {{ $utilisateur->nom }} {{ $utilisateur->prenom }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('enr_user', 'enr_ligne_errors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="enr_date">
                                            <strong>Date d&#39;affectation</strong>
                                        </label>
                                        <input id="enr_date" class="form-control @error('enr_date', 'enr_ligne_errors') is-invalid @enderror" 
                                               name="enr_date" type="date" value="{{ old('enr_date') }}" />
                                        @error('enr_date', 'enr_ligne_errors')
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
                <button class="btn btn-primary" type="submit" form="form_enr_ligne">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
<div id="modal_attr_ligne" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Attribuer une ligne</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-7">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="form_attr_mobile" action="attr_mobile" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3"><label class="form-label" for="attr_ligne"><strong>Numéro d&#39;appel</strong></label><input id="attr_ligne" class="form-control" type="text" name="attr_ligne" value="+261 32 59 599 53" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="attr_sim"><strong>Numéro SIM</strong></label><input id="attr_sim" class="form-control" type="text" name="attr_sim" value="98745632145698" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="attr_operateur"><strong>Opérateur</strong></label><input id="attr_operateur" class="form-control" type="text" name="attr_operateur" value="Orange" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="attr_type"><strong>Type</strong></label><input id="attr_type" class="form-control" type="text" name="attr_type" value="Internet mobile" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="attr_forfait"><strong>Forfait</strong></label><input id="attr_forfait" class="form-control" type="text" name="attr_forfait" value="Forfait 0" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="attr_resp"><strong>Responsable</strong></label><select id="attr_resp" class="form-select" name="attr_resp">
                                            <option value="0" selected>Choisir le responsable</option>
                                            <optgroup label="Dépôt Anosibe">
                                                <option value="1" selected>Randriamanivo Mpiahisoa</option>
                                                <option value="2">Razafindrasoava Mirindra</option>
                                            </optgroup>
                                            <optgroup label="DTAMA">
                                                <option value="3">Tantelison Odilon</option>
                                            </optgroup>
                                        </select></div>
                                    <div class="mb-3"><label class="form-label" for="attr_date"><strong>Date d&#39;affectation</strong></label><input id="attr_date" class="form-control" type="datetime-local" name="attr_date" /></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-primary" type="submit" form="form_attr_mobile">Attribuer</button></div>
        </div>
    </div>
</div>
<div id="modal_resil_ligne" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Demander la résiliation de cette ligne</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-7">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="form_resil_mobile" action="resil_mobile" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3"><label class="form-label" for="resil_ligne"><strong>Numéro d&#39;appel</strong></label><input id="resil_ligne" class="form-control" type="text" name="resil_ligne" value="+261 32 59 599 53" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="resil_sim"><strong>Numéro SIM</strong></label><input id="resil_sim" class="form-control" type="text" name="resil_sim" value="98745632145698" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="resil_operateur"><strong>Opérateur</strong></label><input id="resil_operateur" class="form-control" type="text" name="resil_operateur" value="Orange" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="resil_type"><strong>Type</strong></label><input id="resil_type" class="form-control" type="text" name="resil_type" value="Internet mobile" readonly /></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-danger" type="submit" form="form_resil_mobile">Résilier</button></div>
        </div>
    </div>
</div>
<div id="modal_react_ligne" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Demander la réactivation de cette ligne</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-7">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="form_resil_mobile-1" action="react_mobile" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3"><label class="form-label" for="react_ligne"><strong>Numéro Ligne</strong></label><input id="react_ligne" class="form-control" type="text" name="react_ligne" value="+261 32 65 466 32" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="react_sim"><strong>Numéro SIM</strong></label><input id="react_sim" class="form-control" type="text" name="react_sim" value="98745632145698" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="react_operateur"><strong>Opérateur</strong></label><input id="react_operateur" class="form-control" type="text" name="react_operateur" value="Orange" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="react_type"><strong>Type</strong></label><input id="react_type" class="form-control" type="text" name="react_type" value="Internet mobile" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="react_forfait"><strong>Forfait</strong></label><select id="react_forfait" class="form-select" name="react_forfait">
                                            <option value="0" selected>Choisir le forfait</option>
                                            <option value="1">Forfait 0</option>
                                            <option value="2">Forfait 1</option>
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
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-info" type="submit" form="form_resil_mobile">Réactiver</button></div>
        </div>
    </div>
</div>