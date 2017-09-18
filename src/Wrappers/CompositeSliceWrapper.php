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

    /**
     * @return array
     */
    public function toArray()
    {
        $document = $this->getDoc()->toArray();
        $document['type'] = $this->getObject()->getSliceType();
        return $document;
    }

    /**
     * Get the wrapped slice
     *
     * @return mixed
     */
    public function getDoc()
    {
        return FluentResponse::handle(
            $this->getDocRaw()
        );
    }

    /**
     * Get the raw prismic slice
     *
     * @return mixed
     */
    public function getDocRaw()
    {
        return $this->getObject()->getPrimary();
    }

    /**
     * Overload to the primary group doc
     *
     * @param $name
     * @return DynamicSlice|StructuredTextDummy|static
     */
    public function get($name)
    {
        return $this->getDoc()->get($name);
    }

    /**
     * Overload to the primary group doc
     *
     * @param $name
     * @return DynamicSlice|StructuredTextDummy|static
     */
    public function exists($name)
    {
        return $this->getDoc()->exists($name);
    }
}