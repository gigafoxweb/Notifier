<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */
namespace GigaFoxWeb\Notifier;

/**
 * Class Notifier
 * @package GigaFoxWeb\Notifier
 */
abstract class Notifier implements INotifier
{

    /**
     * @return string
     */
    public static function getClassName() {
        return get_called_class();
    }

    /**
     * @param string|Notification $notification
     * @param null|NotificationFiltrator $filtrator
     * @throws NotifierException
     */
    public static function show($notification, $filtrator = null)
    {
        if (is_string($notification)) {
            $notification = static::get($notification);
        }
        if ($notification instanceof Notification) {
            if ($filtrator instanceof NotificationFiltrator) {
                self::useFiltrator($filtrator, $notification);
            }
            echo $notification->value;
            static::set($notification->id, null);
        } else {
            throw new NotifierException('Wrong first param for Notifier::show()');
        }
    }

    /**
     * @param null $filtrator
     * @param array $search
     * @throws NotifierException
     */
    public static function showAll($filtrator = null, array $search = [])
    {
        $notifications = self::searchBy($search);
        foreach ($notifications as $notification) {
            self::show($notification, $filtrator);
        }
    }

    /**
     * @param array $search
     * @return array|mixed
     */
    public static function searchBy(array $search) {
        $notifications = static::getAll();
        $notifications = isset($search['keys']) ? self::searchNotificationsByKeys($search['keys']) : $notifications;
        $notifications = isset($search['prefix']) ? self::searchNotificationsByKeyPrefix($search['prefix'], array_keys($notifications)) : $notifications;
        $notifications = isset($search['params']) ? self::searchNotificationsByParams($search['params'], array_keys($notifications)) : $notifications;
        $notifications = isset($search['function']) ? self::searchNotificationsByFunction($search['function'], array_keys($notifications)) : $notifications;
        return $notifications;
    }

    /**
     * @param NotificationFiltrator $filtrator
     * @param Notification $notification
     * @throws NotifierException
     */
    public static function useFiltrator(NotificationFiltrator $filtrator, Notification $notification) {
        /* @var $notification Notification */
        $filtrator->filtrate($notification);
        static::set($notification->id, $notification->value, $notification->params);
    }

    /**
     * @param array $keys
     * @return array
     */
    public static function searchNotificationsByKeys(array $keys) {
        $notifications = [];
        foreach ($keys as $key) {
            $notification = static::get($key);
            if($notification instanceof Notification) {
                $notifications[$key] = $notification;
            }
        }
        return $notifications;
    }

    /**
     * @param $prefix
     * @param array $keys
     * @return array
     */
    public static function searchNotificationsByKeyPrefix($prefix, array $keys = []) {
        $notifications = empty($keys) ? static::getAll() : self::searchNotificationsByKeys($keys);
        return Helper::searchByKeyPrefix($prefix, $notifications);
    }

    /**
     * @param $prefix
     * @param array $notifications
     * @return array
     */
    public static function searchNotificationsKeysByKeyPrefix($prefix, array $notifications = []) {
        $notifications = empty($notifications) ? static::getAll() : $notifications;
        return array_keys(Helper::searchByKeyPrefix($prefix, $notifications));
    }


    /**
     * @param array $params
     * @param array $notifications
     * @return array
     * @throws NotifierException
     */
    public static function searchNotificationKeysByParams(array $params = [], array $notifications = []) {
        $notifications = empty($notifications) ? static::getAll() : $notifications;
        return array_keys(Helper::searchByParams($params, $notifications));
    }

    /**
     * @param array $params
     * @param array $keys
     * @return array
     * @throws NotifierException
     */
    public static function searchNotificationsByParams(array $params = [], array $keys = []) {
        $notifications = empty($keys) ? static::getAll() : self::searchNotificationsByKeys($keys);
        return Helper::searchByParams($params, $notifications);
    }

    /**
     * @param callable $function
     * @param array $keys
     * @return array
     * @throws NotifierException
     */
    public static function searchNotificationsByFunction(callable $function, array $keys) {
        $notifications = empty($keys) ? static::getAll() : self::searchNotificationsByKeys($keys);
        return Helper::searchByFunction($function, $notifications);
    }

    /**
     * @param callable $function
     * @param array $notifications
     * @return array
     * @throws NotifierException
     */
    public static function searchNotificationsKeysByFunction(callable $function, array $notifications) {
        $notifications = empty($notifications) ? static::getAll() : $notifications;
        return array_keys(Helper::searchByFunction($function, $notifications));
    }

}