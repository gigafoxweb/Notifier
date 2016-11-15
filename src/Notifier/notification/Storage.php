<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */
namespace GigaFoxWeb\Notifier\notification;


use GigaFoxWeb\Notifier\Notification;
/**
 * Class Storage
 *
 * @package GigaFoxWeb\Notifier\notification
 */
abstract class Storage {

    /**
     * @param string $id
     * @param Notification $notification
     */
    abstract public function setNotification($id, Notification $notification);

    /**
     * @param string $id
     *
     * @return Notification|null
     */
    abstract public function getNotification($id);

    /**
     * @param string $id
     */
    abstract public function removeNotification($id);

    /**
     * @return Notification[]
     */
    abstract public function getNotifications();

}