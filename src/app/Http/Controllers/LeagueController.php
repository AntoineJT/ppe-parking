<?php

namespace App\Http\Controllers;

use App\Models\Ligue;
use App\Utils\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class LeagueController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $validator = Validator::make(Request::all(), [
            'action' => 'required'
        ]);
        if ($validator->fails())
            return FlashMessage::redirectBackWithWarningMessage("Le formulaire n'est pas bien renseigné!")
                ->withInput(Request::all());

        switch (Request::input('action')) {
            case 'add':
                return self::add();
            case 'delete':
                return self::delete();
        }
        return FlashMessage::redirectBackWithErrorMessage("Données transmises invalides!");
    }

    private static function add()
    {
        $name = Request::input('nom');
        if ($name === null)
            return FlashMessage::redirectBackWithWarningMessage("Aucun nom de ligue n'a été renseigné!");

        $fails = Ligue::createLeague($name) === null;
        if ($fails)
            return FlashMessage::redirectBackWithErrorMessage('Impossible de créer la ligue!');
        return FlashMessage::redirectBackWithSuccessMessage('La ligue a correctement été créée!');
    }

    private static function delete()
    {
        $id = Request::input('id');
        if ($id === null)
            return FlashMessage::redirectBackWithWarningMessage('Impossible de déterminer quelle ligue supprimer!');

        $succeed = Ligue::deleteLeague($id);
        if (!$succeed)
            return FlashMessage::redirectBackWithErrorMessage('Impossible de supprimer la ligue!');
        return FlashMessage::redirectBackWithSuccessMessage('La ligue a bien été supprimée!');
    }
}
