<?php

namespace Incraigulous\PrismicToolkit;


use Prismic\Fragment\GroupDoc;

/**
 * A dynamic wrapper for prismic GroupDocs to give a clearer and simpler API.
 *
 * Class DynamicGroupDoc
 * @package Incraigulous\PrismicToolkit
 */
class DynamicGroupDoc
{
    public $groupDoc;

    public function __construct(GroupDoc $groupDoc)
    {
        $this->groupDoc = $groupDoc;
    }

    /**
     * Overload parameters to fields
     * @param $name
     * @return DynamicSlice|static
     */
    public function __get($name)
    {
        return $this->resolveField($name);
    }

    /**
     * Resolve a field by name
     *
     * @param $name
     * @return DynamicSlice|static
     */
    public function resolveField($name)
    {
        $object = $this->groupDoc->getFragments()[$name];
        return (new Response())->handle($object);
    }

    /**
     * Overload methods to the document.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }
        return call_user_func_array([$this->groupDoc, $name], $arguments);
    }
}