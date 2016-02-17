<?php
namespace GigaFoxWeb\Notifier;

/**
 * Class Helper
 * @package GigaFoxWeb\Notifier
 */
class Helper {

    /**
     * @param $prefix
     * @param array $notifications
     * @return array
     */
    public static function searchByKeyPrefix($prefix, array $notifications) {
        foreach ($notifications as $key => $notification) {
            if (is_string($prefix)) {
                if (strpos($key, $prefix) !== 0) {
                    unset($notifications[$key]);
                }
            } else {
                if (is_array($prefix)) {
                    $r = false;
                    foreach ($prefix as $p) {
                        if (strpos($key, $p) === 0) {
                            $r = true;
                            break;
                        }
                    }
                    if (!$r) {
                        unset($notifications[$key]);
                    }
                }
            }
        }
        return $notifications;
    }


    /**
     * @param array $params
     * @param array $notifications
     * @return array
     * @throws NotifierException
     */
    public static function searchByParams(array $params, array $notifications) {
        foreach ($notifications as $key => $notification) {
            if (!$notification instanceof Notification) {
                throw new NotifierException("Nottification {$key} does not instanceof Notification");
            }
            if (!self::checkByParams($params, $notification->params)) {
                unset($notifications[$key]);
            }
        }
        return $notifications;
    }


    /**
     * @param callable $function
     * @param array $notifications
     * @return array
     * @throws NotifierException
     */
    public static function searchByFunction(callable $function, array $notifications) {
        foreach ($notifications as $key => $notification) {
            if (!$notification instanceof Notification) {
                throw new NotifierException("Nottification {$key} does not instanceof Notification");
            }
            if (!self::checkByFunction($function, $notification)) {
                unset($notifications[$key]);
            }
        }
        return $notifications;
    }

    /**
     * @param callable $function
     * @param Notification $notification
     * @return mixed
     */
    public static function checkByFunction(callable $function, Notification $notification) {
        return $function($notification);
    }

    /**
     * @param array $searchParams
     * @param array $params
     * @return bool
     * @throws NotifierException
     */
    public static function checkByParams(array $searchParams, array $params) {
        //example search : [['param1' , 'value1'], 'param2', ['param3' , 'value3']]
        $result = true;
        foreach ($searchParams as $s) {
            if (is_array($s)) {
                if (!isset($s[0]) || !isset($s[1])) {
                    throw new NotifierException('array search key must contains key and value like [$key, $value]');
                }
                if (!array_key_exists($s[0], $params) || $params[$s[0]] !== $s[1]) {
                    $result = false;
                    break;
                };
            } elseif(is_string($s)) {
                if (!array_key_exists($s, $params)) {
                    $result = false;
                    break;
                }
            }
        }
        return $result;
    }

}