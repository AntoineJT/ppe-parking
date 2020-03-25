<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Utils\FlashMessage;
use App\Utils\SessionManager;
use App\Utils\TimeManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ConfigurationController extends Controller
{
    public function show(): string
    {
        $duration = Config::getExpirationTime();

        return view('admin.configuration', [
            'access' => ACCESS_ADMIN,
            // On le récupère comme ça car carbon gère les mois, etc.
            'days' => floor($duration->timestamp /60 /60 /24),
            'hours' => $duration->hour,
            'minutes' => $duration->minute
        ]);
    }

    public function __invoke(): RedirectResponse
    {
        $validator = Validator::make(Request::all(), [
            'action' => [
                'required',
                Rule::in([
                    'expiration',
                    'full-refresh'
                ])
            ]
        ]);
        if ($validator->fails())
            return FlashMessage::redirectBackWithWarningMessage("Le formulaire n'a pas été renseigné correctement!");
        if (!SessionManager::isAdmin())
            return FlashMessage::redirectBackWithErrorMessage("Vous n'êtes pas administrateur! Action impossible!");

        switch (Request::input('action')) {
            case 'expiration':
                return self::expiration();
            case 'full-refresh':
                return self::fullRefresh();
        }

        return FlashMessage::notYetImplemented();
    }

    private static function expiration(): RedirectResponse
    {
        $validator = Validator::make(Request::all(), [
            'jours' => 'required',
            'heures' => 'required|between:0,23',
            'minutes' => 'required|between:0,59'
        ]);
        if ($validator->fails())
            return FlashMessage::redirectBackWithWarningMessage("Le formulaire n'a pas été renseigné correctement!");

        $time = TimeManager::unixBeginTime()
            ->addRealMinutes(Request::input('minutes'))
            ->addRealHours(Request::input('heures'))
            ->addRealDays(Request::input('jours'));
        $duration = $time->timestamp / 60;
        //$duration = ($time->day-1)*24*60 + $time->hour*60 + $time->minute;

        if (!Config::setExpirationTime($duration))
            return FlashMessage::redirectBackWithErrorMessage("La durée avant expiration n'a pu être mise à jour!");
        return FlashMessage::redirectBackWithSuccessMessage("La durée avant expiration a bien été mise à jour!");
    }

    private static function fullRefresh(): RedirectResponse
    {
        $fails = !DB::unprepared('CALL FULL_REFRESH_AVAILABILITIES');
        if ($fails)
            return FlashMessage::redirectBackWithErrorMessage("La disponibilité des places n'a pu être recalculée!");
        return FlashMessage::redirectBackWithSuccessMessage('La disponibilité des places a été recalculée!');
    }
}
