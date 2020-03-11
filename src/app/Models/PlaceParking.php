<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceParking extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'places';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'numero';

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
}
