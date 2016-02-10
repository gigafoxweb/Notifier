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
     * @param array $config options by which you can find the notifications (prefix, 'paramsKeys', 'keys')
     *
     */
    public static function showAll($filtrator = null, array $config = [])
    {
        $notifications = static::getAll();
        $keys = [];
        if (!empty($config)) {
            if (!isset($config['keys']) && !isset($config['prefix']) && !isset($config['params'])) {
                throw new NotifierException('wrong config for showAll method!');
            }
            if (isset($config['keys'])) {
                $notifications = [];
                foreach ($config['keys'] as $key) {
                    $notification = static::get($key);
                    if(!empty($notifications)) {
                        $notifications[] = $notification;
                    }
                }
            }
            if (isset($config['prefix'])) {
                foreach ($notifications as $key => $value) {
                    if (strpos($key, $config['prefix']) === 0) {
                        $keys[] = $key;
                    }
                }
            }
            if (isset($config['paramsKeys'])) {
                //example : [['param1' , 'value1'], 'param2', ['param3' , 'value3']]
                foreach ($notifications as $key => $value) {
                    if (is_array($config['paramsKeys'])) {
                        $r = true;
                        foreach ($config['paramsKeys'] as $param) {
                            if (is_array($param)) {
                                if (!isset($param[0]) || !isset($param[1])) {
                                    throw new NotifierException('array param key must contains key and value like [$key, $value]');
                                }
                                if (!array_key_exists($param[0], $value['params']) || $value['params'][$param[0]] !== $param[1]) {
                                    $r = false;
                                    break;
                                };
                            } elseif(is_string($param)) {
                                if (!array_key_exists($param, $value['params'])) {
                                    $r = false;
                                    break;
                                }
                            }
                        }
                        if ($r) {
                            $keys[] = $key;
                        }
                    } elseif (is_string($config['params'])) {
                        if (array_key_exists($config['params'], $value['params'])) {
                            $keys[] = $key;
                        }
                    }
                }
            }
        } else {
            $keys = array_keys($notifications);
        }

        $keys = array_unique($keys);
        foreach ($keys as $key) {
            static::show($key, $filtrator);
        }
    }

}