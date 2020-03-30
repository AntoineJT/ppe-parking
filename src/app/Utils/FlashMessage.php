<?php


namespace App\Utils;


use Illuminate\Http\RedirectResponse;

trait FlashMessage
{
    public static function redirectWithMessage(RedirectResponse $to, string $type, string $message): RedirectResponse
    {
        return $to->with($type, $message);
    }

    public static function redirectWithSuccessMessage(RedirectResponse $to, string $message): RedirectResponse
    {
        return self::redirectWithMessage($to, 'success', $message);
    }

    public static function redirectWithErrorMessage(RedirectResponse $to, string $message): RedirectResponse
    {
        return self::redirectWithMessage($to, 'error', $message);
    }

    public static function redirectWithWarningMessage(RedirectResponse $to, string $message): RedirectResponse
    {
        return self::redirectWithMessage($to, 'warning', $message);
    }

    public static function redirectWithInfoMessage(RedirectResponse $to, string $message): RedirectResponse
    {
        return self::redirectWithMessage($to, 'info', $message);
    }

    public static function redirectBackWithMessage(string $type, string $message): RedirectResponse
    {
        return self::redirectWithMessage(back(), $type, $message);
    }

    public static function redirectBackWithSuccessMessage(string $message): RedirectResponse
    {
        return self::redirectBackWithMessage('success', $message);
    }

    public static function redirectBackWithErrorMessage(string $message): RedirectResponse
    {
        return self::redirectBackWithMessage('error', $message);
    }

    public static function redirectBackWithWarningMessage(string $message): RedirectResponse
    {
        return self::redirectBackWithMessage('warning', $message);
    }

    public static function redirectBackWithInfoMessage(string $message): RedirectResponse
    {
        return self::redirectBackWithMessage('info', $message);
    }

    public static function notYetImplemented(): RedirectResponse
    {
        return self::redirectBackWithInfoMessage("Cette fonctionnalité n'est pas encore implémentée!");
    }
}
