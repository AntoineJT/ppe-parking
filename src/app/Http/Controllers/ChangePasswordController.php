<?php

namespace App\Http\Controllers;

use App\Enums\UserStateEnum;
use App\Models\LienResetModel;
use App\Models\UtilisateurModel;
use App\Utils\FlashMessage;
use App\Utils\SessionManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    public function changePassword(): RedirectResponse
    {
        $link = Request::input('link');

        $rules = [
            'motdepasse' => 'required',
            'verifmotdepasse' => 'required'
        ];
        $validator = Validator::make(Request::all(), $rules);
        if ($validator->fails()) {
            return FlashMessage::redirectBackWithWarningMessage('Les données fournies ne sont pas conformes!');
        }
        $data = [
            'mdp' => Request::input('motdepasse'),
            'verifmdp' => Request::input('verifmotdepasse')
        ];
        if (!SessionManager::isLogged() && !Session::exists('link')) {
            return FlashMessage::redirectBackWithErrorMessage("Vous n'êtes ni connecté, ni disposant d'un lien de réinitialisation de mot de passe!");
        }
        if (!self::checkPasswords($data)) {
            return FlashMessage::redirectBackWithWarningMessage('Les mots de passe ne correspondent pas!');
        }
        $user_id = ($link === NULL) ? Session::get('id') : LienResetModel::find($link)->id;
        $user = UtilisateurModel::find($user_id);
        if (!$user->changePassword($data['mdp'])) {
            return FlashMessage::redirectBackWithErrorMessage("Le nouveau mot de passe n'a pas été enregistré!");
        }
        if ($user->getState() === UserStateEnum::STATE_NEWLY_CREATED && $user->isPersonnel()) {
            $valid = $user->toPersonnel()->setState(UserStateEnum::STATE_DISABLED);
            if (!$valid)
                return FlashMessage::redirectBackWithErrorMessage("Votre compte n'a pas été validé! Veuillez en informer l'administrateur!");
        }

        if (Session::exists('link')) {
            Session::remove('link');

            if (!LienResetModel::deleteResetLink($link))
                return FlashMessage::redirectWithWarningMessage(Redirect::to('/connexion'), "Mot de passe changé! Cependant, le lien n'a pas été supprimé de la base de données! Veuillez en informer un administrateur!");
        }
        return FlashMessage::redirectWithSuccessMessage(Redirect::to('/connexion'), 'Mot de passe changé!');
    }

    private static function checkPasswords(array $data): bool
    {
        return $data['mdp'] === $data['verifmdp'];
    }
}
