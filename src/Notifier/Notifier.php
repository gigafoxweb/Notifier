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
	 * @param Notification|array|string|callable $notificationConfig
	 * * @throws \Exception
	 * @return Notification
	 */
	public static function createNotification($notificationConfig) {
		$notification = $notificationConfig;
		if (is_array($notificationConfig)) {
			$message = array_key_exists(0, $notificationConfig) ? $notificationConfig[0] : '';
			$params = array_key_exists(1, $notificationConfig) ? $notificationConfig[1] : [];
			$notification = new Notification($message, $params);
		} elseif (is_string($notificationConfig)) {
			$notification = new Notification($notificationConfig);
		} elseif (is_callable($notificationConfig)) {
			$notification = call_user_func($notificationConfig);
		}
		if (!$notification instanceof Notification) {
			throw new \Exception("Wrong notification config: " . static::class);
		}
		return $notification;
	}

	/**
	 * @param string $key
	 * @param NotificationFilter[]|Callable[]|array $filters
	 */
	public static function showNotification($key, array $filters = []) {
    	$notification = static::getNotification($key);
		if ($notification instanceof Notification) {
			$notification = self::useFilters($notification, $filters);
			echo $notification->getMessage();
			static::removeNotification($key);
		}
    }

	/**
	 * @param $key
	 * @param array $filters
	 *
	 * @return Notification|null
	 */
	public static function getFiltratedNotification($key, array $filters = []) {
		$notification = static::getNotification($key);
		if ($notification instanceof Notification) {
			$notification = self::useFilters($notification, $filters);
			static::removeNotification($key);
		}
		return $notification;
	}

	/**
	 * @param array $search
	 * @param NotificationFilter[]|Callable[]|array $filters
	 */
	public static function showNotificationsBy(array $search = [], array $filters = []) {
		$notifications = self::searchBy($search);
		foreach ($notifications as $notificationKey => $notification) {
			self::showNotification($notificationKey, $filters);
		}
	}

	/**
	 * @param array $search
	 * @param NotificationFilter[]|Callable[]|array $filters
	 *
	 * @return array|Notification[]
	 */
	public static function getNotificationsBy(array $search = [], array $filters = []) {
		$notifications = self::searchBy($search);
		foreach ($notifications as $notificationKey => $notification) {
			$notifications[$notificationKey] = self::getFiltratedNotification($notificationKey, $filters);
		}
		return $notifications;
	}

	/**
	 * @param Notification $notification
	 * @param NotificationFilter[]|Callable[]|array $filters
	 *
	 * @return Notification
	 */
	public static function useFilters(Notification $notification, array $filters = []) {
		foreach ($filters as $filter) {
			if (is_array($filter)) {
				if (isset($filter['function'])) {
					$search = (isset($filter['search'])) ? $filter['search'] : [];
					$filter = new InlineNotificationFilter($filter['function'], $search);
				}
			} elseif (is_callable($filter)) {
				$filter = new InlineNotificationFilter($filter);
			}
			if ($filter instanceof NotificationFilter) {
				if ($filter->isFor($notification)) {
					$filter->filtrate($notification);
				}
			}
		}
		return $notification;
	}

	/**
     * @param array $search
     * @return Notification[]|array
     */
    public static function searchBy(array $search = []) {
		$notifications = array_key_exists('keys', $search) ? self::searchNotificationsByKeys($search['keys']) : static::getAllNotifications('array');
        $notifications = array_key_exists('prefix', $search) ? Helper::searchByKeyPrefix($search['prefix'], $notifications) : $notifications;
        $notifications = array_key_exists('params', $search) ? Helper::searchByParams($search['params'], $notifications) : $notifications;
        $notifications = array_key_exists('function', $search) ? Helper::searchByFunction($search['function'], $notifications) : $notifications;
        return $notifications;
    }

    /**
     * @param array $keys
     * @return Notification[]|array
     */
    public static function searchNotificationsByKeys(array $keys = []) {
        $notifications = [];
        foreach ($keys as $key) {
            $notification = static::getNotification($key);
            if ($notification instanceof Notification) {
                $notifications[$key] = $notification;
            }
        }
        return $notifications;
    }

    /**
     * @param string $prefix
     * @param array $keys
     * @return Notification[]|array
     */
    public static function searchNotificationsByKeyPrefix($prefix, array $keys = []) {
        $notifications = empty($keys) ? static::getAllNotifications('array') : self::searchNotificationsByKeys($keys);
        return Helper::searchByKeyPrefix($prefix, $notifications);
    }

    /**
     * @param string $prefix
     * @param Notification[]|array $notifications
     * @return array
     */
    public static function searchNotificationsKeysByKeyPrefix($prefix, array $notifications = []) {
        $notifications = empty($notifications) ? static::getAllNotifications('array') : $notifications;
        return array_keys(Helper::searchByKeyPrefix($prefix, $notifications));
    }


	/**
	 * @param array $params
	 * @param array $keys
	 * @return Notification[]|array
	 */
	public static function searchNotificationsByParams(array $params = [], array $keys = []) {
		$notifications = empty($keys) ? static::getAllNotifications('array') : self::searchNotificationsByKeys($keys);
		return Helper::searchByParams($params, $notifications);
	}

	/**
     * @param array $params
     * @param Notification[] $notifications
     * @return array
     */
    public static function searchNotificationKeysByParams(array $params = [], array $notifications = []) {
        $notifications = empty($notifications) ? static::getAllNotifications('array') : $notifications;
        return array_keys(Helper::searchByParams($params, $notifications));
    }

    /**
     * @param callable $function
     * @param array $keys
     * @return Notification[]|array
     */
    public static function searchNotificationsByFunction(callable $function, array $keys = []) {
        $notifications = empty($keys) ? static::getAllNotifications('array') : self::searchNotificationsByKeys($keys);
        return Helper::searchByFunction($function, $notifications);
    }

    /**
     * @param callable $function
     * @param Notification[] $notifications
     * @return array
     */
    public static function searchNotificationsKeysByFunction(callable $function, array $notifications = []) {
        $notifications = empty($notifications) ? static::getAllNotifications('array') : $notifications;
        return array_keys(Helper::searchByFunction($function, $notifications));
    }

}