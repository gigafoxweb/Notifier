<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */
namespace GigaFoxWeb\Notifier\notification\filters;


use GigaFoxWeb\Notifier\Notification;
use GigaFoxWeb\Notifier\notification\Filter;

/**
 * Class RequireParam
 *
 * @package GigaFoxWeb\Notifier\notification\filter
 */
class RequireParam extends Filter  {

    /**
     * @var array
     */
    protected $params = [];

    /**
     * RequireParam constructor.
     *
     * @param array $params
     */
    public function __construct(array $params = []) {
        $this->params = $params;
    }

    /**
     * @param Notification $notification
     *
     * @return bool
     */
    public function check(Notification $notification) {
        $notificationParams = $notification->getParams();
        foreach ($this->params as $param) {
            if (!array_key_exists($param, $notificationParams)) {
                return false;
            }
        }
        return true;
    }

}