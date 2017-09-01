<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 8/30/17
 * Time: 4:11 PM
 */

namespace Incraigulous\PrismicToolkit\Wrappers;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Incraigulous\PrismicToolkit\Wrappers\Traits\HasArrayableObject;
use Incraigulous\PrismicToolkit\Wrappers\Traits\HasJasonableObject;
use Incraigulous\PrismicToolkit\Wrappers\Traits\OverloadsToObject;
use Prismic\Fragment\Link\FileLink;

class FileLinkWrapper
{
    use OverloadsToObject, HasArrayableObject, HasJasonableObject;

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