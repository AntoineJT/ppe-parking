<?php

namespace App\Http\Controllers;

use App\Enums\StateEnum;
use App\Mail\ResetLink;
use App\Models\ResetLinkModel;
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
        $user_id = self::registerUser($data);
        if (!AccountManager::isUserIdValid($user_id)) {
            return FlashMessage::redirectBackWithErrorMessage("L'enregistrement a échoué!");
        }
        $reset_link = Generator::generateResetLink();
        if (!ResetLinkModel::saveResetLink($user_id, $reset_link)) {
            return FlashMessage::redirectBackWithErrorMessage("L'enregistrement a échoué!");
        }
        Mail::to($data['courriel'])->send(new ResetLink($reset_link));
        return FlashMessage::redirectBackWithSuccessMessage('Vous avez bien inscrit cet utilisateur!');
    }

    private static function registerPersonnel(array $data): int
    {
        $user_id = self::createUser($data);
        $is_valid = AccountManager::isUserIdValid($user_id) && AccountManager::addUserToPersonnel($user_id);
        return $is_valid ? $user_id : 0;
    }

    /*
    private static function registerAdmin(array $data): int
    {
        $user_id = self::createUser($data);
        $is_valid = AccountManager::isUserIdValid($user_id) && AccountManager::addUserToAdmin($user_id);
        return $is_valid ? $user_id : 0;
    }
    */

    private static function registerUser(array $data): int
    {
        if (!SessionManager::isAdmin())
            return false;

//        if ($data['type'] === AuthEnum::AUTH_PERSONNEL) {
            return self::registerPersonnel($data);

        /* } else
            if ($data['type'] === AuthEnum::AUTH_ADMIN) {
                if (!SessionManager::isSuperAdmin())
                    return false;

                return self::registerAdmin($data);
            }
        return false;
        */
    }

    private static function createUser(array $data): int
    {
        $password = Generator::generateGarbagePassword();
        $hashed_password = Hash::make($password);

        DB::beginTransaction();
        $user_id = AccountManager::getNextUserId();
        $success = DB::table('Utilisateur')
            ->insert([
                'id' => $user_id,
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'mail' => $data['courriel'],
                'mdp' => $hashed_password
            ]);
        DB::commit();
        return $success ? $user_id : 0;
    }
}
