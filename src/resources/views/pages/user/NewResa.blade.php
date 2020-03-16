@extends('layouts.app')
@section('title', 'user_resa')
<div class="user-form m-auto">
      <form method="POST">
          @csrf
        <h3>Bonjour <i class="fas fa-user-circle"></i>{{ SessionManager::getFullTypeName() }}</h3>
        <div class="form-group mt-4">
            <input class="form-control" name="Date" type="date" placeholder="Date" required>
        </div>
        <div class="form-group mt-4">
            <input class="form-control" name="HeureDeb" type="time" placeholder="Heure Début" required>
        </div>
        <div class="form-group mt-4">
            <input class="form-control" name="HeureFin" type="time" placeholder="Heure Fin" required>
        </div>
        <br>Bonne Journée<br>
        <button class="btn-block btn btn-primary btn-b mt-4" href="{{ route('History') }}"> type="button">Consulter l'historique</button>
    </form>
</div>
@section('content')
@endsection
