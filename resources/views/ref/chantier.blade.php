@extends('base/baseRef')
<head>
    <title>Utilisateurs - Telecom</title>
</head>

@section('content_ref')

    <div class="container-fluid">
        <h3 class="text-dark"><i class="far fa-building" style="padding-right: 5px;"></i>Chantiers</h3>
        <div class="text-center mb-4">
            <a class="btn btn-primary btn-icon-split" role="button" data-bs-target="#ajouter_chantier" data-bs-toggle="modal">
                <span class="icon"><i class="fas fa-plus-circle" style="padding-top: 5px;"></i></span>
                <span class="text">Ajouter un chantier</span></a></div>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="m-0 fw-bold" style="color: #0a4866;">Gestion des chantiers</p>
            </div>
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-xl-7">
                        <div></div>
                    </div>
                    <div class="col">
                        <form action="search_chantier_ue">
                            <div class="input-group"><span class="input-group-text">UE</span><input class="form-control" type="text" placeholder="Rechercher par UE" name="search_chantier_ue" /><button class="btn btn-primary" type="submit">Rechercher</button></div>
                        </form>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-xl-7">
                        <div class="btn-group" role="group"><button class="btn btn-outline-primary active" type="button" style="margin-right: 0px;">Tout</button><button class="btn btn-outline-primary" type="button">Siège - ADM</button><button class="btn btn-outline-primary" type="button">Batiment</button><button class="btn btn-outline-primary" type="button">Route</button><button class="btn btn-outline-primary" type="button">Grand Projet</button><button class="btn btn-outline-primary" type="button">Industrie</button></div>
                    </div>
                    <div class="col">
                        <form action="search_chantier_service">
                            <div class="input-group"><span class="input-group-text">Service</span><input class="form-control" type="text" placeholder="Rechercher par Service" name="search_chantier_service" /><button class="btn btn-primary" type="submit">Rechercher</button></div>
                        </form>
                    </div>
                </div>
                <div id="dataTable-1" class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                    <table id="dataTable" class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>UE</th>
                                <th>Code UE</th>
                                <th>Service</th>
                                <th>Code Imputation</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SIEGE - ADM</td>
                                <td>2200001AD001</td>
                                <td>Service Informatique</td>
                                <td>300800</td>
                                <td class="text-center"><a href="#" data-bs-target="#supprimer_chantier" data-bs-toggle="modal"><i class="far fa-trash-alt text-danger" style="font-size: 25px;" data-toggle="tooltip" title="Supprimer"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal_ref')

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
                                <form id="add_ue" action="add_chantier" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3"><label class="form-label" for="add_lib_ue"><strong>UE</strong></label><input id="add_lib_ue" class="form-control" type="text" placeholder="Entrer le libellé UE" name="add_lib_ue" /></div>
                                    <div class="mb-3"><label class="form-label" for="add_ue"><strong>Code UE</strong></label><input id="add_ue" class="form-control" type="text" placeholder="Entrer le code UE" name="add_ue" /></div>
                                    <div class="mb-3"><label class="form-label" for="add_lib_service"><strong>Libellé Service</strong><br /></label><input id="add_lib_service" class="form-control" type="text" placeholder="Entrer le libellé service" name="add_lib_service" /></div>
                                    <div class="mb-3"><label class="form-label" for="add_code_imp"><strong>Code Imputation</strong></label><input id="add_code_imp" class="form-control" type="text" placeholder="Entrer le code imputation" name="add_code_imp" /></div>
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
                <h4 class="modal-title text-danger">Voulez vous vraiment supprimer ce chantier?</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-dark" style="margin-bottom: 0px;">Chantier: <strong>2200001AD001-Service Informatique-300800</strong></p>
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
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><a class="btn btn-danger" role="button" form="add_ue">Supprimer</a></div>
        </div>
    </div>
</div>

@endsection