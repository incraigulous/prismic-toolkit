<?php

namespace Incraigulous\PrismicToolkit\Tests;

use Incraigulous\PrismicToolkit\Wrappers\SliceWrapper;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Response;

/**
 * @group responses
 * @group slices
 *
 * Class DynamicSliceTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class DynamicSliceTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_make_dynamic_slices()
    {
        $slices = Response::make(
            Prismic::getByUID('blog_post', 'post-1')
        )->body;

        $this->assertInstanceOf(SliceWrapper::class, $slices->first());
    }

    /**
     * @test
     *
     */
    public function it_is_jsonable()
    {
        $slices = Response::make(
            Prismic::getByUID('blog_post', 'post-1')
        )->body;

        $json = $slices->toJson();
        $std = json_decode($json);

        $this->assertTrue(is_string($json));
        $this->assertTrue(is_string($std[0])->text);
    }

    /**
     * @test
     *
     */
    public function it_is_arrayable()
    {
        $slices = Response::make(
            Prismic::getByUID('blog_post', 'post-1')
        )->body;

        $array = $slices->toArray();

        $this->assertTrue(is_array($array));
        $this->assertTrue(is_string($array[0])['text']);
    }
}
