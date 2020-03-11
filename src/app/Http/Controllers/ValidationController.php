<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use App\Utils\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class ValidationController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $validator = Validator::make(\Illuminate\Support\Facades\Request::all(), [
            'id' => 'required'
        ]);
        if ($validator->fails())
            return FlashMessage::redirectWithErrorMessage(Redirect::to('/admin/valider'), "L'identifiant de l'utilisateur n'a pas été fourni!");

        $user_id = Request::input('id');
        //

        return FlashMessage::redirectWithInfoMessage(Redirect::to('/admin/valider'), 'This feature is not yet implemented!');
        // return FlashMessage::redirectWithSuccessMessage(Redirect::to('/admin/valider'), "L'utilisateur a bien été validé!");
    }
}
