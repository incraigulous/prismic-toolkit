<?php

namespace Incraigulous\PrismicToolkit\Wrappers;


use Prismic\Fragment\GroupDoc;

/**
 * A dynamic wrapper for prismic GroupDocs to give a clearer and simpler API.
 *
 * Class GroupDocWrapper
 * @package Incraigulous\PrismicToolkit
 */
class GroupDocWrapper extends FragmentableObjectWrapper
{
    /**
     * Resolve a field by name
     *
     * @param $name
     * @return SliceWrapper|static
     */
    public function getRaw($name)
    {
        return $this->all()[$name];
    }

    /**
     * Does a field name exit?
     *
     * @param $name
     * @return bool
     */
    public function exists($name)
    {
        return array_key_exists($name, $this->all());
    }
}