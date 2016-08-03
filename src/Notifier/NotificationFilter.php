<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */

namespace GigaFoxWeb\Notifier;


/**
 * Class NotificationFilter
 *
 * @package GigaFoxWeb\Notifier\Notifier
 */
abstract class NotificationFilter {

	/**
	 * @var array
	 */
	private $search = [];

	/**
	 * NotificationFilter constructor.
	 *
	 * @param array $search
	 */
	public function __construct(array $search = []) {
		$this->setSearch($search);
	}

	/**
	 * @param Notification $notification
	 *
	 * @return mixed
	 */
	abstract public function filtrate(Notification $notification);

	/**
	 * @param Notification $notification
	 *
	 * @return bool
	 */
	public function isFor(Notification $notification) {
		$r = true;
		if (isset($this->search['params'])) {
			$r = Helper::checkByParams($this->search['params'], $notification);
		}
		if ($r) {
			if (isset($this->search['function'])) {
				$r = Helper::checkByFunction($this->search['function'], $notification);
			}
		}
		return $r;
	}

	/**
	 * @param array $search
	 */
	public function setSearch(array $search = []) {
		$this->search = $search;
	}

}