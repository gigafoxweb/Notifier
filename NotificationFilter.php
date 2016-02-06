<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */

namespace GigaFoxWeb;


/**
 * Class NotificationFilter
 * @package GigaFoxWeb
 */
class NotificationFilter {

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
        if (!empty($notification)) {
            foreach ($this->filters as $filter) {
                if (empty($filter['for'])) {
                    $notification['value'] = call_user_func($filter['function'], $notification['value'], $notification['params']);
                } elseif (is_string($filter['for'])) {
                    if (array_key_exists($filter['for'], $notification['params'])) {
                        $notification['value'] = call_user_func($filter['function'], $notification['value'], $notification['params']);
                    }
                } elseif (is_array($filter['for'])) {
                    $k = key($filter['for']);
                    $v = $filter['for'];
                    if (empty($k) || empty($v) || count($filter['for']) > 1) {
                        // @todo mass params filter
                        throw new NotifierException('Wrong "for" parameter for NotificationFilter');
                    }
                    if (array_key_exists($k, $notification['params']) &&
                        $notification['params'][$k] === $v[$k]) {
                        $notification['value'] = call_user_func($filter['function'], $notification['value'], $notification['params']);
                    }
                }
            }
        }
        if (!is_string($notification['value'])) {
            throw new NotifierException('Callback filter function must return string value');
        }
        return $notification['value'];
    }

}