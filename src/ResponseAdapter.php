<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 8/2/17
 * Time: 10:46 AM
 */

namespace Incraigulous\PrismicToolkit;

use Prismic\Document;
use Prismic\Fragment\CompositeSlice;
use Prismic\Fragment\Group;
use Prismic\Fragment\GroupDoc;
use Prismic\Fragment\Link\DocumentLink;
use Prismic\Fragment\SliceZone;

class ResponseAdapter
{
    public function handle($responseObject)
    {
        switch (get_class($responseObject)) {
            case Document::class:
                return new DynamicDocument($responseObject);
                break;
            case Group::class:
                return new Collection($responseObject);
                break;
            case GroupDoc::class;
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
            default:
                return $responseObject;
        }
    }
}