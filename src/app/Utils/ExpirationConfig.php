<?php


namespace App\Utils;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileNotFoundException;

// TODO Peut être utiliser https://github.com/yosymfony/Toml
trait ExpirationConfig
{
    private static $filename = 'expiration.txt';

    // can this be null?

    /**
     * @param Carbon $date
     * @return Carbon
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function getExpirationDate(Carbon $date): Carbon
    {
        $content = Storage::get(self::$filename);
        // TODO it would be better to throw another exception
        if ($content === null || !is_int($content))
            throw new \Illuminate\Contracts\Filesystem\FileNotFoundException;
        $date->addRealMinutes(intval($content));
        return $date;
    }

    public static function set(string $content): string
    {
        return Storage::disk('local')->put(self::$filename, $content);
    }
}
