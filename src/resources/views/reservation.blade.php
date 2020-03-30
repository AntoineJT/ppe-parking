@extends('layouts.app')
@section('title', 'Réserver une place')

@section('content')
    <div class="card mb-2 mt-2 w-50 mx-auto text-center">
        <div class="card-body d-flex flex-column">
            <span class="card-title h3">Réservation active</span>
            @if ($reservation !== null)
                <div class="card mb-2 mt-2 w-50 mx-auto text-center">
                    <div class="card-body d-flex flex-column">
                        <span class="card-title h4">{{ $reservation['place'] }}</span>
                        <span>Date de la demande : {{ $reservation['date_demande'] }}</span>
                        <span>Date d'expiration : {{ $reservation['date_expiration'] }}</span>
                    </div>
                </div>
            @else
                <span class="font-italic">Vous n'avez aucune réservation active</span>
            @endif
        </div>
    </div>
    <form method="POST" class="d-flex justify-content-center">
        @csrf
        <button class="btn btn-primary">Réserver une place</button>
    </form>
    <div class="card mb-2 mt-2 w-50 mx-auto text-center">
        <div class="card-body d-flex flex-column">
            <span class="card-title h3">Vos réservations antérieures</span>
            @if (!empty($old_reservations))
                @foreach($old_reservations as $old_reservation)
                    <div class="card mb-2 mt-2 w-50 mx-auto text-center">
                        <div class="card-body d-flex flex-column">
                            <span class="card-title h4">{{ $old_reservation['place'] }}</span>
                            <span>Statut : {{ $old_reservation['nom_statut'] }}</span>
                            <span>Date de la demande : {{ $old_reservation['date_demande'] }}</span>
                            <span>Date d'expiration : {{ $old_reservation['date_expiration'] }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <span class="font-italic">Vous n'avez aucune réservation antérieure</span>
            @endif
        </div>
    </div>
@endsection
