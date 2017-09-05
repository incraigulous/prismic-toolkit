<?php

namespace Incraigulous\PrismicToolkit\Tests;
use Carbon\Carbon;
use Incraigulous\PrismicToolkit\Wrappers\ColorWrapper;
use Incraigulous\PrismicToolkit\Wrappers\DocumentWrapper;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Response;
use Incraigulous\PrismicToolkit\Wrappers\GeoPointwrapper;
use Incraigulous\PrismicToolkit\Wrappers\FileLinkWrapper;
use Incraigulous\PrismicToolkit\Wrappers\EmbedWrapper;
use Incraigulous\PrismicToolkit\Wrappers\ImageLinkWrapper;
use Incraigulous\PrismicToolkit\Wrappers\ImageWrapper;
use Prismic\Fragment\Color;
use Prismic\Fragment\Embed;
use Prismic\Fragment\GeoPoint;
use Prismic\Fragment\Image;
use Prismic\Fragment\Link\ImageLink;

/**
 * @group responses
 * @group documents
 *
 * Class DynamicCollectionTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class DocumentWrapperTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_make_dynamic_documents()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $document = Response::make($single);
        $this->assertInstanceOf(DocumentWrapper::class, $document);
    }

    /**
     * @test
     */
    public function it_can_resolve_fields()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $document = Response::make($single);
        $this->stringContains('<', $document->title);
        $this->stringContains('<', $document->rich_text);
        $this->assertInstanceOf(ImageWrapper::class, $document->image);
        $this->assertInstanceOf(ImageLinkWrapper::class, $document->media);
        $this->assertInstanceOf(Carbon::class, $document->date);
        $this->assertInstanceOf(Carbon::class, $document->timestamp);
        $this->assertInstanceOf(ColorWrapper::class, $document->color);
        $this->assertTrue(is_numeric($document->number));
        $this->assertTrue(is_string($document->key_text));
        $this->assertTrue(is_string($document->select));
        $this->assertInstanceOf(EmbedWrapper::class, $document->embed);
        $this->assertInstanceOf(GeoPointWrapper::class, $document->geopoint);
    }

    /**
     * @test
     */
    public function it_can_test_if_a_field_exists()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $document = Response::make($single);
        $this->assertFalse($document->has('cats'));
        $this->assertTrue($document->has('title'));
        $this->assertFalse($document->exists('cats'));
        $this->assertTrue($document->exists('title'));
    }

    /**
     * @test
     */
    public function it_is_arrayable()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $document = Response::make($single);
        $array = $document->toArray();

        $this->assertTrue(is_array($array));
        $this->stringContains('<', $array['title']);
        $this->stringContains('<', $array['rich_text']);
        $this->assertTrue(is_string($array['media']['url']));
        $this->assertTrue(is_numeric($array['number']));
        $this->assertTrue(is_string($array['key_text']));
        $this->assertTrue(is_string($array['select']));
    }

    /**
     * @test
     */
    public function it_is_jsonable()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $document = Response::make($single);
        $json = $document->toJson();
        $array = json_decode($json, true);
        $this->assertTrue(is_string($json));
        $this->stringContains('<', $array['title']);
        $this->stringContains('<', $array['rich_text']);
        $this->assertTrue(is_string($array['image']['url']));
        $this->assertTrue(is_string($array['media']['url']));
        $this->assertTrue(is_string($array['date']['date']));
        $this->assertTrue(is_string($array['timestamp']['date']));
        $this->assertTrue(is_string($array['color']['hex']));
        $this->assertTrue(is_string($array['embed']['html']));
        $this->assertTrue(is_string($array['geopoint']['text']));
        $this->assertTrue(is_numeric($array['number']));
        $this->assertTrue(is_string($array['key_text']));
        $this->assertTrue(is_string($array['select']));
    }
}
