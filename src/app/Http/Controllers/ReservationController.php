<?php

namespace App\Http\Controllers;

use App\Utils\FlashMessage;
use Illuminate\Http\RedirectResponse;

class ReservationController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        return FlashMessage::notYetImplemented();
    }
}
