<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 8/2/17
 * Time: 10:52 AM
 */

namespace Incraigulous\PrismicToolkit\Helpers;

use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Response;
use Prismic\Fragment\Link\DocumentLink;

/**
 * Resolve prismic links
 *
 * Class LinkResolver
 * @package Incraigulous\PrismicToolkit
 */
class LinkResolver
{
    public static function resolve($link)
    {
        if($link instanceof DocumentLink) {
            return self::resolveWithHttp($link);
        } else {
            return $link->getUrl();
        }
    }

    public static function resolveWithHttp(DocumentLink $link)
    {
        return Response::handle(
            Prismic::getById($link->getId())
        );
    }
}