<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */
namespace GigaFoxWeb\Notifier;


use GigaFoxWeb\Notifier\notification\Handler;

/**
 * Interface INotifier
 *
 * @package GigaFoxWeb\Notifier
 */
interface INotifier {

    /**
     * @param string $id
     * @param Storage $storage
     */
    public function setStorage($id, Storage $storage);

    /**
     * @param string $id
     *
     * @return Storage|null
     */
    public function getStorage($id);

    /**
     * @param string $id
     * @param Handler $handler
     */
    public function setHandler($id, Handler $handler);

    /**
     * @param string $id
     *
     * @return Handler|null
     */
    public function getHandler($id);

    /**
     * @return Storage[]
     */
    public function getStorages();

    /**
     * @return Handler[]
     */
    public function getHandlers();

}