<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */

namespace GigaFoxWeb\Notifier;


/**
 * Class Notifier
 * @package GigaFoxWeb
 */
abstract class Notifier implements INotifier
{


    /**
     * @param $key
     * @param null $filtrator
     * @throws NotifierException
     */
    public static function show($key, $filtrator = null)
    {
        $notification = static::get($key);
        if (!empty($notification)) {
            if (!empty($filtrator)) {
                if ($filtrator instanceof NotificationFiltrator) {
                    $notification['value'] = $filtrator->filtrate($notification);
                } else if (is_callable($filtrator)) {
                    $paramsFilter = new NotificationFiltrator();
                    $paramsFilter->add($filtrator);
                    $notification['value'] = $paramsFilter->filtrate($notification);
                }
                static::set($key, $notification['value'], $notification['params']);
            }
            static::set($key, null);
            echo $notification['value'];
        }
    }


    /**
     * @param null $filtrator
     * @param array $keys
     */
    public static function showAll($filtrator = null, array $keys = [])
    {
        $keys = !empty($keys) ? $keys : array_keys(static::getAll());
        foreach ($keys as $key) {
            static::show($key, $filtrator);
        }
    }

}