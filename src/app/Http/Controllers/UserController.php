<?php

namespace App\Http\Controllers;

use App\Enums\UserStateEnum;
use App\Models\LienReset;
use App\Models\Ligue;
use App\Models\Personnel;
use App\Models\Utilisateur;
use App\Utils\AssertionManager;
use App\Utils\FlashMessage;
use App\Utils\SessionManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
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
                    'disable',
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

        $personnel = $user->toPersonnel();
        if ($personnel === null)
            return FlashMessage::redirectBackWithErrorMessage("L'utilisateur n'est pas un membre du personnel!");

        switch (Request::input('action')) {
            case 'validate':
                return self::validateIt($personnel);
            case 'modify':
                return self::modify($user);
            case 'change-password':
                return self::changePassword($user);
            case 'disable':
                return self::disable($personnel);
            case 'delete':
                return self::delete($personnel);
        }
        return FlashMessage::notYetImplemented();
    }

    private static function validateIt(Personnel $personnel): RedirectResponse
    {
        $success = $personnel->setState(UserStateEnum::STATE_ENABLED);

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

    private static function delete(Personnel $personnel): RedirectResponse
    {
        if (!$personnel->deleteUser())
            return FlashMessage::redirectBackWithErrorMessage("Impossible de supprimer l'utilisateur!");
        // TODO Envoyer un mail à l'utilisateur dont le compte s'est fait supprimer?
        return FlashMessage::redirectBackWithSuccessMessage("L'utilisateur a bien été supprimé!");
    }

    private static function disable(Personnel $personnel): RedirectResponse
    {
        $succeed = $personnel->setState(UserStateEnum::STATE_DISABLED);
        if (!$succeed)
            return FlashMessage::redirectBackWithErrorMessage("Impossible de désactiver ce compte!");
        return FlashMessage::redirectBackWithSuccessMessage('Le compte a été correctement désactivé!');
    }

    private static function modify(Utilisateur $user): RedirectResponse
    {
        $validator = Validator::make(Request::all(), [
            'nom' => 'required',
            'prenom' => 'required',
            'courriel' => 'required',
            'ligue' => 'required'
        ]);
        if ($validator->fails())
            return FlashMessage::redirectBackWithWarningMessage("Le formulaire n'a pas été renseigné correctement!");

        $succeed = false;
        AssertionManager::setAssertException(true); // make assert throws AssertException

        DB::transaction(function() use ($user, &$succeed) {
            $personnel = $user->toPersonnel();
            $ligue_id = Request::input('ligue');
            assert(Ligue::exists($ligue_id));
            $personnel->id_ligue = $ligue_id;
            assert($personnel->save());

            $user->nom = Request::input('nom');
            $user->prenom = Request::input('prenom');
            $user->mail = Request::input('courriel');
            assert($user->save());

            $succeed = true;
        });

        AssertionManager::rollbackAssertException(); // avoid side-effects
        if (!$succeed)
            return FlashMessage::redirectBackWithErrorMessage("Impossible d'effectuer les modifications!");

        return FlashMessage::redirectBackWithSuccessMessage("Les données du compte ont bien été mises à jour!");
    }
}
