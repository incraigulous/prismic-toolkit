<?php

namespace Incraigulous\PrismicToolkit\Wrappers;

use Incraigulous\PrismicToolkit\Wrappers\Traits\HasArrayableObject;
use Incraigulous\PrismicToolkit\Wrappers\Traits\HasJsonableObject;
use Incraigulous\PrismicToolkit\Wrappers\Traits\OverloadsToObject;
use Prismic\Fragment\Link\FileLink;

class FileLinkWrapper
{
    use OverloadsToObject, HasArrayableObject, HasJsonableObject;

    public function __construct(FileLink $object)
    {
        $this->object = $object;
    }

    public function toArray()
    {
        return [
            'url' => $this->getObject()->getUrl(),
            'kind' => $this->getObject()->getKind(),
            'size' => $this->getObject()->getSize(),
            'filename' => $this->getObject()->getFilename(),
            'html' => $this->getObject()->asHtml(),
            'text' => $this->getObject()->asText()
        ];
    }
}