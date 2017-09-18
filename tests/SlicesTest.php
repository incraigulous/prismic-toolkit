<?php

namespace Incraigulous\PrismicToolkit\Tests;

use Incraigulous\PrismicToolkit\Wrappers\CompositeSliceWrapper;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Wrappers\GroupDocWrapper;

/**
 * @group responses
 * @group slices
 *
 * Class SlicesTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class SlicesTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_make_slices()
    {
        $slices = Prismic::getByUID('blog_post', 'post-1')->body;

        $this->assertInstanceOf(CompositeSliceWrapper::class, $slices->first());
        $this->assertInstanceOf(GroupDocWrapper::class, $slices->first()->getDoc());
    }

    /**
     * @test
     */
    public function it_can_resolve_content_from_slices()
    {
        $slices = Prismic::getByUID('blog_post', 'post-1')->body;

        $this->assertTrue(str_contains($slices->first()->text,'<'));
    }

    /**
     * @test
     */
    public function it_is_arrayable()
    {
        $slices = Prismic::getByUID('blog_post', 'post-1')->body;
        $array = $slices->toArray();
        $this->assertArrayHasKey('type', $array[0]);
    }

    /**
     * @test
     */
    public function it_is_jsonable()
    {
        $slices = Prismic::getByUID('blog_post', 'post-1')->body;
        $json = $slices->toJson();
        $this->assertTrue(is_string($json));
        $array = json_decode($json, 1);
        $this->assertArrayHasKey('type', $array[0]);
    }

    /**
     * @test
     */
    public function it_can_get_the_type()
    {
        $slice = Prismic::getByUID('blog_post', 'post-1')->body->first();
        $this->assertEquals($slice->type, 'text');
    }
}
