<?php

namespace App\Models;

use App\Enums\UserStateEnum;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
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
