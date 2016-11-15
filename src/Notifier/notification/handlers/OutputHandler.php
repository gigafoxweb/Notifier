<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */
namespace GigaFoxWeb\Notifier\notification\handlers;


use GigaFoxWeb\Notifier\Notification;
use GigaFoxWeb\Notifier\notification\Handler;

/**
 * Class OutputHandler
 *
 * @package GigaFoxWeb\Notifier\notification\handlers
 */
class OutputHandler extends Handler {

    /**
     * @var string|null
     */
    protected $layout;

    /**
     * OutputHandler constructor.
     *
     * @param string|null $layout
     */
    public function __construct($layout = null) {
        $this->layout = $layout;
    }

    /**
     * @param Notification $notification
     */
    protected function process(Notification $notification) {
        if (is_file($this->layout)) {
            ob_start();
            include $this->layout;
            echo ob_get_clean();
        } else {
            echo $notification->getMessage() . PHP_EOL;
        }
    }

}