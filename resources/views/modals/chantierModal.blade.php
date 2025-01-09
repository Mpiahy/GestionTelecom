<div id="ajouter_chantier" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Ajouter une localisation</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="add_lib_service" method="post" action="{{ route('ref.chantier.add') }}" style="color: #a0c8d8;">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="add_lib_service"><strong>Libellé Service</strong></label>
                                        <select id="add_lib_service" class="form-select" name="add_lib_service">
                                            <option value="0" selected disabled>Choisir Service</option>
                                            @foreach ($services as $service)
                                                <option value="{{$service->id_service}}">{{$service->libelle_service}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="add_lib_imp"><strong>Libellé Imputation</strong></label>
                                        <input required id="add_lib_imp" class="form-control" type="text" placeholder="Entrer le code imputation" name="add_lib_imp" />
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
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-primary" type="submit" form="add_lib_service">Ajouter</button></div>
        </div>
    </div>
</div>
<div id="supprimer_chantier" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-danger">Voulez vous vraiment supprimer cette localisation?</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-dark" style="margin-bottom: 0px;">Localisation: <strong></strong></p>
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
                <h4 class="modal-title text-primary">Modifier cette localisation</h4>
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
                                        <label class="form-label" for="edt_lib_service"><strong>Libellé Service</strong></label>
                                        <select id="edt_lib_service" class="form-select" name="edt_lib_service">
                                            <option value="0" disabled>Choisir Service</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id_service }}" {{ old('id_service') == $service->id_service ? 'selected' : '' }}">{{$service->libelle_service}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="edt_lib_imp"><strong>Code Imputation</strong></label>
                                        <input required id="edt_lib_imp" class="form-control" type="text" placeholder="Entrer le code imputation" name="edt_lib_imp" />
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