<?php
namespace Incraigulous\PrismicToolkit\Wrappers;


class ColorWrapper extends FragmentWrapper
{
    public function toArray()
    {
        return [
            'hex' => $this->getObject()->getHexValue()
        ];
    }
}