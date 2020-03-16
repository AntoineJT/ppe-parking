<?php


namespace App\Utils;


trait AssertionManager
{
    private static $assert_exception = null;

    // this will only run once
    public static function initAssertException()
    {
        if (self::$assert_exception !== null)
            return;
        self::$assert_exception = ini_get('assert.exception');
    }

    public static function rollbackAssertException()
    {
        self::assert_die(self::$assert_exception !== null, "You can't rollback assert exception state before to init or setting it!");
        ini_set('assert.exception', self::$assert_exception);
    }

    public static function setAssertException(bool $bool)
    {
        self::initAssertException();
        ini_set('assert.exception', $bool);
    }

    private static function assert_die(bool $succeed, string $error_message)
    {
        if ($succeed)
            return;
        die($error_message);
    }
}
