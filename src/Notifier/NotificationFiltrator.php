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
/**
 * Class NotificationFiltrator
 * @package GigaFoxWeb\Notifier
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
        $this->filters[] = ['function' => $function, 'for' => $for];
        return $this;
    }

    /**
     * @param Notification $notification
     * @throws NotifierException
     */
    public function filtrate(Notification &$notification)
    {
        foreach ($this->filters as $filter) {
            if (empty($filter['for'])) {
                $notification = call_user_func($filter['function'], $notification);
            } else {
                if (isset($filter['for']['params'])) {
                    if (Helper::checkByParams($filter['for']['params'], $notification->params)) {
                        $notification = call_user_func($filter['function'], $notification);
                    }
                } elseif (isset($filter['for']['function'])) {
                    if (Helper::checkByFunction($filter['for']['function'], $notification)) {
                        $notification = call_user_func($filter['function'], $notification);
                    }
                }
            }
            if (!$notification instanceof Notification) {
                throw new NotifierException('Callback filter function must return Notification object');
            }
        }
    }

}