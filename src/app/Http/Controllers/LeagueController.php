<?php

namespace App\Http\Controllers;

use App\Utils\FlashMessage;
use Illuminate\Http\RedirectResponse;

class LeagueController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        return FlashMessage::redirectBackWithInfoMessage("Cette fonctionnalité n'est pas encore implémentée!");
    }
}
