<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 8/2/17
 * Time: 10:46 AM
 */

namespace Incraigulous\PrismicToolkit;

use Carbon\Carbon;
use Prismic\Document;
use Prismic\Fragment\CompositeSlice;
use Prismic\Fragment\Date;
use Prismic\Fragment\Group;
use Prismic\Fragment\GroupDoc;
use Prismic\Fragment\Link\DocumentLink;
use Prismic\Fragment\SliceZone;
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
     * @return DynamicSlice|static
     */
    public static function make($responseObject) {
        return self::handle($responseObject);
    }

    /**
     * Accept an level of Prismic response, modify it and return it if needed.
     * If the object passed isn't handled, return it as is.
     *
     * @param $responseObject
     * @return Collection|DynamicDocument|DynamicGroupDoc|DynamicSlice|static
     */
    public static function handle($responseObject)
    {
        switch (get_class($responseObject)) {
            case Document::class:
                return new DynamicDocument($responseObject);
                break;
            case Group::class:
                return new Collection($responseObject->getArray());
                break;
            case GroupDoc::class:
                return new DynamicGroupDoc($responseObject);
                break;
            case SliceZone::class:
                return new Collection($responseObject->getSlices());
                break;
            case CompositeSlice::class:
                return new DynamicSlice($responseObject);
                break;
            case DocumentLink::class:
                return (new LinkResolver())->resolve($responseObject);
                break;
            case Date::class:
            case Timestamp::class:
                return Carbon::parse($responseObject->getValue());
                break;
            default:
                return $responseObject;
        }
    }
}