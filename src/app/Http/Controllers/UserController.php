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
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $validator = Validator::make(Request::all(), [
            'id' => 'required',
            'action' => [
                'required',
                Rule::in([
                    'validate',
                    'modify',
                    'change-password'
                ])
            ]
        ]);
        if ($validator->fails())
            return FlashMessage::redirectBackWithWarningMessage("Le formulaire n'a pas été renseigné correctement!");
        if (!SessionManager::isAdmin())
            return FlashMessage::redirectBackWithErrorMessage("Vous n'êtes pas administrateur! Action impossible!");

        $user_id = Request::input('id');

        switch (Request::input('action')) {
            case 'validate':
                return self::validateIt($user_id);
            // case 'modify':
            // case 'change-password':
        }
        return FlashMessage::redirectBackWithErrorMessage('Opération impossible!');
    }

    private static function validateIt(int $user_id): RedirectResponse
    {
        $success = Personnel::find_($user_id)->setState(UserStateEnum::STATE_ENABLED);

        if (!$success)
            return FlashMessage::redirectBackWithErrorMessage("La validation de l'utilisateur a échoué!");
        return FlashMessage::redirectBackWithSuccessMessage("L'utilisateur a bien été validé!");
    }
}
