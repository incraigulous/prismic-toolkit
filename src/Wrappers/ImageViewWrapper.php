<?php
namespace Incraigulous\PrismicToolkit\Wrappers;

use Incraigulous\PrismicToolkit\Wrappers\Traits\HasArrayableObject;
use Incraigulous\PrismicToolkit\Wrappers\Traits\HasJsonableObject;
use Incraigulous\PrismicToolkit\Wrappers\Traits\OverloadsToObject;
use Prismic\Fragment\ImageView;

class ImageViewWrapper
{
    use OverloadsToObject, HasArrayableObject, HasJsonableObject;

    public function __construct(ImageView $object)
    {
        $this->object = $object;
    }

    public function toArray()
    {
        return [
            'url' => $this->getUrl(),
            'alt' => $this->getAlt(),
            'copyright' => $this->getAlt(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'link' => $this->getLink()
        ];
    }

    /**
     * Alias directly to getraw
     *
     * @param $name
     * @return DynamicSlice|StructuredTextDummy|static
     */
    public function get($name)
    {
        return $this->getRaw($name);
    }

    /**
     * Overload properties to main image view and then to image view keys
     *
     * @param $name
     * @return DynamicSlice|StructuredTextDummy|static
     */
    public function getRaw($name)
    {
        $array = $this->toArray();
        return $array[$name];
    }
}