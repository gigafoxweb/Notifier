<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */
namespace GigaFoxWeb\Notifier\notification;


use GigaFoxWeb\Notifier\Notification;

/**
 * Class Handler
 *
 * @package GigaFoxWeb\Notifier\notification
 */
abstract class Handler {

    /**
     * @var Filtrator|null;
     */
    protected $filtrator;

    /**
     * @param Filtrator $filtrator
     */
    public function setFiltrator(Filtrator $filtrator = null) {
        $this->filtrator = $filtrator;
    }

    /**
     * @return Filtrator|null
     */
    public function getFiltrator() {
        return $this->filtrator;
    }

    /**
     * @param Storage $storage
     */
    public function processStorage(Storage $storage) {
        foreach ($storage->getNotifications() as $id => $notification) {
            $this->processNotification($notification);
            $storage->removeNotification($id);
        }
    }

    /**
     * @param Notification $notification
     */
    public function processNotification(Notification $notification) {
        if (!$this->filtrator instanceof Filtrator || $this->filtrator->applyFilters($notification)) {
            $this->process($notification);
        }
    }

    /**
     * @param Notification $notification
     */
    abstract protected function process(Notification $notification);

}