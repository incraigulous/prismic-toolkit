<?php

namespace Incraigulous\PrismicToolkit\Tests;
use Carbon\Carbon;
use Incraigulous\PrismicToolkit\DynamicDocument;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Response;
use Prismic\Fragment\Color;
use Prismic\Fragment\Embed;
use Prismic\Fragment\GeoPoint;
use Prismic\Fragment\Image;
use Prismic\Fragment\Link\ImageLink;
use Prismic\Fragment\Number;
use Prismic\Fragment\StructuredText;
use Prismic\Fragment\Text;

/**
 * @group responses
 * @group documents
 *
 * Class DynamicCollectionTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class DynamicDocumentTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_make_dynamic_documents()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $document = Response::make($single);
        $this->assertInstanceOf(DynamicDocument::class, $document);
    }

    /**
     * @test
     */
    public function it_can_resolve_fields()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $document = Response::make($single);
        $this->assertInstanceOf(StructuredText::class, $document->title);
        $this->assertInstanceOf(StructuredText::class, $document->rich_text);
        $this->assertInstanceOf(Image::class, $document->image);
        $this->assertInstanceOf(ImageLink::class, $document->media);
        $this->assertInstanceOf(Carbon::class, $document->date);
        $this->assertInstanceOf(Carbon::class, $document->timestamp);
        $this->assertInstanceOf(Color::class, $document->color);
        $this->assertInstanceOf(Number::class, $document->number);
        $this->assertInstanceOf(Text::class, $document->key_text);
        $this->assertInstanceOf(Text::class, $document->select);
        $this->assertInstanceOf(Embed::class, $document->embed);
        $this->assertInstanceOf(GeoPoint::class, $document->geopoint);
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
    }
}
