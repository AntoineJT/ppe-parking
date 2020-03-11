<?php

namespace App\Http\Controllers;

use App\Enums\UserStateEnum;
use App\Mail\ResetLink;
use App\Models\LienReset;
use App\Models\Utilisateur;
use App\Utils\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class ResetLinkController extends Controller
{
    public function createResetLink()
    {
        $validator = Validator::make(Request::all(), [
            'courriel' => 'required'
        ]);
        if ($validator->fails())
            return FlashMessage::redirectWithWarningMessage(Redirect::to('/connexion'), "Vous devez saisir l'adresse de courriel associée à votre compte pour générer un lien de réinitialisation de mot de passe");

        $email = Request::input('courriel');

        $user = Utilisateur::getUserFromEmail($email);
        if ($user->getState() === UserStateEnum::STATE_DISABLED)
            return FlashMessage::redirectWithInfoMessage(Redirect::to('/connexion'), 'Votre compte est désactivé! Vous ne pouvez, par conséquent, créer un lien de réinitialisation de mot de passe!');

        $reset_link = LienReset::create($user);
        if ($reset_link === null)
            return self::redirectToHomeWithFlashMessage();

        self::sendResetLinkByMail($email, $reset_link->lien);
        return self::redirectToHomeWithFlashMessage();
    }

    private static function redirectToHomeWithFlashMessage(): RedirectResponse
    {
        $message = 'Si un compte est associé à cette adresse e-mail, un lien de réinitialisation de mot de passe sera envoyé!';
        return FlashMessage::redirectWithInfoMessage(Redirect::to('/connexion'), $message);
    }

    private static function sendResetLinkByMail(string $email_to, string $reset_link): void
    {
        Mail::to($email_to)->send(new ResetLink($reset_link));
    }
}
