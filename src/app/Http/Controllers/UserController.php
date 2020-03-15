<?php

namespace App\Http\Controllers;

use App\Enums\UserStateEnum;
use App\Models\LienReset;
use App\Models\Personnel;
use App\Models\Utilisateur;
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
                    'change-password',
                    'delete'
                ])
            ]
        ]);
        if ($validator->fails())
            return FlashMessage::redirectBackWithWarningMessage("Le formulaire n'a pas été renseigné correctement!");
        if (!SessionManager::isAdmin())
            return FlashMessage::redirectBackWithErrorMessage("Vous n'êtes pas administrateur! Action impossible!");

        $user_id = Request::input('id');
        $user = Utilisateur::find($user_id);
        if ($user === null)
            return FlashMessage::redirectBackWithErrorMessage("L'utilisateur n'existe pas!");
        if ($user->isAdmin())
            return FlashMessage::redirectBackWithErrorMessage('Cet utilisateur est administrateur et ne peut donc pas être géré!');

        switch (Request::input('action')) {
            case 'validate':
                return self::validateIt($user_id);
            // case 'modify':
            case 'change-password':
                return self::changePassword($user);
            case 'delete':
                return self::delete($user);
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

    private static function changePassword(Utilisateur $user): RedirectResponse
    {
        $reset_link = LienReset::create($user);
        if ($reset_link === null)
            return FlashMessage::redirectBackWithErrorMessage("Le lien de réinitialisation du mot de passe n'a pu être créé!");

        return Redirect::to(route('reset-link', [
            'link' => $reset_link->lien
        ]));
    }

    private static function delete(Utilisateur $user): RedirectResponse
    {
        $personnel = $user->toPersonnel();
        if ($personnel === null)
            return FlashMessage::redirectBackWithErrorMessage("L'utilisateur n'est pas un membre du personnel!");
        if (!$personnel->deleteUser())
            return FlashMessage::redirectBackWithErrorMessage("Impossible de supprimer l'utilisateur!");
        // TODO Envoyer un mail à l'utilisateur dont le compte s'est fait supprimer?
        return FlashMessage::redirectBackWithSuccessMessage("L'utilisateur a bien été supprimé!");
    }
}
