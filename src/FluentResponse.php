<?php
namespace Incraigulous\PrismicToolkit;

use Carbon\Carbon;
use Incraigulous\PrismicToolkit\Helpers\LinkResolver;
use Incraigulous\PrismicToolkit\Wrappers\ApiWrapper;
use Incraigulous\PrismicToolkit\Wrappers\Collection;
use Incraigulous\PrismicToolkit\Wrappers\ColorWrapper;
use Incraigulous\PrismicToolkit\Wrappers\CompositeSliceWrapper;
use Incraigulous\PrismicToolkit\Wrappers\GeoPointwrapper;
use Incraigulous\PrismicToolkit\Wrappers\FileLinkWrapper;
use Incraigulous\PrismicToolkit\Wrappers\EmbedWrapper;
use Incraigulous\PrismicToolkit\Wrappers\GroupDocWrapper;
use Incraigulous\PrismicToolkit\Wrappers\ImageViewWrapper;
use Incraigulous\PrismicToolkit\Wrappers\ImageWrapper;
use Incraigulous\PrismicToolkit\Wrappers\ImageLinkWrapper;
use Incraigulous\PrismicToolkit\Wrappers\ResponseWrapper;
use Incraigulous\PrismicToolkit\Wrappers\SliceWrapper;
use Incraigulous\PrismicToolkit\Wrappers\DocumentWrapper;
use Incraigulous\PrismicToolkit\Wrappers\StructuredTextWrapper;
use Incraigulous\PrismicToolkit\Wrappers\WebLinkWrapper;
use Prismic\Api;
use Prismic\Document;
use Prismic\Fragment\Color;
use Prismic\Fragment\CompositeSlice;
use Prismic\Fragment\Date;
use Prismic\Fragment\Embed;
use Prismic\Fragment\GeoPoint;
use Prismic\Fragment\Group;
use Prismic\Fragment\GroupDoc;
use Prismic\Fragment\Image;
use Prismic\Fragment\ImageView;
use Prismic\Fragment\Link\DocumentLink;
use Prismic\Fragment\Link\FileLink;
use Prismic\Fragment\Link\ImageLink;
use Prismic\Fragment\Link\WebLink;
use Prismic\Fragment\Number;
use Prismic\Fragment\SliceZone;
use Prismic\Fragment\StructuredText;
use Prismic\Fragment\Text;
use Prismic\Fragment\Timestamp;
use Prismic\Response;

/**
 * A factory for handing any level of Prismic responses.
 *
 * Class FluentResponse
 * @package Incraigulous\PrismicToolkit
 */
class FluentResponse
{
    /**
     * An alias for make.
     *
     * @param $responseObject
     * @return mixed
     */
    public static function make($responseObject) {
        return self::handle($responseObject);
    }

    /**
     * Accept an level of Prismic response, modify it and return it if needed.
     * If the object passed isn't handled, return it as is.
     *
     * @param $response
     * @return mixed
     */
    public static function handle($response)
    {
        if (is_string($response)) {
            return $response;
        }

        if (is_array($response) && !is_assoc($response)) {
            return new Collection($response);
        }

        if (!is_object($response)) {
            return $response;
        }

        switch (get_class($response)) {
            case Api::class:
                return new ApiWrapper($response);
                break;
            case Color::class:
                return new ColorWrapper($response);
                break;
            case CompositeSlice::class:
                return new CompositeSliceWrapper($response);
                break;
            case Date::class:
            case Timestamp::class:
                return Carbon::parse($response->getValue());
                break;
            case Document::class:
                return new DocumentWrapper($response);
                break;
            case DocumentLink::class:
                return LinkResolver::resolve($response);
                break;
            case Embed::class:
                return new EmbedWrapper($response);
                break;
            case FileLink::class:
                return new FileLinkWrapper($response);
                break;
            case GeoPoint::class:
                return new GeoPointWrapper($response);
                break;
            case Group::class:
                return new Collection($response->getArray());
                break;
            case GroupDoc::class:
                return new GroupDocWrapper($response);
                break;
            case Image::class:
                return new ImageWrapper($response);
                break;
            case ImageLink::class:
                return new ImageLinkWrapper($response);
                break;
            case ImageView::class:
                return new ImageViewWrapper($response);
                break;
            case Number::class:
                return $response->getValue();
                break;
            case Response::class:
                return new ResponseWrapper($response);
                break;
            case SliceZone::class:
                return new Collection($response->getSlices());
                break;
            case StructuredText::class:
                return new StructuredTextWrapper($response);
                break;
            case Text::class:
                return $response->asText();
                break;
            case WebLink::class:
                return new WebLinkWrapper($response);
                break;
            default:
                return $response;
        }
    }
}