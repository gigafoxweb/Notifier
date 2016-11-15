<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */
namespace GigaFoxWeb\Notifier\notification;


use GigaFoxWeb\Notifier\Notification;

/**
 * Class Filter
 *
 * @package GigaFoxWeb\Notifier\notification
 */
abstract class Filter {

    /**
     * @param Notification $notification
     *
     * @return bool
     */
    abstract public function check(Notification $notification);

}