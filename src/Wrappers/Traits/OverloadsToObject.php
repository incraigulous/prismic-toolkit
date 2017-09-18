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
        /**
         * Does a property already exist on THIS object?
         */
        if (property_exists($this, $name))
        {
            return $this->$name;
        }

        /**
         * Does a getter method exist for the property?
         */
        if ($this->hasGetter($name))
        {
            return $this->resolveGetter($name);
        }

        /**
         * Does the property exist on the TARGET object?
         */
        if (!$this->exists($name)) {
            return null;
        }

        /**
         * Resolve the property from the target object
         */
        return $this->get($name);
    }

    /**
     * Return the getter method name for a given property
     * @param $name
     * @return string
     */
    protected function resolveGetterMethodName($name)
    {
        return 'get' . ucfirst($name);
    }

    /**
     * Does a getter method exist for a given property?
     * @param $name
     * @return bool
     */
    protected function hasGetter($name)
    {
        return method_exists($this, $this->resolveGetterMethodName($name));
    }

    /**
     * Resolve a getter method by name
     * @param $name
     * @return bool
     */
    public function resolveGetter($name)
    {
        $methodName = $this->resolveGetterMethodName($name);
        return call_user_func_array([$this, $methodName], []);
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