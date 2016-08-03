<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */

namespace GigaFoxWeb\Notifier;


/**
 * Class SessionNotifier
 * @package GigaFoxWeb\Notifier
 */
class SessionNotifier extends Notifier {

    /**
     * @var string
     */
    private static $prefix = 'GFW_notification_';

	/**
	 * @param string $key
	 * @param array|callable|Notification|string $notificationConfig
	 */
	public static function setNotification($key, $notificationConfig) {
        static::checkError();
		$_SESSION[static::$prefix][$key] = $notificationConfig;
    }

	/**
	 * @param string $key
	 */
	public static function removeNotification($key) {
		if (isset($_SESSION[static::$prefix][$key])) {
			unset ($_SESSION[static::$prefix][$key]);
		}
	}

	/**
	 * @param string $key
	 *
	 * @return Notification|null
	 */
	public static function getNotification($key) {
        static::checkError();
        if (isset($_SESSION[static::$prefix][$key])) {
        	if (!$_SESSION[static::$prefix][$key] instanceof Notification) {
				$_SESSION[static::$prefix][$key] = self::createNotification($_SESSION[static::$prefix][$key]);
			}
            return $_SESSION[static::$prefix][$key];
        }
        return null;
    }

	/**
	 * @param string $type
	 *
	 * @return mixed
	 */
	public static function getAllNotifications($type = 'array') {
        static::checkError();
        $notifications = [];
        if (isset($_SESSION[static::$prefix])) {
            foreach ($_SESSION[static::$prefix] as $key => $notification) {
                $notifications[$key] = static::getNotification($key);
            }
        }
        switch ($type) {
            case 'array' :
                break;
            case 'json' :
                $notifications = json_encode($notifications);
                break;
        }
        return $notifications;
    }

    /**
     * @throws SessionNotifierException
     */
    private static function checkError() {
        if (!session_id()) {
            throw new SessionNotifierException('Session did not start');
        }
    }

    public function setPrefix($prefix) {
    	static::$prefix = $prefix;
	}

}