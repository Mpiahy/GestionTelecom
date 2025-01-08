@extends('base/baseIndex')

<head>
    <title>Simulations - Telecom</title>
</head>

@section('content_index')

<div class="container-fluid">

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Titre principal -->
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h4 class="text-dark mb-0">
            <i class="fas fa-gamepad"></i> Simulations
        </h4>
    </div>

    <!-- Bouton de simulation -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Simuler Affectations</h5>
            <p class="card-text">
                Cliquez sur le bouton ci-dessous pour générer des affectations aléatoires entre utilisateurs et lignes.
                Une affectation sera créée pour chaque utilisateur et ligne avec des dates aléatoires.
            </p>
            <form action="{{ route('simulation.run') }}" method="POST">
                @csrf
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-random"></i> Simuler Affectations
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
