<?php
namespace Incraigulous\PrismicToolkit\Wrappers;


class GeoPointWrapper extends FragmentWrapper
{
    public function toArray()
    {
        return [
            'html' => $this->getObject()->asHtml(),
            'latitude' => $this->getObject()->getLatitude(),
            'longitude' => $this->getObject()->getLongitude(),
            'text' => $this->getObject()->asText()
        ];
    }
}