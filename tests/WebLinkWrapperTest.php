<?php

namespace Incraigulous\PrismicToolkit\Tests;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Wrappers\FileLinkWrapper;
use Incraigulous\PrismicToolkit\Wrappers\WebLinkWrapper;


/**
 * @group filelink
 *
 * Class FileLinkWrapperTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class WebLinkWrapperTest extends TestCase
{

    /**
     * @test
     */
    public function it_can_resolve_file_link_wrappers()
    {
        $document = Prismic::getByUID('single', 'test-single');
        $this->assertInstanceOf(WebLinkWrapper::class, $document->web_link);
    }

    /**
     * @test
     */
    public function it_is_arrayable()
    {
        $link = Prismic::getByUID('single', 'test-single')->web_link;
        $array = $link->toArray();
        $this->assertTrue(str_contains($array['url'], '.'));
    }

    /**
     * @test
     */
    public function it_is_jsonable()
    {
        $link = Prismic::getByUID('single', 'test-single')->web_link;
        $json = $link->toJson();
        $this->assertTrue(is_string($json));
        $array = json_decode($json, 1);
        $this->assertTrue(str_contains($array['url'], '.'));
    }

    /**
     * @test
     */
    public function it_can_get_urls()
    {
        $link = Prismic::getByUID('single', 'test-single')->web_link;
        $this->assertTrue(is_string($link->url));
    }
}