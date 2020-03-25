@extends('layouts.app')
@section('title', 'Paramètres')

@section('content')
    <div class="mx-auto text-center w-50">
        <h2>Configuration</h2>
        <div class="card w-50 mx-auto">
        {{-- todo préremplir champs avec durée actuelle --}}
            <div class="card-body">
                <h5 class="card-title">Durée avant expiration</h5>
                <form class="flex-column d-flex w-50 justify-content-center mx-auto" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="expiration">
                    <div class="input-group">
                        <label for="jours" class="input-group-prepend input-group-text w-50">Jours</label>
                        <input type="number" name="jours" value="0" min="0" class="form-control mr-2" required>
                    </div>
                    <div class="input-group">
                        <label for="heures" class="input-group-prepend input-group-text w-50">Heures</label>
                        <input type="number" name="heures" value="0" min="0" max="23" class="form-control mr-2" required>
                    </div>
                    <div class="input-group">
                        <label for="minutes" class="input-group-prepend input-group-text w-50">Minutes</label>
                        <input type="number" name="minutes" value="0" min="0" max="59" class="form-control mr-2" required>
                    </div>
                    <button class="btn btn-primary flex-column mt-2"><i class="fas fa-save mr-2"></i>Enregistrer</button>
                </form>
            </div>
        </div>
        <div class="card w-50 mx-auto">
            <div class="card-body">
                <h5 class="card-title">Actions</h5>
                <form method="POST">
                    @csrf
                    <input type="hidden" name="action" value="full-refresh">
                    <button class="btn btn-success"><i class="fas fa-sync-alt mr-2"></i>Recalculer la disponibilité des places</button>
                </form>
            </div>
        </div>
    </div>
@endsection
