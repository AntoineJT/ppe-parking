<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LigueModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ligue';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_ligue';

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
//    protected $keyType = 'string';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
