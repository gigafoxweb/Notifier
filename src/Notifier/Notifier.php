<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */
namespace GigaFoxWeb\Notifier;


use GigaFoxWeb\Notifier\notification\Handler;
use GigaFoxWeb\Notifier\notification\Storage;

/**
 * Class Notifier
 *
 * @package GigaFoxWeb\Notifier
 */
class Notifier implements INotifier {

    /**
     * @var static
     */
    protected static $instance;

    /**
     * @var Storage[]
     */
    protected $storages = [];

    /**
     * @var Handler[]
     */
    protected $handlers = [];

    /**
     * Notifier constructor.
     */
    protected function __construct() {}

    /**
     *
     */
    protected function __sleep() {}

    /**
     *
     */
    protected function __wakeup() {}

    /**
     *
     */
    protected function __clone() {}

    /**
     * @return static
     */
    public static function instance() {
        if (!static::$instance instanceof static) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * @param string $id
     * @param Storage $storage
     *
     * @return Storage
     */
    public function setStorage($id, Storage $storage) {
        $this->storages[$id] = $storage;
        return $this->storages[$id];
    }

    /**
     * @param string $id
     *
     * @return Storage|null
     */
    public function getStorage($id) {
        return isset($this->storages[$id]) ? $this->storages[$id] : null;
    }

    /**
     * @param string $id
     * @param Handler $handler
     *
     * @return Handler
     */
    public function setHandler($id, Handler $handler) {
        $this->handlers[$id] = $handler;
        return $this->handlers[$id];
    }

    /**
     * @param string $id
     *
     * @return Handler|null
     */
    public function getHandler($id) {
        return isset($this->handlers[$id]) ? $this->handlers[$id] : null;
    }

    /**
     * @return Storage[]
     */
    public function getStorages() {
        return $this->storages;
    }

    /**
     * @return Handler[]
     */
    public function getHandlers() {
        return $this->handlers;
    }

}