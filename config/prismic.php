<?php
return [
    'endpoint' => env('PRISMIC_ENDPOINT'),
    'token' => env('PRISMIC_TOKEN'),

    /**
     * Register sync rules for determining if an endpoint should be precached.
     */
    'cacheRules' => [
        \Incraigulous\PrismicToolkit\CacheRules\IgnoreHandshake::class
    ],

    /**
     * A cacher that implements Prismic\Cache\CacheInterface
     *
     * Options:
     * \Incraigulous\PrismicToolkit\Cachers\LaravelCacher::class,
     * \Incraigulous\PrismicToolkit\Cachers\LaravelTaggedCacher::class,
     * \Prismic\Cache\ApcCache::class,
     * \Prismic\Cache\NoCache::class
     */
    'cacher' => \Incraigulous\PrismicToolkit\Cachers\LaravelTaggedCacher::class,

    /**
     * If using a tagged cacher, which cache tag should it be scoped to?
     */
    'cacheTag' => 'prismic',

    /**
     * In minutes. 0 for forever.
     */
    'cacheTime' => 0,

    /**
     * The queue driver
     */
    'queueDriver' => 'sync',

    /**
     * How many minutes should content syncing as a result of webhooks be delayed
     */
    'syncDelay' => 5,

    /**
     * If a secret is defined on the prismic webhook
     */
    'webhookSecret' => null,

    'timezone' => 'UTC'
];