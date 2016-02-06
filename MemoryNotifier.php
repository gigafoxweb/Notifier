<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */

namespace GigaFoxWeb;


/**
 * Class MemoryNotifier
 * @package GigaFoxWeb
 */
class MemoryNotifier extends Notifier {


    /**
     * @var array
     */
    private static $notifications = [];

    /**
     * @param $key
     * @param null $value
     * @param array $params
     * @throws NotifierException
     */
    public static function set($key, $value = null, array $params = [])
    {
        if (empty($value)) {
            unset(self::$notifications[$key]);
        } else {
            if (!is_string($value)) {
                throw new NotifierException('The notification must be a string');
            }
            self::$notifications[$key] = ['value' => $value, 'params' => $params];
        }
    }

    /**
     * @param $key
     * @return null
     */
    public static function get($key)
    {
        return isset(self::$notifications[$key]) ? self::$notifications[$key] : null;
    }


    /**
     * @param string $type
     * @return array|string
     */
    public static function getAll($type = 'array')
    {
        $n = self::$notifications;
        switch ($type) {
            case 'array' :
                break;
            case 'json' :
                $n = json_encode($n);
                break;
        }
        return $n;
    }

}