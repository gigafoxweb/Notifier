<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */

namespace GigaFoxWeb\Notifier;


/**
 * Class Helper
 * @package GigaFoxWeb\Notifier
 */
class Helper {

    /**
     * @param string $prefix
     * @param Notification[] $notifications
	 * @throws NotifierException
	 * @return Notification[]
     */
    public static function searchByKeyPrefix($prefix, array $notifications = []) {
        foreach ($notifications as $key => $notification) {
			if (!$notification instanceof Notification) {
				throw new NotifierException("Notification {$key} does not instanceof Notification");
			}
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
     * @param Notification[] $notifications
	 * * @throws NotifierException
     * @return Notification[]
     */
    public static function searchByParams(array $params, array $notifications = []) {
        foreach ($notifications as $key => $notification) {
			if (!$notification instanceof Notification) {
				throw new NotifierException("Notification {$key} does not instanceof Notification");
			}
            if (!self::checkByParams($params, $notification)) {
                unset($notifications[$key]);
            }
        }
        return $notifications;
    }


    /**
     * @param callable $function
     * @param Notification[] $notifications
	 * * @throws NotifierException
     * @return Notification[]
     */
    public static function searchByFunction(callable $function, array $notifications = []) {
        foreach ($notifications as $key => $notification) {
            if (!$notification instanceof Notification) {
                throw new NotifierException("Notification {$key} does not instanceof Notification");
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
     * @return bool
     */
    public static function checkByFunction(callable $function, Notification $notification) {
        return call_user_func($function, $notification);
    }

    /**
     * @param array $searchParams
	 * @param Notification $notification
     * @return bool
     * @throws NotifierException
     */
    public static function checkByParams(array $searchParams, Notification $notification) {
        //example search : [['param1' , 'value1'], 'param2', ['param3' , 'value3']]
        $result = true;
		$params = $notification->getParams();
        foreach ($searchParams as $s) {
            if (is_array($s)) {
                if (!array_key_exists(0, $s) || !array_key_exists(1, $s)) {
                    throw new NotifierException('Array search item must contains key and value like: [$key, $value]');
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