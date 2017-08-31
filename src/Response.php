<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 8/2/17
 * Time: 10:46 AM
 */

namespace Incraigulous\PrismicToolkit;

use Carbon\Carbon;
use Incraigulous\PrismicToolkit\Helpers\LinkResolver;
use Incraigulous\PrismicToolkit\Wrappers\Collection;
use Incraigulous\PrismicToolkit\Wrappers\ColorWrapper;
use Incraigulous\PrismicToolkit\Wrappers\EmbedWrapper;
use Incraigulous\PrismicToolkit\Wrappers\FileLinkWrapper;
use Incraigulous\PrismicToolkit\Wrappers\GeoPointWrapper;
use Incraigulous\PrismicToolkit\Wrappers\GroupDocWrapper;
use Incraigulous\PrismicToolkit\Wrappers\ImageWrapper;
use Incraigulous\PrismicToolkit\Wrappers\ImageLinkWrapper;
use Incraigulous\PrismicToolkit\Wrappers\SliceWrapper;
use Incraigulous\PrismicToolkit\Wrappers\DocumentWrapper;
use Incraigulous\PrismicToolkit\Wrappers\WebLinkWrapper;
use Prismic\Document;
use Prismic\Fragment\Color;
use Prismic\Fragment\CompositeSlice;
use Prismic\Fragment\Date;
use Prismic\Fragment\Embed;
use Prismic\Fragment\GeoPoint;
use Prismic\Fragment\Group;
use Prismic\Fragment\GroupDoc;
use Prismic\Fragment\Image;
use Prismic\Fragment\Link\DocumentLink;
use Prismic\Fragment\Link\FileLink;
use Prismic\Fragment\Link\ImageLink;
use Prismic\Fragment\Link\WebLink;
use Prismic\Fragment\Number;
use Prismic\Fragment\SliceZone;
use Prismic\Fragment\StructuredText;
use Prismic\Fragment\Text;
use Prismic\Fragment\Timestamp;

/**
 * A factory for handing any level of Prismic responses.
 *
 * Class Response
 * @package Incraigulous\PrismicToolkit
 */
class Response
{
    /**
     * An alias for make.
     *
     * @param $responseObject
     * @return SliceWrapper|static
     */
    public static function make($responseObject) {
        return self::handle($responseObject);
    }

    /**
     * Accept an level of Prismic response, modify it and return it if needed.
     * If the object passed isn't handled, return it as is.
     *
     * @param $responseObject
     * @return Collection|DocumentWrapper|GroupDocWrapper|SliceWrapper|static
     */
    public static function handle($responseObject)
    {
        switch (get_class($responseObject)) {
            case CompositeSlice::class:
                return new SliceWrapper($responseObject);
                break;
            case Color::class:
                return new ColorWrapper($responseObject);
                break;
            case Date::class:
            case Timestamp::class:
                return Carbon::parse($responseObject->getValue());
                break;
            case Document::class:
                return new DocumentWrapper($responseObject);
                break;
            case DocumentLink::class:
                return LinkResolver::resolve($responseObject);
                break;
            case Embed::class:
                return new EmbedWrapper($responseObject);
                break;
            case FileLink::class:
                return new FileLinkWrapper($responseObject);
                break;
            case GeoPoint::class:
                return new GeoPointWrapper($responseObject);
                break;
            case Group::class:
                return new Collection($responseObject->getArray());
                break;
            case GroupDoc::class:
                return new GroupDocWrapper($responseObject);
                break;
            case Image::class:
                return new ImageWrapper($responseObject);
                break;
            case ImageLink::class:
                return new ImageLinkWrapper($responseObject);
                break;
            case Number::class:
                return $responseObject->getValue();
                break;
            case SliceZone::class:
                return new Collection($responseObject->getSlices());
                break;
            case StructuredText::class:
                return $responseObject->asHtml();
                break;
            case Text::class:
                return $responseObject->asText();
                break;
            case WebLink::class:
                return new WebLinkWrapper($responseObject);
                break;
            default:
                return $responseObject;
        }
    }
}