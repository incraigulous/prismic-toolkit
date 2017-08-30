<?php

namespace Incraigulous\PrismicToolkit;

use Incraigulous\PrismicToolkit\Traits\OverloadsToObject;
use Prismic\Document;

/**
 * A dynamic wrapper for prismic documents to give it a clearer and simpler API.
 *
 * Class DynamicDocument
 * @package Incraigulous\PrismicToolkit
 */
class DynamicDocument
{
    use OverloadsToObject;

    public $object;

    public function __construct(Document $document)
    {
        $this->object = $document;
    }

    /**
     * Resolve fields by name
     *
     * @param $name
     * @return DynamicSlice|StructuredTextDummy|static
     */
    public function getRaw($name)
    {
        return $this->object->getFragments()[$this->resolveFieldName($name)];
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
        return $this->object->getType() . '.' . $name;
    }
}