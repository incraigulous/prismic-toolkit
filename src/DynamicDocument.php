<?php

namespace Incraigulous\PrismicToolkit;

use Prismic\Document;

/**
 * A dynamic wrapper for prismic documents to give it a clearer and simpler API.
 *
 * Class DynamicDocument
 * @package Incraigulous\PrismicToolkit
 */
class DynamicDocument
{
    public $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
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

        return call_user_func_array([$this->document, $name], $arguments);
    }

    /**
     * Overload properties to fields
     *
     * @param $name
     * @return DynamicSlice|StructuredTextDummy|static
     */
    public function __get($name)
    {
        return $this->resolveField($name);
    }

    /**
     * Resolve fields by name
     *
     * @param $name
     * @return DynamicSlice|StructuredTextDummy|static
     */
    public function resolveField($name)
    {
        if ( ! $this->exists($name)) {
            return new StructuredTextDummy();
        }
        $object = $this->document->getFragments()[$this->resolveFieldName($name)];

        return (new Response())->handle($object);
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
     * Does a field name exit?
     *
     * @param $name
     * @return bool
     */
    public function exists($name)
    {
        $fragments = $this->document->getFragments();

        return array_key_exists($this->resolveFieldName($name), $fragments);
    }

    /**
     * Format a field name prismic style.
     *
     * @param $name
     * @return string
     */
    public function resolveFieldName($name)
    {
        return $this->document->getType() . '.' . $name;
    }
}