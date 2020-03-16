@extends('layouts.app')
@section('title', 'user_history')
<div class="container">
        <h3>Bonjour <i class="fas fa-user-circle"></i>{{ SessionManager::getFullTypeName() }}</h3><br>
        <h3><i class="fas fa-history"></i> Votre Historique des réservation</h3>
        <table class="table">
          <thead class="thead-light">
            <tr>
              <th scope="col">Jour</th>
              <th scope="col">Plage Horaire</th>
              <th scope="col">Place</th>
              <th scope="col">Liste d'attente ?</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        <br>Bonne Journée<br>
        <button class="btn-block btn btn-primary btn-b mt-4" href="{{ route('Resa') }}"> type="button">Nouvelle Réservation</button>
    </form>
</div>
@section('content')
@endsection
