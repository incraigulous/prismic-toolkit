<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 8/23/17
 * Time: 3:30 PM
 */

namespace Incraigulous\PrismicToolkit;

use Prismic\Api;

/**
 * An endpoint to be called by Prismic.
 *
 * Can be passed to Prismic\Api::submit
 *
 * Class Endpoint
 * @package Incraigulous\PrismicToolkit
 */

class Endpoint
{
    private $url;

    /**
     * Endpoint constructor.
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Return the URL.
     * Used by Prismic\Api::submit
     * @return mixed
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * End code keys to avoid escaping issues when saving to the database.
     * When keys were stored unencoded, they didn't match when trying to recall them later.
     *
     * @return string
     */
    public function makeCacheKey()
    {
        return md5($this->url);
    }

    /**
     * Loop through all registered cache rules to find out if we should precache the endpoint.
     * @return bool
     */
    public function shouldPreCache()
    {
        $result = true;
        foreach(config('prismic.cacheRules') as $rule) {
            $cacheRule = new $rule($this);
            if (!$cacheRule->shouldPrecache()) {
                $result = false;
            }
        }
        return $result;
    }

    /**
     * Loop through all registered cache rules to find out if we should cache the endpoint.
     * @return bool
     */
    public function shouldCache()
    {
        $result = true;
        foreach(config('prismic.cacheRules') as $rule) {
            $cacheRule = new $rule($this);
            if (!$cacheRule->shouldCache()) {
                $result = false;
            }
        }
        return $result;
    }
}