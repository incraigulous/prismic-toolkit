<?php
namespace Incraigulous\PrismicToolkit\Traits;

use Incraigulous\PrismicToolkit\Response;

/**
 * Overload method and properties calls to an object unless they exist on the instance.
 * Also provides some helpers and accessors.
 *
 * Trait OverloadsToObject
 * @package Incraigulous\PrismicToolkit\Traits
 */
trait OverloadsToObject
{
    /**
     * Return the object
     *
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Overload methods to the object.
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

        return $this->callMethod($name, $arguments);
    }

    public function callMethod($name, $arguments)
    {
        return call_user_func_array([$this->getObject(), $name], $arguments);
    }

    /**
     * Overload properties to fields
     *
     * @param $name
     * @return DynamicSlice|static
     */
    public function __get($name)
    {
        if (property_exists($this, $name))
        {
            return $this->$name;
        }

        if (!$this->exists($name)) {
            return null;
        }

        return $this->get($name);
    }

    /**
     * Get a property from the object and handle it.
     *
     * @param $name
     * @return DynamicSlice|StructuredTextDummy|static
     */
    public function get($name)
    {
        return Response::handle(
            $this->getRaw($name)
        );
    }

    /**
     * Get a property from the object.
     *
     * @param $name
     * @return DynamicSlice|StructuredTextDummy|static
     */
    public function getRaw($name)
    {
        return $this->getObject()->$name;
    }

    /**
     * Alias for exists()
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return $this->exists($name);
    }

    /**
     * Does a property name exist?
     *
     * @param $name
     * @return bool
     */
    public function exists($name)
    {
        return property_exists($this->getObject(), $name);
    }
}