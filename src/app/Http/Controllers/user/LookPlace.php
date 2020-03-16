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

class PlaceController extends Controller
{
    public function show()
    {
        $places = Place::get();

        return view('home', compact('places'));
    }

    }
}
