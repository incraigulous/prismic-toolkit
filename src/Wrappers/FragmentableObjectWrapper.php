<?php
namespace Incraigulous\PrismicToolkit\Wrappers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Incraigulous\PrismicToolkit\FluentResponse;
use Incraigulous\PrismicToolkit\Wrappers\Traits\HasArrayableObject;
use Incraigulous\PrismicToolkit\Wrappers\Traits\HasJsonableObject;
use Incraigulous\PrismicToolkit\Wrappers\Traits\OverloadsToObject;
use Prismic\WithFragments;

/**
 * Overload method and properties calls to an object unless they exist on the instance.
 * Also provides some helpers and accessors.
 *
 * Trait OverloadsToObject
 * @package Incraigulous\PrismicToolkit\Traits
 */

abstract class FragmentableObjectWrapper implements Jsonable, Arrayable
{
    use OverloadsToObject, HasJsonableObject, HasArrayableObject;

    public function __construct(WithFragments $object)
    {
        $this->object = $object;
    }

    public function all()
    {
        return $this->getObject()->getFragments();
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        $data = $this->toArray();
        return json_encode($data, $options);
    }

    /**
     * Format a field name prismic style.
     *
     * @param $name
     * @return string
     */
    public function resolveFieldKey($name)
    {
        return $name;
    }

    public function resolveFieldName($key)
    {
        return $key;
    }
}