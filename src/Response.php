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

class Response
{
    public static function make($responseObject) {
        return self::handle($responseObject);
    }

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