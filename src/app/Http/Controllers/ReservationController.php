<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStateEnum;
use App\Models\Personnel;
use App\Models\Place;
use App\Models\Reservation;
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
        $reservation = Reservation::getActiveReservations($personnel);
        $already_has_one = $reservation->exists();
        $reservation = !$already_has_one ?: $reservation->first();
        $place = Place::find($reservation->id_place);

        $old_reservations = Reservation::where('id_personnel', $personnel->id)
            ->where('type_statut', '!=', ReservationStateEnum::ACTIVE)
            ->where('type_statut', '!=', ReservationStateEnum::WAITING);
        $old_exists = $old_reservations->exists();
        $old_reservations = $old_reservations->get();

        return view('reservation', [
            'access' => ACCESS_SEMIPUBLIC,
            'already_has_one' => $already_has_one,
            'reservation' => $reservation,
            'place' => $place,
            'old_exists' => $old_exists,
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
