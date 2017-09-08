<?php

namespace Incraigulous\PrismicToolkit\Tests;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Wrappers\ImageViewWrapper;


/**
 * @group image
 *
 * Class ImageViewWrapperTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class ImageViewWrapperTest extends TestCase
{

    /**
     * @test
     */
    public function it_can_resolve_image_wrappers()
    {
        $document = Prismic::getByUID('single', 'test-single');
        $this->assertInstanceOf(ImageViewWrapper::class, $document->image->main);
    }

    /**
     * @test
     */
    public function it_can_resolve_image_wrappers_content()
    {
        $imageWrapper = Prismic::getByUID('single', 'test-single')->image->main;
        $this->assertTrue(is_string($imageWrapper->url));
    }

    /**
     * @test
     */
    public function it_is_arrayable()
    {
        $image = Prismic::getByUID('single', 'test-single')->image->main;
        $array = $image->toArray();
        $this->assertTrue(is_numeric($array['height']));
    }

    /**
     * @test
     */
    public function it_is_jsonable()
    {
        $image = Prismic::getByUID('single', 'test-single')->image->main;
        $json = $image->toJson();
        $this->assertTrue(is_string($json));
        $array = json_decode($json, 1);
        $this->assertTrue(is_numeric($array['height']));
    }
}