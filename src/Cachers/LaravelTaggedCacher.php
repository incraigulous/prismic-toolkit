<?php

namespace Incraigulous\PrismicToolkit\Cachers;

/**
 * Adapter service compatible with Laravel and Prismic caching.
 */
use Incraigulous\PrismicToolkit\Endpoint;
use Incraigulous\PrismicToolkit\Models\PrismicEndpoint;
use Prismic\Cache\CacheInterface;

class LaravelTaggedCacher implements CacheInterface
{
    /**
     * Does the key exist?
     *
     * @param $key
     *
     * @return mixed
     * @throws \Exception
     */
    public function has($key)
    {
        $endpoint = new Endpoint($key);
        return cache()->tags(config('prismic.cacheTag'))->has($endpoint->makeCacheKey());
    }

    /**
     * Get a cache value by key.
     *
     * Stores the key to be precached if the response exists.
     *
     * @param string $key
     *
     * @return mixed
     * @throws \Exception
     */
    public function get($key)
    {
        $endpoint = new Endpoint($key);
        $response = cache()->tags(config('prismic.cacheTag'))->get($endpoint->makeCacheKey());
        if ( ! $response && $endpoint->shouldPreCache()) {
            PrismicEndpoint::firstOrCreate(['endpoint' => $endpoint->urlWithoutRelease()]);
        }

        return $response;
    }

    /**
     * Cache an item.
     *
     * If no TTL is provided, it will be cached for ever.
     *
     * Note: Prismic will pass 315360000 instead of zero for zero ttls.
     *
     * @param string    $key
     * @param \stdClass $value
     * @param int       $ttl
     *
     * @throws \Exception
     */
    public function set($key, $value, $ttl = 0)
    {
        $endpoint = new Endpoint($key);
        if (!$endpoint->shouldCache()) return;

        if ( ! $ttl || $ttl === 315360000) {
            return $this->forever($key, $value);
        } else {
            return $this->put($key, $value, $ttl);
        }
    }

    /**
     * Put an item in the cache.
     *
     * @param $key
     * @param $value
     * @param $ttl
     *
     * @throws \Exception
     */
    public function put($key, $value, $ttl)
    {
        $endpoint = new Endpoint($key);
        cache()->tags(config('prismic.cacheTag'))->put($endpoint->makeCacheKey(), $value, $ttl);
    }

    /**
     * Cache an item forever.
     *
     * @param $key
     * @param $value
     *
     * @throws \Exception
     */
    public function forever($key, $value)
    {
        $endpoint = new Endpoint($key);
        cache()->tags(config('prismic.cacheTag'))->forever($endpoint->makeCacheKey(), $value);
    }

    /**
     * Remove an item from the cache.
     *
     * @param $key
     *
     * @return mixed
     * @throws \Exception
     */
    public function forget($key)
    {
        $endpoint = new Endpoint($key);
        return cache()->tags(config('prismic.cacheTag'))->forget($endpoint->makeCacheKey());
    }

    /**
     * Alias for forget.
     *
     * @param string $key
     *
     * @return mixed
     * @throws \Exception
     */
    public function delete($key)
    {
        $endpoint = new Endpoint($key);
        return $this->forget($endpoint->makeCacheKey());
    }

    /**
     * Clear the cache.
     *
     * @return mixed
     * @throws \Exception
     */
    public function flush()
    {
        return cache()->tags(config('prismic.cacheTag'))->flush();
    }

    /**
     * Alias for clear.
     *
     * @return mixed|void
     * @throws \Exception
     */
    public function clear()
    {
        return $this->flush();
    }
}