<?php

namespace App\Http\Controllers;

use App\Enums\UserStateEnum;
use App\Models\LienReset;
use App\Models\Utilisateur;
use App\Utils\FlashMessage;
use App\Utils\SessionManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $validator = Validator::make(Request::all(), [
            'motdepasse' => 'required',
            'verifmotdepasse' => 'required'
        ]);
        if ($validator->fails())
            return FlashMessage::redirectBackWithWarningMessage('Les données fournies ne sont pas conformes!');

        $link = Request::input('link');
        $mdp = Request::input('motdepasse');

        if (!SessionManager::isLogged() && !Session::exists('link'))
            return FlashMessage::redirectBackWithErrorMessage("Vous n'êtes ni connecté, ni disposant d'un lien de réinitialisation de mot de passe!");
        // check passwords
        if ($mdp !== Request::input('verifmotdepasse'))
            return FlashMessage::redirectBackWithWarningMessage('Les mots de passe ne correspondent pas!');

        $user_id = ($link === NULL) ? Session::get('id') : LienReset::find($link)->id_utilisateur;
        $user = Utilisateur::find($user_id);

        if (!$user->changePassword($mdp))
            return FlashMessage::redirectBackWithErrorMessage("Le nouveau mot de passe n'a pas été enregistré!");

        if ($user->getState() === UserStateEnum::STATE_NEWLY_CREATED && $user->isPersonnel()) {
            $valid = $user->toPersonnel()->setState(UserStateEnum::STATE_DISABLED);
            if (!$valid)
                return FlashMessage::redirectBackWithErrorMessage("Votre compte n'a pas été validé! Veuillez en informer l'administrateur!");
        }

        if (Session::exists('link')) {
            Session::remove('link');

            if (!LienReset::deleteResetLink($link))
                return FlashMessage::redirectWithWarningMessage(Redirect::to('/connexion'), "Mot de passe changé! Cependant, le lien n'a pas été supprimé de la base de données! Veuillez en informer un administrateur!");
        }

        return FlashMessage::redirectWithSuccessMessage(Redirect::to('/connexion'), 'Mot de passe changé!');
    }

}
