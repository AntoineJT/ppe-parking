<?php

namespace App\Models;

use App\Enums\ReservationStateEnum;
use App\Utils\AssertionManager;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @param Personnel $personnel
     * @param Collection $available_places
     * @return Reservation|null
     */
    public static function create(Personnel $personnel, ?Collection $available_places): ?Reservation
    {
        $reservation = null;
        AssertionManager::setAssertException(true);
        DB::transaction(function () use ($personnel, $available_places, &$reservation) {
            $in_queue = ($available_places === null);
            $place = (!$in_queue) ? $available_places->random() : null;

            $reservation = new Reservation;
            $reservation->date_demande = Carbon::now()->toDateTimeString();
            $reservation->date_expiration = Carbon::now()->addRealMinutes(Config::getRawExpirationTime());
            $reservation->id_personnel = $personnel->id;
            $reservation->type_statut = ($in_queue) ? ReservationStateEnum::WAITING : ReservationStateEnum::ACTIVE;
            $reservation->id_place = (!$in_queue) ? $place->id : null;
            assert($reservation->save());

            if (!$in_queue) {
                $place->disponible = false;
                assert($place->save());
            }

            $personnel->rang = ($in_queue) ? Personnel::max('rang') + 1 : null;
            assert($personnel->save());
        });
        AssertionManager::rollbackAssertException();
        return $reservation;
    }

    public function getPlace(): ?Place
    {
        if ($this->id_place === null)
            return null;
        return Place::find($this->id_place);
    }

    public static function getActiveReservations(Personnel $personnel)
    {
        return Reservation::where('type_statut', ReservationStateEnum::ACTIVE)
            ->orWhere('type_statut', '=', ReservationStateEnum::WAITING)
            ->where('id_personnel', '=', $personnel->id);
    }
}
