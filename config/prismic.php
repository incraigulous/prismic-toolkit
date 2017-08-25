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
     */
    'cacher' => \Incraigulous\PrismicToolkit\Cachers\LaravelTaggedCacher::class,

    /**
     * If using a tagged cacher, which cache tag should it be scoped to?
     */
    'cacheTag' => 'prismic',

    /**
     * In minutes. 0 for forever.
     */
    'cacheTime' => 0
];