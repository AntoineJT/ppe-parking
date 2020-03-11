<?php

namespace App\Http\Controllers;

use App\Mail\ResetLink;
use App\Models\LienReset;
use App\Models\Personnel;
use App\Models\Utilisateur;
use App\Utils\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

// TODO Vérifier si nom et prénom déjà dans DB!!
class RegisterController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $validator = Validator::make(Request::all(), [
            'nom' => 'required',
            'prenom' => 'required',
            'courriel' => 'required',
        ]);
        if ($validator->fails())
            return FlashMessage::redirectBackWithWarningMessage("Le formulaire n'est pas bien renseigné!")
                ->withInput(Request::except('mdp'));

        $data = [
            'nom' => Request::input('nom'),
            'prenom' => Request::input('prenom'),
            'courriel' => Request::input('courriel'),
        ];

        $personnel = self::registerPersonnel($data);
        if ($personnel === null)
            return FlashMessage::redirectBackWithErrorMessage("L'enregistrement a échoué!");

        $reset_link = LienReset::create($personnel->getUser());
        if ($reset_link === null)
            return FlashMessage::redirectBackWithErrorMessage("L'enregistrement a échoué!");

        Mail::to($data['courriel'])->send(new ResetLink($reset_link->lien));

        return FlashMessage::redirectBackWithSuccessMessage('Vous avez bien été inscrit!')
            ->with('info', "Un lien vous a été envoyé par courriel! Il permet de choisir un mot de passe et de pré-valider votre compte!")
            ->with('warning', "Votre compte ne sera pas utilisable tant qu'un administrateur ne l'aura pas validé!");
    }

    private static function registerPersonnel(array $data): ?Personnel
    {
        $user = Utilisateur::create($data['nom'], $data['prenom'], $data['courriel']);
        if ($user === null)
            return null;
        return Personnel::addUser($user);
    }
}
