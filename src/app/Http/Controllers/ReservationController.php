<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStateEnum;
use App\Models\Personnel;
use App\Models\Place;
use App\Models\Reservation;
use App\Utils\FlashMessage;
use App\Utils\SessionManager;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class ReservationController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        if (SessionManager::isAdmin())
            return FlashMessage::redirectBackWithWarningMessage('Vous êtes administrateur et ne pouvez donc pas réserver de place!');

        $personnel = Personnel::find_(Session::get('id'));
        if ($personnel === null)
            return FlashMessage::redirectBackWithErrorMessage("Cet utilisateur n'existe pas!");

        $available_places = Place::where('disponible', true)->get();
        if ($available_places->isEmpty())
            return FlashMessage::redirectBackWithInfoMessage("Désolé, aucune place n'a été renseigné par l'administrateur!");

        try {
            $reservation = Reservation::create($personnel, $available_places);
        } catch (FileNotFoundException $e) {
            return FlashMessage::redirectBackWithErrorMessage("Désolé, aucune durée d'expiration n'a été renseignée par l'administrateur!");
        }
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
