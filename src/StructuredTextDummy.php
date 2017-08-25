<?php

namespace Incraigulous\PrismicToolkit;

/**
 * A dummy for structured text fields.
 *
 * Class StructuredTextDummy
 * @package Incraigulous\PrismicToolkit
 */
class StructuredTextDummy
{
    public function asHtml(){
        return null;
    }

    public function asText(){
        return null;
    }

    public function getUrl() {
        return null;
    }

    public function __get($name) {
        return null;
    }
}