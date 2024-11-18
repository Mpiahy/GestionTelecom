@extends('base/baseRef')

<head>
    <title>Opérateur - Telecom</title>
</head>

@section('content_ref')
<div class="container-fluid">
    <h3 class="text-dark mb-5"><i class="fas fa-globe" style="padding-right: 5px;"></i>Opérateurs</h3>
    
    <!-- Affichage des messages de succès ou d'erreur -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
                        @foreach ($contactsOperateurs as $contact)
                            <tr>
                                <td>
                                    <a class="text-decoration-none" href="http://www.{{ strtolower($contact->operateur->nom_operateur) }}.mg">
                                        {{ $contact->operateur->nom_operateur }}
                                    </a>
                                </td>
                                <td>{{ $contact->nom }}</td>
                                <td>
                                    <a class="link-primary" href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                                </td>
                                <td class="text-center">
                                    <a href="#" 
                                       data-bs-toggle="modal" 
                                       data-bs-target="#modifier_contact_operateur" 
                                       class="edit-contact"
                                       data-id="{{ $contact->id_contact }}" 
                                       data-nom="{{ $contact->nom }}" 
                                       data-email="{{ $contact->email }}" 
                                       data-operateur="{{ $contact->operateur->nom_operateur }}">
                                        <i class="far fa-edit text-warning" style="font-size: 25px;"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>                    
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal_ref')
<!-- Modal pour modifier un contact -->
<div id="modifier_contact_operateur" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Modifier le contact pour cet opérateur</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_edt_contact_operateur" action="{{ route('operateur.modifier') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_contact" id="modal-id-contact">
                    <div class="mb-3">
                        <label class="form-label" for="nom_contact"><strong>Nom du contact</strong></label>
                        <input id="modal-nom-contact" class="form-control" type="text" name="nom_contact" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email_contact"><strong>Email du contact</strong></label>
                        <input id="modal-email-contact" class="form-control" type="email" name="email_contact" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button>
                <button class="btn btn-primary" type="submit" form="form_edt_contact_operateur">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Écoute les clics sur les boutons d'édition
        document.querySelectorAll('.edit-contact').forEach(function (button) {
            button.addEventListener('click', function () {
                // Récupère les données depuis les attributs
                const id = this.getAttribute('data-id');
                const nom = this.getAttribute('data-nom');
                const email = this.getAttribute('data-email');
                const operateur = this.getAttribute('data-operateur');
                
                // Remplit les champs du modal
                document.getElementById('modal-id-contact').value = id;
                document.getElementById('modal-nom-contact').value = nom;
                document.getElementById('modal-email-contact').value = email;
            });
        });
    });
</script>

@endsection