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
use Prismic\Fragment\Link\WebLink;

class WebLinkWrapper implements Arrayable, Jsonable
{
    use OverloadsToObject, HasArrayableObject, HasJsonableObject;

    public function __construct(WebLink $object)
    {
        $this->object = $object;
    }

    public function toArray()
    {
        return [
            'url' => $this->getUrl(),
            'contentType' => $this->getObject()->getContentType(),
        ];
    }

    public function getUrl()
    {
        return $this->getObject()->getUrl();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getUrl();
    }
}