<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */

namespace GigaFoxWeb\Notifier;


/**
 * Class InlineNotificationFilter
 *
 * @package GigaFoxWeb\Notifier\Notifier
 */
class InlineNotificationFilter extends NotificationFilter {

	/**
	 * @var callable
	 */
	private $filterFunction;

	/**
	 * InlineNotificationFilter constructor.
	 *
	 * @param callable $filterFunction
	 * @param array $search
	 */
	public function __construct(callable $filterFunction, array $search = []) {
		$this->setFilterFunction($filterFunction);
		parent::__construct($search);
	}

	/**
	 * @param Notification $notification
	 * @return void
	 */
	public function filtrate(Notification $notification) {
		call_user_func($this->filterFunction, $notification);
	}

	/**
	 * @param callable $filterFunction
	 */
	public function setFilterFunction(callable $filterFunction) {
		$this->filterFunction = $filterFunction;
	}



}