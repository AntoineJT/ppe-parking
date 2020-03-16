<?php

namespace App\Http\Controllers\user;

use App\Enums\UserStateEnum;
use App\Models\Utilisateur;
use App\Utils\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use App\Enums\AuthEnum;

class BookingController extends Controller
{
    public function create(Request $id)
    {
        $user = User::find($id)->first();
        $place = Place::where('available', TRUE)
                      ->first();

        if ( empty($place) )
        {
            $user->joinRank();
            flash('Vous êtes sur liste d\'attente et votre demande de réservation est au rang  '.$user->rank)->important();
        }else
        {
            create(['user_id' => $user->id, 'place_id' => $place->id]);
            $place->available = FALSE;
            $place->save();
            flash('Vous avez votre place N° '.$place->id)->success()->important();
        }

        return redirect()->back();
    }
