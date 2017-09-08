<?php
namespace Incraigulous\PrismicToolkit\Wrappers\Traits;

use Incraigulous\PrismicToolkit\FluentResponse;

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

    /**
     * Call a method on the object
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function callMethod($name, $arguments)
    {
        return FluentResponse::make(call_user_func_array([$this->getObject(), $name], $arguments));
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
        return FluentResponse::handle(
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
     * Get all in object.
     * @return array
     */
    public function all()
    {
        return get_object_vars($this->getObject());
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

    /**
     * Reverse of resolveFieldKey
     * @param $key
     * @return mixed
     */
    public function resolveFieldName($key)
    {
        return $key;
    }
}