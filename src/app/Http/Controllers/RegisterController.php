<?php

namespace App\Http\Controllers;

use App\Enums\UserStateEnum;
use App\Mail\ResetLink;
use App\Models\LienResetModel;
use App\Models\PersonnelModel;
use App\Models\UtilisateurModel;
use App\Utils\Database\AccountManager;
use App\Utils\FlashMessage;
use App\Utils\SessionManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use App\Enums\AuthEnum;
use App\Utils\Generator;

// TODO Vérifier si nom et prénom déjà dans DB!!
class RegisterController extends Controller
{
    public function register(): RedirectResponse
    {
        $rules = [
            'nom' => 'required',
            'prenom' => 'required',
            'courriel' => 'required',
        ];
        $validator = Validator::make(Request::all(), $rules);
        if ($validator->fails()) {
            return FlashMessage::redirectBackWithWarningMessage("Le formulaire n'est pas bien renseigné!")
                ->withInput(Request::except('mdp'));
        }
        $data = [
            'nom' => Request::input('nom'),
            'prenom' => Request::input('prenom'),
            'courriel' => Request::input('courriel'),
        ];
        $user = self::registerPersonnel($data);
        if ($user === null
            || !AccountManager::isUserIdValid($user->id))
            return FlashMessage::redirectBackWithErrorMessage("L'enregistrement a échoué!");
        $reset_link = Generator::generateResetLink();
        if (!LienResetModel::saveResetLink($user->id, $reset_link)) {
            return FlashMessage::redirectBackWithErrorMessage("L'enregistrement a échoué!");
        }
        Mail::to($data['courriel'])->send(new ResetLink($reset_link));
        return FlashMessage::redirectBackWithSuccessMessage('Vous avez bien été inscrit!')
            ->with('info', "Un lien vous a été envoyé par courriel! Il permet de choisir un mot de passe et de pré-valider votre compte!")
            ->with('warning', "Votre compte ne sera pas utilisable tant qu'un administrateur ne l'aura pas validé!");
    }

    private static function registerPersonnel(array $data): ?PersonnelModel
    {
        $user = UtilisateurModel::create($data['nom'], $data['prenom'], $data['courriel']);
        if (!AccountManager::isUserIdValid($user->id))
            return null;
        return PersonnelModel::addUser($user);
    }
}
