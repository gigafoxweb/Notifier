<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */
namespace GigaFoxWeb\Notifier\notification;


use GigaFoxWeb\Notifier\Notification;

/**
 * Class Filtrator
 *
 * @package GigaFoxWeb\Notifier\notification
 */
class Filtrator {

    /**
     * @var Filter[]
     */
    protected $filters = [];

    /**
     * @param Notification $notification
     *
     * @return bool
     */
    public function applyFilters(Notification $notification) {
        foreach ($this->filters as $filter) {
            if (!$filter->check($notification)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param Filter $filter
     */
    public function addFilter(Filter $filter) {
        $this->filters[] = $filter;
    }

}