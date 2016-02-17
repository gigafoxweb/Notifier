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
     * @param string $value
     * @param array $params
     */
    public static function set($key, $value = null, array $params = []);

    /**
     * @param string $key
     * @return Notification
     */
    public static function get($key);

    /**
     * @param string|Notification $notification
     * @param null|NotificationFiltrator $filtrator
     */
    public static function show($key, $filtrator = null);

    /**
     * @param string $type
     * @return array|string
     */
    public static function getAll($type = 'array');

    /**
     * @param null $filtrator
     * @param array $search
     */
    public static function showAll($filtrator = null, array $search = []);

    /**
     * @return mixed
     */
    public static function getClassName();

}