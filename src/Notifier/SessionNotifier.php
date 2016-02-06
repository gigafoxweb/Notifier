<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */

namespace GigaFoxWeb\Notifier;


/**
 * Class SessionNotifier
 * @package GigaFoxWeb
 */
class SessionNotifier extends Notifier {

    private static $prefix = 'GFW_notification_';

    public static function set($key, $value = null, array $params = [])
    {
        self::checkError();
        if (empty($value)) {
            unset($_SESSION[self::$prefix][$key]);
        } else {
            if (!is_string($value)) {
                throw new NotifierException('The notification must be a string');
            }
            $_SESSION[self::$prefix][$key] = ['value' => $value, 'params' => $params];
        }
    }

    public static function get($key)
    {
        self::checkError();
        return isset($_SESSION[self::$prefix][$key]) ? $_SESSION[self::$prefix][$key] : null;
    }


    public static function getAll($type = 'array')
    {
        self::checkError();
        $n = isset($_SESSION[self::$prefix]) ? $_SESSION[self::$prefix] : [];
        switch ($type) {
            case 'array' :
                break;
            case 'json' :
                $n = json_encode($n);
                break;
        }
        return $n;
    }


    private static function checkError()
    {
        if (!session_id()) {
            throw new SessionNotifierException('Session did not start');
        }
    }


}