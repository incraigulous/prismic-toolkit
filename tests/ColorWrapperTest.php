<?php

namespace Incraigulous\PrismicToolkit\Tests;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Response;
use Incraigulous\PrismicToolkit\Wrappers\ColorWrapper;


/**
 * @group color
 *
 * Class ColorWrapperTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class ColorWrapperTest extends TestCase
{

    /**
     * @test
     */
    public function it_can_resolve_color_wrappers()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $document = Response::make($single);
        $this->assertInstanceOf(ColorWrapper::class, $document->color);
    }

    /**
     * @test
     */
    public function it_can_resolve_color_wrapper_content()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $color = Response::make($single)->color;
        $this->assertTrue(str_contains($color->getHexValue(), '#'));
    }

    /**
     * @test
     */
    public function it_is_arrayable()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $color = Response::make($single)->color;
        $array = $color->toArray();
        $this->assertTrue(str_contains($array['hex'], '#'));
    }

    /**
     * @test
     */
    public function it_is_jsonable()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $color = Response::make($single)->color;
        $json = $color->toJson();
        $this->assertTrue(is_string($json));
        $array = json_decode($json, 1);
        $this->assertTrue(str_contains($array['hex'], '#'));
    }
}