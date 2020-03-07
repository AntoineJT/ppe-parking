<?php

namespace App\Models;

use App\Enums\UserStateEnum;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function getState(): int
    {
        return UserStateEnum::STATE_ENABLED;
    }
}
