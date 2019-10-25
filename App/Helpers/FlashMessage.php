<?php

namespace App\Helpers;

class FlashMessage {
    private static $sessionCache;
    const SESSION_NAME = '_FLASHMESSAGE';

    public static function setMessage ($name, $data) {
        if (!isset($_SESSION[SELF::SESSION_NAME])) {
            $_SESSION[SELF::SESSION_NAME] = [];    
        }
        $_SESSION[SELF::SESSION_NAME][$name] = $data;
    }

    public static function hasMessage ($name) {
        return !empty(SELF::getMessage($name));
    }

    public static function getMessage ($name) {
        if (!isset($_SESSION[SELF::SESSION_NAME]) && !isset(SELF::$sessionCache)) return null;
        if (!isset(SELF::$sessionCache)) {
            SELF::$sessionCache = $_SESSION[SELF::SESSION_NAME];
            unset($_SESSION[SELF::SESSION_NAME]);
        }

        if (empty(SELF::$sessionCache)) {
            return null;
        }

        if (!isset(SELF::$sessionCache[$name])) {
            return null;
        }

        return SELF::$sessionCache[$name];
    }
}