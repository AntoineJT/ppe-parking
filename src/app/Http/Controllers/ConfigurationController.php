<?php

namespace App\Http\Controllers;

use App\Utils\FlashMessage;
use Illuminate\Http\RedirectResponse;

class ConfigurationController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        return FlashMessage::notYetImplemented();
    }
}
