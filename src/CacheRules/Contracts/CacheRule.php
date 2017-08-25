<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 8/25/17
 * Time: 8:53 AM
 */

namespace Incraigulous\PrismicToolkit\CacheRules\Contracts;


/**
 * Prismic makes an initial handshake request that we shouldn't precache.
 * Class IgnoreHandshake
 * @package Incraigulous\PrismicToolkit\CacheRules
 */
interface CacheRule
{
    public function shouldCache();
    public function shouldPrecache();
}