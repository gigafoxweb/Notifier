<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */
namespace GigaFoxWeb\Notifier\Notifier\notification\filters;


use GigaFoxWeb\Notifier\Notification;
use GigaFoxWeb\Notifier\notification\Filter;

/**
 * Class Callback
 *
 * @package GigaFoxWeb\Notifier\Notifier\notification\filters
 */
class Callback extends Filter {

    /**
     * @var callable
     */
    protected $function;

    /**
     * Callback constructor.
     *
     * @param callable $function
     */
    public function __construct(callable $function) {
        $this->function = $function;
    }

    /**
     * @param Notification $notification
     *
     * @return bool
     */
    public function check(Notification $notification) {
        return (boolean) call_user_func($this->function, $notification);
    }

}