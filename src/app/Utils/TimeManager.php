<?php


namespace App\Utils;


use Illuminate\Support\Carbon;

trait TimeManager
{
    public static function unixBeginTime(): Carbon
    {
        return Carbon::createFromTimestamp(0, '+00');
    }

    // TODO Déplacer la logique du temps située dans ConfigController ici
}
