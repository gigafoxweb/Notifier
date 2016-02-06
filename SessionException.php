<?php
namespace GigaFoxWeb;

/**
 * Class SessionException
 * @package GigaFoxWeb
 */
class SessionException extends NotifierException {

    /**
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($message, $code = 0, Exception $previous = null) {
        $message = $message . '  | SessionNotifier';
        parent::__construct($message, $code, $previous);
    }

}