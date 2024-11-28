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
                                            <option value="0" selected disabled>Choisir UE</option>
                                            @foreach ($ue as $ues)
                                                <option value="{{$ues->id_ue}}">{{$ues->libelle_ue}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="add_bu"><strong>Numéro BU</strong></label>
                                        <input required id="add_bu" class="form-control" type="text" placeholder="Entrer le numéro BU" name="add_bu" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="add_lib_service"><strong>Libellé Service</strong></label>
                                        <input required id="add_lib_service" class="form-control" type="text" placeholder="Entrer le libellé service" name="add_lib_service" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="add_code_imp"><strong>Code Imputation</strong></label>
                                        <input required id="add_code_imp" class="form-control" type="text" placeholder="Entrer le code imputation" name="add_code_imp" />
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
                <h4 class="modal-title text-danger">Voulez vous vraiment supprimer ce chantier?</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-dark" style="margin-bottom: 0px;">Chantier: <strong></strong></p>
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
                                            <option value="0" disabled>Choisir UE</option>
                                            @foreach ($ue as $ues)
                                                <option value="{{ $ues->id_ue }}">{{ $ues->libelle_ue }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_bu"><strong>Numéro BU</strong></label>
                                        <input required id="edt_bu" class="form-control" type="text" placeholder="Entrer le numéro BU" name="edt_bu" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_lib_service"><strong>Libellé Service</strong></label>
                                        <input required id="edt_lib_service" class="form-control" type="text" placeholder="Entrer le libellé service" name="edt_lib_service" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_code_imp"><strong>Code Imputation</strong></label>
                                        <input required id="edt_code_imp" class="form-control" type="text" placeholder="Entrer le code imputation" name="edt_code_imp" />
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