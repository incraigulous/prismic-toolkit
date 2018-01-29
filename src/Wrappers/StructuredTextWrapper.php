<?php

namespace Incraigulous\PrismicToolkit\Wrappers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Incraigulous\PrismicToolkit\Wrappers\Traits\HasArrayableObject;
use Incraigulous\PrismicToolkit\Wrappers\Traits\HasJsonableObject;
use Incraigulous\PrismicToolkit\Wrappers\Traits\OverloadsToObject;
use Prismic\Fragment\StructuredText;

class StructuredTextWrapper implements Arrayable, Jsonable
{
    use OverloadsToObject, HasArrayableObject, HasJsonableObject;

    public function __construct(StructuredText $object)
    {
        $this->object = $object;
    }

    /**
     * Convert to an array
     */
    public function toArray()
    {
        return [
            'html' => $this->html,
            'text' => $this->text
        ];
    }

    /**
     * Alias to asHtml
     * @return mixed
     */
    public function getHtml()
    {
        return $this->getObject()->asHtml();
    }

    /**
     * Alias to asText
     * @return mixed
     */
    public function getText()
    {
        return $this->getObject()->asText();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getObject()->asHtml();
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return ! (bool) $this->getText();
    }

    /**
     * @return bool
     */
    public function isSet()
    {
        return $this->isEmpty();
    }
}