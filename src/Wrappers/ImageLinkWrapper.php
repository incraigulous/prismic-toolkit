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
use Incraigulous\PrismicToolkit\Wrappers\Traits\HasJsonableObject;
use Incraigulous\PrismicToolkit\Wrappers\Traits\OverloadsToObject;
use Prismic\Fragment\Link\FileLink;
use Prismic\Fragment\Link\ImageLink;

class ImageLinkWrapper implements Arrayable, Jsonable
{
    use OverloadsToObject, HasArrayableObject, HasJsonableObject;

    public function __construct(ImageLink $object)
    {
        $this->object = $object;
    }

    public function toArray()
    {
        return [
            'height' => $this->getObject()->getHeight(),
            'width' => $this->getObject()->getWidth(),
            'url' => $this->getObject()->getUrl(),
            'kind' => $this->getObject()->getKind(),
            'size' => $this->getObject()->getSize(),
            'filename' => $this->getObject()->getFilename(),
            'html' => $this->getObject()->asHtml(),
            'text' => $this->getObject()->asText()
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getObject()->getUrl();
    }
}