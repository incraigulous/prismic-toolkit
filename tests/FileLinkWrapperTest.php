<?php

namespace Incraigulous\PrismicToolkit\Tests;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Response;
use Incraigulous\PrismicToolkit\Wrappers\FileLinkWrapper;


/**
 * @group filelink
 *
 * Class FileLinkWrapperTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class FileLinkWrapperTest extends TestCase
{

    /**
     * @test
     */
    public function it_can_resolve_file_link_wrappers()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $document = Response::make($single);
        $this->assertInstanceOf(FileLinkWrapper::class, $document->file_link);
    }

    /**
     * @test
     */
    public function it_can_resolve_file_link_wrapper_content()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $fileLink = Response::make($single)->file_link;
        $this->assertTrue(str_contains($fileLink->getFilename(), '.'));
    }

    /**
     * @test
     */
    public function it_is_arrayable()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $fileLink = Response::make($single)->file_link;
        $array = $fileLink->toArray();
        $this->assertTrue(str_contains($array['filename'], '.'));
    }

    /**
     * @test
     */
    public function it_is_jsonable()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $fileLink = Response::make($single)->file_link;
        $json = $fileLink->toJson();
        $this->assertTrue(is_string($json));
        $array = json_decode($json, 1);
        $this->assertTrue(str_contains($array['filename'], '.'));
    }
}