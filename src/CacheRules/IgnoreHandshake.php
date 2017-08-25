<?php

namespace Incraigulous\PrismicToolkit\CacheRules;


use Incraigulous\PrismicToolkit\Endpoint;
use Incraigulous\PrismicToolkit\CacheRules\Contracts\CacheRule;

/**
 * Prismic makes an initial handshake request that we shouldn't precache.
 * Class IgnoreHandshake
 * @package Incraigulous\PrismicToolkit\CacheRules
 */
class IgnoreHandshake implements CacheRule
{
    private $endpoint;

    public function __construct(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function shouldCache()
    {
        return true;
    }

    public function shouldPrecache()
    {
        return ! str_contains($this->endpoint->url(), '/api#');
    }
}