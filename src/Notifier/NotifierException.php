<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */

namespace GigaFoxWeb\Notifier;


use Exception;

/**
 * Class NotifierException
 * @package GigaFoxWeb\Notifier
 */
class NotifierException extends Exception {

    /**
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($message, $code = 0, Exception $previous = null) {
        $message = 'NotifierError : ' . $message;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}