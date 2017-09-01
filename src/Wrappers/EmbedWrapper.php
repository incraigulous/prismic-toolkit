<?php
namespace Incraigulous\PrismicToolkit\Wrappers;


class EmbedWrapper extends FragmentWrapper
{
    public function toArray()
    {
        return [
            'type' => $this->getObject()->getType(),
            'html' => $this->getObject()->asHtml(),
            'provider' => $this->getObject()->getProvider(),
            'url' => $this->getObject()->getUrl(),
            'width' => $this->getObject()->getWidth(),
            'height' => $this->getObject()->getHeight(),
            'oEmbedJson' => (array) $this->getObject()->getOEmbedJson(),
            'text' => $this->getObject()->asText()
        ];
    }
}