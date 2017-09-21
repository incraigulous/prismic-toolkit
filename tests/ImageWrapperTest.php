<?php

namespace Incraigulous\PrismicToolkit\Tests;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Wrappers\ImageViewWrapper;
use Incraigulous\PrismicToolkit\Wrappers\ImageWrapper;


/**
 * @group image
 *
 * Class ImageWrapperTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class ImageWrapperTest extends TestCase
{

    /**
     * @test
     */
    public function it_can_resolve_image_wrappers()
    {
        $document = Prismic::getByUID('single', 'test-single');
        $this->assertInstanceOf(ImageWrapper::class, $document->image);
    }

    /**
     * @test
     */
    public function it_can_resolve_image_wrappers_content()
    {
        $imageWrapper = Prismic::getByUID('single', 'test-single')->image->main;
        $this->assertInstanceOf(ImageViewWrapper::class, $imageWrapper);
    }

    /**
     * @test
     */
    public function it_is_arrayable()
    {
        $image = Prismic::getByUID('single', 'test-single')->image;
        $array = $image->toArray();
        $this->assertArrayHasKey('main', $array);
    }

    /**
     * @test
     */
    public function it_is_jsonable()
    {
        $image = Prismic::getByUID('single', 'test-single')->image;
        $json = $image->toJson();
        $this->assertTrue(is_string($json));
        $array = json_decode($json, 1);
        $this->assertArrayHasKey('main', $array);
        $this->assertArrayHasKey('retina', $array);
    }
}