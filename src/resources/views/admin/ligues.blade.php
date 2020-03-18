@extends('layouts.app')
@section('title', 'Gestion ligues')

@section('content')
    <div class="mx-auto text-center w-50">
        <h2>Ajouter une ligue</h2>
        <form class="flex-row d-flex w-50 mx-auto" method="POST">
            @csrf
            <input type="hidden" name="action" value="add">
            <input type="text" name="nom" class="form-control mr-2" placeholder="Nom ligue" required>
            <button class="btn btn-primary">Ajouter</button>
        </form>

        <h2>Supprimer une ligue existante</h2>
        @foreach(App\Models\Ligue::all() as $ligue)
            <form class="mb-2" method="POST">
                @csrf
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="{{ $ligue->id }}">
                <div class="card w-50 mx-auto">
                    <div class="card-body">
                        <h5 class="card-title">{{ $ligue->nom }}</h5>
                        <button class="btn btn-danger"><i class="fas fa-trash-alt mr-2"></i>Supprimer</button>
                    </div>
                </div>
            </form>
        @endforeach
        {{-- TODO Pouvoir renommer une ligue? --}}
    </div>
@endsection
