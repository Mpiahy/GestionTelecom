@extends('base/baseRef')
<head>
    <title>Lignes - Telecom</title>
</head>

@section('content_ref')

    <div class="container-fluid">
        <h3 class="text-dark mb-1"><i class="fas fa-satellite-dish" style="padding-right: 5px;"></i>Lignes</h3>
        <div class="text-center mb-4"><a class="btn btn-primary btn-icon-split" role="button" data-bs-target="#modal_act_ligne" data-bs-toggle="modal"><span class="icon"><i class="fas fa-plus-circle"></i></span><span class="text">Demander l&#39;activation d&#39;une ligne</span></a></div>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="m-0 fw-bold" style="color: #0a4866;">Gestion des lignes</p>
            </div>
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col">
                        <form action="search_ligne_sim">
                            <div class="input-group"><span class="input-group-text">SIM</span><input class="form-control" type="text" placeholder="Rechercher par SIM" name="search_ligne_sim" /><button class="btn btn-primary" type="submit">Rechercher</button></div>
                        </form>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <div class="btn-group" role="group"><button class="btn btn-outline-primary active" type="button" style="margin-right: 0px;">Tout</button><button class="btn btn-outline-info" type="button">Attribué</button><button class="btn btn-outline-secondary" type="button">Non attribué</button><button class="btn btn-outline-warning" type="button">En attente</button><button class="btn btn-outline-danger" type="button">Résilié</button></div>
                    </div>
                    <div class="col">
                        <form action="search_ligne_user">
                            <div class="input-group"><span class="input-group-text">Utilisateur</span><input class="form-control" type="text" placeholder="Rechercher par Utilisateur" name="search_ligne_user" /><button class="btn btn-primary" type="submit">Rechercher</button></div>
                        </form>
                    </div>
                </div>
                <div id="dataTable-1" class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                    <table id="dataTable" class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>Statut</th>
                                <th>Type</th>
                                <th>Forfait</th>
                                <th>Numéro Ligne</th>
                                <th>Numéro SIM</th>
                                <th>Utilisateur</th>
                                <th>Localisation</th>
                                <th class="text-center" style="padding-right: 30px;padding-left: 30px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Attribué</td>
                                <td>Voix Mobile</td>
                                <td>Forfait 0</td>
                                <td>+261 34 49 599 53</td>
                                <td>35412365845632</td>
                                <td>Randriamanivo Andriamahaleo Mpiahisoa</td>
                                <td>PROJET MASAY IMMEUBLE R+6 PHASE 00</td>
                                <td class="text-center" style="padding-left: 1px;padding-right: 0px;"><a style="margin-right: 5px;" data-bs-target="#modal_resil_ligne" data-bs-toggle="modal" href="#" data-toggle="tooltip" title="Résilier"><i class="far fa-window-close text-danger" style="font-size: 25px;"></i></a><a href="voir_ligne_mobile" style="margin-right: 5px;" data-bs-target="#modal_voir_ligne" title="Voir" data-toggle="tootlip" data-bs-toggle="modal"><i class="fas fa-search-plus text-primary" style="font-size: 25px;"></i></a><a href="edit_operateur" data-bs-target="#modal_edit_ligne" data-bs-toggle="modal" data-toggle="tooltip" title="Modifier"><i class="far fa-edit text-warning" style="font-size: 25px;"></i></a></td>
                            </tr>
                            <tr>
                                <td>Résilié</td>
                                <td>Voix Fixe</td>
                                <td>Forfait 0</td>
                                <td>+261 20 22 599 53</td>
                                <td>35412365845632</td>
                                <td>--</td>
                                <td>--</td>
                                <td class="text-center" style="padding-left: 0px;padding-right: 0px;"><a style="margin-right: 5px;" data-bs-target="#modal_react_ligne" data-bs-toggle="modal" title="Réactiver" href="react_ligne_mobile" data-toggle="tooltip"><i class="far fa-arrow-alt-circle-up text-success" style="font-size: 25px;"></i></a><a href="voir_ligne_mobile" style="margin-right: 5px;" data-bs-target="#modal_voir_ligne" data-bs-toggle="modal" title="Voir" data-toggle="tooltip"><i class="fas fa-search-plus text-primary" style="font-size: 25px;"></i></a><a href="edit_operateur" data-bs-target="#modal_edit_ligne" data-bs-toggle="modal" title="Modifier" dat data-toggle="tooltip"><i class="far fa-edit text-warning" style="font-size: 25px;"></i></a></td>
                            </tr>
                            <tr>
                                <td>Non attribué</td>
                                <td>Internet Mobile</td>
                                <td>Wifiber PRO</td>
                                <td>+261 32 59 599 53</td>
                                <td>35712365412354</td>
                                <td>--<br /></td>
                                <td>--</td>
                                <td class="text-center" style="padding-left: 0px;padding-right: 0px;"><a href="attr_ligne_mobile" style="margin-right: 5px;" data-bs-target="#modal_attr_ligne" data-bs-toggle="modal" title="Attribuer" data-toggle="tooltip"><i class="fas fa-bars text-info" style="font-size: 25px;"></i></a><a href="voir_ligne_mobile" style="margin-right: 5px;" data-bs-target="#modal_voir_ligne" title="Voir" data-toggle="tooltip" data-bs-toggle="modal"><i class="fas fa-search-plus text-primary" style="font-size: 25px;"></i></a><a href="edit_operateur" data-bs-target="#modal_edit_ligne" data-bs-toggle="modal" title="Modifier" data-toggle="tooltip"><i class="far fa-edit text-warning" style="font-size: 25px;"></i></a></td>
                            </tr>
                            <tr>
                                <td>En attente</td>
                                <td>Voix Mobile</td>
                                <td>Forfait 4</td>
                                <td>--</td>
                                <td>35712365412354</td>
                                <td>--<br /></td>
                                <td>--</td>
                                <td class="text-center" style="padding-left: 0px;padding-right: 0px;"><a href="attr_ligne_mobile" style="margin-right: 5px;" data-bs-target="#modal_enr_ligne" data-bs-toggle="modal" title="Enregistrer" data-toggle="tooltip"><i class="far fa-save text-info" style="font-size: 25px;"></i></a><a href="voir_ligne_mobile" style="margin-right: 5px;" data-bs-target="#modal_voir_ligne" title="Voir" data-toggle="tooltip" data-bs-toggle="modal"><i class="fas fa-search-plus text-primary" style="font-size: 25px;"></i></a><a href="edit_operateur" data-bs-target="#modal_edit_ligne" data-bs-toggle="modal" title="Modifier" data-toggle="tooltip"><i class="far fa-edit text-warning" style="font-size: 25px;"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal_ref')

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
                    <div class="col-xl-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="form_edt_mobile" action="edit_mobile" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3"><label class="form-label" for="edt_ligne"><strong>Numéro d&#39;appel</strong></label><input id="edt_ligne" class="form-control" type="text" name="edt_ligne" value="+261 34 49 599 53" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="edt_sim"><strong>Numéro SIM</strong><br /></label><input id="edt_sim" class="form-control" type="text" name="edt_sim" value="64587932145698" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="edt_operateur"><strong>Opérateur</strong><br /></label><input id="edt_operateur" class="form-control" type="text" name="edt_operateur" value="TELMA" readonly /></div>
                                    <div class="mb-3"><label class="form-label" for="edt_ip"><strong>Adresse IP</strong></label><input id="edt_ip" class="form-control" type="text" placeholder="Entrer le nom du contact" name="edt_ip" value="198.424.453.25" /></div>
                                    <div class="mb-3"><label class="form-label" for="edt_resp"><strong>Responsable</strong><br /></label><select id="edt_resp" class="form-select" name="edt_resp">
                                            <option value="0">Choisir le responsable</option>
                                            <option value="1" selected>Randriamanivo Andriamahaleo Mpiahisoa</option>
                                            <option value="2">Odilon</option>
                                            <option value="3">Mirindra</option>
                                        </select></div>
                                    <div class="mb-3"><label class="form-label" for="edt_date"><strong>Date d&#39;affectation</strong><br /></label><input id="edt_date" class="form-control" type="date" name="edt_date" /></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-primary" type="submit" form="form_edt_mobile">Modifier</button></div>
        </div>
    </div>
</div>
<div id="modal_act_ligne" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Demande d&#39;activation d&#39;une ligne</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="form_act_mobile" action="activate_mobile" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3"><label class="form-label" for="act_sim"><strong>Numéro SIM</strong></label><input id="act_sim" class="form-control" type="text" name="act_sim" placeholder="Numéro SIM" /></div>
                                    <div class="mb-3"><label class="form-label" for="act_operateur"><strong>Opérateur</strong></label><select id="act_operateur" class="form-select" name="act_operateur">
                                            <option value="0" selected>Choisir l&#39;opérateur</option>
                                            <option value="1">Telma</option>
                                            <option value="2">Orange</option>
                                            <option value="3">Airtel</option>
                                        </select></div>
                                    <div class="mb-3"><label class="form-label" for="act_type"><strong>Type</strong></label><select id="act_type" class="form-select" name="act_type">
                                            <option value="0" selected>Choisir le type</option>
                                            <option value="1">Voix Mobile</option>
                                            <option value="2">Internet Mobile</option>
                                        </select></div>
                                    <div class="mb-3"><label class="form-label" for="act_forfait"><strong>Forfait</strong></label><select id="act_forfait" class="form-select" name="act_forfait">
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
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-primary" type="submit" form="form_act_mobile">Demander</button></div>
        </div>
    </div>
</div>
<div id="modal_enr_ligne" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Enregistrer une ligne</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="form_enr_ligne" action="enr_mobile" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3"><label class="form-label" for="enr_ligne"><strong>Numéro Ligne</strong></label><input id="enr_ligne" class="form-control" type="text" name="enr_ligne" placeholder="Numéro Ligne" /></div>
                                    <div class="mb-3"><label class="form-label" for="enr_sim"><strong>Numéro SIM</strong></label><input id="enr_sim" class="form-control" type="text" name="enr_sim" value="45236514279865" /></div>
                                    <div class="mb-3"><label class="form-label" for="enr_ip"><strong>Adresse IP</strong></label><input id="enr_ip" class="form-control" type="text" placeholder="Adresse IP" name="enr_ip" /></div>
                                    <div class="mb-3"><label class="form-label" for="enr_forfait"><strong>Forfait</strong></label><input id="enr_sims" class="form-control" type="text" name="enr_sim" readonly value="Forfait 0" /></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-primary" type="submit" form="enr_sim">Enregistrer</button></div>
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

@endsection