<?php

namespace Incraigulous\PrismicToolkit;


use Prismic\Fragment\GroupDoc;

class DynamicGroupDoc
{
    public $groupDoc;

    public function __construct(GroupDoc $groupDoc)
    {
        $this->groupDoc = $groupDoc;
    }

    public function __get($name)
    {
        return $this->resolveField($name);
    }

    public function resolveField($name)
    {
        $object = $this->groupDoc->getFragments()[$name];
        return (new ResponseAdapter())->handle($object);
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