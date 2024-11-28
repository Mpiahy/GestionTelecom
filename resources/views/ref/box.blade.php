@extends('base/baseRef')
<head>
    <title>Box - Telecom</title>
</head>

@section('content_ref')

<div class="container-fluid">
    <h3 class="text-dark mb-1"><i class="fas fa-wifi" style="padding-right: 6px;"></i>BOX Internet</h3>
    <div class="text-center mb-4">
        <a class="btn btn-primary btn-icon-split" role="button" data-bs-target="#modal_enr_box" data-bs-toggle="modal" href="#">
            <span class="icon"><i class="fas fa-plus-circle"></i></span><span class="text">Enregistrer un box</span>
        </a>
    </div>
    <div class="card shadow">
        <div class="card-header py-3">
            <p class="m-0 fw-bold" style="color: #0a4866;">Gestion des box</p>
        </div>
        <div class="card-body">
            <div class="row mt-2">
                <div class="col">
                    <form method="get" action="{{ route('ref.box') }}">
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
                    <form action="search_box_user">
                        <div class="input-group">
                            <span class="input-group-text">Utilisateur</span>
                            <input class="form-control" type="text" placeholder="Rechercher par Utilisateur" name="search_box_user" />
                            <button class="btn btn-primary" type="button">Rechercher</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <div></div>
                </div>
                <div class="col">
                    <form action="search_box_imei">
                        <div class="input-group">
                            <span class="input-group-text">IMEI</span>
                            <input class="form-control" type="text" placeholder="Rechercher par Imei" name="search_box_imei" />
                            <button class="btn btn-primary" type="button">Rechercher</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-xl-6">
                    <div class="btn-group" role="group">
                        <button class="btn btn-outline-primary active" type="button" style="margin-right: 0px;">Tout</button>
                        <button class="btn btn-outline-info" type="button">Nouveau</button>
                        <button class="btn btn-outline-success" type="button">Attribué</button>
                        <button class="btn btn-outline-warning" type="button">Retourné</button>
                        <button class="btn btn-outline-danger" type="button">HS</button>
                    </div>
                </div>
                <div class="col-xl-6">
                    <form action="search_box_sn">
                        <div class="input-group">
                            <span class="input-group-text">SN</span>
                            <input class="form-control" type="text" placeholder="Rechercher par Numéro de série" name="search_box_sn" />
                            <button class="btn btn-primary" type="button">Rechercher</button>
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
                            <th>Imei</th>
                            <th>Serial Number</th>
                            <th>Responsable</th>
                            <th>Localisation</th>
                            <th>Etat</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Huawei</td>
                            <td>B612</td>
                            <td>7824553867</td>
                            <td>278GD36GH3678</td>
                            <td><a class="text-decoration-none" href="#">Randriamanivo Andriamahaleo Mpiahisoa</a></td>
                            <td>Service Info SGMAD</td>
                            <td>Attribué</td>
                            <td class="text-center">
                                <a class="text-decoration-none" style="margin-right: 10px;" data-bs-target="#modal_attr_box" data-bs-toggle="modal" data-toggle="tootlip" title="Attribuer" href="#">
                                    <i class="fas fa-bars text-success" style="font-size: 25px;"></i>
                                </a>
                                <a class="text-decoration-none" style="margin-right: 10px;" data-bs-target="#modal_edt_box" data-bs-toggle="modal" data-toggle="tootlip" title="Modifier" href="#">
                                    <i class="far fa-edit text-info" style="font-size: 25px;"></i>
                                </a>
                                <a class="text-decoration-none" data-bs-target="#modal_histo_box" data-bs-toggle="modal" data-toggle="tooltip" title="Historique" href="#" style="margin-right: 10px;">
                                    <i class="fas fa-history text-primary" style="font-size: 25px;"></i>
                                </a>
                                <a class="text-decoration-none" data-bs-target="#modal_hs_box" data-bs-toggle="modal" data-toggle="tooltip" title="Déclarer HS" href="#">
                                    <i class="far fa-times-circle text-danger" style="font-size: 25px;"></i>
                                </a>
                                <a class="text-decoration-none" data-bs-target="#modal_retour_box" data-bs-toggle="modal" data-toggle="tooltip" title="Retourner" href="#" style="margin-left: 10px;">
                                    <i class="fas fa-undo text-warning" style="font-size: 25px;"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('modal_ref')

<div id="modal_enr_box" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Modifier un box</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="form_edt_box" action="edt_box" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3"><label class="form-label" for="edt_box_marque"><strong>Marque</strong></label><select id="edt_box_marque" class="form-select" name="edt_box_marque" required>
                                            <option value="0" selected>Choisir la marque</option>
                                            <option value="2">Huawei</option>
                                        </select></div>
                                    <div class="mb-3"><label class="form-label" for="edt_box_modele"><strong>Modèle</strong></label><select id="edt_box_modele" class="form-select" name="edt_box_modele" required>
                                            <option value="0" selected>Choisir le modèle</option>
                                            <option value="1">A05</option>
                                            <option value="2">15 Pro Max</option>
                                        </select></div>
                                    <div class="mb-3"><label class="form-label" for="edt_box_imei"><strong>Imei</strong></label><input id="edt_box_imei" class="form-control" type="text" placeholder="Entrer l&#39;imei" name="edt_box_imei" required /></div>
                                    <div class="mb-3"><label class="form-label" for="edt_box_sn"><strong>Numéro de série</strong></label><input id="edt_box_sn" class="form-control" type="text" placeholder="Entrer le numéro de série" name="edt_box_sn" required /></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-info" type="submit" form="form_edt_box">Modifier</button></div>
        </div>
    </div>
</div>
<div id="modal_edt_box" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Enregistrer un box</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="form_enr_box-1" action="enr_box" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3"><label class="form-label" for="enr_box_marque"><strong>Marque</strong></label><select id="enr_box_marque-1" class="form-select" name="enr_box_marque" required>
                                            <option value="0" selected>Choisir la marque</option>
                                            <option value="2">Huawei</option>
                                        </select></div>
                                    <div class="mb-3"><label class="form-label" for="enr_box_modele"><strong>Modèle</strong></label><select id="enr_box_modele-1" class="form-select" name="enr_box_modele" required>
                                            <option value="0" selected>Choisir le modèle</option>
                                            <option value="1">A05</option>
                                            <option value="2">15 Pro Max</option>
                                        </select></div>
                                    <div class="mb-3"><label class="form-label" for="enr_box_imei"><strong>Imei</strong></label><input id="enr_box_imei-1" class="form-control" type="text" placeholder="Entrer l&#39;imei" name="enr_box_imei" required /></div>
                                    <div class="mb-3"><label class="form-label" for="enr_box_sn"><strong>Numéro de série</strong></label><input id="enr_box_sn-1" class="form-control" type="text" placeholder="Entrer le numéro de série" name="enr_box_sn" required /></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-primary" type="submit" form="form_enr_box">Enregistrer</button></div>
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
                                    <div class="mb-3"><label class="form-label" for="attr_box"><strong>Box</strong><br /></label><input id="attr_box" class="form-control" type="text" name="attr_box" value="Huawei B612" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="attr_box_sn"><strong>Numéro de série</strong><br /></label><input id="attr_box_sn" class="form-control" type="text" name="attr_box_sn" value="36546586978" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="attr_box_ue"><strong>Localisation</strong></label><select id="attr_box_ue" class="form-select" name="attr_box_ue">
                                            <option value="0" selected>Choisir une localisation</option>
                                            <optgroup label="Dépôt Anosibe"></optgroup>
                                            <optgroup label="DTAMA"></optgroup>
                                        </select></div>
                                    <div class="mb-3"><label class="form-label" for="attr_box_emp"><strong>Employé</strong></label><select id="attr_phone_emp-1" class="form-select" name="attr_box_emp">
                                            <option value="0" selected>Choisir le responsable</option>
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
                <p class="text-dark" style="margin-bottom: 0px;">Box: <strong>Huawei B612</strong></p>
                <p class="text-dark">SN: <strong>321 54982 543</strong></p>
                <div id="dataTable-2" class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                    <table id="dataTable" class="table table-hover my-0">
                        <tbody>
                            <tr>
                                <th class="table-primary">Employé</th>
                                <th class="table-primary">Localisation</th>
                                <th class="table-primary text-dark">Date d&#39;affectation</th>
                                <th class="table-primary">Date de retour</th>
                            </tr>
                            <tr>
                                <td class="text-dark">Tantelison Odilon</td>
                                <td class="text-dark">SGMAD</td>
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
                <p class="text-dark" style="margin-bottom: 0px;">Box: <strong>Huawei B612</strong></p>
                <p class="text-dark" style="margin-bottom: 0px;">SN: <strong>564 65498 65498</strong></p>
                <div class="row visually-hidden">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-7">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="form_hs_box" action="hs_box" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3"><label class="form-label" for="hs_box"><strong>Box</strong><br /></label><input id="hs_box" class="form-control" type="text" name="hs_box" value="Huawei B612" readonly disabled /></div>
                                    <div class="mb-3"><label class="form-label" for="hs_sn_box"><strong>SN</strong></label><input id="hs_sn_box" class="form-control" type="text" name="hs_sn_box" value="78524 498 6549 8" readonly disabled /></div>
                                    <div class="mb-3"><label class="form-label" for="hs_etat_box"><strong>Etat</strong></label><select id="hs_etat_box" class="form-select" name="hs_etat_box" readonly disabled>
                                            <option value="3" selected>HS</option>
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
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><a class="btn btn-danger" role="button" form="form_hs_box">Déclarer HS</a></div>
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
                                    <div class="mb-3"><label class="form-label" for="retour_box"><strong>Box</strong><br /></label><input id="retour_box" class="form-control" type="text" name="retour_box" value="Huawei B612" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="retour_sn"><strong>SN</strong></label><input id="retour_sn" class="form-control" type="text" name="retour_sn" value="78524 498 6549 8" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="retour_emp"><strong>Employé responsable</strong><br /></label><input id="retour_emp" class="form-control" type="text" name="retour_emp" value="Tantelison Odilon" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="retour_ue"><strong>Localisation</strong><br /></label><input id="retour_ue" class="form-control" type="text" name="retour_ue" value="SGMAD" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="retour_etat"><strong>Etat</strong></label><select id="retour_etat" class="form-select" name="retour_etat" readonly disabled>
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
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-danger" type="submit" form="form_retour_box">Retourner</button></div>
        </div>
    </div>
</div>

@endsection