<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 8/30/17
 * Time: 4:11 PM
 */

namespace Incraigulous\PrismicToolkit\Wrappers;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Incraigulous\PrismicToolkit\FluentResponse;
use Incraigulous\PrismicToolkit\Wrappers\Traits\HasArrayableObject;
use Incraigulous\PrismicToolkit\Wrappers\Traits\HasJsonableObject;
use Incraigulous\PrismicToolkit\Wrappers\Traits\OverloadsToObject;
use Prismic\Fragment\CompositeSlice;

class CompositeSliceWrapper implements Arrayable, Jsonable
{
    use OverloadsToObject, HasArrayableObject, HasJsonableObject;

    public function __construct(CompositeSlice $object)
    {
        $this->object = $object;
    }

    public function getType()
    {
        return $this->getObject()->getSliceType();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $document = $this->getNonRepeating()->toArray();
        $document['type'] = $this->getType();
        $document['repeating'] = $this->getRepeating();
        return $document;
    }

    /**
     * Get the non repeatable field
     *
     * @return mixed
     */
    public function getNonRepeating()
    {
        return FluentResponse::handle(
            $this->getNonRepeatingRaw()
        );
    }

    /**
     * Get the raw prismic slice
     *
     * @return mixed
     */
    public function getNonRepeatingRaw()
    {
        return $this->getObject()->getPrimary();
    }

    /**
     * Get the wrapped slice
     *
     * @return mixed
     */
    public function getRepeating()
    {
        return FluentResponse::handle(
            $this->getRepeatingRaw()
        );
    }

    /**
     * Get the raw prismic slice
     *
     * @return mixed
     */
    public function getRepeatingRaw()
    {
        return $this->getObject()->getItems();
    }

    /**
     * Overload to the primary group doc
     *
     * @param $name
     * @return DynamicSlice|StructuredTextDummy|static
     */
    public function get($name)
    {
        return $this->getNonRepeating()->get($name);
    }

    /**
     * Overload to the primary group doc
     *
     * @param $name
     * @return DynamicSlice|StructuredTextDummy|static
     */
    public function exists($name)
    {
        return $this->getNonRepeating()->exists($name);
    }
}