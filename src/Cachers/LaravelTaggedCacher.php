<?php

namespace Incraigulous\PrismicToolkit\Cachers;

/**
 * Adapter service compatible with Laravel and Prismic caching.
 *
 */
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Models\PrismicEndpoint;
use Prismic\Cache\CacheInterface;

class LaravelTaggedCacher implements CacheInterface
{
    private $cacheTag = 'prismic';

    public function has($key)
    {
        return cache()->tags($this->cacheTag)->has($key);
    }

    public function get($key)
    {
        $response = cache()->tags($this->cacheTag)->get($key);
        if (!$response && str_contains($key, 'access_token')) {
            PrismicEndpoint::firstOrCreate(['endpoint' => $key]);
        }
        return $response;
    }

    public function set($key, $value, $ttl = 0)
    {
        if (!$ttl) {
            return $this->forever($key, $value);
        } else {
            return $this->put($key, $value, $ttl);
        }
    }

    public function put($key, $value, $ttl)
    {
        return cache()->tags($this->cacheTag)->put($key, $value, $ttl);
    }

    public function forever($key, $value) {
        return cache()->tags($this->cacheTag)->forever($key, $value);
    }

    public function forget($key) {
        return cache()->tags($this->cacheTag)->forget($key);
    }

    public function delete($key)
    {
        return $this->forget($key);
    }

    public function flush()
    {
        return cache()->tags($this->cacheTag)->flush();
    }

    public function clear()
    {
        return $this->flush();
    }
}