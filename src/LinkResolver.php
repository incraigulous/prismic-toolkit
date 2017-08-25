<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 8/2/17
 * Time: 10:52 AM
 */

namespace Incraigulous\PrismicToolkit;

use Incraigulous\PrismicToolkit\Facades\Prismic;
use Prismic\Fragment\Link\DocumentLink;

/**
 * Resolve prismic links
 *
 * Class LinkResolver
 * @package Incraigulous\PrismicToolkit
 */
class LinkResolver
{
    public function resolve($link)
    {
        if($link instanceof DocumentLink) {
            return $this->resolveWithHttp($link);
        } else {
            return $link->getUrl();
        }
    }

    public function resolveWithHttp(DocumentLink $link)
    {
        return (new Response())->handle(
            Prismic::getById($link->getId())
        );
    }
}