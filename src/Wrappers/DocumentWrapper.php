<?php

namespace Incraigulous\PrismicToolkit\Wrappers;

use Prismic\Document;

/**
 * A dynamic wrapper for prismic documents to give it a clearer and simpler API.
 *
 * Class DocumentWrapper
 * @package Incraigulous\PrismicToolkit
 */
class DocumentWrapper extends FragmentableObjectWrapper
{

    /**
     * Resolve fields by name
     *
     * @param $name
     * @return SliceWrapper|StructuredTextDummy|static
     */
    public function getRaw($name)
    {
        return $this->object->getFragments()[$this->resolveFieldKey($name)];
    }

    /**
     * Does a field name exit?
     *
     * @param $name
     * @return bool
     */
    public function exists($name)
    {
        return array_key_exists($this->resolveFieldKey($name), $this->all());
    }

    /**
     * Format a field name prismic style.
     *
     * @param $name
     * @return string
     */
    public function resolveFieldKey($name)
    {
        return $this->object->getType() . '.' . $name;
    }

    /**
     * Format a field name prismic style.
     *
     * @param $name
     * @return string
     */
    public function resolveFieldName($key)
    {
        return str_replace($this->object->getType().'.', '', $key);
    }

    public function getUrl()
    {
        if (defined('PRISMIC_LINK_RESOLVER')) {
            $resolverClass = PRISMIC_LINK_RESOLVER;
            $resolver = new $resolverClass;
            return $resolver->resolve($this);
        }
    }
}