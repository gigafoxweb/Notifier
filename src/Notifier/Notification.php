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
    private $message;

    /**
     * @var array
     */
    private $params;

	/**
	 * Notification constructor.
	 *
	 * @param string $message
	 * @param array $params
	 */
	public function __construct($message = '', array $params = []) {
		$this->setMessage($message);
		$this->setParams($params);
	}

	/**
	 * @param string $name
	 *
	 * @return mixed|null
	 */
	public function __get($name) {
		$method = 'get' . ucfirst($name);
		if (method_exists($this, $method)) {
			return call_user_func([$this, $method]);
		}
		return null;
	}

	/**
	 * @param string $name
	 * @param $message
	 */
	public function __set($name, $message) {
		$method = 'set' . ucfirst($name);
		if (method_exists($this, $method)) {
			call_user_func([$this, $method], $message);
		}
	}

	/**
	 * @return string
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @param string $message
	 *
	 * @throws NotifierException
	 */
	public function setMessage($message) {
		if (!is_string($message)) {
			$type = gettype($message);
			throw new NotifierException("Notification $this->message must be a string, {$type} given.");
		}
		$this->message = $message;
	}

	/**
	 * @return array
	 */
	public function getParams() {
		return $this->params;
	}

	/**
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function getParam($name) {
		return array_key_exists($name, $this->params) ? $this->params[$name] : null;
	}

	/**
	 * @param string $name
	 * @param mixed $value
	 */
	public function setParam($name, $value) {
		$this->params[$name] = $value;
	}

	/**
	 * @param array $params
	 */
	public function setParams(array $params = []) {
		$this->params = $params;
	}


}