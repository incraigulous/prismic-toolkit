<?php
return [
    'endpoint' => env('PRISMIC_ENDPOINT'),
    'token' => env('PRISMIC_TOKEN'),
    'cacher' => \Incraigulous\PrismicToolkit\Cachers\LaravelTaggedCacher::class
];