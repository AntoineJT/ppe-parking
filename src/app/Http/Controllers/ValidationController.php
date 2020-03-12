<?php

namespace App\Http\Controllers;

use App\Enums\UserStateEnum;
use App\Models\Personnel;
use App\Utils\FlashMessage;
use App\Utils\SessionManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class ValidationController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $validator = Validator::make(Request::all(), [
            'id' => 'required'
        ]);
        if ($validator->fails())
            return FlashMessage::redirectWithErrorMessage(Redirect::to('/admin/valider'), "L'identifiant de l'utilisateur n'a pas été fourni!");

        if (SessionManager::isPersonnel())
            return FlashMessage::redirectBackWithErrorMessage("Vous n'êtes pas administrateur! Action impossible!");

        $user_id = Request::input('id');
        $success = Personnel::find_($user_id)->setState(UserStateEnum::STATE_ENABLED);

        if (!$success)
            return FlashMessage::redirectBackWithErrorMessage("La validation de l'utilisateur a échoué!");

        return FlashMessage::redirectWithSuccessMessage(Redirect::to('/admin/valider'), "L'utilisateur a bien été validé!");
    }
}
