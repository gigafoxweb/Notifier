<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */
namespace GigaFoxWeb\Notifier\storages;


use GigaFoxWeb\Notifier\Notification;
use GigaFoxWeb\Notifier\Storage;

/**
 * Class Memory
 *
 * @package GigaFoxWeb\Notifier\storages
 */
class Memory extends Storage {

    /**
     * @var Notification[]
     */
    protected $notifications = [];

    /**
     * @param string $id
     * @param Notification $notification
     */
    public function setNotification($id, Notification $notification) {
        $this->notifications[$id] = $notification;
    }

    /**
     * @param string $id
     *
     * @return Notification|null
     */
    public function getNotification($id) {
        return isset($this->notifications[$id]) ? $this->notifications[$id] : null;
    }

    /**
     * @param string $id
     */
    public function removeNotification($id) {
        unset($this->notifications[$id]);
    }

    /**
     * @return Notification[]
     */
    public function getNotifications() {
        return $this->notifications;
    }
}