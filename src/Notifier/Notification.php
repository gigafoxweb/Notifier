<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */
namespace GigaFoxWeb\Notifier;


/**
 * Class Notification
 *
 * @package GigaFoxWeb\Notifier
 */
class Notification {

    /**
     * @var string
     */
    protected $message;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * Notification constructor.
     *
     * @param string $message
     * @param array $params
     */
    public function __construct($message, array $params = []) {
        $this->setMessage($message);
        $this->setParams($params);
    }

    /**
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * @param string $message
     */
    public function setMessage($message) {
        $this->message = $message;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params = []) {
        $this->params = $params;
    }

}