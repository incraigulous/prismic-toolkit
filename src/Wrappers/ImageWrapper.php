<?php
namespace Incraigulous\PrismicToolkit\Wrappers;


class ImageWrapper extends FragmentWrapper
{
    public function toArray()
    {
        $imageView = $this->getObject()->getMain();
        return [
            'url' => $imageView->getUrl(),
            'alt' => $imageView->getAlt(),
            'copyright' => $imageView->getAlt(),
            'width' => $imageView->getWidth(),
            'height' => $imageView->getHeight(),
            'link' => $imageView->getLink()
        ];
    }
}