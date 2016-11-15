<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */
namespace GigaFoxWeb\Notifier\storages;


use GigaFoxWeb\Notifier\Notification;
use GigaFoxWeb\Notifier\Storage;

/**
 * Class Session
 *
 * @package GigaFoxWeb\Notifier\storages
 */
class Session extends Storage {

    /**
     * @var string
     */
    protected $sessionId;

    /**
     * Session constructor.
     *
     * @param $sessionId
     */
    public function __construct($sessionId) {
        $this->sessionId = $sessionId;
        $_SESSION[$this->sessionId] = [];
    }

    /**
     * @param string $id
     * @param Notification $notification
     */
    public function setNotification($id, Notification $notification) {
        $_SESSION[$this->sessionId][$id] = $notification;
    }

    /**
     * @param string $id
     *
     * @return null
     */
    public function getNotification($id) {
        return isset($_SESSION[$this->sessionId][$id]) ? $_SESSION[$this->sessionId][$id] : null;
    }

    /**
     * @param string $id
     */
    public function removeNotification($id) {
        unset($_SESSION[$this->sessionId][$id]);
    }

    /**
     * @return mixed
     */
    public function getNotifications() {
        return $_SESSION[$this->sessionId];
    }

}