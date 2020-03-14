<?php

namespace App\Http\Controllers;

use App\Models\Ligue;
use App\Models\Place;
use App\Utils\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class ParkingSpaceController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $validator = Validator::make(Request::all(), [
            'action' => 'required'
        ]);
        if ($validator->fails())
            return FlashMessage::redirectBackWithWarningMessage("Le formulaire n'est pas bien renseigné!")
                ->withInput(Request::all());

        $action = Request::input('action');
        if ($action === 'add') {
            $validator = Validator::make(Request::all(), [
                'numero' => 'required|alpha_num|size:10'
            ]);
            if ($validator->fails())
                return FlashMessage::redirectBackWithWarningMessage("Le numéro de place n'est pas valide!");

            $label = Request::input('numero');
            if ($label === null)
                return FlashMessage::redirectBackWithWarningMessage("Aucun numéro de place n'a été renseigné!");

            $fails = Place::createSpace($label) === null;
            if ($fails)
                return FlashMessage::redirectBackWithErrorMessage('Impossible de créer la place!');
            return FlashMessage::redirectBackWithSuccessMessage('La place a été créée correctement!');
        } else
            if ($action === 'delete') {
                $id = Request::input('id');
                if ($id === null)
                    return FlashMessage::redirectBackWithWarningMessage('Impossible de déterminer quelle place supprimer!');

                $succeed = Place::deleteSpace($id);
                if (!$succeed)
                    return FlashMessage::redirectBackWithErrorMessage('Impossible de supprimer la place!');
                return FlashMessage::redirectBackWithSuccessMessage('La place a bien été supprimée!');
            }

        return FlashMessage::redirectBackWithErrorMessage("Données transmises invalides!");
    }
}
