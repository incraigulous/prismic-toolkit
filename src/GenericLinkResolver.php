<?php

namespace Incraigulous\PrismicToolkit;

use Incraigulous\PrismicToolkit\Wrappers\DocumentWrapper;
use Prismic\Fragment\Link\DocumentLink;
use Prismic\LinkResolver;

class GenericLinkResolver extends LinkResolver
{
    public function resolve($link)
    {
        if($link instanceof DocumentLink) {
            if ($link->isBroken()) {
                return null;
            }
            return '/' . $link->getUid();
        } elseif ($link instanceof DocumentWrapper) {
            return '/' . $link->getUid();
        } else {
            return $link->getUrl();
        }
    }
}