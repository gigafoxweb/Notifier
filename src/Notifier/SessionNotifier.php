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
     * @param $key
     * @param null $value
     * @param array $params
     * @throws NotifierException
     * @throws SessionNotifierException
     */
    public static function set($key, $value = null, array $params = [])
    {
        self::checkError();
        if (empty($value)) {
            unset($_SESSION[self::$prefix][$key]);
        } else {
            if (!is_string($value)) {
                throw new NotifierException('The notification message must be a string');
            }
            $_SESSION[self::$prefix][$key] = ['value' => $value, 'params' => $params];
        }
    }

    /**
     * @param $key
     * @return Notification|null
     * @throws SessionNotifierException
     */
    public static function get($key)
    {
        self::checkError();
        $notification = null;
        if (isset($_SESSION[self::$prefix][$key])) {
            $notification = self::createNotificationObject($key, $_SESSION[self::$prefix[$key]]);
        }
        return $notification;
    }

    /**
     * @param string $type
     * @return array|string
     * @throws SessionNotifierException
     */
    public static function getAll($type = 'array')
    {
        self::checkError();
        $notifications = [];
        if (isset($_SESSION[self::$prefix])) {
            foreach ($_SESSION[self::$prefix] as $key => $notification) {
                $notifications[$key] = self::createNotificationObject($key, $notification);
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
     * @param $key
     * @param array $notificationArray
     * @return Notification
     */
    private static function createNotificationObject($key, array $notificationArray) {
        $notification = new Notification();
        $notification->id = $key;
        $notification->value = $notificationArray['value'];
        $notification->params = $notificationArray['params'];
        return $notification;
    }

    /**
     * @throws SessionNotifierException
     */
    private static function checkError()
    {
        if (!session_id()) {
            throw new SessionNotifierException('Session did not start');
        }
    }


}