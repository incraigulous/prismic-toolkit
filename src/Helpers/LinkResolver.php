<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 8/2/17
 * Time: 10:52 AM
 */

namespace Incraigulous\PrismicToolkit\Helpers;

use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\FluentResponse;
use Prismic\Fragment\Link\DocumentLink;
use Prismic\Fragment\Link\FileLink;
use Prismic\Fragment\Link\ImageLink;
use Prismic\Fragment\Link\LinkInterface;

/**
 * Resolve prismic links
 *
 * Class LinkResolver
 * @package Incraigulous\PrismicToolkit
 */
class LinkResolver
{
    public static function resolve(LinkInterface $link)
    {
        switch (get_class($link)) {
            case DocumentLink::class:
                return self::resolveDocumentLink($link);
                break;
            case FileLink::class:
            case ImageLink::class:
                return self::resolveFileLink($link);
                break;
            default:
                $link->getUrl();
        }
    }

    public static function resolveDocumentLink(DocumentLink $link)
    {
        return FluentResponse::handle(
            Prismic::getById($link->getId())
        );
    }

    public static function resolveFileLink(LinkInterface $link)
    {
        return FluentResponse::handle($link);
    }
}