<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStateEnum;
use App\Models\Personnel;
use App\Models\Place;
use App\Models\Reservation;
use App\Models\Statut;
use App\Utils\FlashMessage;
use App\Utils\SessionManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReservationController extends Controller
{
    public function show(): string
    {
        $personnel = Personnel::find_(session('id'));
        $reservations = Reservation::getActiveReservations($personnel);
        $reservation = $reservations->exists() ? $reservations->first() : null;
        $raw_old_reservations = Reservation::where('id_personnel', $personnel->id)
            ->where('type_statut', '!=', ReservationStateEnum::ACTIVE)
            ->where('type_statut', '!=', ReservationStateEnum::WAITING)
            ->get();

        $old_reservations = [];
        foreach ($raw_old_reservations as $raw_old_reservation) {
            $place = Place::find($raw_old_reservation->id_place);
            $old_reservations[] = [
                'place' => ($place !== null) ? "Place $place->numero" : 'Refusée',
                'nom_statut' => Statut::find($raw_old_reservation->type_statut)->nom,
                'date_demande' => $raw_old_reservation->date_demande,
                'date_expiration' => $raw_old_reservation->date_expiration
            ];
        }

        $r = null;
        if ($reservation !== null) {
            $place = Place::find($reservation->id_place);
            $r = [
                'place' => ($place !== null) ? "Place $place->numero" : 'En attente',
                'date_demande' => $reservation->date_demande,
                'date_expiration' => $reservation->date_expiration
            ];
        }
        return view('reservation', [
            'access' => ACCESS_SEMIPUBLIC,
            'reservation' => $r,
            'old_reservations' => $old_reservations
        ]);
    }

    public function __invoke(): RedirectResponse
    {
        if (SessionManager::isAdmin())
            return FlashMessage::redirectBackWithWarningMessage('Vous êtes administrateur et ne pouvez donc pas réserver de place!');

        $personnel = Personnel::find_(Session::get('id'));
        if ($personnel === null)
            return FlashMessage::redirectBackWithErrorMessage("Cet utilisateur n'existe pas!");

        assert(DB::unprepared('CALL FAST_REFRESH_AVAILABILITIES'));

        // FIXME Semble ne pas fonctionner avec MariaDB sur Linux
        $available_places = Place::where('disponible', true)->get();
        if ($available_places->isEmpty())
            return FlashMessage::redirectBackWithInfoMessage("Désolé, aucune place n'est disponible actuellement!");

        if (Reservation::getActiveReservations($personnel)->exists())
            return FlashMessage::redirectBackWithWarningMessage("Vous ne pouvez pas réserver une nouvelle place : vous avez déjà une réservation en cours!");

        $reservation = Reservation::create($personnel, $available_places);
        if ($reservation === null)
            return FlashMessage::redirectBackWithErrorMessage('Impossible de créer une réservation!');

        switch ($reservation->type_statut) {
            case ReservationStateEnum::ACTIVE:
                return FlashMessage::redirectBackWithSuccessMessage('Vous avez obtenu la place : ' . $reservation->getPlace()->numero);
            case ReservationStateEnum::WAITING:
                return FlashMessage::redirectBackWithInfoMessage("Vous avez été placé en liste d'attente");
        }

        return FlashMessage::notYetImplemented();
    }
}
