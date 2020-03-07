<?php


namespace App\Enums;


class UserStateEnum
{
    public const STATE_NEWLY_CREATED = 0;
    public const STATE_DISABLED = 1;
    public const STATE_ENABLED = 2;

    /*
    private const STATES_ORDERED = [
        self::STATE_NEWLY_CREATED,
        self::STATE_DISABLED,
        self::STATE_ENABLED,
    ];

    public static function getByValue(int $value) : UserStateEnum {
        assert($value >= 0, 'UserState value must be greater or equals to 0');
        return self::STATES_ORDERED[$value];
    }
    */
}
