<?php
/**
 * @link http://www.gigafoxweb.com/
 * @copyright Copyright (c) http://www.gigafoxweb.com/
 */

namespace GigaFoxWeb;


/**
 * Interface INotifier
 * @package GigaFoxWeb
 */
interface INotifier {


    /**
     * @param $key
     * @param null $value
     * @param array $params
     * @return mixed
     */
    public static function set($key, $value = null, array $params = []);


    /**
     * @param $key
     * @return mixed
     */
    public static function get($key);


    /**
     * @param $key
     * @param null $filter
     * @return mixed
     */
    public static function show($key, $filter = null);


    /**
     * @param string $type
     * @return mixed
     */
    public static function getAll($type = 'array');


    /**
     * @param null $filter
     * @param array $keys
     * @return mixed
     */
    public static function showAll($filter = null, array $keys = []);

}