<?php
namespace GigaFoxWeb;


/**
 * Class Notifier
 * @package GigaFoxWeb
 */
abstract class Notifier implements INotifier
{


    /**
     * @param $key
     * @param null $filter
     * @throws NotifierException
     */
    public static function show($key, $filter = null)
    {
        $notification = static::get($key);
        if (!empty($notification)) {
            if (!empty($filter)) {
                if ($filter instanceof NotificationFilter) {
                    $notification['value'] = $filter->filtrate($notification);
                } else if (is_callable($filter)) {
                    $paramsFilter = new NotificationFilter();
                    $paramsFilter->add($filter);
                    $notification['value'] = $paramsFilter->filtrate($notification);
                } else if (is_array($filter)) {
                    // @todo array with filter functions given
                }
                static::set($key, $notification['value'], $notification['params']);
            }
            static::set($key, null);
            echo $notification['value'];
        }

    }


    /**
     * @param null $filter
     * @param array $keys
     */
    public static function showAll($filter = null, array $keys = [])
    {
        $keys = !empty($keys) ? $keys : array_keys(static::getAll());
        foreach ($keys as $key) {
            static::show($key, $filter);
        }
    }

}