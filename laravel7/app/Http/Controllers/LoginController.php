<?php

namespace App\Http\Controllers;

use App\Enums\UserStateEnum;
use App\Models\UtilisateurModel;
use App\Utils\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use App\Enums\AuthEnum;

class LoginController extends Controller
{
    public function doLogin(): RedirectResponse
    {
        $rules = [
            'courriel' => 'required',
            'password' => 'required'
        ];
        $validator = Validator::make(Request::all(), $rules);
        if ($validator->fails()) {
            return FlashMessage::redirectBackWithErrorMessage('Les données fournies ne sont pas conformes!')
                ->withInput(Request::except('password'));
        }
        $data = [
            'courriel' => Request::input('courriel'),
            'password' => Request::input('password')
        ];
        return self::log($data);
    }

    private static function sendErrorMessageOnAuthenticationFailure(): RedirectResponse
    {
        return FlashMessage::redirectBackWithErrorMessage('Couple courriel/mot de passe invalide!');
    }

    private static function login($results, array $data, string $type): RedirectResponse
    {
        $user_id = $results->id;
        $user = UtilisateurModel::find($user_id);
        $state = $user->getState();

        if ($state === UserStateEnum::STATE_DISABLED)
            return FlashMessage::redirectBackWithInfoMessage("Votre compte est désactivé! Vous ne pouvez pas vous connecter! Contactez l'administrateur s'il s'agit d'une erreur!");
        if ($state === UserStateEnum::STATE_NEWLY_CREATED)
            return FlashMessage::redirectBackWithInfoMessage("Vous devez valider votre adresse de courriel avant de pouvoir vous connecter!");

        if ($results == NULL)
            return self::sendErrorMessageOnAuthenticationFailure(); // Adresse e-mail invalide!
        else
            if (!Hash::check($data['password'], $results->mdp))
                return self::sendErrorMessageOnAuthenticationFailure(); // Mot de passe invalide!
            else {
                Request::session()->put('id', $user_id);
                Request::session()->put('type', $type);
                return FlashMessage::redirectWithSuccessMessage(Redirect::to('/'), 'Vous êtes connecté!');
            }
    }

    private static function log(array $data): RedirectResponse
    {
        $user = UtilisateurModel::getUserFromEmail($data['courriel']);

        if ($user === null)
            return self::sendErrorMessageOnAuthenticationFailure();

        $auth_type = $user->isAdmin() ? AuthEnum::AUTH_ADMIN : AuthEnum::AUTH_PERSONNEL;
        return self::login($user, $data, $auth_type);
    }
}
