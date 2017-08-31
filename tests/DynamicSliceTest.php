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
}
