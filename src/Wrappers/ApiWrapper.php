<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 9/8/17
 * Time: 1:10 PM
 */

namespace Incraigulous\PrismicToolkit\Wrappers;

use Incraigulous\PrismicToolkit\Wrappers\Traits\OverloadsToObject;

class ApiWrapper
{
    use OverloadsToObject;

    public function __construct(\Prismic\Api $object)
    {
        $this->object = $object;
    }
}