<?php

namespace Incraigulous\PrismicToolkit\Tests;

use Incraigulous\PrismicToolkit\Wrappers\GroupDocWrapper;
use Incraigulous\PrismicToolkit\Facades\Prismic;

/**
 * @group responses
 * @group slices
 *
 * Class DynamicSliceTest
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

        $this->assertInstanceOf(GroupDocWrapper::class, $slices->first());
    }

    /**
     * @test
     */
    public function it_can_resolve_content_from_slices()
    {
        $slices = Prismic::getByUID('blog_post', 'post-1')->body;

        $this->assertTrue(str_contains($slices->first()->text,'<'));
    }
}
