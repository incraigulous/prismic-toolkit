<?php

namespace Incraigulous\PrismicToolkit\CacheRules;


use Incraigulous\PrismicToolkit\Endpoint;
use Incraigulous\PrismicToolkit\CacheRules\Contracts\CacheRule;

/**
 * Used for testing. Could also be used as a dirty way to disable the prismic cache.
 *
 * Class NoCache
 * @package Incraigulous\PrismicToolkit\CacheRules
 */
class NoCache implements CacheRule
{
    private $endpoint;

    public function __construct(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function shouldCache()
    {
        return false;
    }

    public function shouldPrecache()
    {
        return true;
    }
}