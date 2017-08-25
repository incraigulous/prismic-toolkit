<?php

namespace Incraigulous\PrismicToolkit\Facades;

/**
 * Class Prismic
 * @package Incraigulous\PrismicToolkit\Facades
 */
class Prismic extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'prismic';
    }
}