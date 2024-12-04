@extends('base/baseRef')
<head>
    <title>Forfaits - Telecom</title>
</head>

@section('content_ref')

    <div class="container-fluid">
        <h3 class="text-dark"><i class="fas fa-money-check-alt" style="padding-right: 5px;"></i>Offres et forfaits</h3>
        <div class="text-center mb-4"><a class="btn btn-primary btn-icon-split" role="button" data-bs-target="#ajouter_forfait" data-bs-toggle="modal"><span class="icon"><i class="fas fa-plus-circle" style="padding-top: 5px;"></i></span><span class="text">Ajouter un nouveau forfait</span></a></div>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="m-0 fw-bold" style="color: #0a4866;">Gestion des forfaits</p>
            </div>
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-xl-12">
                        <div class="btn-group" role="group"><button class="btn btn-outline-primary active" type="button">Forfait 0</button><button class="btn btn-outline-primary" type="button">Forfait 1</button><button class="btn btn-outline-primary" type="button">Forfait 2</button><button class="btn btn-outline-primary" type="button">Forfait 2Bis</button><button class="btn btn-outline-primary" type="button">Forfait 3</button><button class="btn btn-outline-primary" type="button">Forfait 4</button><button class="btn btn-outline-primary" type="button">Forfait 5</button></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div id="dataTable-forfait_prix" class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                            <table id="dataTable" class="table table-hover my-0">
                                <thead>
                                    <tr>
                                        <th>Libellé</th>
                                        <th>Prix</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Prix Unitaire Hors Taxe non remisé</td>
                                        <td>18300 Ar</td>
                                    </tr>
                                    <tr>
                                        <td>Droit d&#39;accise (+8%)</td>
                                        <td>1464 Ar</td>
                                    </tr>
                                    <tr>
                                        <td>Remise pied de pages (-20%)</td>
                                        <td>3660 Ar</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Prix Unitaire Hors Taxe Final</th>
                                        <th>16104 Ar</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div id="dataTable-forfait_element" class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                            <table id="dataTable" class="table table-hover my-0">
                                <thead>
                                    <tr>
                                        <th>Eléments</th>
                                        <th>Quantité</th>
                                        <th>Unité</th>
                                        <th>Prix Unitaire</th>
                                        <th>Prix Total</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Appel Flotte initial</td>
                                        <td>5</td>
                                        <td>Heures</td>
                                        <td>2160 Ar</td>
                                        <td>10800 Ar</td>
                                        <td class="text-center"><a href="#" data-bs-target="#modifier_element" data-bs-toggle="modal" style="margin-right: 10px;"><i class="fas fa-cogs text-info" style="font-size: 25px;" title="Modifier"></i></a><a href="#" data-bs-target="#supprimer_element" data-bs-toggle="modal"><i class="far fa-trash-alt text-danger" style="font-size: 25px;" title="Supprimer"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>Appel Flotte supplémentaire</td>
                                        <td>0</td>
                                        <td>Heures</td>
                                        <td>4000 Ar</td>
                                        <td>0 Ar</td>
                                        <td class="text-center"><a href="#" data-bs-target="#modifier_element" data-bs-toggle="modal" style="margin-right: 10px;"><i class="fas fa-cogs text-info" style="font-size: 25px;" title="Modifier"></i></a><a href="#" data-bs-target="#supprimer_element" data-bs-toggle="modal"><i class="far fa-trash-alt text-danger" style="font-size: 25px;" title="Supprimer"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>Appel Tout TELMA</td>
                                        <td>2</td>
                                        <td>Heures</td>
                                        <td>4000 Ar</td>
                                        <td>8000 Ar</td>
                                        <td class="text-center"><a href="#" data-bs-target="#modifier_element" data-bs-toggle="modal" style="margin-right: 10px;"><i class="fas fa-cogs text-info" style="font-size: 25px;" title="Modifier"></i></a><a href="#" data-bs-target="#supprimer_element" data-bs-toggle="modal"><i class="far fa-trash-alt text-danger" style="font-size: 25px;" title="Supprimer"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>Appel Tout MADA</td>
                                        <td>1</td>
                                        <td>Heures</td>
                                        <td>9000 Ar</td>
                                        <td>9000 Ar</td>
                                        <td class="text-center"><a href="#" data-bs-target="#modifier_element" data-bs-toggle="modal" style="margin-right: 10px;"><i class="fas fa-cogs text-info" style="font-size: 25px;" title="Modifier"></i></a><a href="#" data-bs-target="#supprimer_element" data-bs-toggle="modal"><i class="far fa-trash-alt text-danger" style="font-size: 25px;" title="Supprimer"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>Appel vers l&#39;Etranger</td>
                                        <td>0</td>
                                        <td>Heures</td>
                                        <td>10000 Ar</td>
                                        <td>0 Ar</td>
                                        <td class="text-center"><a href="#" data-bs-target="#modifier_element" data-bs-toggle="modal" style="margin-right: 10px;"><i class="fas fa-cogs text-info" style="font-size: 25px;" title="Modifier"></i></a><a href="#" data-bs-target="#supprimer_element" data-bs-toggle="modal"><i class="far fa-trash-alt text-danger" style="font-size: 25px;" title="Supprimer"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>DATA</td>
                                        <td>0</td>
                                        <td>15 Go</td>
                                        <td>62500 Ar</td>
                                        <td>0 Ar</td>
                                        <td class="text-center"><a href="#" data-bs-target="#modifier_element" data-bs-toggle="modal" style="margin-right: 10px;"><i class="fas fa-cogs text-info" style="font-size: 25px;" title="Modifier"></i></a><a href="#" data-bs-target="#supprimer_element" data-bs-toggle="modal"><i class="far fa-trash-alt text-danger" style="font-size: 25px;" title="Supprimer"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>SMS</td>
                                        <td>1</td>
                                        <td>100 Sms</td>
                                        <td>7500 Ar</td>
                                        <td>7500 Ar</td>
                                        <td class="text-center"><a href="#" data-bs-target="#modifier_element" data-bs-toggle="modal" style="margin-right: 10px;"><i class="fas fa-cogs text-info" style="font-size: 25px;" title="Modifier"></i></a><a href="#" data-bs-target="#supprimer_element" data-bs-toggle="modal"><i class="far fa-trash-alt text-danger" style="font-size: 25px;" title="Supprimer"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal_ref')

    @include('modals.forfaitModal')

@endsection