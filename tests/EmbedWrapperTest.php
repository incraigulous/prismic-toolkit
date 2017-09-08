<?php

namespace Incraigulous\PrismicToolkit\Tests;

use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Wrappers\EmbedWrapper;


/**
 * @group `
 *
 * Class EmbedWrapperTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class EmbedWrapperTest extends TestCase
{

    /**
     * @test
     */
    public function it_can_resolve_color_wrappers()
    {
        $document = Prismic::getByUID('single', 'test-single');
        $this->assertInstanceOf(EmbedWrapper::class, $document->embed);
    }

    /**
     * @test
     */
    public function it_can_resolve_color_wrapper_content()
    {
         $embed = Prismic::getByUID('single', 'test-single')->embed;
        $this->assertTrue(str_contains($embed->asHtml(), 'iframe'));
    }

    /**
     * @test
     */
    public function it_is_arrayable()
    {
        $embed = Prismic::getByUID('single', 'test-single')->embed;
        $array = $embed->toArray();
        $this->assertTrue(str_contains($array['html'], 'iframe'));
    }

    /**
     * @test
     */
    public function it_is_jsonable()
    {
        $embed = Prismic::getByUID('single', 'test-single')->embed;
        $json = $embed->toJson();
        $this->assertTrue(is_string($json));
        $array = json_decode($json, 1);
        $this->assertTrue(str_contains($array['html'], 'iframe'));
    }
}