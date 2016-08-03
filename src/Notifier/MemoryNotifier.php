<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */

namespace GigaFoxWeb\Notifier;


/**
 * Class MemoryNotifier
 * @package GigaFoxWeb\Notifier
 */
class MemoryNotifier extends Notifier {

    /**
     * @var array
     */
    private static $notifications = [];

    /**
     * @param string $key
	 * @param Notification|array|string|callable $notificationConfig
     */
    public static function setNotification($key, $notificationConfig) {
    	static::$notifications[$key] = $notificationConfig;
    }

	/**
	 * @param string $key
	 * @return Notification|null
	 */
	public static function getNotification($key) {
		if (isset(static::$notifications[$key])) {
			if (!static::$notifications instanceof Notification) {
				static::$notifications[$key] = self::createNotification(static::$notifications[$key]);
			}
			return static::$notifications[$key];
		}
		return null;
	}

	/**
	 * @param string $key
	 */
	public static function removeNotification($key) {
		if (isset(static::$notifications[$key])) {
			unset(static::$notifications[$key]);
		}
	}

    /**
     * @param string $type
     * @return mixed
     */
    public static function getAllNotifications($type = 'array')
    {
        foreach (static::$notifications as $key => $notificationConfig) {
        	static::$notifications[$key] = self::createNotification($notificationConfig);
		}
		$n = static::$notifications;
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