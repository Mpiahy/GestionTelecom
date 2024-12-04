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
                        <form action="{{ route('ref.forfait') }}" method="get">
                            <div class="btn-group" role="group">
                                @foreach ($forfaits as $forfait)
                                    <button class="btn btn-outline-primary {{ request('forfait') == $forfait->id_forfait ? 'active' : '' }}" 
                                        type="submit"
                                        name="forfait"
                                        value="{{ $forfait->id_forfait }}">
                                        {{ $forfait->nom_forfait }}
                                    </button>
                                @endforeach
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        @if($forfaitDetails)
                        <div id="dataTable-forfait_prix" class="table-responsive table mt-2" role="grid">
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
                                        <td>{{ $forfaitDetails->prix_forfait_ht_non_remise }}</td>
                                    </tr>
                                    <tr>
                                        <td>Droit d'accise (+8%)</td>
                                        <td>{{ $forfaitDetails->droit_d_accise }}</td>
                                    </tr>
                                    <tr>
                                        <td>Remise pied de pages (-21.6%)</td>
                                        <td>{{ $forfaitDetails->remise_pied_de_page }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Prix Unitaire Hors Taxe Final</th>
                                        <th>{{ $forfaitDetails->prix_forfait_ht }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endif
                        @if($elements)
                            <div id="dataTable-forfait_element" class="table-responsive table mt-2" role="grid">
                                <table id="dataTable" class="table table-hover my-0">
                                    <thead>
                                        <tr>
                                            <th>Éléments</th>
                                            <th>Quantité</th>
                                            <th>Unité</th>
                                            <th>Prix Unitaire</th>
                                            <th>Prix Total</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($elements as $element)
                                            <tr>
                                                <td>{{ $element->libelle }}</td>
                                                <td>{{ $element->quantite }}</td>
                                                <td>{{ $element->unite }}</td>
                                                <td>{{ $element->prix_unitaire_element }}</td>
                                                <td>{{ $element->prix_total_element }}</td>
                                                <td class="text-center">
                                                    <a class="text-decoration-none" href="#" data-bs-target="#modifier_element" data-bs-toggle="modal" style="margin-right: 10px;">
                                                        <i class="fas fa-cogs text-info" style="font-size: 25px;" title="Modifier"></i>
                                                    </a>
                                                    <a class="text-decoration-none" href="#" data-bs-target="#supprimer_element" data-bs-toggle="modal">
                                                        <i class="far fa-trash-alt text-danger" style="font-size: 25px;" title="Supprimer"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal_ref')

    @include('modals.forfaitModal')

@endsection