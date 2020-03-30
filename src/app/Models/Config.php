<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Config extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'config';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'key';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public const EXPIRATION_TIME = 'expiration.time';

    private static function expiration()
    {
        return Config::find(self::EXPIRATION_TIME);
    }

    public static function getExpirationTime(): Carbon
    {
        return Carbon::createFromTimestamp(self::expiration()->value*60, '+00');
    }

    public static function getRawExpirationTime(): int
    {
        return self::expiration()->value;
    }

    public static function setExpirationTime(int $new_duration): bool
    {
        $expiration = self::expiration();
        $expiration->value = $new_duration;
        return $expiration->save();
    }
}
