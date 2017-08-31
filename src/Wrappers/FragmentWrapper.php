<?php
namespace Incraigulous\PrismicToolkit\Wrappers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Incraigulous\PrismicToolkit\Wrappers\Traits\HasArrayableObject;
use Incraigulous\PrismicToolkit\Wrappers\Traits\HasJasonableObject;
use Incraigulous\PrismicToolkit\Wrappers\Traits\OverloadsToObject;
use Prismic\Fragment\FragmentInterface;
use Prismic\WithFragments;

/**
 * Overload method and properties calls to an object unless they exist on the instance.
 * Also provides some helpers and accessors.
 *
 * Trait OverloadsToObject
 * @package Incraigulous\PrismicToolkit\Traits
 */

abstract class FragmentWrapper implements Jsonable, Arrayable
{
    use OverloadsToObject, HasArrayableObject, HasJasonableObject;

    public function __construct(FragmentInterface $object)
    {
        $this->object = $object;
    }

    /**
     * Return as array
     *
     * @return mixed
     */
    public function toArray()
    {
        return json_decode(json_encode($this->getObject()->getMain()), 1);
    }
}