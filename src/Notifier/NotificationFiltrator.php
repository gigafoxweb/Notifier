<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */

namespace GigaFoxWeb\Notifier;


/**
 * Class NotificationFilter
 * @package GigaFoxWeb
 */
class NotificationFiltrator {

    /**
     * @var array
     */
    private $filters = [];

    /**
     * @param callable $function
     * @param null $for
     * @return $this
     */
    public function add(callable $function, $for = null)
    {
        //$for =  (string) param key, (array) param key with value, (null) for all notifications
        $this->filters[] = ['for' => $for, 'function' => $function];
        return $this;
    }

    /**
     * @param array $notification
     * @return string
     * @throws NotifierException
     */
    public function filtrate(array $notification = [])
    {
        $r = '';
        if (!empty($notification)) {
            $r = $notification['value'];
            foreach ($this->filters as $filter) {
                if (empty($filter['for'])) {
                    $r = call_user_func($filter['function'], $r, $notification['params']);
                } elseif (is_string($filter['for'])) {
                    if (array_key_exists($filter['for'], $notification['params'])) {
                        $r = call_user_func($filter['function'], $r, $notification['params']);
                    }
                } elseif (is_array($filter['for'])) {
                    $f = false;
                    foreach ($filter['for'] as $k => $v) {
                        $f = (array_key_exists($k, $notification['params']) && $notification['params'][$k] === $v);
                        if (!$f) break;
                    }
                    if ($f) {
                        $r = call_user_func($filter['function'], $r, $notification['params']);
                    }
                    if (!is_string($r)) {
                        throw new NotifierException('Callback filter function must return string value');
                    }
                }
            }
        }
        return $r;
    }

}