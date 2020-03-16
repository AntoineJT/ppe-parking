@extends('layouts.app')
@section('title', 'user_home')
<div class="user-form m-auto">
    <form>
        <h3>Bonjour <i class="fas fa-user-circle"></i>{{ SessionManager::getFullTypeName() }}</h3>
        @if (!SessionManager::havePlace())
            <p class="mt-4">
                <i>Votre Place est la place{{ SessionManager::getPlace() }}<br>
                Elle vous est réservée le{{ SessionManager::getFullTypeName() }}
                de {{ SessionManager::getHDeb() }} à{{ SessionManager::getHFin() }}</i>
            </p>
        @elseif (SessionManager::Wait())
        <p class="mt-4">
            <i>Vous êtes {{ SessionManager::getRang() }}ème sur la liste d'attente<br>
            Veuillez patienter pour l'attribution finale de la place</i>
        </p>
        @endif
        <br>Bonne Journée<br>
        <button class="btn-block btn btn-primary btn-b mt-4" href="{{ route('Resa') }}"> type="button">Nouvelle Réservation</button>
        <button class="btn-block btn btn-primary btn-b mt-4" href="{{ route('History') }}"> type="button">Consulter l'historique</button>
    </form>
</div>
@section('content')
@endsection
