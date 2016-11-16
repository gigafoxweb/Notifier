<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */
namespace GigaFoxWeb\Notifier\Notifier\notification\filters;


use GigaFoxWeb\Notifier\Notification;
use GigaFoxWeb\Notifier\notification\Filter;

/**
 * Class RequiredValue
 *
 * @package GigaFoxWeb\Notifier\Notifier\notification\filters
 */
class RequiredValue extends Filter  {

    /**
     * @var array
     */
    protected $values;

    /**
     * RequiredValue constructor.
     *
     * @param array $values
     */
    public function __construct(array $values = []) {
        $this->values = $values;
    }

    /**
     * @param Notification $notification
     *
     * @return bool
     */
    public function check(Notification $notification) {
        $notificationParams = $notification->getParams();
        foreach ($this->values as $key => $value) {
            if (!array_key_exists($key, $notificationParams) || $notificationParams[$key] !== $value) {
                return false;
            }
        }
        return true;
    }

}