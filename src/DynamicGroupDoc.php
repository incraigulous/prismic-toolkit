<?php

namespace Incraigulous\PrismicToolkit;


use Incraigulous\PrismicToolkit\Traits\OverloadsToObject;
use Prismic\Fragment\GroupDoc;

/**
 * A dynamic wrapper for prismic GroupDocs to give a clearer and simpler API.
 *
 * Class DynamicGroupDoc
 * @package Incraigulous\PrismicToolkit
 */
class DynamicGroupDoc
{
    use OverloadsToObject;

    public $object;

    public function __construct(GroupDoc $groupDoc)
    {
        $this->object = $groupDoc;
    }

    /**
     * Resolve a field by name
     *
     * @param $name
     * @return DynamicSlice|static
     */
    public function getRaw($name)
    {
        return $this->getObject()->getFragments()[$name];
    }

    /**
     * Does a field name exit?
     *
     * @param $name
     * @return bool
     */
    public function exists($name)
    {
        $fragments = $this->object->getFragments();
        return array_key_exists($name, $fragments);
    }
}