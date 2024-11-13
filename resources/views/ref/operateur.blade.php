@extends('base/baseRef')
<head>
    <title>Opérateur - Telecom</title>
</head>

@section('content_ref')

    <div class="container-fluid">
        <h3 class="text-dark mb-5"><i class="fas fa-globe" style="padding-right: 5px;"></i>Opérateurs</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="m-0 fw-bold" style="color: #0a4866;">Gestion des opérateurs</p>
            </div>
            <div class="card-body">
                <div id="dataTable-1" class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                    <table id="dataTable" class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>Opérateur</th>
                                <th>Contact</th>
                                <th>E-mail</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a class="text-decoration-none" href="www.telma.mg">TELMA</a></td>
                                <td>Airina Satou</td>
                                <td class="link-primary">satou@email.com</td>
                                <td class="text-center"><a data-bs-target="#modifier_contact_operateur" data-bs-toggle="modal" href="#"><i class="far fa-edit text-warning" style="font-size: 25px;"></i></a></td>
                            </tr>
                            <tr>
                                <td><a class="text-decoration-none" href="www.orange.mg">ORANGE</a></td>
                                <td>Angelica Ramos</td>
                                <td class="link-primary">ramos@email.com</td>
                                <td class="text-center"><a href="#" data-bs-target="#modifier_contact_operateur" data-bs-toggle="modal"><i class="far fa-edit text-warning" style="font-size: 25px;"></i></a></td>
                            </tr>
                            <tr>
                                <td><a class="text-decoration-none" href="www.airtel.mg">AIRTEL</a></td>
                                <td>Ashton Cox</td>
                                <td class="link-primary">ashton@email.com</td>
                                <td class="text-center"><a href="#" data-bs-target="#modifier_contact_operateur" data-bs-toggle="modal"><i class="far fa-edit text-warning" style="font-size: 25px;"></i></a></td>
                            </tr>
                            <tr>
                                <td><a class="text-decoration-none" href="www.starlink.com">STARLINK</a></td>
                                <td>Randriamanivo Mpiahisoa</td>
                                <td class="link-primary">mpiahy@email.com</td>
                                <td class="text-center"><a href="#" data-bs-target="#modifier_contact_operateur" data-bs-toggle="modal"><i class="far fa-edit text-warning" style="font-size: 25px;"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal_ref')

<div id="modifier_contact_operateur" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Modifier le contact pour cet opérateur</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <p class="text-dark" style="margin-bottom: 0px;">Opérateur: <strong>TELMA</strong></p>
                            </div>
                            <div class="card-body">
                                <form id="form_edt_contact_operateur" action="edt_contact_operateur" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3"><label class="form-label" for="nom_contact"><strong>Nom du contact</strong></label><input id="nom_contact" class="form-control" type="text" placeholder="Entrez le nom du contact" name="nom_contact" value="Randriamanivo Mpiahy" /></div>
                                    <div class="mb-3"><label class="form-label" for="email_contact"><strong>Email du contact</strong></label><input id="email_contact" class="form-control" type="email" placeholder="Entrez l&#39;email du contact" name="email_contact" value="mpiahy@email.com" /></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-primary" type="submit" form="form_edt_contact_operateur">Enregistrer</button></div>
        </div>
    </div>
</div>

@endsection