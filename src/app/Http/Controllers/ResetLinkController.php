<?php

namespace App\Http\Controllers;

use App\Enums\StateEnum;
use App\Enums\UserStateEnum;
use App\Mail\ResetLink;
use App\Models\ResetLinkModel;
use App\Utils\Database\AccountManager;
use App\Utils\FlashMessage;
use App\Utils\Generator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class ResetLinkController extends Controller
{
    public function createResetLink()
    {
        $rules = [
            'courriel' => 'required'
        ];
        $validator = Validator::make(Request::all(), $rules);
        if ($validator->fails()) {
            return FlashMessage::redirectWithWarningMessage(Redirect::to('/connexion'), "Vous devez saisir l'adresse de courriel associée à votre compte pour générer un lien de réinitialisation de mot de passe");
        }

        $email = Request::input('courriel');
        $user_id = AccountManager::getUserIdFromEmail($email);

        if (!AccountManager::isUserIdValid($user_id))
            return self::redirectToHomeWithFlashMessage();
        if (AccountManager::getUserState($user_id) === UserStateEnum::STATE_DISABLED)
            return FlashMessage::redirectWithInfoMessage(Redirect::to('/connexion'), 'Votre compte est désactivé! Vous ne pouvez, par conséquent, créer un lien de réinitialisation de mot de passe!');

        $reset_link = self::generateResetLink($email);

        if (!self::isResetLinkValid($reset_link))
            return self::redirectToHomeWithFlashMessage();
        if (!ResetLinkModel::saveResetLink($user_id, $reset_link))
            return self::redirectToHomeWithFlashMessage();

        self::sendResetLinkByMail($email, $reset_link);
        return self::redirectToHomeWithFlashMessage();
    }

    private static function redirectToHomeWithFlashMessage(): RedirectResponse
    {
        $message = 'Si un compte est associé à cette adresse e-mail, un lien de réinitialisation de mot de passe sera envoyé!';
        return FlashMessage::redirectWithInfoMessage(Redirect::to('/connexion'), $message);
    }

    private static function isResetLinkValid(string $reset_link): bool
    {
        return $reset_link !== 'ERROR';
    }

    private static function generateResetLink(string $email): string
    {
        if (!AccountManager::isMailLinkedWithAccount($email))
            return 'ERROR';
        return Generator::generateResetLink();
    }

    private static function sendResetLinkByMail(string $email_to, string $reset_link): void
    {
        Mail::to($email_to)->send(new ResetLink($reset_link));
    }
}
