@extends('layouts.app')
@section('title', 'Gestion places')

@section('content')
    <div class="mx-auto text-center w-50">
        <h2>Ajouter une place</h2>
        <form class="flex-row d-flex w-50 mx-auto" method="POST">
            @csrf
            <input type="hidden" name="action" value="add">
            <input type="text" minlength="10" maxlength="10" name="numero" class="form-control mr-2"
                   placeholder="Numéro place">
            <button class="btn btn-primary">Ajouter</button>
        </form>

        <h2>Supprimer une place existante</h2>
        @foreach(App\Models\Place::all() as $place)
            <form class="mb-2" method="POST">
                @csrf
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="{{ $place->id }}">
                <div class="card w-50 mx-auto">
                    <div class="card-body">
                        <h5 class="card-title">{{ $place->numero }}</h5>
                        <button class="btn btn-danger"><i class="fas fa-trash-alt mr-2"></i>Supprimer</button>
                    </div>
                </div>
            </form>
        @endforeach
    </div>
@endsection
