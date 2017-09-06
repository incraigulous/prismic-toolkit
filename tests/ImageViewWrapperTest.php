<?php

namespace Incraigulous\PrismicToolkit\Tests;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Response;
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
        $single = Prismic::getByUID('single', 'test-single');
        $document = Response::make($single);
        $this->assertInstanceOf(ImageViewWrapper::class, $document->image->main);
    }

    /**
     * @test
     */
    public function it_can_resolve_image_wrappers_content()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $imageWrapper = Response::make($single)->image->main;
        $this->assertTrue(is_string($imageWrapper->url));
    }

    /**
     * @test
     */
    public function it_is_arrayable()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $image = Response::make($single)->image->main;
        $array = $image->toArray();
        $this->assertTrue(is_numeric($array['height']));
    }

    /**
     * @test
     */
    public function it_is_jsonable()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $image = Response::make($single)->image->main;
        $json = $image->toJson();
        $this->assertTrue(is_string($json));
        $array = json_decode($json, 1);
        $this->assertTrue(is_numeric($array['height']));
    }
}