@extends('layouts.app')
@section('title', 'Réserver une place')

@section('content')
    @php
        use App\Models\Personnel;
        use App\Models\Reservation;

        $personnel = Personnel::find_(session('id'));
        $reserv = Reservation::getActiveReservations($personnel);
        $already_has_one = $reserv->exists();
        $reserv = !$already_has_one ?: $reserv->first();
    @endphp
    <div class="card mb-2 mt-2 w-50 mx-auto text-center">
        <div class="card-body d-flex flex-column">
            <span class="card-title h3">Réservation active</span>
            @if ($already_has_one)
                <div class="card mb-2 mt-2 w-50 mx-auto text-center">
                    <div class="card-body d-flex flex-column">
                        <span class="card-title h4">Place {{ \App\Models\Place::find($reserv->id_place)->numero }}</span>
                        <span>Date de la demande : {{ $reserv->date_demande }}</span>
                        <span>Date d'expiration : {{ $reserv->date_expiration }}</span>
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
            @php
                $old_reservations = Reservation::where('id_personnel', $personnel->id)
                    ->where('type_statut', '!=', \App\Enums\ReservationStateEnum::ACTIVE);
                $old_exists = $old_reservations->exists();
                $old_reservations = $old_reservations->get();
            @endphp
            @if ($old_exists)
                @foreach($old_reservations as $old_reserv)
                    <div class="card mb-2 mt-2 w-50 mx-auto text-center">
                        <div class="card-body d-flex flex-column">
                            <span class="card-title h4">Place {{ \App\Models\Place::find($old_reserv->id_place)->numero }}</span>
                            <span>Statut : {{ \App\Models\Statut::find($old_reserv->type_statut)->nom }}</span>
                            <span>Date de la demande : {{ $old_reserv->date_demande }}</span>
                            <span>Date d'expiration : {{ $old_reserv->date_expiration }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <span class="font-italic">Vous n'avez aucune réservation antérieure</span>
            @endif
        </div>
    </div>
@endsection
