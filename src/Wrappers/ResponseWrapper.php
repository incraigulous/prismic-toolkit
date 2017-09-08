<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 9/8/17
 * Time: 1:21 PM
 */

namespace Incraigulous\PrismicToolkit\Wrappers;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Incraigulous\PrismicToolkit\Wrappers\Traits\HasArrayableObject;
use Incraigulous\PrismicToolkit\Wrappers\Traits\HasJsonableObject;
use Incraigulous\PrismicToolkit\Wrappers\Traits\OverloadsToObject;
use Prismic\Response;

class ResponseWrapper implements Arrayable, Jsonable
{
    use OverloadsToObject, HasArrayableObject, HasJsonableObject;

    public function __construct(Response $object)
    {
        $this->object = $object;
    }

    public function toArray()
    {
        $this->getResults()->toArray();
    }
}