<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */

namespace GigaFoxWeb\Notifier;


/**
 * Interface INotifier
 * @package GigaFoxWeb\Notifier
 */
interface INotifier {

    /**
     * @param string $key
     * @param Notification|array|string|callable $notificationConfig
     */
    public static function setNotification($key, $notificationConfig);

    /**
     * @param string $key
     * @return Notification|null
     */
    public static function getNotification($key);

	/**
	 * @param string $key
	 */
	public static function removeNotification($key);

	/**
	 * @param string $key
	 * @param NotificationFilter[]|Callable[]|array $filters
	 */
	public static function showNotification($key, array $filters = []);

    /**
     * @param string $type
     * @return mixed
     */
    public static function getAllNotifications($type = 'array');

    /**
     * @return string
     */
    public static function getClassName();

}